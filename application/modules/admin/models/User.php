<?php
Class User extends CI_Model {

    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
        $this->table_files = 'user_files';
    }

    public function get($type, $field, $order, $numrows, $start, $search, $fields, $count, $state)
    {
        if ($type) {
            $this->db->where('user_type_id', $type);
        }
        $where = "(";
        foreach ($fields as $k => $v) {
            $where .= $v." LIKE '%".$search."%'";
            if (count($fields) != $k + 1) {
                $where .= " OR ";
            }
        }
        $where .= ")";
        $this->db->where($where);
        $this->db->where('creating_user_id is NULL', NULL, FALSE);
        
        if (is_numeric($state) AND $state > 0) {
            $this->db->where('user_state_id', $state);
        }

        $this->db->order_by($field, $order);
        if($numrows > 0) {
            $this->db->limit($numrows, $start);
        }
        $query = $this->db->get($this->table);
        if ($count) {
            return $query->num_rows();
        } else {
            $rows = $query->result();
            foreach ($rows as $k => $v) {
                $v->type = $this->db->where('id', $v->user_type_id)->get('user_types')->row();
            }
            return $rows;
        }
    }

    public function get_by_id($id)
    {
        if ($user = $this->db->where('id', $id)->get($this->table)->row()) {
            $user->type = $this->db->where('id', $user->user_type_id)->get('user_types')->row();
            return $user;
        }
        return FALSE;
    }

    public function authenticate($data)
    {
        if ($user = $this->db->where('email', $data['email'])
            ->where('password', sha1($data['password']))
            ->where('user_type_id', 1)
            ->where('creating_user_id', NULL)
            ->get($this->table)
            ->row()) {
            return $user;
        }
        return FALSE;
    }

    public function update_order($order)
    {
        foreach ($order as $k => $v) {
            $this->db->set('position', $k);
            $this->db->where('id', $v);
            $this->db->update($this->table_files);
        }
        return true;
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

    public function update_crop($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table_files, $data);
    }

    public function order($order) {
        foreach ($order as $k => $v) {
            $this->db->set('position', $k);
            $this->db->where('id', $v);
            $this->db->update($this->table_files);
        }
        return true;
    }
}