<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$db = new PDO('mysql:host=localhost:3306;dbname=base;charset=utf8', 'root', '');
$query = "SELECT * FROM marcas";

$stmt = $db->prepare($query);

$stmt->execute();

echo json_encode($stmt->fetchAll());