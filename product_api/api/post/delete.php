<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");
header("Access-Control-Allow-Methods:DELETE");
header("Access-Control-Allow-Headers:Content-Type,Authorization,X-Requested-With");

require_once('../../config/Database.php');
require_once('../../model/Post.php');

$database = new Database();
$db = $database->connect();

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));
if (isset($data->id) && ($data->id)) {
    $post->buyerID = $data->id;

    if ($post->delete()) {
        echo json_encode(
            array("Message" => "Buyer Deleted Successfully")
        );
    } else {
        echo json_encode(
            array(
                "Message" => "Something Went Wrong"
            )
        );
    }
} else {
    echo json_encode(
        array("Message" => "Please set the ID")
    );
}
