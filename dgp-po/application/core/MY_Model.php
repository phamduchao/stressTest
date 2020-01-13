<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    protected $_table_name = '';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval'; // method to filter primary key for more security


    function __construct()
    {
        parent::__construct();
    }

    public function get($id = NULL, $is_single = FALSE)
    {
        if ($id != NULL) {
            // filter for more security
            $filter = $this->_primary_filter;
            $id = $filter($id);

            $this->db->where($this->_primary_key, $id);
            $method = 'row';
        } else {
            if ($is_single == FALSE) {
                $method = 'result';
            } else {
                $method = 'row';
            }
        }

        // return
        return $this->db->get($this->_table_name)->$method();
    }

    public function get_by($where, $is_single = FALSE)
    {
        $this->db->where($where);
        return $this->get(NULL, $is_single);
    }

    public function save($data, $id = NULL)
    {
        if ($id < 1) {
            // insert
            !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
            $this->db->set($data);
            $this->db->insert($this->_table_name);

            $id = $this->db->insert_id();
        } else {
            // update
            !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = $id;

            // filter for more security
            $filter = $this->_primary_filter;
            $id = $filter($id);

            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);
        }

        return $id;
    }

    public function delete($id)
    {
        // filter for more security
        $filter = $this->_primary_filter;
        $id = $filter($id);

        if ($id < 1) {
            return FALSE;
        }

        $this->db->where($this->_primary_key, $id);
        $this->db->limit(1);
        $this->db->delete($this->_table_name);

        return $id;
    }

    public function delete_by($where)
    {

        if (empty($where)) {
            return FALSE;
        }

        $this->db->where($where);
        $this->db->delete($this->_table_name);

        return TRUE;
    }

    public function truncate_table(){
        $sql = "TRUNCATE `{$this->_table_name}`";
        $this->db->query($sql);
    }

    public function limit_data()
    {
        $where_str = '';
        $level = $this->session->userdata('level');
        $position = $this->session->userdata('position');
        $userID = $this->session->userdata('id');
        if ($level == 1) {
            if ($position == 1) {
                $where_str = " and u.id = '{$userID}' ";
            } elseif ($position == 2){
                $where_str = " and u.leaderID = '{$userID}' ";
            } elseif ($position == 3){
                $where_str = " and u.supID = '{$userID}' ";
            } elseif ($position == 4){
                $where_str = " and u.ssID = '{$userID}' ";
            } elseif ($position == 5){
                $where_str = " and u.asmID = '{$userID}' ";
            } elseif ($position == 6){
                $where_str = " and u.rsmID = '{$userID}' ";
            } else {

            }
        } elseif ($level == 8){
            $rsmPermit = $this->session->userdata('rsmPermit');
            $rsmPermit = json_decode($rsmPermit);
            if (!empty($rsmPermit)){
                $strIN = '('.implode(',', $rsmPermit).')';
                $where_str = " and u.rsmID IN {$strIN}";
            }

        }
        return $where_str;
    }

    public function get_array_for_select($table, $fieldValue = 'id', $fieldText = 'fullName', $selectedID = false, $where_str = null){
        $return = '';
        $sql = "select * from `$table` {$where_str}";
        $records = $this->db->query($sql)->result();
        foreach ($records as $record){
            $selected = '';
            if ("{$record->$fieldValue}" == "$selectedID") {
                $selected = 'selected';
            }
            $return .= "<option {$selected} value='{$record->$fieldValue}'>{$record->$fieldText}</option>";
        }
        return $return;
    }

}