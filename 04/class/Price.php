<?php

class Price
{
    private $ean;
    private $price;


    /**
     * @param $ean
     * @param $price
     */
    public function __construct($ean, $price)
    {
        $this->ean = $ean;
        $this->price = $price;
    }


    /**
     * @return mixed
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * @param mixed $ean
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    #######################################################

    addNewPrice()
}