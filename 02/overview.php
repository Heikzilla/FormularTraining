<?php
session_start();

$status = false;


if (array_key_exists('send', $_POST)){
    $status = newUserEntry();

    if($status){
        session_destroy();
    }

}

function newUserEntry(){
    $pdo = new PDO('mysql:dbname=Users;host=127.0.0.1', 'root','');

    $sql = "INSERT INTO user (id, vorname, nachname, email, sex)
            VALUES ('',:var_vorname,:var_nachname, :var_email, :var_sex)";

    $params = array(
        'var_vorname' => $_SESSION['vorname'],
        'var_nachname' => $_SESSION['nachname'],
        'var_email' => $_SESSION['email'],
        'var_sex' => $_SESSION['sex']
    );

    $statement = $pdo->prepare($sql);

    try {
        $statement->execute($params);
    }catch (PDOException $exception){
        print_r($exception);
        #throw $exception;
    }

    $rowCount = $statement->rowCount();

    if ($rowCount == 1){
        return true;
    }else{
        return false;
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <title>Check Your Data</title>
</head>
<body>
<?php if(!$status) : ?>

<?= $_SESSION['sex'] ?><br>
Vorname: <?= $_SESSION['vorname'] ?><br>
Nachname: <?= $_SESSION['nachname'] ?><br>
eMail: <?= $_SESSION['email'] ?><br>
<a href="index.php">Zurück</a>

<form method="post">
    <input type="submit" name="send" value="bestätigen" />
</form>
<?php else : ?>
<p>Daten Hochgeladen: Vielen dank!</p>
    <a href="index.php">Zurück</a>
<?php endif; ?>
</body>
</html>
