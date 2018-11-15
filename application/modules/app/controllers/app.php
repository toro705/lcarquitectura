<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends MX_Controller {

    private $module;
    private $table;
    private $moduleTitles;
    private $views;
    private $faker;
    private $types;
    private $fields;
    private $paginationSession;
    private $image;
    private $fileFolders;
    private $fileProperties;

	public function __construct() 
	{
 
    }

    public function index()
    {
        $this->load->view('main');

        $data['all_published_slider'] = $this->checkout_model->select_all_slider_info();
    }

    public function detail($id = FALSE)
    {
        if (is_numeric($id) AND $course = $this->Course->get_by_id($id)) {
            $user = $_SESSION['User'];
            $lessons_user = [];
            $course->modules = $this->db->where('course_id', $course->id)->where('creating_user_id', NULL)->order_by('position', 'ASC')->get('course_modules')->result();
            foreach ($course->modules as $k => $module) {

                $lessons_user[$k] = new stdClass();
                if ($lessons_user[$k]->user = $this->db
                        ->select('lesson_users.*, course_module_id, completed, name, lessons.position')
                        ->where('user_id', $user->id)
                        ->where('lessons.course_module_id', $module->id)
                        ->join('lessons', 'lessons.id = lesson_users.lesson_id')
                        ->where('completed', 1)
                        ->order_by('lessons.position', 'DESC')
                        ->get('lesson_users')
                        ->row()) {
                }

                if (!$module->lessons = $this->db->where('course_module_id', $module->id)->where('creating_user_id', NULL)->order_by('position', 'ASC')->get('lessons')->result()) {
                    show_404();
                }
                $total = count($module->lessons);
                $user = $_SESSION['User'];
                $completed = $this->db
                    ->select('lesson_users.id, course_module_id, completed')
                    ->where('user_id', $user->id)
                    ->where('completed', 1)
                    ->where('lessons.course_module_id', $module->id)
                    ->join('lessons', 'lessons.id = lesson_users.lesson_id')
                    ->get('lesson_users')
                    ->num_rows();
                $module->percentage = round(($completed * 100) / $total);
                foreach ($module->lessons as $lesson) {
                    switch ($lesson->lesson_type_id) {
                        case 1:
                            $icon = 'icn-12';
                            break;
                        case 2:
                            $icon = 'icn-12';
                            $lesson->movie = $this->db->where('lesson_id', $lesson->id)->get('lesson_movies')->row();
                            if ($lesson->movie->url) {
                                $url = explode('/', $lesson->movie->url);
                                $lesson->movie->movie_id = end($url);
                            }
                            break;
                        case 3:
                            $icon = 'icn-30';
                            break;
                    }
                    $lesson->icon = $icon;
                    $lesson->type = $this->db->where('id', $lesson->lesson_type_id)->get('lesson_types')->row();
                    $lesson->user = $this->db->where('user_id', $user->id)->where('lesson_id', $lesson->id)->get('lesson_users')->row();
                }
            }
            $data['course'] = $course;

            foreach ($lessons_user as $k => $v) {
                if (!isset($lessons_user[$k]->user)) {
                    if (isset($lessons_user[$k - 1]->user)) {
                        $current_lesson_user = $lessons_user[$k - 1];
                    }
                }
            }
            if (isset($current_lesson_user)) {
                if ($current_lesson     = $this->db->where('id', $current_lesson_user->user->lesson_id)->get('lessons')->row()) {
                    $this->load->module('app/lessons');
                    $activities         = $this->lessons->prev_next_lesson($current_lesson->id);
                    $data['activities'] = $activities;
                }
            }

        } else {
            show_404();
        }
        $this->session->set_userdata('Course', ['id' => $id]);
        $data['page_content'] = $this->load->view($this->views['detail'], $data, TRUE);
        $this->load->view($this->views['template_logged'], $data);   
    }

    public function dashboard($id = FALSE)
    {
        $data['module'] = $this->module;
        if (is_numeric($id) AND $course = $this->Course->get_by_id($id)) {
            $course->modules = $this->db->where('course_id', $course->id)->where('creating_user_id', NULL)->order_by('position', 'ASC')->get('course_modules')->result();
            foreach ($course->modules as $v) {
                $v->lessons = $this->db->where('course_module_id', $v->id)->where('creating_user_id', NULL)->order_by('position', 'ASC')->get('lessons')->result();
            }
            foreach ($course->modules as $v) {
                foreach ($v->lessons as $lesson) {
                    switch ($lesson->lesson_type_id) {
                        case 1:
                            $icon = 'icn-12';
                            break;
                        case 2:
                            $icon = 'icn-12';
                            break;
                        case 3:
                            $icon = 'icn-13';
                            break;
                    }
                    $lesson->icon = $icon;
                    $lesson->type = $this->db->where('id', $lesson->lesson_type_id)->get('lesson_types')->row();
                }
            }
            $data['course'] = $course;
        } else {
            show_404();
        }
        
        $data['page_content'] = $this->load->view($this->views['dashboard'], $data, TRUE);
        $this->load->view($this->views['template_logged'], $data);   
    }
    // app/course/certificate/2
    private function certificate($id = FALSE)
    {
        require APPPATH . 'libraries/fpdf/fpdf.php';
        $user   = $_SESSION['User'];
        $course = $this->Course->get_by_id($id);
        $border = 0;
        $align  = 'C';

        $pdf = new FPDF('L', 'mm', [297, 210]);
        
        $pdf->AddPage();

        $pdf->Image(base_url('public/app/img/certificado-2018.png'), 0, 0, 297, 210);
        
        $pdf->AddFont('ZurichCalligraphicItalic','B','ZurichCalligraphicItalic.php');
        $pdf->SetFont('ZurichCalligraphicItalic', 'B', 25);
        
        // $pdf->SetXY(46, 73);
        // $pdf->Cell(230.5, 7, utf8_decode($user->first_name . ' ' . $user->last_name), $border, 1, 'L');
        
        $pdf->SetXY(63.7, 72);
        $pdf->Cell(213, 7, utf8_decode($user->first_name . ' ' . $user->last_name), $border, 1, $align);
        
        // print_r(strlen('Curso Introductorio de Marketing Online: Herramientas para de'));
        // exit;

        // $course->name = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore perferendis ratione ex quidem cumque eius voluptatum aperiam laboriosam recusandae placeat';
        $length = strlen($course->name);
        // Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi volupta
        // Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi voluptate dolore provident, atqu
        // Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore perferendis ratione ex quidem cumque eius voluptatum aperiam laboriosam recusandae placeat, ducimus distinctio soluta sequi consequuntur nobis mollitia tempora, quos consequatur nobis mo
        // Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore perferendis ratione ex quidem cumque eius voluptatum aperiam laboriosam recusandae placeat
        // print_r($length);
        // exit;

        if ($length <= 70) {

            $pdf->SetFont('ZurichCalligraphicItalic', 'B', 24);
            $pdf->SetXY(63.7, 85.6);
            $pdf->Cell(213, 7, utf8_decode($course->name), $border, 1, $align);

        } else if ($length > 70 AND $length <= 95) {

            $pdf->SetFont('ZurichCalligraphicItalic', 'B', 18);
            $pdf->SetXY(63.7, 86);
            $pdf->Cell(213, 7, utf8_decode($course->name), $border, 1, $align);

        } else {

            $course->name = explode(' ', $course->name);
            $words_length = count($course->name);
            $words_length_medium = round($words_length / 2);
            $course->name = array_chunk($course->name, $words_length_medium);
            $course->name[0] = implode(' ', $course->name[0]);
            $course->name[1] = implode(' ', $course->name[1]);

            $pdf->SetFont('ZurichCalligraphicItalic', 'B', 18);

            $pdf->SetXY(63.7, 81);
            $pdf->Cell(213, 5, utf8_decode($course->name[0]), $border, 1, $align);

            $pdf->SetXY(63.7, 87);
            $pdf->Cell(213, 5, utf8_decode($course->name[1]), $border, 1, $align);

        }

        $pdf->SetFont('ZurichCalligraphicItalic', 'B', 25);

        $pdf->SetXY(27, 98.5);
        $pdf->Cell(43, 7, $course->duration, $border, 1, $align);

        setlocale(LC_ALL, 'es_ES');
        $date           = [];
        $string         = date('d/m/Y', time());
        $month          = DateTime::createFromFormat('d/m/Y', $string);
        $date['month']  = ucwords(strftime('%B', $month->getTimestamp()));
        $date['day']    = date('m', time());
        $date['year']   = date('Y', time());

        $pdf->SetXY(102, 126);
        $pdf->Cell(25, 7, $date['day'], $border, 1, $align);

        $pdf->SetXY(138, 126);
        $pdf->Cell(52.5, 7, $date['month'], $border, 1, $align);

        $pdf->SetXY(201.5, 126);
        $pdf->Cell(34, 7, $date['year'], $border, 1, $align);

        $pdf_blob = $pdf->Output("", "S");
        $jpg_blob = new Imagick();
        $jpg_blob->readimageblob($pdf_blob);
        if (!$this->db->where('user_id', $user->id)->where('course_id', $course->id)->get('course_certificates')->row()) {
            $this->db->insert('course_certificates', [
                'user_id'   => $user->id,
                'course_id' => $course->id,
                'pdf'       => $pdf_blob,
                'jpg'       => $jpg_blob->getimageblob(),
                'created'   => time()
                ]
            );
            $this->db->where('user_id', $user->id)->where('course_id', $course->id)->update('course_users', ['finalized' => time()]);
        }
        // echo '<object data="data:application/pdf;base64,'.base64_encode($pdf_blob).'" type="application/pdf" width="100%" height="100%"></object>';
    }
    
    public function finalized($id = FALSE)
    {
        if ($id AND is_numeric($id) AND $data['course'] = $this->Course->get_by_id($id)) {
            $this->certificate($id);
            $data['page_content'] = $this->load->view($this->views['finalized'], $data, TRUE);
            $this->load->view($this->views['template_logged'], $data);
        } else {
            show_404();
        }
    }

    public function certificates()
    {
        // $certificates = $this->db->select('id, course_id, user_id, created')->where('user_id', $_SESSION['User']->id)->get('course_certificates')->result();
        $certificates = $this->db->where('user_id', $_SESSION['User']->id)->get('course_certificates')->result();
        foreach ($certificates as $k => $v) {
            $v->course = $this->Course->get_by_id($v->course_id);
        }
        $data['certificates'] = $certificates;
        $data['page_content'] = $this->load->view($this->views['certificates'], $data, TRUE);
        $this->load->view($this->views['template_logged'], $data);
    }

    public function certificateDownload($id = FALSE)
    {
        if ($id AND is_numeric($id) AND $certificate = $this->db->where('course_id', $id)->where('user_id', $_SESSION['User']->id)->get('course_certificates')->row()) {
            header('Content-Type: application/pdf');
            header('Content-Length: '.strlen($certificate->pdf));
            header('Content-Disposition: attachment; filename=certificado.pdf');
            print $certificate->pdf;
        } else {
            show_404();
        }   
    }

    public function certificate_download($id = FALSE)
    {
        if ($id AND is_numeric($id) AND $certificate = $this->db->where('id', $id)->get('course_certificates')->row()) {
            header('Content-Type: application/pdf');
            header('Content-Length: '.strlen($certificate->pdf));
            header('Content-Disposition: attachment; filename=certificado.pdf');
            print $certificate->pdf;
        } else {
            show_404();
        }   
    }
}