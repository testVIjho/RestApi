<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");
require_once("../../config/Database.php");
require_once("../../model/Post.php");

//Instantiate DB Connection

$database = new Database();
$db = $database->connect();

//Instantiate buyer 

$post = new Post($db);
$result = $post->read();
$num = $result->rowCount();
if ($num > 0) {
    $arr_input = [];
    $arr_input['data'] = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $arr_item = [
            'Product_id' => $row['productID'],
            'productName' => $row['productName'],
            'buyerID' => $row['buyerID'],
            'buyerName' => $row['buyerName'],
            'quantity' => $row['quantity'],
            'price' => $row['price']
        ];
        //push to data 
        array_push($arr_input['data'], $arr_item);
    }
    // Turn to Json Output

    echo json_encode($arr_input);
} else {
    echo json_encode(
        array("message" => "No Data fount")
    );
}
