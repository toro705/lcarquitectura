<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class App {
    
    public function __construct()
    {
		log_message('debug', "Admin Class Initialized");
		require_once BASEPATH.'database/DB.php';
	    $this->db = DB('default', TRUE);
	    $this->ci = & get_instance();
	    !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
	    // $this->ci->load->model('User');
    }

	public function character_limiter_strip_tags($string, $n)
	{	
		return character_limiter(strip_tags($string), $n);
	}

	public function message($message, $state = 'success', $sticky = 'remove')
	{
		$icn = 'icn-23';
		if ($state == 'success') {
			$icn = 'icn-4';
		}
		return '<div class="boxup-container animated wow fadeInUp '.$sticky.'"><div class="boxup"><div class="circle-finished"><i class="icn '.$icn.'"></i></div><div class="boxup-data"><p>'.$message.'</p></div></div></div>';
	}

	public function session_update($id)
	{
        $this->ci->session->set_userdata('User', $this->ci->User->get_by_id($id));
	}

}