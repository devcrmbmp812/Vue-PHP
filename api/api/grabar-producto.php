<?php
header('Content-Type: application/json; charset=utf-8');

$db = new PDO('mysql:host=localhost:3306;dbname=base;charset=utf8', 'root', '');

// Recibimos los datos de la petición.
// Como recibimos un JSON, así como vimos en CWM, tenemos que
// leer el string del búffer de entrada de php.
$buffer = file_get_contents('php://input');

$postData = json_decode($buffer, true);

// TODO: Validar los datos...

$query = "INSERT INTO productos (nombre, id_marca, id_categoria, precio, descripcion)
		VALUES (:nombre, :id_marca, :id_categoria, :precio, :descripcion)";

$stmt = $db->prepare($query);

$exito = $stmt->execute([
	'nombre' 		=> $postData['nombre'],
	'id_marca' 		=> $postData['id_marca'],
	'id_categoria' 	=> $postData['id_categoria'],
	'precio' 		=> $postData['precio'],
	'descripcion' 	=> $postData['descripcion'],
]);

if($exito) {
	$salida = [
		'status' => 1, // OK!
		'data' => [
			'id_producto' 	=> $db->lastInsertId(),
			'nombre' 		=> $postData['nombre'],
			'id_marca' 		=> $postData['id_marca'],
			'id_categoria' 	=> $postData['id_categoria'],
			'precio' 		=> $postData['precio'],
			'descripcion' 	=> $postData['descripcion'],
		]
	];
} else {
	$salida = [
		'status' => 0,
		'data' => [
			'error' => 'Error al grabar el registo.'
		]
	];
}

echo json_encode($salida);

