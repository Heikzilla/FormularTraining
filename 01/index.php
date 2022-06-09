<?php

$entrys = loadGastbuchEntry();
$error = array();
session_start();


if (isset($_POST['name'])){
    $_SESSION = $_POST;

    if(!preg_match('/\w+@\w+.\w+/', $_SESSION['email'])){
        $_SESSION['error']['email'] = "Feld muss eMail sein";
    }
    if (strlen(trim($_SESSION['gasteintrag'])) == 0){
        $_SESSION['error']['gasteintrag'] = "Darf nicht nur aus Leerzeichen bestehen";
    }

    if(count($_SESSION['error']) == 0){
        newGastbuchEntry($_SESSION);
        session_destroy();
    }


    header('Location: index.php');
}
############################################################

function connect2DB(){
    $dsn = 'mysql:dbname=gastbuch;host=127.0.0.1';
    $user = 'root';
    $password = '';

    $pdo = new PDO($dsn, $user, $password);

    return $pdo;
}

function loadGastbuchEntry()
{

    $pdo = connect2DB();

    $sql = "SELECT * FROM `gastbucheintrag`";

    $statement = $pdo->prepare($sql);

    try {
        $statement->execute();
    } catch (PDOException $exception) {

    }

    return $statement->fetchAll(PDO::FETCH_ASSOC);


}

function newGastbuchEntry($array){

    $pdo = connect2DB();

    $sql = "INSERT INTO gastbucheintrag (name, email, text)
            VALUES (:para_name, :para_email, :para_text)";

    $params = array(
        'para_name'  => $array['name'],
        'para_email' => $array['email'],
        'para_text'  => $array['gasteintrag']
    );

    $statement = $pdo->prepare($sql);

    try {
        $statement->execute($params);
    } catch (PDOException $error) {
        $dbError = "FEHLER beim ausführen des Execute befehls\n";
    }

    #$rowCount = $statement->rowCount();
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Document</title>
    </head>
    <body>
        <div class="row">
            <div class="column">&nbsp;</div>
            <div class="column">
                <?php foreach($entrys as $key => $values):  ?>
                    <div>
                        <p id="rcorners1"><?= $entrys[$key]['text']; ?><br><br>
                        Name: <?php echo ($entrys[$key]['name'] == '' || $entrys[$key]['name'] == 'name') ? 'Anonymous' : $entrys[$key]['name']; ?></p>
                    </div>
                <?php endforeach; ?>
                <div id="rcorners2">
                    <form action="index.php" method="post">
                        <label for="name">Name: </label>
                        <input type="text" id="name" name="name" value="<?php echo  isset($_SESSION['name']) ? $_SESSION['name'] : '' ?>"><br>

                        <?php echo  isset($_SESSION['error']['email']) ?  "<p id='error'>" . $_SESSION['error']['email'] . "</p>" : '' ?>
                        <label for="email">Ihre Email: </label>
                        <input type="text" id="email" name="email" value="<?php echo  isset($_SESSION['email']) ? $_SESSION['email'] : 'email' ?>"><br>

                        <?php echo  isset($_SESSION['error']['gasteintrag']) ?  "<p id='error'>" . $_SESSION['error']['gasteintrag'] . "</p>" : '' ?>
                        <textarea name="gasteintrag" id="" cols="30" rows="10"><?php echo  isset($_SESSION['gasteintrag']) ? $_SESSION['gasteintrag'] : '' ?></textarea><br>
                        <input type="submit" value="Submit">
                    </form>
                </div>

            </div>
            <div class="column">&nbsp;</div>
        </div>
    </body>
</html>