<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sliders extends MX_Controller {

    private $module;
    private $table;
    private $moduleTitles;
    private $views;
    private $types;
    private $fields;
    private $paginationSession;
    private $uploadFolder;
    private $image;

	public function __construct() 
	{
        parent::__construct();
        $this->module = 'slider';
        $this->table = 'slider';
        $this->load->model('Slider');
        $this->paginationSession = 'state_pagination';
        $this->moduleTitles = [
            'create' => [
                'title'  => 'Estado',
                'action' => 'Agregar'
            ],
            'read'   => [   
                'title'  => 'Estado',
                'action' => 'Buscar / Editar',
            ],
            'update' => [
                'title'  => 'Estado',
                'action' => 'Editar'
            ]
        ];
        $this->fields = [
            'slider_id',
            'slider_name'
        ];
        $this->views   = [
            'template' => 'templates/logged_view',
            'update'   => 'slider/update_view',
            'read'     => 'slider/read_view',
            'detail'   => 'slider/detail_view',
        ];
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');
        $this->filesFolders     = [
            'upload'            => 'public/app/images/slider/original/', 
            'large'             => 'public/app/images/slider/large/',
        ];
        $this->filesProperties  = [
            'extensions'        => array('jpg', 'jpeg', 'png'),
            'image'             => TRUE,
            'padding'           => FALSE,
            'image_default'     => 'file.png',
            'aspect_ratio_x'    => 1,
            'aspect_ratio_y'    => 1,
            'max_width'         => 500000000,
            'large_width'       => 1366,
            'max_number_files'  => 100,
            'max_file_size'     => 10048000000,
            'min_file_size'     => 2000,
            'encrypted_name'    => TRUE,
            'accept_file_types' => 'jpg|jpeg|png'
        ];
        $this->filesProperties['max_height']    = round(($this->filesProperties['max_width']    / $this->filesProperties['aspect_ratio_x']) * $this->filesProperties['aspect_ratio_y']);
        $this->filesProperties['large_height']  = round(($this->filesProperties['large_width']  / $this->filesProperties['aspect_ratio_x']) * $this->filesProperties['aspect_ratio_y']);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');
    }

	public function index()
	{
		$data['page_content'] = $this->load->view($this->views['update'], '', TRUE);

        $this->load->view($this->views['template'], $data);
	}

    public function create($id = FALSE)
    {
        if ($state = $this->State->get_by_id($id)) {
            $data = (array) $state;
        } else {
            $state = $this->db->field_data($this->table);
            foreach ($state as $v) {
                $data[$v->name] = $v->default;
            }
        }
        $data['state'] = (!empty($data['state'])) ? TRUE : FALSE;
        if (empty($data['id'])) {
            foreach ($this->moduleTitles['create'] as $k => $v) {
                $data[$k] = $v;
            }
        } else {
            foreach ($this->moduleTitles['update'] as $k => $v) {
                $data[$k] = $v;
            }
        }
        $this->form_validation->set_rules('name', 'Nombre', 'required');
        // $this->form_validation->set_rules('state', 'Activo');
        // if ($this->form_validation->run()) {
            // $state = $this->input->post();
            // $state['state'] = (!empty($state['state'])) ? 1 : 0;
            // $state['updated'] = time();
            // if (empty($data['id'])) {
            //     $state['created'] = time();
            //     $this->db->insert($this->table, $state);
            // } else {
            //     $id = $data['id'];
            //     unset($state['id']);
            //     $this->db->where('id', $id)->update($this->table, $state);
            // }
        //     $this->redirect();
        // }
        $data['module'] = $this->module;
        $data['page_content'] = $this->load->view($this->views['update'], $data, TRUE);
        $this->load->view($this->views['template'], $data);
    }

    public function read($field = 'id', $order = 'asc', $numrows = 10, $start = 0)
    {
        if (!in_array($field, $this->fields)) {
            $field = 'id';
        }
        $data = [
            'field'     => $field,
            'order'     => $order,
            'numrows'   => $numrows,
            'start'     => $start
        ];
        if ($search = $this->input->post('search')) {
            $data['search'] = $search;
            $data['start'] = 0;
        } else if ($this->input->post('search') === '') {
            $data['search'] = '';
        } else {
            $pagination = $this->session->userdata($this->paginationSession);
            $data['search'] = $pagination['search'];
        }
        $this->session->set_userdata($this->paginationSession, $data);
        $data['total_rows'] = $this->State->get($field, $order, 0, 0, $data['search'], $this->fields, TRUE);
        $this->load->library('pagination');
        $config['base_url']     = base_url('admin/' . $this->module . '/read/' . $field . '/' . $order . '/' . $numrows . '/');
        $config['total_rows']   = $data['total_rows'];
        $config['per_page']     = $numrows;
        $config['uri_segment']  = 7;
        $config['num_links']    = 2;
        $this->pagination->initialize($config);
        $data['session_pagination'] = $this->paginationSession;
        $data['module'] = $this->module;
        $data['pagination'] = $this->pagination->create_links();
        $rows = $this->State->get($field, $order, $numrows, $start, $data['search'], $this->fields, FALSE);
        $data['numrows'] = $data['numrows']; 
        if ($this->uri->segment(7)) {
            $data['start_rows'] = $this->uri->segment(7);
        } else {
            $data['start_rows'] = 1;
        }
        $data['end_rows'] = $this->uri->segment(7) + $data['numrows'];
        $data[$this->table] = $rows;
        foreach ($this->moduleTitles['read'] as $k => $v) {
            $data[$k] = $v;
        }
        $data['page_content'] = $this->load->view($this->views['read'], $data, TRUE);
        $this->load->view($this->views['template'], $data);
    }
    public function file_upload($id = FALSE)
    {
        if($this->input->is_ajax_request()) {
            $config['upload_path']      = $this->uploadFolder;
            $config['allowed_types']    = 'jpg|jpeg|png';
            $config['max_size']         = $this->filesProperties['max_file_size'];
            $config['max_width']        = $this->filesProperties['max_width'];
            $config['max_height']       = $this->filesProperties['max_width'];
            $config['quality']          = '100%';
            $config['encrypt_name']     = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')) {
                $file                   = $this->upload->data();
                $info                   = new stdClass();
                $info->file             = $file['file_name'];
                $info->w                = $file['image_width'];
                $info->h                = $file['image_height'];
                $info->ext              = str_replace('.', '', strtolower($file['file_ext']));
                if (is_numeric($id) AND $user = $this->User->get_by_id($id)) {
                    if ($user->image != $this->image['default']) {
                        @unlink($this->uploadFolder . $user->image);
                    }
                    $this->db->where('id', $id)->update('users', ['image' => $info->file, 'updated' => time()]);
                    if ($_SESSION['User']->id == $id) {
                        $this->admin->session_update($id);
                    }
                }
                $info->type             = $file['file_type'];
                $info->url              = base_url($this->uploadFolder . $info->file);
                
                $sourceWidth = $info->w;
                $sourceHeight = $info->h;
                $targetWidth = 300;
                $targetHeight = 300;
                $sourceRatio = $sourceWidth / $sourceHeight;
                $targetRatio = $targetWidth / $targetHeight;
                if ( $sourceRatio < $targetRatio ) {
                    $scale = $sourceWidth / $targetWidth;
                } else {
                    $scale = $sourceHeight / $targetHeight;
                }
                $resizeWidth = (int)($sourceWidth / $scale);
                $resizeHeight = (int)($sourceHeight / $scale);
                $cropLeft = (int)(($resizeWidth - $targetWidth) / 2);
                $cropTop = (int)(($resizeHeight - $targetHeight) / 2);

                $this->load->library('wideimage/WideImage');
                $image = WideImage::load($this->uploadFolder . $info->file);
                // $image->resize($resizeWidth, $resizeHeight, 'outside')
                // ->crop($cropLeft, $cropTop, $targetWidth, $targetHeight)
                $image->saveToFile($this->uploadFolder . $info->file);
                die(json_encode($info));
            } else {
                $info                   = new stdClass();
                $info->message          = strip_tags($this->upload->display_errors());
                die(json_encode($info));
            }   
        }
    }
    public function update_file_name()
    {
        if ($this->input->is_ajax_request()) {
            $data['success'] = TRUE;
            $input = $this->input->post();
            foreach ($input['files'] as $file) {
                if (!$this->db->where('id', $file['id'])->update('user_files', ['label' => $file['name']])) {
                    $data['success'] = FALSE;
                }
            }
            die(json_encode($data));
        } else {
            show_404();
        }
    }
    public function create_file($id = FALSE)
    {
        if($this->input->is_ajax_request() AND $id AND is_numeric($id)) {
            if ($this->input->post('type')) {
                $info                   = new stdClass();
                $info->name             = 'video';
                $info->label            = '';
                $info->extension        = 'video';
                $info->user_id          = $id;
                $info->id               = $this->User->create_file($info);
                $info->url              = base_url($this->filesFolders['upload'] . $info->name);
                $info->thumbnailUrl     = $this->file_image('video');
                $info->deleteUrl        = base_url('admin/' . $this->module.'/delete_file/'. $info->id);
                $info->deleteType       = 'POST';
                $info                   = array($info);
                $result                 = new stdClass($info);
                $result->files          = $info;
                die(json_encode($result));
            }
            $config['upload_path']      = $this->filesFolders['upload'];
            $config['allowed_types']    = '*';
            $config['max_size']         = $this->filesProperties['max_file_size'] / 1000;
            $config['max_width']        = $this->filesProperties['max_width'];
            $config['max_height']       = $this->filesProperties['max_height'];
            $config['quality']          = '100%';
            $config['encrypt_name']     = $this->filesProperties['encrypted_name'];
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('file')) {
                $file                   = $this->upload->data();
                $info                   = new stdClass();
                $info->name             = $file['file_name'];
                $info->label            = $file['raw_name'];
                $info->w                = $file['image_width'];
                $info->h                = $file['image_height'];
                $info->extension        = str_replace('.', '', strtolower($file['file_ext']));
                if (in_array($info->extension, $this->filesProperties['extensions'])) {
                    if ($this->filesProperties['padding']) {
                        $image          = $this->padding($info);
                        $info->w        = $image->w;
                        $info->h        = $image->h;
                    }
                    $this->resize_large($info, $this->filesFolders['upload']);
                    copy($this->filesFolders['large'] . $info->name, $this->filesFolders['crop'] . $info->name);
                }
                $info->user_id          = $id;
                $info->id               = $this->User->create_file($info);
                $info->type             = $file['file_type'];
                $info->type             = $file['image_type'];
                $info->url              = base_url($this->filesFolders['upload'] . $info->name);
                if (in_array($info->extension, $this->filesProperties['extensions'])) {
                    $info->thumbnailUrl = base_url($this->filesFolders['small']  . $info->name);
                } else {
                    $info->thumbnailUrl = $this->file_image($info->extension);
                }
                $info->deleteUrl        = base_url('admin/' . $this->module.'/delete_file/'. $info->id);
                $info->deleteType       = 'POST';
                $info                   = array($info);
                $result                 = new stdClass($info);
                $result->files          = $info;
                die(json_encode($result));
            } else {
                $info                   = new stdClass();
                $info->error            = strip_tags($this->upload->display_errors());
                $info                   = array($info);
                $result                 = new stdClass();
                $result->files          = $info;
                die(json_encode($result));
            }   
        }
    }

    private function file_image($extension)
    {
        switch ($extension) {
            case 'xls':
            case 'xlsx':
                $image = 'xls.png';
            break;

            case 'doc':
            case 'docx':
                $image = 'doc.png';
            break;

            case 'ppt':
            case 'pptx':
                $image = 'ppt.png';
            break;

            case 'mp4':
                $image = 'mp4.png';
            break;

            case 'mp3':
                $image = 'mp3.png';
            break;

            case 'pdf':
                $image = 'pdf.png';
            break;

            case 'zip':
                $image = 'zip.png';
            break;

            case 'video':
                $image = 'mp4.png';
            break;
            
            default:
                $image = 'default.png';
            break;
        }
        return base_url($this->filesFolders['small']  . $image);
    }

    public function read_files($id = FALSE)
    {
        if($this->input->is_ajax_request() AND $id AND is_numeric($id)) {
            $data                   = array();
            $files                  = $this->User->read_files($id);
            foreach($files as $k    => $v) {
                if (in_array($v->extension, $this->filesProperties['extensions'])) {
                    $thumbnailUrl = base_url($this->filesFolders['small']  . $v->name);
                } else {
                    $thumbnailUrl = $this->file_image($v->extension);
                }
                $data[$k]           = (object) 
                array(
                    'thumbnailUrl'  => $thumbnailUrl,
                    'url'           => base_url($this->filesFolders['upload'] . $v->name),
                    'deleteUrl'     => base_url('admin/'.$this->module.'/delete_file/'. $v->id),
                    'name'          => $v->name,
                    'label'         => $v->label,
                    'position'      => $v->position,
                    'id'            => $v->id,
                    'x'             => $v->x,
                    'y'             => $v->y,
                    'x2'            => $v->x2,
                    'y2'            => $v->y2,
                    'w'             => $v->w,
                    'h'             => $v->h,
                    'deleteType'    => 'POST');
            }
            $data['files']          = $data;
            die(json_encode($data));
        }
    }

    private function delete_files($files)
    {
        foreach ($files as $v) {
            unlink($this->filesFolders['upload'] . $v->name);
            if($this->filesProperties['image']) {
                unlink($this->filesFolders['large'] . $v->name);
            }
            $this->User->delete_file($v->name); 
        }
    }

    public function delete_file($id = FALSE) {
        if($this->input->is_ajax_request() AND $file = $this->db->where('id', $id)->get('user_files')->row()) {
            $file = $file->name;
            $success                = @unlink($this->filesFolders['upload'] . $file);
            if($this->filesProperties['image']) {
                $success           .= @unlink($this->filesFolders['large']  . $file);
            }
            $this->User->delete_file($id);
            $info                   = new stdClass();
            $info->sucess           = $success;
            $info                   = array($info);
            $result                 = new stdClass();
            $result->files          = $info;
            die(json_encode($result));
        }
    }

    private function read_image_size($path, $name) {
        $v              = getimagesize($path.$name);
        $image          = new stdClass();
        $image->name    = $name;
        $image->w       = $v[0];
        $image->h       = $v[1];
        return $image;
    }

    public function update($id = FALSE)
    {
        if (is_numeric($id) AND $this->State->get_by_id($id)) {
            $this->create($id);
        } else {
            show_404();
        }
    }

    public function delete($id = FALSE)
    {
        if ($id AND is_numeric($id) AND $state = $this->State->get_by_id($id) AND $this->db->where('id', $id)->delete($this->table)) {
            $this->redirect();
        } else {
            show_404();
        }
    }

    public function redirect()
    {
        if (!$this->session->userdata($this->paginationSession)) {
            $data = [
                'field'     => 'id',
                'order'     => 'asc',
                'numrows'   => 10,
                'start'     => 0
            ];
        } else {
            $data = $this->session->userdata($this->paginationSession);
        }
        if ($this->input->post('numrows') AND is_numeric($data['numrows'])) {
            $data['numrows'] = $this->input->post('numrows') AND is_numeric($data['numrows']);
        }
        redirect('admin/' . $this->module . '/read/' . $data['field'] . '/' . $data['order'] . '/' . $data['numrows'] . '/' . $data['start']);
    }
}
