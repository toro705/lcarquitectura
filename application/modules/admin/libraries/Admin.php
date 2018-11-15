<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin {
    
    public function __construct()
    {
		log_message('debug', "Admin Class Initialized");
		require_once BASEPATH.'database/DB.php';
	    $this->db = DB('default', TRUE);
	    $this->ci = & get_instance();
	    !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
	    $this->ci->load->model('User');
    }

	public function character_limiter_strip_tags($string, $n)
	{	
		return character_limiter(strip_tags($string), $n);
	}

	public function message($message, $state = 'success', $sticky = 'false')
	{
		return '<script type="text/javascript">toastr.'.$state.'('.json_encode($message).')</script>';
	}

	public function session_update($id)
	{
        $this->ci->session->set_userdata('User', $this->ci->User->get_by_id($id));
	}

	public function teacher_privileges($course_id = FALSE, $privilege = FALSE)
	{
		$user = $this->ci->session->userdata('User');
		if ($user->user_type_id == 2) {
	        if ($course_id AND $this->ci->db->where('course_id', $course_id)->where('user_id', $user->id)->get('course_users')->result()) {
	        	return TRUE;
	        } else {
	        	if ($privilege) {
		            $message = 'No dispone de suficientes privilegios de acceso para ejecutar esta operación. &nbsp;&nbsp; <input action="action" type="button" value="Volver a la página anterior" onclick="history.go(-1);" />';
		            show_error($message, 403, 'Privilegios insuficientes');
	        	}
	            return FALSE;
	        }
		}
	}

}