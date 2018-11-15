<?php
Class Slider extends CI_Model {

    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'states';
    }

    public function get($field, $order, $numrows, $start, $search, $fields, $count)
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
        $this->db->order_by($field, $order);
        if($numrows > 0) {
            $this->db->limit($numrows, $start);
        }
        $query = $this->db->get($this->table);
        if ($count) {
            return $query->num_rows();
        } else {
            $rows = $query->result();
            return $rows;
        }
    }

    public function get_by_id($id)
    {
        if ($row = $this->db->where('id', $id)->get($this->table)->row()) {
            return $row;
        }
        return FALSE;
    }

    public function create_file($data)
    {
        $this->db->insert($this->table_files, $data);
        return  $this->db->insert_id();
    }

    public function read_files($lesson_id) {
        $this->db->where('user_id', $lesson_id);
        $this->db->order_by('position', 'asc');
        $query = $this->db->get($this->table_files);
        return $query->result();
    }

    public function delete_file($id) {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->delete($this->table_files);
        return $this->db->affected_rows();
    }

}