<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$input = file_get_contents('php://input');
$postData = json_decode($input, true);
$db = new PDO('mysql:host=localhost:3306;dbname=base;charset=utf8', 'root', '');
$id = intval($postData['id']);
$query = "SELECT * FROM productos where id_producto = $id";

$stmt = $db->prepare($query);

$stmt->execute();

echo json_encode($stmt->fetchAll());