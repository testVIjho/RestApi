<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json");
header("Access-Control-Allow-Method:DELETE");
header("Access-Control-Allow-Header:Content-Type,Authorization,X-Requested-With");

require_once("../../config/Database.php");
require_once("../../model/Product.php");

$database = new Database();
$db = $database->connect();

$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id) && ($data->id)) {
    $product->id = $data->id;
    if ($product->delete()) {
        echo json_encode(
            array("Message" => "Product Deleted Successfully")
        );
    } else {
        echo json_encode(
            array("Message" => "Something Went Wrong")
        );
    }
} else {
    echo json_encode(
        array("Message" => "Please set the ID")
    );
}
