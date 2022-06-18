<?php

class Article
{
    private $id;
    private $titel;
    private $eintrag;
    private $timestamp;

    /**
     * @param $titel
     * @param $eintrag
     */
    public function __construct($id = '', $titel = '', $eintrag = '')
    {
        $this->setId($id);
        $this->setTitel($titel);
        $this->setEintrag($eintrag);
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
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * @param mixed $titel
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;
    }

    /**
     * @return mixed
     */
    public function getEintrag()
    {
        return $this->eintrag;
    }

    /**
     * @param mixed $eintrag
     */
    public function setEintrag($eintrag)
    {
        $this->eintrag = $eintrag;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    ########################################################################

    private function connect2DB(){
        $dsn = 'mysql:dbname=05;host=127.0.0.1';
        $user = 'root';
        $password = '';

        return new PDO($dsn, $user, $password);
    }

    public function newEntry(){

        #$pdo = $this->connect2DB();

        $dsn = 'mysql:dbname=05;host=127.0.0.1';
        $user = 'root';
        $password = '';

        $pdo = new PDO($dsn, $user, $password);

        $sql = "INSERT INTO eintrag(titel, eintrag, user, timestamp) VALUES (:para_titel, :para_eintrag, :para_user, CURRENT_TIMESTAMP())";

        $params = array(
            'para_titel'  => $this->getTitel(),
            'para_eintrag' => $this->getEintrag(),
            'para_user'  => "1"
        );

        $statement = $pdo->prepare($sql);

        try {
            $statement->execute($params);
        } catch (PDOException $error) {
            print_r("FEHLER beim ausführen des Execute befehls $error\n");
        }

        $rowCount = $statement->rowCount();
        print_r($rowCount);
        if ($rowCount == 1){
            return true;
        }else{
            return false;
        }
    }

    public function loadAllEntrys()
    {

        #$pdo = connect2DB();

        $dsn = 'mysql:dbname=05;host=127.0.0.1';
        $user = 'root';
        $password = '';

        $pdo = new PDO($dsn, $user, $password);

        $sql = "SELECT * FROM `eintrag`";

        $statement = $pdo->prepare($sql);

        try {
            $statement->execute();
        } catch (PDOException $exception) {

        }

        $array = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($array as $key => $value){

            $obj[$key] = new Article();

            $obj[$key]->setId($array[$key]['id']);
            $obj[$key]->setTitel($array[$key]['titel']);
            $obj[$key]->setEintrag($array[$key]['eintrag']);
        }

        return $obj;
    }

    public function loadEntry()
    {

        #$pdo = connect2DB();

        $dsn = 'mysql:dbname=05;host=127.0.0.1';
        $user = 'root';
        $password = '';

        $pdo = new PDO($dsn, $user, $password);

        $sql = "SELECT * FROM `eintrag` WHERE id = :id";

        $statement = $pdo->prepare($sql);

        $id = $this->getId();

        $statement->bindParam(':id', $id);

        try {
            $statement->execute();
        } catch (PDOException $exception) {
            echo "ERROR! " . $exception;
        }

        $array = $statement->fetchAll(PDO::FETCH_ASSOC);

            $obj = new Article();

            $this->setTitel($array[0]['titel']);
            $this->setEintrag($array[0]['eintrag']);

        return $obj;
    }
}