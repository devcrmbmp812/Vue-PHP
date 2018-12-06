<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$db = new PDO('mysql:host=localhost:3306;dbname=base;charset=utf8', 'root', '');
$input = file_get_contents('php://input');
$postData = json_decode($input, true);

$email = $postData['email'];
$password =  $postData['password'];
$nombre = $postData['nombre'];
$query = "select usuario FROM usuarios where mail = '$email' LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute();

$query_admin = "select usuario FROM usuarios_admin where email = '$email' LIMIT 1";
$stmt_admin = $db->prepare($query_admin);
$stmt_admin->execute();

if($stmt->fetch(PDO::FETCH_ASSOC) || $stmt_admin->fetch(PDO::FETCH_ASSOC)){
    echo json_encode([
        'status' => 0,
        'data' => 'exist'
    ]);
}
else{
    $query = "insert  into `usuarios`(`mail`,`password`,`nombre`) values ( '$email', '$password','$nombre'); ";

    $stmt = $db->exec($query);
    echo json_encode([
        'status' => 1,
        'data' => $postData
    ]);

}
