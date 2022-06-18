<?php
require_once('class/Article.php');
session_start();

$article = new Article();
$obj = $article->loadAllEntrys();
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
<h1>Blog</h1>
 <?php echo (isset($_SESSION['login'])) ? 'HELLO ' . $_SESSION['nickname'] . ' <a href="newContent.php">new Article</a> <a href="logout.php">logout</a>' : '<a href="login.php">login</a>' ?>
<br>
<br>
<?php foreach($obj as $values):  ?>
    <div>
        <a href="article.php?id=<?= $values->getId() ?>"><?= $values->getTitel(); ?></a> <br>
        <p id="rcorners1"><?= $values->getEintrag() ?></p>
    </div>
<?php endforeach; ?>
</body>
</html>
