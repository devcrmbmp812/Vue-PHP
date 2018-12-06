<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

//$db = new PDO('mysql:host=localhost:3308;dbname=pet;charset=utf8', 'root', '');
$db = new PDO('mysql:host=localhost:3306;dbname=base;charset=utf8', 'root', '');
$query = "SELECT * FROM productos p inner join categorias c on p.id_categoria = c.id_categoria inner join marcas m on p.id_marca = m.id_marca
	ORDER BY p.id_producto";

$stmt = $db->prepare($query);

$stmt->execute();

// sleep(1);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));