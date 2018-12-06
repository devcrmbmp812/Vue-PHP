<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$input = file_get_contents('php://input');
$postData = json_decode($input, true);

$name = $postData['name'];
$email = $postData['email'];
$db = new PDO('mysql:host=localhost:3306;dbname=base;charset=utf8', 'root', '');
$query = "insert  into `newsletter`(`name`,`email`) values ( '$name', '$email'); ";
$stmt = $db->exec($query);

echo json_encode([
    'status' => 1,
    'msg' => 'Se ha suscribido con exito'
]);

