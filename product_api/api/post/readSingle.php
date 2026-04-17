<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../model/Post.php');

$database = new Database();
$db = $database->connect();

$post = new Post($db);
//GET ID
$post->buyerID = isset($_GET['id']) ? $_GET['id'] : die();

//get post
$post->readSingle();

$post_arr = array(
    'id' => $post->buyerID,
    'productName' => $post->productName,
    'buyerName' => $post->buyerName,
    'quantity' => $post->quantity,
    'price' => $post->price,
    'productID' => $post->productID,
);

print_r(json_encode($post_arr));
