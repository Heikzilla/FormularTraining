<?php
session_start();

if($_POST){

    $_SESSION = $_POST;

    if ($_SESSION['vorname'] == '') {
        $_SESSION['error']['vorname'] = "Vorname bitte ausfüllen";
    }

    if ($_SESSION['nachname'] == '') {
        $_SESSION['error']['nachname'] = "Nachname bitte ausfüllen";
    }

    if(!preg_match('/\w+@\w+.\w+/', $_SESSION['email'])){
        $_SESSION['error']['email'] = "Eingabe ist keine gültige Email adresse.";
    }elseif ($_SESSION['email'] == ''){
        $_SESSION['error']['email'] = "Email bitte ausfüllen.";
    }

    if (count($_SESSION['error']) == 0){
        header('Location: overview.php');
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
        <title>User Formular</title>
    </head>
    <body>
        <div class="column">&nbsp;</div>
        <div class="column">
            <form action="index.php" method="post">

                <label for="sex">Anrede: </label>
                <select name="sex" id="lang">
                    <option value="male"   <?php echo (isset($_SESSION['sex']) && $_SESSION['sex'] == 'male') ?   'selected="selected"' : ''; ?>>Herr</option>
                    <option value="female" <?php echo (isset($_SESSION['sex']) && $_SESSION['sex'] == 'female') ? 'selected="selected"' : ''; ?>>Frau</option>
                    <option value="divers" <?php echo (isset($_SESSION['sex']) && $_SESSION['sex'] == 'divers') ? 'selected="selected"' : ''; ?>>Divers</option>
                    <option value="none"   <?php echo (isset($_SESSION['sex']) && $_SESSION['sex'] == 'none') ?   'selected="selected"' : ''; ?>>Keine</option>
                </select><br>

                <label for="Vorname">Name: </label>
                <input type="text" id="vorname" name="vorname" value="<?php echo (isset($_SESSION['vorname']) && $_SESSION['vorname'] != '') ? $_SESSION['vorname'] : 'Vorname'; ?>"><br>

                <label for="Nachname">Nachname: </label>
                <input type="text" id="nachname" name="nachname" value="<?php echo (isset($_SESSION['nachname']) && $_SESSION['nachname'] != '') ? $_SESSION['nachname'] : 'Nachname'; ?>"><br>

                <label for="email">Ihre Email: </label>
                <input type="email" id="email" name="email" value="<?php echo (isset($_SESSION['email']) && $_SESSION['email'] != '') ? $_SESSION['email'] : 'email'; ?>"><br>

                <input type="submit" value="Submit">
                <input type="reset">
            </form>
        </div>
        <div class="column">&nbsp;</div>
    </body>
</html>
