<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");
header("Access-Control-Allow-Method:POST");
header("Access-Control-Allow-Header:Content-Type,Authorization,X-Requested-With");

require_once("../../config/Database.php");
require_once("../../model/Product.php");

$database = new Database();
$db = $database->connect();

$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));
if (isset($data->id)) {
    $product->id = $data->id;
    $product->productName = $data->productName;
    if ($product->create()) {
        echo json_encode(
            array("Message" => "Product Created Successfully")
        );
    } else {
        echo json_encode(
            array(
                "message" => "Something Went Wrong"
            )
        );
    }
} else {
    echo json_encode(
        array("Message" => "Please Set the Data")
    );
}
