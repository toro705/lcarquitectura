<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {

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
        $this->module = 'users';
        $this->table = 'users';
        $this->load->model('User');
        $this->paginationSession = 'user_pagination';
        $this->uploadFolder = 'public/app/images/users/';
        $this->image['default'] = USER_IMAGE_DEFAULT;
        $this->moduleTitles = [
            'create' => [
                'title'  => '',
                'action' => 'Agregar'
            ],
            'read'   => [
                'title'  => '',
                'action' => 'Buscar / Editar',
            ],
            'update' => [
                'title'  => '',
                'action' => 'Editar'
            ]
        ];
        $this->fields = [
            'id',
            'first_name',
            'last_name',
            'email'
        ];
        $this->types = [
            1 => 'Administrador',
            2 => 'Proyecto',
            3 => 'Slider',
            4 => 'Listado de Proyectos'
        ];
        $this->views   = [
            'template_logged'   => 'templates/logged_view',
            'template_login'    => 'templates/login_view',
            'update'            => 'users/update_view',
            'read'              => 'users/read_view',
            'signin'            => 'users/sign_in_view',
            'detail'            => 'users/detail_view',
            'dashboards'        => 'dashboards/index_view',
            'courses'           => 'users/courses_view'
        ];
        $this->filesFolders     = [
            'upload'            => 'public/app/files/proyectos/original/', 
            'large'             => 'public/app/files/proyectos/large/',
            'medium'            => 'public/app/files/proyectos/medium/',
            'small'             => 'public/app/files/proyectos/small/',
            'crop'              => 'public/app/files/proyectos/crop/'
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
            'medium_width'      => 750,
            'small_width'       => 100,
            'max_number_files'  => 100,
            'max_file_size'     => 10048000000,
            'min_file_size'     => 100,
            'encrypted_name'    => TRUE,
            'accept_file_types' => 'jpg|jpeg|png'
        ];
        $this->filesProperties['max_height']    = round(($this->filesProperties['max_width']    / $this->filesProperties['aspect_ratio_x']) * $this->filesProperties['aspect_ratio_y']);
        $this->filesProperties['large_height']  = round(($this->filesProperties['large_width']  / $this->filesProperties['aspect_ratio_x']) * $this->filesProperties['aspect_ratio_y']);
        $this->filesProperties['medium_height'] = round(($this->filesProperties['medium_width'] / $this->filesProperties['aspect_ratio_x']) * $this->filesProperties['aspect_ratio_y']);
        $this->filesProperties['small_height']  = round(($this->filesProperties['small_width']  / $this->filesProperties['aspect_ratio_x']) * $this->filesProperties['aspect_ratio_y']);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="help-block has-error">', '</span>');
    }

	public function index()
	{
		$data['page_content'] = $this->load->view($this->views['update'], '', TRUE);
        $this->load->view($this->views['template_logged'], $data);
	}

    public function creating($type = FALSE)
    {
        if ($user = $this->db->where('creating_user_id', $_SESSION['User']->id)->where('updated >=', strtotime('-1 hour'))->order_by('id')->get('users')->row()) {
            $this->db->where('id', $user->id)->update($this->table, ['user_type_id' => $type, 'updated' => time()]);
            return $user->id;
        } else if ($user = $this->db->where('creating_user_id is NOT NULL', NULL, FALSE)->where('updated <=', strtotime('-1 hour'))->order_by('id')->get($this->table)->row()) {
            if ($user->image != $this->image['default']) {
                @unlink($this->uploadFolder . $user->image);
            }
            $this->db->where('id', $user->id)->update($this->table, ['creating_user_id' => $_SESSION['User']->id, 'user_type_id' => $type, 'image' => $this->image['default'], 'updated' => time()]);
            return $user->id;
        }
        $this->db->insert($this->table, ['user_type_id' => $type, 'creating_user_id' => $_SESSION['User']->id, 'updated' => time()]);
        return $this->db->insert_id();
    }

    public function create($type = FALSE, $id = FALSE)
    {
        if (!$user = $this->User->get_by_id($id)) {
            $user = $this->User->get_by_id($this->creating($type));
        }
        foreach ($user as $k => $v) {
            $data[$k] = $v;
        }
        $data['state'] = (!empty($data['state'])) ? TRUE : FALSE;
        if ($data['creating_user_id']) {
            $this->moduleTitles['create']['title'] = $this->types[$type];
            foreach ($this->moduleTitles['create'] as $k => $v) {
                $data[$k] = $v;
            }
        } else {
            $this->moduleTitles['update']['title'] = $this->types[$type];
            foreach ($this->moduleTitles['update'] as $k => $v) {
                $data[$k] = $v;
            }
        }

        if ($type AND in_array($type, array(1, 2, 3, 4))) {
            $user_types = $this->db->get('user_types')->result();
            foreach ($user_types as $k => $v) {
                $v->selected = ($v->id == $type)  ? TRUE : FALSE;
            }
            $data['user_types'] = $user_types;
            $data['type'] = $type;
            
            $origins = $this->db->get('user_origins')->result();
            foreach ($origins as $k => $v) {
                $v->selected = ($v->id == $user->user_origin_id)  ? TRUE : FALSE;
            }
            $data['origins'] = $origins;

            if ($type == 2) {
                $this->form_validation->set_rules('description', 'Biografía', 'required|min_length[10]');
                $this->form_validation->set_rules('user_origin_id', 'Origen', 'required');
            }
            if ($type == 3) {
            }
            if ($type == 4) {
            }
            $this->form_validation->set_rules('first_name', 'Nombre', 'required');
            $this->form_validation->set_rules('last_name', 'Apellido', 'required');
            if ($type == 1) {
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            }
            if ($data['email'] != $this->input->post('email')) {
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            }
            if($this->input->post('password') OR $this->input->post('password_confirm')) {
                $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[6]');
                $this->form_validation->set_rules('password_confirm', 'Repetir Contraseña', 'required|matches[password_confirm]');
            }

            $this->form_validation->set_rules('state', 'Activo');
            if ($this->form_validation->run()) {
                $user = $this->input->post();
                if ($type == 2) {
                    unset($user['password']);
                }
                if ($type == 3) {
                    unset($user['password']);
                }
                if ($type == 4) {
                    unset($user['password']);
                }
                if (empty($user['password'])) {
                    unset($user['password']);
                } else {
                    $user['password'] = sha1($user['password']);
                }
                unset($user['password_confirm']);
                $user['state'] = (!empty($user['state'])) ? 1 : 0;
                if ($data['creating_user_id']) {
                    $user['creating_user_id'] = NULL;
                    $user['created'] = time();
                    $user['updated'] = time();
                } else {
                    $user['updated'] = time();
                }
                $user['user_type_id'] = $type;
                $id = $data['id'];
                unset($user['id']);
                $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
                $this->db->where('id', $id)->update('users', $user);
                $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
               
                if ($_SESSION['User']->id == $id) {
                    $this->admin->session_update($id);
                }
                $order = 'asc';
                if ($type == 1 AND $data['creating_user_id']) {
                    $order = 'desc';
                }
                $this->session->set_userdata($this->paginationSession . '_' . $type, [
                    'type'    => $type,
                    'field'   => 'id',
                    'order'   => $order,
                    'numrows' => 10,
                    'start'   => 0
                ]);
                $user = $_SESSION['User'];
                switch ($type) {
                    case 2:
                        redirect('admin/users/read/2/id/asc/10/0');
                        break;
                    
                    case 4:
                        redirect('admin/dashboards');
                        break;
                    
                    default:
                        $this->redirect($type);
                        break;
                }
        
            }
            $data['module'] = $this->module;
            $data['page_content'] = $this->load->view($this->views['update'], $data, TRUE);
            $this->load->view($this->views['template_logged'], $data);
        } else {
            show_404();
        }
    }

    public function read($type = FALSE, $field = 'id', $order = 'asc', $numrows = 10, $start = 0)
    {
        if (!in_array($type, array_keys($this->types))) {
            show_404();
        }
        if (!in_array($field, $this->fields)) {
            $field = 'id';
        }
        $data = [
            'type'      => $type,
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
            $pagination = $this->session->userdata($this->paginationSession . '_' . $type);
            $data['search'] = '';
        }

        if ($state = $this->input->post('state')) {
            $data['state'] = $state;
            $data['start'] = 0;
        } else {
            $pagination = $this->session->userdata($this->paginationSession . '_' . $type);
            $data['state'] = '';
            // $data['state'] = $pagination['state'];
        }

        $this->session->set_userdata($this->paginationSession . '_' . $type, $data);



        $data['total_rows'] = $this->User->get($type, $field, $order, 0, 0, $data['search'], $this->fields, TRUE, $data['state']);
        $this->load->library('pagination');
        $config['base_url']     = base_url('admin/' . $this->module . '/read/' . $type . '/' . $field . '/' . $order . '/' . $numrows . '/');
        $config['total_rows']   = $data['total_rows'];
        $config['per_page']     = $numrows;
        $config['uri_segment']  = 8;
        $config['num_links']    = 2;
        $this->pagination->initialize($config);
        $data['session_pagination'] = $this->paginationSession . '_' . $type;
        $data['module'] = $this->module;
        $data['pagination'] = $this->pagination->create_links();
        $rows = $this->User->get($type, $field, $order, $numrows, $start, $data['search'], $this->fields, FALSE, $data['state']);
        $data['numrows'] = count($rows); 
        if ($this->uri->segment(8)) {
            $data['start_rows'] = $this->uri->segment(8);
        } else {
            $data['start_rows'] = 1;
        }
        $data['end_rows'] = $this->uri->segment(8) + $data['numrows'];
        $data['users'] = $rows;
        $this->moduleTitles['read']['title'] = $this->types[$type];
        foreach ($this->moduleTitles['read'] as $k => $v) {
            $data[$k] = $v;
        }
        $data['page_content'] = $this->load->view($this->views['read'], $data, TRUE);
        $this->load->view($this->views['template_logged'], $data);
    }

    public function update($type = FALSE, $id = FALSE)
    {
        $user = $_SESSION['User'];
        if ($user->user_type_id == 2 AND $this->uri->segment(5) != $user->id) {
            $message = 'No dispone de suficientes privilegios de acceso para ejecutar esta operación. &nbsp;&nbsp; <input action="action" type="button" value="Volver a la página anterior" onclick="history.go(-1);" />';
            show_error($message, 403, 'Privilegios insuficientes');
            return FALSE;
        }
        if ($user->user_type_id == 3 AND $this->uri->segment(5) != $user->id) {
            $message = 'No dispone de suficientes privilegios de acceso para ejecutar esta operación. &nbsp;&nbsp; <input action="action" type="button" value="Volver a la página anterior" onclick="history.go(-1);" />';
            show_error($message, 403, 'Privilegios insuficientes');
            return FALSE;
        }
        if ($user->user_type_id == 4 AND $this->uri->segment(5) != $user->id) {
            $message = 'No dispone de suficientes privilegios de acceso para ejecutar esta operación. &nbsp;&nbsp; <input action="action" type="button" value="Volver a la página anterior" onclick="history.go(-1);" />';
            show_error($message, 403, 'Privilegios insuficientes');
            return FALSE;
        }
        if (is_numeric($id) AND $this->User->get_by_id($id)) {
            $this->create($type, $id);
        } else {
            show_404();
        }
    }

    public function delete($id = FALSE)
    {
        if ($id AND is_numeric($id) AND $user = $this->User->get_by_id($id)) {
            $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
            $this->db->where('id', $user->id)->delete('users');
            $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
            if ($user->image != $this->image['default']) {
                @unlink($this->uploadFolder . $user->image);
            }
            $this->redirect($user->user_type_id);
        } else {
            show_404();
        }
    }

    public function view($id = FALSE)
    {
        if ($this->input->is_ajax_request() AND is_numeric($id) AND $user = $this->User->get_by_id($id)) {
            echo $this->load->view($this->views['detail'], $user);
        } else {
            show_404();
        }
    }

    public function redirect($type)
    {
        if (!in_array($type, array_keys($this->types))) {
            show_404();
        }
        if (!$this->session->userdata($this->paginationSession . '_' . $type)) {
            $data = [
                'type'      => $type,
                'field'     => 'id',
                'order'     => 'asc',
                'numrows'   => 10,
                'start'     => 0
            ];
        } else {
            $data = $this->session->userdata($this->paginationSession . '_' . $type);
        }
        if ($this->input->post('numrows') AND is_numeric($data['numrows'])) {
            $data['numrows'] = $this->input->post('numrows') AND is_numeric($data['numrows']);
        }
        redirect('admin/' . $this->module . '/read/' . $type . '/' . $data['field'] . '/' . $data['order'] . '/' . $data['numrows'] . '/' . $data['start']);
    }

    public function signIn()
    {
        $data = array();
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Contraseña', 'required');
        if ($this->form_validation->run()) {
            if ($user = $this->User->authenticate($this->input->post())) {
                $this->session->set_userdata('Menu', ['class' => 'sidebar-collapse']);
                $this->session->set_userdata('User', $user);
                redirect('admin/dashboards');
            } else {
                $data['message'][] = $this->admin->message('Los datos ingresados no son válidos.', 'warning', 'true');
            }
        }
        $data['page_content'] = $this->load->view($this->views['signin'], $data, TRUE);
        $this->load->view($this->views['template_login'], $data);
    }

    public function signout()
    {
        session_destroy();
        redirect('admin/users/signin');
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

    public function teachers()
    {
        if($this->input->is_ajax_request()) {
            $data['result'] = FALSE;
            if ($teachers = $this->db->select('id, first_name, last_name')->where('user_type_id', 2)->where('creating_user_id', NULL)->where('state', 1)->get('users')->result()) {
                $data['result'] = TRUE;
                $data['teachers'] = $teachers;
            }
            die(json_encode($data));
        } else {
            show_404();
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
                    $this->resize_medium($info);
                    $this->resize_small($info);
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
                unlink($this->filesFolders['crop'] . $v->name);
                unlink($this->filesFolders['large'] . $v->name);
                unlink($this->filesFolders['medium'] . $v->name);
                unlink($this->filesFolders['small'] . $v->name);
            }
            $this->User->delete_file($v->name); 
        }
    }

    public function delete_file($id = FALSE) {
        if($this->input->is_ajax_request() AND $file = $this->db->where('id', $id)->get('user_files')->row()) {
            $file = $file->name;
            $success                = @unlink($this->filesFolders['upload'] . $file);
            if($this->filesProperties['image']) {
                $success           .= @unlink($this->filesFolders['crop']  . $file);
                $success           .= @unlink($this->filesFolders['large']  . $file);
                $success           .= @unlink($this->filesFolders['medium'] . $file);
                $success           .= @unlink($this->filesFolders['small']  . $file);
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

    private function padding($image)
    {
        if ($image->w > $this->filesProperties['large_width']) {
            $this->load->library('wideimage/WideImage');
            $new_image  = WideImage::load($this->filesFolders['upload'] . $image->name);
            $new_image->resize($this->filesProperties['large_width'], $this->filesProperties['large_height'])->saveToFile($this->filesFolders['upload'] . $image->name);
            $image      = $this->read_image_size($this->filesFolders['upload'], $image->name);
        }
        $height         = ($image->w / $this->filesProperties['aspect_ratio_x']) * $this->filesProperties['aspect_ratio_y'];
        $width          = ($image->h / $this->filesProperties['aspect_ratio_y']) * $this->filesProperties['aspect_ratio_x'];
        $this->load->library('wideimage/WideImage');
        $new_image      = WideImage::load($this->filesFolders['upload'] . $image->name);
        $color          = $new_image->allocateColor(255, 255, 255);
        if($height > $image->h) {
            $diferencia = $height - $image->h;
            $new_image->resizeCanvas('100%', '100%+'.$diferencia, 0, $diferencia/2, $color)
            ->saveToFile($this->filesFolders['upload'] . $image->name);
        } else {
            $diferencia = $width  - $image->w;
            $new_image->resizeCanvas('100%+'.$diferencia, '100%', $diferencia/2, 0, $color)
            ->saveToFile($this->filesFolders['upload'] . $image->name);
        }
        return $this->read_image_size($this->filesFolders['upload'], $image->name);
    }

    public function update_crop($id = FALSE) 
    {
        if($this->input->is_ajax_request() AND $id AND is_numeric($id)) {
            $data['result']     = 1;
            $image              = new stdClass();
            foreach ($this->input->post('data') as $k => $v) {
                $image->$k      = $v;
            }
            $success            = $this->crop($image);
            $success           .= $this->resize_large($image, $this->filesFolders['crop']);
            $success           .= $this->resize_medium($image);
            $success           .= $this->resize_small($image);
            unset($image->w);
            unset($image->h);
            $success           .= $this->User->update_crop($id, $image);
            if(!$success) {
                $data['result'] = 0;
            }
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    private function crop($image)
    {
        $this->load->library('wideimage/WideImage');
        $new_image = WideImage::load($this->filesFolders['upload'] . $image->name);
        $new_image->crop(round($image->x), round($image->y), round($image->w), round($image->h))->saveToFile($this->filesFolders['crop'] . $image->name);
    }

    private function resize_large($image, $folder)
    {
        $this->load->library('wideimage/WideImage');
        $new_image = WideImage::load($folder . $image->name);
        $new_image->resize($this->filesProperties['large_width'], $this->filesProperties['large_height'])->saveToFile($this->filesFolders['large'] . $image->name);
    }

    private function resize_medium($image) 
    {
        $this->load->library('wideimage/WideImage');
        $new_image = WideImage::load($this->filesFolders['crop'] . $image->name);
        $new_image->resize($this->filesProperties['medium_width'], $this->filesProperties['medium_height'])->saveToFile($this->filesFolders['medium'] . $image->name);
    }

    private function resize_small($image) 
    {
        $this->load->library('wideimage/WideImage');
        $new_image = WideImage::load($this->filesFolders['crop'] . $image->name);
        $new_image->resize($this->filesProperties['small_width'], $this->filesProperties['small_height'])->saveToFile($this->filesFolders['small'] . $image->name);
    }

    public function update_order()
    {
        $data['result'] = 0;
        if ($this->input->is_ajax_request() AND $order = $this->input->post('order')) {
            if ($this->User->update_order($order)) {
                $data['result'] = 1;
            }
        }
        die(json_encode($data));
    }

    public function order()
    {
        if ($this->input->is_ajax_request() AND $positions = $this->input->post('positions') AND $module = $this->input->post('module')) {
            $positions = explode(',', $positions);
            $data['success'] = TRUE;
            unset($positions[0]);
            foreach ($positions as $k => $id) {
                if (!$this->db->where('id', $id)->update($this->table, ['course_module_id' => $module, 'position' => $k, 'updated' => time()])) {
                    $data['success'] = FALSE;
                }
            }
            die(json_encode($data));
        } else {
            show_404();
        }
    }
}
