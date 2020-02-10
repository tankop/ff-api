<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class HotelModelMap extends MasterModel
{

    const ID = 'id';
    const NAME_SEARCH_ID = 'name_search_id';
    const ADDRESS = 'address';
    const CITY = 'city';
    const COUNTRY = 'country';
    const DISTANCE = 'distance';
    const HOTELCODE = 'hotelcode';
    const IS_SEARCHED_CITY = 'is_searched_city';
    const LAT = 'lat';
    const LON = 'lon';
    const NAME = 'name';
    const SOURCE = 'source';
    const STARS = 'stars';
    const DB_TABLE_NAME = 'hotel';
    const DB_CRUD_NAME = 'hotel_crud';
    protected $id;
    protected $name_search_id;
    protected $address;
    protected $city;
    protected $country;
    protected $distance;
    protected $hotelcode;
    protected $is_searched_city;
    protected $lat;
    protected $lon;
    protected $name;
    protected $source;
    protected $stars;
    protected $min_price;
    protected $max_price;

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

    public function getNameSearchId()
    {
        return $this->name_search_id;
    }

    public function setNameSearchId($name_search_id)
    {
        $this->name_search_id = $name_search_id;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    public function getHotelcode()
    {
        return $this->hotelcode;
    }

    public function setHotelcode($hotelcode)
    {
        $this->hotelcode = $hotelcode;
    }

    public function getIsSearchedCity()
    {
        return $this->is_searched_city;
    }

    public function setIsSearchedCity($is_searched_city)
    {
        $this->is_searched_city = $is_searched_city;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    public function getLon()
    {
        return $this->lon;
    }

    public function setLon($lon)
    {
        $this->lon = $lon;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function getStars()
    {
        return $this->stars;
    }

    public function setStars($stars)
    {
        $this->stars = $stars;
    }

    public function getMinPrice()
    {
        return $this->min_price;
    }

    public function setMinPrice($min_price)
    {
        $this->min_price = $min_price;
    }

    public function getMaxPrice()
    {
        return $this->max_price;
    }

    public function setMaxPrice($max_price)
    {
        $this->max_price = $max_price;
    }
}
