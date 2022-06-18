<?php

class User
{
    private $id;
    private $nickname;
    private $email;
    private $passHash;

    /**
     * @param $nickname
     * @param $email
     * @param $passHash
     */
    public function __construct($nickname = '', $email = '', $passHash = '')
    {
        $this->setNickname($nickname);
        $this->setEmail($email);
        $this->setPassHash($passHash);
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
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassHash()
    {
        return $this->passHash;
    }

    /**
     * @param mixed $passHash
     */
    public function setPassHash($passHash)
    {
        $this->passHash = $passHash;
    }

##########################################################################

    public function checkEmailExists(){

        $pdo = new PDO('mysql:dbname=05;host=127.0.0.1','root','');

        $sql = "SELECT COUNT(*) FROM `user` WHERE `email` = :var_email";

        $statement = $pdo->prepare($sql);

        $statement->bindParam('var_email', $this->getEmail());

        try {
            $statement->execute();
        }catch (PDOException $exception){

        }

        $value = $statement->fetch(PDO::FETCH_BOTH);
        print_r($value);
        if($value['COUNT(*)'] > 0){
            return false;
        }elseif ($value['COUNT(*)'] == 0){
            return true;
        }
    }

    public function checkPassword(){

        $pdo = new PDO('mysql:dbname=05;host=127.0.0.1','root','');

        $sql = "SELECT password, nickname FROM `user` WHERE `email` = :var_email";

        $statement = $pdo->prepare($sql);

        $statement->bindParam('var_email', $this->getEmail());

        try {
            $statement->execute();
        }catch (PDOException $exception){

        }

        $value = $statement->fetch(PDO::FETCH_BOTH);

        if(password_verify($this->getPassHash(), $value['password'])){
            $this->setNickname($value['nickname']);
            return true;
        }else{
            return false;
        }
    }

    public function uploadNewUser(){

        $pdo = new PDO('mysql:dbname=05;host=127.0.0.1','root','');

        $sql = "INSERT INTO user (id, nickname,email, password) VALUES ('', :par_nickname, :par_email, :par_password)";

        $params = array(
            'par_nickname' => $this->getNickname(),
            'par_email' => $this->getEmail(),
            'par_password' => $this->getPassHash()
        );

        $statement = $pdo->prepare($sql);

        try {
            $statement->execute($params);
        }catch (PDOException $exception){
            #return false;
        }

        $countRow = $statement->rowCount();

        if ($countRow == 1){
            return true;
        }else{
            return false;
        }
    }
}