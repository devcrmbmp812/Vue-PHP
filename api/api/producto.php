<?php
header('Content-Type: application/json; charset=utf-8');

//$db = new PDO('mysql:host=localhost:3308;dbname=pet;charset=utf8', 'root', '');
$db = new PDO('mysql:host=localhost:3306;dbname=base;charset=utf8', 'root', '');
$query = "SELECT * FROM productos
		WHERE id_producto = ?";

$stmt = $db->prepare($query);

$stmt->execute([$_GET['id']]);

echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));