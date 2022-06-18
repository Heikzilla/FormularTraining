<?php

class Product
{

    private $ean;
    private $productName;
    private $category;

    /**
     * @param $ean
     * @param $productName
     * @param $category
     */
    public function __construct($ean = '', $productName = '', $category = '')
    {
        $this->setEan($ean);
        $this->setProductName($productName);
        $this->setCategory($category);
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
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @param mixed $productName
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

###################################################################

    public function newProductEntry()
    {
        $pdo = new PDO('mysql:dbname=04;host=127.0.0.1','root','');

        $sql = "INSERT INTO productitem (ean, ProductName, CategoryID) 
                VALUES (:var_ean, :var_categoryName, :var_categorieID)";

        $statement = $pdo->prepare($sql);

        $params = array(
            'var_ean' => $this->getEan(),
            'var_categoryName' => $this->getProductName(),
            'var_categorieID' => $this->getCategory()
        );

        try {
            $statement->execute($params);
        }catch (PDOException $exception){
            echo 'Verbindung fehlgeschlagen';
        }

        $countRow = $statement->rowCount();

        if ($countRow == 1){
            return true;
        }else{
            return false;
        }
    }

    public static function getAllProducts()
    {
        $sql = "SELECT productitem.EAN, productitem.ProductName, category.categoryName FROM `productitem` 
                LEFT JOIN category ON productitem.CategoryID = category.id;";

    }

}