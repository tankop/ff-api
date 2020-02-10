<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class HotelModel extends HotelModelMap
{

    function __construct()
    {
        parent::__construct();
    }

    public static function get()
    {
        return new self;
    }

    public function save()
    {
        $this->db->trans_begin();
        $hotel = HotelModel::get()->getById($this->getId());
        if ($hotel instanceof HotelModel){
            $this->update();
        }else{
            $this->insert();
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function getAll($count = 0, $offset = 0, $where = false, $like = false, $order_by = false)
    {
        $this->db_tablename = self::DB_CRUD_NAME;
        return parent::getAll($count, $offset, $where, $like, $order_by);
    }
}
