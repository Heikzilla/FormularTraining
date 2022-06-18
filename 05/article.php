<?php
require_once('class/Article.php');

    if (isset($_GET['id'])){
        $article = new Article();

        $id = intval($_GET['id']);
        if(is_integer($id)){
            $article->setId($id);
            $article->loadEntry();
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
    <title>Document</title>
</head>
<body>
<a href="index.php">Startseite</a><br>
<?= $article->getTitel() ?><br>
<?= $article->getEintrag() ?>
</body>
</html>
