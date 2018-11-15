<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Certificate extends CI_Controller {
    
    private $ci;

    public function __construct()
    {
        $this->ci = & get_instance();
    }

    private function user_in_course($course_id)
    {
        $user = $this->ci->session->userdata('User');
        if ($user->user_type_id == 3 OR $user->user_type_id == 2) {
            return TRUE;
        }
        if ($this->ci->db->where('course_id', $course_id)->where('user_id', $user->id)->get('course_users')->result()) {
            return TRUE;
        }
        $message = 'No dispone de suficientes privilegios de acceso para ejecutar esta operación. &nbsp;&nbsp; <input action="action" type="button" value="Volver a la página anterior" onclick="history.go(-1);" />';
        show_error($message, 403, 'Privilegios insuficientes');
    }
    
    public function Check()
    {
        $domain = $_SERVER['SERVER_NAME'];
        switch ($domain) {

            case 'capacitarte.com':
            case 'app.capacitarte.com':
            case 'app.plataformacursos.tb-stage.com.ar':
            case 'app.educacionadistancia.org':
                
                $this->ci->load->helper('url');
                $this->ci->load->library('session');
                $this->ci->load->model('Lesson');
                $this->ci->load->model('Course');
                $user       = $this->ci->session->userdata('User');
                $module     = 'app';
                $controller = strtolower($this->ci->uri->segment(2));
                $function   = strtolower($this->ci->uri->segment(3));
                $create     = FALSE;
                if (!$this->ci->input->is_ajax_request() AND 
                    $controller == 'lesson' AND 
                    is_numeric($function) AND 
                    $lesson = $this->ci->Lesson->get_by_id($function)) {
                    $course_id = $lesson->module->course_id;
                    $this->user_in_course($course_id);
                    $create = TRUE;
                }

                if (!$this->ci->input->is_ajax_request() AND 
                    $controller == 'course' AND 
                    $function == 'finalized' AND 
                    is_numeric($this->ci->uri->segment(4)) AND 
                    $course = $this->ci->Course->get_by_id($this->ci->uri->segment(4))) {
                    $course_id = $course->id;
                    $this->user_in_course($course_id);
                    $create = TRUE;
                }

                if (!$this->ci->input->is_ajax_request() AND 
                    $controller == 'forum' AND 
                    is_numeric($this->ci->uri->segment(3)) AND 
                    $course = $this->ci->Course->get_by_id($this->ci->uri->segment(3))) {
                    $course_id = $course->id;
                    $this->user_in_course($course_id);
                }

                if (!$this->ci->input->is_ajax_request() AND 
                    $controller == 'course' AND 
                    is_numeric($this->ci->uri->segment(3)) AND 
                    $course = $this->ci->Course->get_by_id($this->ci->uri->segment(3))) {
                    $course_id = $course->id;
                    $this->user_in_course($course_id);
                }

                if (!$this->ci->input->is_ajax_request() AND 
                    $controller == 'dashboard' AND 
                    is_numeric($function) AND 
                    $course = $this->ci->Course->get_by_id($function)) {
                    $course_id = $course->id;
                    $this->user_in_course($course_id);
                    $create = TRUE;
                }

                if (!$this->ci->input->is_ajax_request() AND 
                    $controller == 'lesson' AND 
                    $function == 'result' AND 
                    is_numeric($this->ci->uri->segment(4)) AND 
                    $lesson = $this->ci->Lesson->get_by_id($this->ci->uri->segment(4))) {
                    $course_id = $lesson->module->course_id;
                    $this->user_in_course($course_id);
                    $create = TRUE;
                }

                if ($create) {

                    $course = $this->ci->Course->get_by_id($course_id);
                    $user = $_SESSION['User'];
                    if ($course_certificate = $this->ci->db
                        ->where('course_id', $course_id)
                        ->where('user_id', $user->id)
                        ->get('course_certificates')
                        ->row()) {
                        return FALSE;
                    }

                    $progress                       = new stdClass();
                    $progress->lessons              = new stdClass();
                    $progress->exams                = new stdClass();

                    $progress->lessons->total       = 0;
                    $progress->exams->total         = 0;
                    $progress->lessons->completed   = 0;
                    $progress->exams->completed     = 0;

                    $course->modules = $this->ci->db->where('course_id', $course->id)->where('creating_user_id', NULL)->order_by('position', 'ASC')->get('course_modules')->result();

                    foreach ($course->modules as $k => $module) {

                        $lessons_module             = $this->ci->db->where('course_module_id', $module->id)->where('lesson_type_id <', 3)->where('creating_user_id', NULL)->order_by('position', 'ASC')->get('lessons')->num_rows();
                        $exams_module               = $this->ci->db->where('course_module_id', $module->id)->where('lesson_type_id', 3)->where('creating_user_id', NULL)->order_by('position', 'ASC')->get('lessons')->num_rows();
                        $progress->lessons->total   = $progress->lessons->total + $lessons_module;
                        $progress->exams->total     = $progress->exams->total + $exams_module;

                        $module->lessons            = $this->ci->db->where('course_module_id', $module->id)->where('creating_user_id', NULL)->order_by('position', 'ASC')->get('lessons')->result();
                        
                        $lessons_completed = $this->ci->db
                            ->select('lesson_users.id, course_module_id, completed')
                            ->where('user_id', $user->id)
                            ->where('completed', 1)
                            ->where('lesson_type_id <', 3)
                            ->where('lessons.course_module_id', $module->id)
                            ->join('lessons', 'lessons.id = lesson_users.lesson_id')
                            ->get('lesson_users')
                            ->num_rows();
                        $progress->lessons->completed = $progress->lessons->completed + $lessons_completed;

                        $exams_completed = $this->ci->db
                            ->select('lesson_users.id, course_module_id, completed')
                            ->where('user_id', $user->id)
                            ->where('completed', 1)
                            ->where('lesson_type_id', 3)
                            ->where('lessons.course_module_id', $module->id)
                            ->join('lessons', 'lessons.id = lesson_users.lesson_id')
                            ->get('lesson_users')
                            ->num_rows();
                        $progress->exams->completed = $progress->exams->completed + $exams_completed;
                    }

                    $progress->total        = $progress->lessons->total + $progress->exams->total;
                    $progress->completed    = $progress->lessons->completed + $progress->exams->completed;
                    if ($progress->total > 0) {
                        $progress->percentage   = round(($progress->completed * 100) / $progress->total);
                    } else {
                        $progress->percentage   = round(($progress->completed * 100));
                    }
                    if ($progress->percentage == 100) {
                        redirect('app/course/finalized/'.$course_id);
                    }
                }
                break;
                
        }
    }
}