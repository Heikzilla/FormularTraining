<?php

if (count($_POST) > 0){

    $email = $_POST['email'];
    $password = $_POST['password'];
    if (checkEmailExists($email)){
        $user = requestEmailPasshash($email);
        printf( 'Valide Email. ');
        if (password_verify($password, $user[0]['password'])) {
            session_start();
            $_SESSION['nickname'] = $user[0]['nickname'];
            $_SESSION['login'] = true;

            header('Location: welcome.php');
            printf( 'Valides Passwort.');
        } else {
            #header("Location: login.php");
            printf( 'Invalides Passwort.');
        }
    }
}

#############################################################################

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
        printf('true');
        return true;
    }elseif ($value['COUNT(*)'] == 0){
        printf('false');
        return false;
    }

}

function requestEmailPasshash($email){

    $pdo = new PDO('mysql:dbname=03;host=127.0.0.1','root','');

    $sql = "SELECT nickname, email, password FROM `user` WHERE `email` = :var_email";

    $statement = $pdo->prepare($sql);

    $statement->bindParam('var_email', $email);

    try {
        $statement->execute();
    }catch (PDOException $exception){

    }

    $value = $statement->fetchAll();

    var_dump($value[0]["email"]);
    var_dump($value[0]["password"]);

    return $value;

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="post">
        <label>Email: </label>
        <input name="email" id="email" type="email"><br>
        <label>Passwort: </label>
        <input name="password" id="password" type="password"><br>
        <input type="submit" value="submit">
    </form>
</body>
</html>
