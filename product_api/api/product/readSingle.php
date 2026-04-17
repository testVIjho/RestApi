<?php
header("Access-Control-Allow-Origin:*");
header("Content-type:application/json");
header("Access-Control-Allow-Method:GET");

require_once('../../config/Database.php');
require_once('../../model/Product.php');

$database = new Database();
$db = $database->connect();

$product = new Product($db);


$product->id = isset($_GET['id']) ? $_GET['id'] : die();
if (isset($product->id)) {
    $product->readSingle();
    $product_arr = [
        "id" => $product->id,
        "ProductName" => $product->productName
    ];

    print_r(json_encode($product_arr));
} else {
    echo json_encode(
        array("Message" => "Please Set the ID")
    );
}
