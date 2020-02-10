<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MasterModel extends CI_Model
{

    protected $db_prefix;
    protected $class_name;
    protected $db_tablename;
    protected $db_fields;
    protected $json_data_path;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db_prefix = $this->db->dbprefix;
        $this->class_name = get_class($this);
    }

    public function getDbTableName()
    {
        return $this->db_tablename;
    }

    public function setDbTableName($db_tablename)
    {
        $this->db_tablename = $this->db_prefix . $db_tablename;
    }

    public function getDbFields()
    {
        return $this->db_fields;
    }

    public function setDbFields($db_fields)
    {
        $this->db_fields = $db_fields;
    }

    public function fromArray($array, $strict = false)
    {
        if (is_array($array) && !empty($array)) {
            foreach ($array as $key => $value) {
                if (!$strict) {
                    $this->$key = $value;
                } else {
                    if ($this->checkProperty($key)) {
                        $this->$key = $value;
                    }
                }
            }
        }
    }

    public function toArray($strict = false)
    {
        $array = get_object_vars($this);
        if ($strict) {
            foreach ($array as $key => $value) {
                if (!$this->checkProperty($key)) {
                    unset($array[$key]);
                }
            }
        }
        return $array;
    }

    public function save()
    {
        if (!isset($this->id) || !$this->id) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }

    public function insert()
    {
        $object_array = $this->toArray(true);
        $insert_data = array();
        foreach ($this->db_fields as $field) {
            if (isset($object_array[$field])) {
                $insert_data[$field] = $object_array[$field];
            }


            if (isset($object_array[$field]) && $object_array[$field] === 'NULL') {
                $insert_data[$field] = null;
            }
        }

        $this->db->insert($this->db_tablename, $insert_data);
        $insert_id = $this->db->insert_id();
        if ($this->checkProperty('id')) {
            $this->id = $insert_id;
        }
        return $insert_id;
    }

    public function update($pk = false)
    {
        $object_array = $this->toArray(true);

        $propery = 'id';
        if ($pk) {
            if (is_array($pk)){
                $propery = [];
                foreach ($pk as $pk_item){
                    if ($this->checkProperty($pk_item)) {
                        $propery[] = $pk_item;
                    }
                }
            }else{
                if ($this->checkProperty($pk)) {
                    $propery = $pk;
                }
            }
        }

        $update_data = array();
        foreach ($this->db_fields as $field) {
            if (isset($object_array[$field])) {
                $update_data[$field] = $object_array[$field];
            }
            if (isset($object_array[$field]) && ($object_array[$field] === 'NULL')) {
                $update_data[$field] = null;
            }
        }
        if (is_array($propery)){
            foreach ($propery as $property_tmp){
                $this->db->where($property_tmp, $this->$property_tmp);
            }
        }else{
            $this->db->where($propery, $this->$propery);
        }
        $this->db->update($this->db_tablename, $update_data);

        $aff_rows = $this->db->affected_rows();
        return $aff_rows;
    }

    public function checkProperty($property, $property_only = false)
    {
        if (is_string($property)) {
            if (!$property_only) {
                if (property_exists($this, $property) && in_array($property, $this->db_fields)) {
                    return true;
                }
            } else {
                if (property_exists($this, $property)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function checkTable()
    {
        if ($this->tableIsEmpty()) {
            if (file_exists($this->json_data_path)) {
                $data_array = json_decode(file_get_contents($this->json_data_path), true);
                if (!empty($data_array)) {
                    $this->db->trans_begin();
                    foreach ($data_array as $data) {
                        if ($this->db_fields == array_keys($data)) {
                            $this->db->insert($this->db_tablename, $data);
                        }
                    }
                    if ($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                    }
                }
            }
        }
    }

    private function tableIsEmpty()
    {
        return $this->db->select()
            ->from($this->db_tablename)
            ->count_all_results() == 0 ? true : false;
    }

    public function getAll($count = 0, $offset = 0, $where = false, $like = false, $order_by = false)
    {
        $this->db->select()
            ->from($this->db_tablename);
        if (is_array($where)) {
            foreach ($where as $field => $value) {
                if (in_array($field, $this->db_fields)) {
                    $this->db->where($field, $value);
                }
            }
        }
        if (is_array($order_by)){
            foreach ($order_by as $order_by_key => $order) {
                if (in_array($order_by_key, $this->db_fields)) {
                    $this->db->order_by($order_by_key, $order);
                }
            }
        }
        if ($count && is_numeric($count)) {
            if ($offset && is_numeric($offset)) {
                $this->db->limit($count, $offset);
            }
            $this->db->limit($count);
        }
        return $this->db->get()->result(get_class($this));
    }

    public function countAll($where = false){
        $this->db->select()
            ->from($this->db_tablename);
        if (is_array($where)) {
            foreach ($where as $field => $value) {
                if (in_array($field, $this->db_fields)) {
                    $this->db->where($field, $value);
                }
            }
        }

        return $this->db->count_all_results();
    }

    public function getById($id){
        return $this->db->select()
            ->from($this->db_tablename)
            ->where('id', $id)
            ->get()->first_row(get_class($this));
    }
}
