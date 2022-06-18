<?php

require_once("class\Category.php");
require_once("class\Product.php");

$category = new Category();
$product = new Product();

#print_r($product->getCategory()->getId());



$categoryEntrys = $category->getAllDBEntrys();

if(isset($_POST)) {

    #New Category is set
    if (isset($_POST['action']) && isset($_POST['category'])){
        if ($_POST['action'] == 'newCategory' && $_POST['category'] != 'newCategory'){
            $category->setCategory($_POST['category']);

            print_r($category->getCategory());

            if ($category->newCategoryEntry()){
                header('location: newItem.php');
            }
        }
    }

    #New Product Item is set
    if (isset($_POST['action'])){
        if ($_POST['action'] == 'newItem'){
            $error = 0;
            if ($_POST['ean'] == 'ean'){
                $error++;
            }
            if ($_POST['productName'] == 'name'){
                $error++;
            }

            if ($error == 0){

                $ean = trim($_POST['ean']);
                $productName = trim($_POST['productName']);
                $productCategory = trim($_POST['productCategory']);

                $product->setEan($ean);
                $product->setProductName($productName);
                $product->setCategory($productCategory);

                if ($product->newProductEntry()){
                    header('location: newItem.php');
                }
            }
        }
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
    <title>NewItem</title>
</head>
<body>
    <div>
        <form action="newItem.php" method="post">
            <label>EAN/Product ID</label>
            <input type="text" name="ean" value="EAN">
            <label>Product Name</label>
            <input type="text" name="productName" value="Name">
            <label>Product Type</label>
            <select name="productCategory">
                <option value=""></option>
                <?php foreach($categoryEntrys as $key => $values):  ?>
                    <option value="<?= $categoryEntrys[$key]['id']; ?>"><?= $categoryEntrys[$key]['categoryName']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="action" value="newItem">
            <br>
            <input type="submit" value="newItem">
        </form>
    </div>

    <div>
        <form action="newItem.php" method="post">
            <label>Product category</label>
            <input type="text" name="category" value="newCategory">
            <input type="hidden" name="action" value="newCategory">
            <br>
            <input type="submit" value="newCategory">
        </form>

        <?php foreach($categoryEntrys as $key => $values):  ?>

                <p><?= $categoryEntrys[$key]['categoryName']; ?></p>
        <?php endforeach; ?>
    </div>

</body>
</html>

