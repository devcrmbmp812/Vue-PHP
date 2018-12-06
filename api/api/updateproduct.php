<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$input = file_get_contents('php://input');
$postData = json_decode($input, true);

$id = intval($postData['id']);
$brand = intval($postData['brand']);
$firstname = $postData['firstname'];
$desc = $postData['desc'];
$precio = $postData['precio'];
$category = intval($postData['category']);
$db = new PDO('mysql:host=localhost:3306;dbname=base;charset=utf8', 'root', '');
$query = "update  `productos` set `id_categoria` = $category, nombre= '$firstname', desc= '$desc', precio= '$precio',id_marca= $brand where id_producto= $id; ";

$stmt = $db->exec($query);

echo json_encode([
    'status' => 1,
    'msg' => $query
]);

