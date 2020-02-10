<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by Tankó Péter
 */
class RoomPacksModelMap extends MasterModel
{

    const BOARD = 'board';
    const CANCELABLE = 'cancelable';
    const HOTELCODE = 'hotelCode';
    const PPRICE = 'pprice';
    const PRICE = 'price';
    const MARKET_PRICE = 'market_price';
    const PROCESSID = 'processId';
    const SOURCE = 'source';
    const SZPPLY = 'supply';
    const DB_TABLE_NAME = 'roompacks';

    protected $board;
    protected $cancelable;
    protected $hotelCode;
    protected $pprice;
    protected $price;
    protected $market_price;
    protected $processId;
    protected $source;
    protected $supply;


    function __construct()
    {
        parent::__construct();
        $this->setDbTablename(self::DB_TABLE_NAME);
        $this->db_fields = $this->db->list_fields($this->db_tablename);
    }

    public function getBoard()
    {
        return $this->board;
    }

    public function setBoard($board)
    {
        $this->board = $board;
    }

    public function getCancelable()
    {
        return $this->cancelable;
    }

    public function setCancelable($cancelable)
    {
        $this->cancelable = $cancelable;
    }

    public function getHotelCode()
    {
        return $this->hotelCode;
    }

    public function setHotelCode($hotelCode)
    {
        $this->hotelCode = $hotelCode;
    }

    public function getPprice()
    {
        return $this->pprice;
    }

    public function setPprice($pprice)
    {
        $this->pprice = $pprice;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getMarketPrice()
    {
        return $this->market_price;
    }

    public function setMarketPrice($market_price)
    {
        $this->market_price = $market_price;
    }

    public function getProcessId()
    {
        return $this->processId;
    }

    public function setProcessId($processId)
    {
        $this->processId = $processId;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function getSupply()
    {
        return $this->supply;
    }

    public function setSupply($supply)
    {
        $this->supply = $supply;
    }
}
