<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

//$db = new PDO('mysql:host=localhost:3308;dbname=pet;charset=utf8', 'root', '');
$input = file_get_contents('php://input');
$postData = json_decode($input, true);

$id = intval($postData['id']);
$db = new PDO('mysql:host=localhost:3306;dbname=base;charset=utf8', 'root', '');
$query = "delete from productos where id_producto= $id";
$stmt = $db->exec($query);

echo json_encode([
    'status' => 1,
    'msg' => 'Borrado con exito'
]);

