<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sessions extends CI_Controller {
    
    private $ci;

    public function __construct()
    {
        $this->ci = & get_instance();
    }
    
    public function Check()
    {
        $domain = $_SERVER['SERVER_NAME'];
        switch ($domain) {

            case 'www.admin.lcarquitectura.com.ar':
            case 'admin.lcarquitectura.com.ar':
                
                // die('Admin Session');
                // $this->ci->load->helper('url');
                // $this->ci->load->library('session');
                // $user       = $this->ci->session->userdata('User');
                // $module     = strtolower($this->ci->uri->segment(1));
                // $module     = 'admin';
                // $controller = strtolower($this->ci->uri->segment(2));
                // $function   = strtolower($this->ci->uri->segment(3));

                // if ($user AND $user->user_type_id == 1) {
                //     $excludes = [
                //         [
                //             'controller' => 'users',
                //             'function'   => 'signout'
                //         ],
                //         [
                //             'controller' => 'users',
                //             'function'   => 'signin'
                //         ],
                //         [
                //             'controller' => 'dashboards',
                //             'function'   => 'menu_toggle'
                //         ]
                //     ];
                //     $redirect = TRUE;
                //     foreach ($excludes as $exclude) {
                //         if ($exclude['controller'] == $controller AND $exclude['function'] == $function) $redirect = FALSE;
                //     }
                //     if ($redirect) redirect($module . '/dashboards');
                    // $access = TRUE;
                    // if ($access) {
                    //     $message = 'No dispone de suficientes privilegios de acceso para ejecutar esta operación. &nbsp;&nbsp; <input action="action" type="button" value="Volver a la página anterior" onclick="history.go(-1);" />';
                    //     show_error($message, 403, 'Privilegios insuficientes');
                    //     return FALSE;
                    // }
                // }

                // $excludes = [
                //     [
                //         'controller' => 'users',
                //         'function'   => 'signin'
                //     ],
                //     [
                //         'controller' => 'users',
                //         'function'   => 'signout'
                //     ]
                // ];
                // if (!$user) {
                //     $redirect = TRUE;
                //         foreach ($excludes as $exclude) {
                //             if ($exclude['controller'] == $controller AND $exclude['function'] == $function) $redirect = FALSE;
                //         }
                //         if ($redirect) redirect($module . '/users/signout');

                // } else {
                //     if ($user->user_type_id == 1) {
                //         if ($controller == '' AND $function == '') redirect($module . '/dashboards');
                //         if ($controller == 'users' AND $function == 'signin') redirect($module . '/dashboards');
                //     } else {
                //         session_destroy();
                //         redirect('admin/users/signin');
                //     }
                // }

                break;
            case 'www.lcarquitectura.com.ar':
            case 'lcarquitectura.com.ar':
            
                break;
            
            default:

                // die('Default Session asd');

                break;
        }
    }
}