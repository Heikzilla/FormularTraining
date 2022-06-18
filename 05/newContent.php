<?php
require_once ('class/Article.php');
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
}

if (isset($_POST['titel'])){
    $_SESSION = $_POST;

    if(!isset($_SESSION['titel'])){
        $_SESSION['error']['titel'] = "Feld darf nicht leer sein sein";
    }
    if (strlen(trim($_SESSION['eintrag'])) == 0){
        $_SESSION['error']['eintrag'] = "Darf nicht nur aus Leerzeichen bestehen";
    }

    if(!isset($_SESSION['error'])){
        $article = new Article();

        $article->setTitel($_SESSION['titel']);
        $article->setEintrag($_SESSION['eintrag']);

        if($article->newEntry()){
            unset($_SESSION['titel'],$_SESSION['eintrag']);
            #header('location: index.php');
        }else{
            echo "Datenbank problem aufgetretten\n";
        }
    }else{
        echo "Es sind fehler aufgetreten";
    }



    #header('Location: index.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<a href="index.php">Startseite</a> <a href="logout.php">logout</a>
<form action="newContent.php" method="post">
    <label for="titel">Titel: </label>
    <?php echo  isset($_SESSION['error']['titel']) ?  "<p id='error'>" . $_SESSION['error']['titel'] . "</p>" : '' ?>
    <input type="text" id="titel" name="titel" value="<?php echo  isset($_SESSION['titel']) ? $_SESSION['titel'] : '' ?>"><br>

    <?php echo  isset($_SESSION['error']['eintrag']) ?  "<p id='error'>" . $_SESSION['error']['eintrag'] . "</p>" : '' ?>
    <textarea name="eintrag" id="" cols="30" rows="10"><?php echo  isset($_SESSION['eintrag']) ? $_SESSION['eintrag'] : '' ?></textarea><br>
    <input type="submit" value="Submit">
</form>
</body>
</html>
