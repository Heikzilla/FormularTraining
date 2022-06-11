<?php
session_start();

if(count($_POST) > 0){
    print_r($_POST);

    $_SESSION = $_POST;
    unset($_SESSION['password'],$_SESSION['password2']);

    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $pw1 = $_POST['password'];
    $pw2 = $_POST['password2'];

    unset($_POST);

    $nickname = checkEntry($nickname);
    $email = checkEntry($email);
    #$pw1 = checkEntry($pw1);
    #$pw2 = checkEntry($pw2);

    if(strlen($nickname) > 64){
        $_SESSION['error']['nickname'] =  "Nickname ist mit " . strlen($nickname) . " ist zu lang! Maxmal 64 Zeichen möglich";
    }

    if (strlen(trim($email)) == 0){
        $_SESSION['error']['email'] = "Email ist Pflichtfeld! Bitte ausfüllen!";
    }

    if (strlen(trim($pw1)) == 0){
        $_SESSION['error']['password'] = "Password ist Pflichtfeld! Bitte ausfüllen!";
    }

    if(!checkEmailExists($email)){
        $_SESSION['error']['email'] = "Email adresse Existiert bereits. Loggen sie sich ein.\n";
    }

    if($pw1 === $pw2){
        $pw_hash = password_hash($pw1, PASSWORD_BCRYPT);
    }else{
        $_SESSION['error']['password'] = "Password stimmt nicht überein. Bitte erneut ausfüllen.";
    }

    if (count($_SESSION['error']) == 0){
        uploadNewUser($nickname,$email,$pw_hash);
        session_destroy();
    }
}

############################################################

function checkEntry($value){
    if (strlen($value) != 0){
        return trim(htmlspecialchars($value, ENT_QUOTES));
    }
}

function checkEmailExists($email){

    $pdo = new PDO('mysql:dbname=03;host=127.0.0.1','root','');

    $sql = "SELECT COUNT(*) FROM `user` WHERE `email` = :var_email";

    $statement = $pdo->prepare($sql);

    $statement->bindParam('var_email', $email);

    try {
        $statement->execute();
    }catch (PDOException $exception){

    }

    $value = $statement->fetch(PDO::FETCH_BOTH);

    if($value['COUNT(*)'] > 0){
        return true;
    }elseif ($value['COUNT(*)'] == 0){
        return false;
    }

}

function uploadNewUser($nickname,$email,$pw_hash){

    $pdo = new PDO('mysql:dbname=03;host=127.0.0.1','root','');

    $sql = "INSERT INTO user (id, nickname,email, password) VALUES ('', :par_nickname, :par_email, :par_password)";

    $params = array(
            'par_nickname' => $nickname,
            'par_email' => $email,
            ':par_password' => $pw_hash
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

function htmlOutputter($string){
    if (strlen(trim($string)) == 0){
        return '';
    }

    return '<p class="error">' . $strng . '</p>';
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
<form action="register.php" method="post">

    <label>Nickname</label>
    <input name="nickname" type="text" value="<?php echo (isset($_SESSION['nickname'])) ? $_SESSION['nickname'] : 'Enter Nickname here' ?>"><br>

    <label>Email*</label>
    <input name="email" id="email" type="email" value="<?php echo (isset($_SESSION['email'])) ? $_SESSION['email'] : 'Enter Nickname here' ?>"><br>

    <label>Passwort*</label><br>
    <input name="password" id="password" type="password"><br>
    <label>Passwort wiederholen*</label><br>
    <input name="password2" id="password2" type="password"><br>
    <input type="submit" value="submit">
</form>
</body>
</html>

<!-- <script>alert( 'BAD PAYLOAD: Success!' );</script> -->