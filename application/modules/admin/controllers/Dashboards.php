<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboards extends MX_Controller {

	public function __construct() 
	{
        parent::__construct();
        $this->views   = [
            'template_logged' => 'templates/logged_view',
            'index'           => 'dashboards/index_view',
        ];
    }

	public function index()
	{
        $data['photos']         = $this->db->get('user_files')->num_rows();
        $data['admins']         = $this->db->where('user_type_id', 1)->where('creating_user_id', NULL)->get('users')->num_rows();
        $data['proyectos']  = $this->db->where('user_type_id', 2)->where('creating_user_id', NULL)->get('users')->num_rows();
		$data['page_content'] = $this->load->view($this->views['index'], $data, TRUE);
        $this->load->view($this->views['template_logged'], $data);
	}

    public function menu_toggle()
    {
        if ($this->input->is_ajax_request()) {
            $state = $this->input->post('state');
            $data['success'] = TRUE;
            if (!$this->session->set_userdata('Menu', ['class' => $state])) {
                $data['success'] = FALSE;
            }
            die(json_encode($data));
        } else {
            show_404();
        }
    }
}