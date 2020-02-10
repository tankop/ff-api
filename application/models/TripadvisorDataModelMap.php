<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class TripadvisorDataModelMap extends MasterModel
{

    const ID = 'id';
    const HOTEL_ID = 'hotel_id';
    const AVGRATING = 'avgrating';
    const RANKING = 'ranking';
    const RATINGIMAGE = 'ratingimage';
    const REVIEWCNT = 'reviewcnt';
    const URL = 'url';
    const DB_TABLE_NAME = 'tripadvisor';
    protected $id;
    protected $hotel_id;
    protected $avgrating;
    protected $ranking;
    protected $ratingimage;
    protected $reviewcnt;
    protected $url;

    function __construct()
    {
        parent::__construct();
        $this->setDbTablename(self::DB_TABLE_NAME);
        $this->db_fields = $this->db->list_fields($this->db_tablename);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getHotelId()
    {
        return $this->hotel_id;
    }

    public function setHotelId($hotel_id)
    {
        $this->hotel_id = $hotel_id;
    }

    public function getAvgrating()
    {
        return $this->avgrating;
    }

    public function setAvgrating($avgrating)
    {
        $this->avgrating = $avgrating;
    }

    public function getRanking()
    {
        return $this->ranking;
    }

    public function setRanking($ranking)
    {
        $this->ranking = $ranking;
    }

    public function getRatingimage()
    {
        return $this->ratingimage;
    }

    public function setRatingimage($ratingimage)
    {
        $this->ratingimage = $ratingimage;
    }

    public function getReviewcnt()
    {
        return $this->reviewcnt;
    }

    public function setReviewcnt($reviewcnt)
    {
        $this->reviewcnt = $reviewcnt;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }
}
