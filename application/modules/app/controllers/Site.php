<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MX_Controller {


	public function __construct() 
	{
        parent::__construct();

    }

    public function index()
    {
        $id = 35;
        if ( $id and is_numeric($id) and $slider = $this->db->where('creating_user_id', NULL)->where('id', $id)->get('users')->row()) {

            // echo "<pre>";
            // print_r($data['work']);
            // echo "</pre>";
            $slider->images = $this->db->where('user_id',  $slider->id)->order_by('position', 'ASC')->get('user_files')->result();
            $data['slider'] =  $slider;

        $this->load->view('main', $data, FALSE);
        } else {
            show_404();
        }
    }

    public function proyectos() {
        $proyectos = $this->db->where('creating_user_id', NULL)->where('user_type_id', 2)->where('state', 1)->order_by("position", "asc")->get('users')->result();
        $listadoproyectos = $this->db->where('creating_user_id', NULL)->where('user_type_id', 4)->order_by("position", "asc")->get('users')->result();
         $data['proyectos'] =  $proyectos;
         $data['listadoproyectos'] =  $listadoproyectos;
        $this->load->view('proyectos', $data, FALSE);

    }
    public function proyecto($id)
    {

        if ( $id and is_numeric($id) and $proyecto = $this->db->where('creating_user_id', NULL)->where('id', $id)->get('users')->row()) {

            // echo "<pre>";
            // print_r($data['work']);
            // echo "</pre>";
            $proyecto->images = $this->db->where('user_id',  $proyecto->id)->order_by('position', 'ASC')->get('user_files')->result();
            $data['proyecto'] =  $proyecto;

            $this->load->view('proyecto', $data, FALSE);
        } else {
            show_404();
        }
    } 
    public function listadoproyecto($id)
    {

        if ( $id and is_numeric($id) and $proyecto = $this->db->where('creating_user_id', NULL)->where('id', $id)->get('users')->row()) {

            // echo "<pre>";
            // print_r($data['work']);
            // echo "</pre>";
            $proyecto->images = $this->db->where('user_id',  $proyecto->id)->get('user_files')->result();
            $data['proyecto'] =  $proyecto;

            $this->load->view('listadoproyecto', $data, FALSE);
        } else {
            show_404();
        }
    }        
    public function estudio() {
        $this->load->view('estudio', FALSE);

    }
    public function contacto() {
        $data['success'] = FALSE;
        // llamada dependencias form
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="text-danger ">', '</p>');

        // reglas form
        $this->form_validation->set_rules('name', 'Nombre y Apellido', 'required|min_length[5]');   
        $this->form_validation->set_rules('email', 'Email', 'required|min_length[8]');   
        $this->form_validation->set_rules('subject', 'Asunto', 'required|min_length[8]');   
        $this->form_validation->set_rules('description', 'Mensaje', 'required|min_length[8]');   

        // send form
        if ($this->form_validation->run()) {
            $dataform = $this->input->post();
            $data['dataform'] = $dataform;
            $this->load->library('email', [
                'crlf'      => "\r\n",
                'newline'   => "\r\n",
                'mailtype'  => 'html',
                'charset'   => 'utf-8',
                'wordwrap'  => TRUE,
                'priority'  => 1
                ]
            );
            $this->email->from('no-reply@c0590484.ferozo.com');
            $this->email->to('info@lcarquitectura.com.ar');
            $this->email->subject('Nueva Inscripción');
            $message = $this->load->view('email', $data, TRUE);
            $this->email->message($message);
            if ($this->email->send()) {
                // se envio el email
                $data['success'] = TRUE;
                $data['mensaje'] = '<h3 style="background: #40b440b3;display: inline-block;clear: both;padding: 10px;color: #E3E3E3;border-radius: 6px;">¡Mensaje Enviado!</h3>';
            }            
        }

        // load view
        $this->load->view('contacto', $data, FALSE);

    }


}