<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Platforms extends MX_Controller {

	public function __construct() 
	{
        parent::__construct();
    }

    public function index()
    {
        $domain = $_SERVER['SERVER_NAME'];
        // echo $domain;
        // die();
        switch ($domain) {

            case 'www.admin.lcarquitectura.com.ar':
            case 'admin.lcarquitectura.com.ar':
                echo modules::run('admin/users/signIn');
                break;

            default:
                
                echo modules::run('app/site/index');
                break;

        }
    }
}