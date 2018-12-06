<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$input = file_get_contents('php://input');
$postData = json_decode($input, true);

$brand = intval($postData['brand']);
$firstname = $postData['firstname'];
$category = intval($postData['category']);
$desc = intval($postData['desc']);
$precio = intval($postData['precio']);
$db = new PDO('mysql:host=localhost:3306;dbname=base;charset=utf8', 'root', '');
$query = "insert  into `productos`(`id_categoria`,`nombre`,`descripcion`,`precio`,`cuotas_sin_interes`,`stock`,`id_marca`,`imagen`) values ( $category, '$firstname', '$desc', $precio, 1, 0, $brand,''); ";
$stmt = $db->exec($query);
// sleep(1);
echo json_encode([
    'status' => 1,
    'msg' => 'Nueva sección añadida'
]);


