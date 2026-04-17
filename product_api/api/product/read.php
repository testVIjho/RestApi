<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");

require_once("../../config/Database.php");
require_once("../../model/Product.php");

$database = new Database();
$db = $database->connect();

$product = new Product($db);

$result = $product->read();

$num = $result->rowCount();

if ($num > 0) {
    $product_arr = [];
    $product_arr['data'] = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $Product_item = [
            'id' => $row['id'],
            'productName' => $row['productName']
        ];
        array_push($product_arr['data'], $Product_item);
    }

    echo json_encode($product_arr);
} else {
    echo json_encode(
        array("Message" => "No Data Found")
    );
}
