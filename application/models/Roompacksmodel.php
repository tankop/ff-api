<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class RoomPacksModel extends RoomPacksModelMap
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
        $object = RoomPacksModel::get()->getByBoardAndHotelCode($this->getBoard(), $this->getHotelCode());
        if ($object instanceof RoomPacksModel){
            $this->update([RoomPacksModel::BOARD, RoomPacksModel::HOTELCODE]);
        }else{
            $this->insert();
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function getByBoardAndHotelCode($board, $hotel_code){
        return $this->db->select()
            ->from($this->db_tablename)
            ->where(self::BOARD, $board)
            ->where(self::HOTELCODE, $hotel_code)
            ->get()->first_row(get_class($this));
    }
}
