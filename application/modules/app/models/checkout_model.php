<?php
Class Checkout_Model extends CI_Model {

    protected $table;
    public function select_all_slider_info() {
        $this->db->select('*');
        $this->db->from('tbl_slider');
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }
    public function __construct()
    {
        parent::__construct();
        $this->table = 'courses';
    }

    public function get_by_id($id)
    {
        if ($course = $this->db->where('id', $id)->get($this->table)->row()) {
            return $course;
        }
        return FALSE;
    }

    public function search($field, $order, $numrows, $start, $search, $fields, $count)
    {
        $where = "(";
        foreach ($fields as $k => $v) {
            $where .= $v." LIKE '%".$search."%'";
            if (count($fields) != $k + 1) {
                $where .= " OR ";
            }
        }
        $where .= ")";
        $this->db->where($where);
        $this->db->where('id >', 1);
        $this->db->where('creating_user_id is NULL', NULL, FALSE);
        $this->db->order_by($field, $order);
        if($numrows > 0) {
            $this->db->limit($numrows, $start);
        }
        $query = $this->db->get($this->table);
        if ($count) {
            $rows = $query->num_rows();
        } else { 
            $rows = $query->result();
            foreach ($rows as $k => $v) {
                $v->user_count = $this->db->where('course_id', $v->id)->get('course_users')->num_rows();
            }
        }
        return $rows;
    }

    public function delete($course)
    {
        $result['success'] = TRUE;
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $course->modules = $this->db->where('course_id', $course->id)->get('course_modules')->result();
        foreach ($course->modules as $module) {
            $module->lessons = $this->db->where('course_module_id', $module->id)->get('lessons')->result();
            foreach ($module->lessons as $lesson) {
                $lesson->files = $this->db->where('lesson_id', $lesson->id)->get('lesson_files')->result();
                foreach ($lesson->files as $file) {
                    @unlink('public/app/files/lessons/original/'.$file->name);
                    @unlink('public/app/files/lessons/large/'   .$file->name);
                    @unlink('public/app/files/lessons/medium/'  .$file->name);
                    @unlink('public/app/files/lessons/small/'   .$file->name);
                    @unlink('public/app/files/lessons/crop/'    .$file->name);
                }
                if (!$this->db->where('lesson_id', $lesson->id)->delete('lesson_files')) {
                    $result['success'] = FALSE;
                }
                switch ($lesson->lesson_type_id) {
                    case 1:
                        if (!$this->db->where('lesson_id', $lesson->id)->delete('lesson_texts')) {
                            $result['success'] = FALSE;
                            $result['errors'][] = 'lesson_id';
                        }
                        break;
                    case 2:
                        $lesson->movie = $this->db->where('lesson_id', $lesson->id)->get('lesson_movies')->row();
                        if (!$this->db->where('lesson_movie_id', $lesson->movie->id)->delete('lesson_movie_concepts')) {
                            $result['success'] = FALSE;
                            $result['errors'][] = 'lesson_movie_concepts';
                        }
                        if (!$this->db->where('lesson_id', $lesson->id)->delete('lesson_movies')) {
                            $result['success'] = FALSE;
                            $result['errors'][] = 'lesson_movies';
                        }
                        break;
                    case 3:
                        $lesson->exam = $this->db->where('lesson_id', $lesson->id)->get('lesson_exams')->row();
                        $lesson->exam->questions = $this->db->where('lesson_exam_id', $lesson->exam->id)->get('questions')->result();
                        foreach ($lesson->exam->questions as $question) {
                            $question->options = $this->db->where('question_id', $question->id)->get('question_options')->result();
                            foreach ($question->options as $option) {
                                if (!$this->db->where('question_option_id', $option->id)->delete('question_answers')) {
                                    $result['success'] = FALSE;
                                    $result['errors'][] = 'question_answers';
                                }
                            }
                            if (!$this->db->where('question_id', $question->id)->delete('question_options')) {
                                $result['success'] = FALSE;
                                $result['errors'][] = 'question_options';
                            }
                        }
                        if (!$this->db->where('lesson_exam_id', $lesson->exam->id)->delete('questions')) {
                            $result['success'] = FALSE;
                            $result['errors'][] = 'questions';
                        }
                        if (!$this->db->where('lesson_id', $lesson->id)->delete('lesson_exams')) {
                            $result['success'] = FALSE;
                            $result['errors'][] = 'lesson_exams';
                        }
                        break;
                    default:
                        die('Course Model, delete, switch: default');
                        break;
                }
            }
            if (!$this->db->where('course_id', $course->id)->delete('course_modules')) {
                $result['success'] = FALSE;
                $result['errors'][] = 'course_modules';
            }
        }
        if (!$this->db->where('id', $course->id)->delete('courses')) {
            $result['success'] = FALSE;
            $result['errors'][] = 'courses';
        }
        $course->forum = $this->db->where('course_id', $course->id)->get('forums')->row();
        $course->forum->questions = $this->db->where('forum_id', $course->forum->id)->get('forum_questions')->result();
        foreach ($course->forum->questions as $question) {
            if (!$this->db->where('forum_question_id', $question->id)->delete('forum_answers')) {
                $result['success'] = FALSE;
                $result['errors'][] = 'forum_answers';
            }
            if (!$this->db->where('forum_question_id', $question->id)->delete('forum_question_views')) {
                $result['success'] = FALSE;
                $result['errors'][] = 'forum_question_views';
            }
        }
        if (!$this->db->where('course_id', $course->id)->delete('forums')) {
            $result['success'] = FALSE;
            $result['errors'][] = 'forums';
        }
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return $result;
    }

    public function update_crop($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
}