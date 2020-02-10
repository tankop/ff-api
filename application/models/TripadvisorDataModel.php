<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class TripadvisorDataModel extends TripadvisorDataModelMap
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
        $object = TripadvisorDataModel::get()->getById($this->getId());
        if ($object instanceof TripadvisorDataModel){
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
}
