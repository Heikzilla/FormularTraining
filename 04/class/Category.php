<?php

class Category
{
    private $id;
    private $category;

    /**
     * @param $id
     * @param $category
     */
    public function __construct($id ='', $category='')
    {
        $this->setId($id);
        $this->setCategory($category);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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

    ########################################################

    #newDBEntry
    public function newCategoryEntry()
    {
        $pdo = new PDO('mysql:dbname=04;host=127.0.0.1','root','');

        $sql = "INSERT INTO category (id, categoryName) 
                VALUES ('', :var_categoryName)";

        $statement = $pdo->prepare($sql);

        $statement->bindParam('var_categoryName', $this->getCategory());

        try {
            $statement->execute();
        }catch (PDOException $exception){

        }

        $countRow = $statement->rowCount();

        if ($countRow == 1){
            return true;
        }else{
            return false;
        }
    }

    #getAllDBEntrys
    public static function getAllDBEntrys()
    {
        $pdo = new PDO('mysql:dbname=04;host=127.0.0.1','root','');

        $sql = "SELECT * FROM `category`";

        $statement = $pdo->prepare($sql);

        try {
            $statement->execute();
        } catch (PDOException $exception) {

        }

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}