<?php
session_start();
print_r($_POST);
require_once('class/User.php');

if(count($_POST) > 0){
    $_SESSION = $_POST;
    unset($_SESSION['password'],$_SESSION['password2']);

    $user = new User();

    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $pw1 = $_POST['password'];
    $pw2 = $_POST['password2'];

    unset($_POST);

    if(strlen($nickname) > 64){
        $_SESSION['error']['nickname'] =  "Nickname ist mit " . strlen($nickname) . " ist zu lang! Maxmal 64 Zeichen möglich";
    }

    if (strlen(trim($email)) == 0){
        $_SESSION['error']['email'] = "Email ist Pflichtfeld! Bitte ausfüllen!";
    }

    if (strlen(trim($pw1)) == 0){
        $_SESSION['error']['password'] = "Password ist Pflichtfeld! Bitte ausfüllen!";
    }

    $user->setEmail($email);
    if(!$user->checkEmailExists()){
        $_SESSION['error']['email'] = "Email adresse Existiert bereits. Loggen sie sich ein.\n";
    }

    if($pw1 === $pw2){
        $pw_hash = password_hash($pw1, PASSWORD_BCRYPT);
    }else{
        $_SESSION['error']['password'] = "Password stimmt nicht überein. Bitte erneut ausfüllen.";
    }
    print_r($_SESSION['error']);

    if (count($_SESSION['error']) == 0){

        $user->setNickname($nickname);
        $user->setPassHash($pw_hash);

        $user->uploadNewUser();
        session_destroy();
        header('location login.php');
    }
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

    <?php echo isset($_SESSION['error']['nickname']) ? $_SESSION['error']['nickname'] : '' ?>
    <label>Nickname</label>
    <input name="nickname" type="text" value="<?php echo (isset($_SESSION['nickname'])) ? $_SESSION['nickname'] : 'Enter Nickname here' ?>"><br>
    <?php echo isset($_SESSION['error']['email']) ? $_SESSION['error']['email'] : '' ?><br>
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
