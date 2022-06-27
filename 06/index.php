<?php
session_start();
#$_SESSION;

    $array = getPriceOverview();

    $array = array_slice($array, -8);
    foreach ($array as $key => $value){
        if($key == 0){
            $array[$key]['arrow'] ='';
            $array[$key]['state'] = '';
            continue;
        }

        if($array[$key-1]['price'] == $array[$key]['price']){
            $array[$key]['arrow'] = '&rarr;';
            $array[$key]['state'] = 'stay';
        }elseif ($array[$key-1]['price'] > $array[$key]['price']){
            $array[$key]['arrow'] = '&darr;';
            $array[$key]['state'] = 'down';
        }elseif ($array[$key-1]['price'] < $array[$key]['price']){
            $array[$key]['arrow'] = '&uarr;';
            $array[$key]['state'] = 'up';
        }


    }
    #print_r($array);

if (isset($_POST['id'])){
    $newPrice = $_POST['newPrice'];
    $ean = $_POST['id'];
    unset($_POST['newPrice']);
    if(preg_match('/[^.,0-9]/',$newPrice)){
        print "Yeah, thats not a number...\n";
    }else{
        if(writeInDB($newPrice, $ean)){
            header('location: index.php');
        }
    }
}

###################################################

function writeInDB($price, $ean){
    $pdo = new PDO('mysql:dbname=06;host=127.0.0.1','root','');

    $sql = "INSERT INTO price (ean, price, date)
            VALUES (:ean,  :price, current_timestamp )";

    $params = array(
            'ean' => $ean,
            'price' => $price
    );

    $statement = $pdo->prepare($sql);

    try {
        $statement->execute($params);
    }catch (PDOException $exception){
        print "Error! Database can not be found";
    }

    $row = $statement->rowCount();

    if ($row == 1){
        return true;
    }else{
        return false;
    }
}

function getPriceOverview($ean = '123'){
    $pdo = new PDO('mysql:dbname=06;host=127.0.0.1','root','');

    $sql = "SELECT * FROM price WHERE ean = :ean";

    $statement = $pdo->prepare($sql);

    $statement->bindParam('ean', $ean);

    try {
        $statement->execute();
    }catch (PDOException $exception){
        print "ERROR! Database can not be found";
    }

    $results = $statement->fetchAll();

    return $results;
}
?>

<!doctype html>
<html lang="en">
<head>
    <style>
        span.up {
            color: #ff0000;
            font-weight:bold;
        }
        span.down {
            color: green;
            font-weight:bold;
        }
        span.stay {
            color: black;
            font-weight:bold;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>



<table  style="width:600px">
    <tr>
        <td>EAN <h2><?php echo '123456'; ?></h2></td>
        <td>Product: <h2>MSI MAINBOARD</h2></td>
        <td rowspan="1"><h1><?php echo $array[count($array)-1]['price']; ?> €</h1></td>
    </tr>
    <tr>
        <td colspan="2">
            price development: <br>
            <?php foreach($array as $key => $value) : ?>

            <span class="<?= $value['state'] ?>"><?= $value['arrow']; ?><?= $value['price']; ?>€  </span>


            <?php endforeach; ?>
        </td>
        <td>
            <form action="index.php" method="post">
                <input type="hidden" name="id" id="id" value="123">
                <input type="text" name="newPrice" id="newPrice">
                <button type="submit" class="addPrice" name="addPrice">+</button>
            </form>
        </td>
    </tr>

</table>
</body>
</html>
