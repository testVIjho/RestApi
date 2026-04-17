<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

require_once('../../config/Database.php');
require_once('../../model/Post.php');

$database = new Database();
$db = $database->connect();

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->productID) && ($data->productID)) {
    $post->buyerName = $data->buyerName;
    $post->quantity = $data->quantity;
    $post->price = $data->price;
    $post->productID = $data->productID;

    if ($post->create()) {
        echo json_encode(
            array(
                "Message" => "Buyer Created"
            )
        );
    } else {
        echo json_encode(
            array("message" => "Something Went Wrong")
        );
    }
} else {
    echo json_encode(
        array("Message" => "Please set the data")
    );
}
