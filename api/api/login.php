<?php
require 'token-functions.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

//$db = new PDO('mysql:host=localhost:3308;dbname=pet;charset=utf8', 'root', '');
$db = new PDO('mysql:host=localhost:3306;dbname=base;charset=utf8', 'root', '');
$input = file_get_contents('php://input');
$postData = json_decode($input, true);

// TODO: Validación ;)

$query = "SELECT * FROM usuarios
		WHERE mail = :email
		AND password = :password";

$stmt = $db->prepare($query);

$stmt->execute([
	'email' 	=> $postData['email'],
	'password' 	=> $postData['password']
]);

//check query admin
$query_admin = "SELECT * FROM usuarios_admin
WHERE email = :email
AND password = :password";
$stmt_admin = $db->prepare($query_admin);
$stmt_admin->execute([
	'email' 	=> $postData['email'],
	'password' 	=> $postData['password']
]);

// Verificamos si el usuario era correcto...
if($fila_admin = $stmt_admin->fetch(PDO::FETCH_ASSOC)){
	echo json_encode([
		'type' => 'admin',
		'status' => 1,
		'msg' => 'Sesión iniciada.',
		'data' => [
			'nombre' => $fila_admin['usuario'],
			'email' => $fila_admin['email'],
		]
	]);
}
else if($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$token = generateToken($fila['id']);
	// echo $token;
	// die;
	// En vez de usar localStorage como hicimos antes para guardar 
	// el token, vamos a guardar en una cookie :)
	// Cookie? Posta?
	// Para cosas como ésta, pueden ser considerablemente más seguras
	// que localStorage. Razón: El flag "httpOnly".
	// Si una cookie se crea con ese flag encedido, la cookie _no_
	// puede ser leída por JS. Con lo cual, los ataques de XSS (a los
	// es vulnerable localStorage), son inservibles.
	// Cómo se crean cookies?
	// Usando setcookie :D
	// El último "true" es para indicar que es de httpOnly
	setcookie('token', $token, 0, "", "", false, true);

	// A la app, le mandamos los datos del usuario que queremos que
	// use, pero no el token.
	echo json_encode([
		'type' => 'normal',
		'status' => 1,
		'msg' => 'Sesión iniciada.',
		'data' => [
			'nombre' => $fila['nombre'],
			'email' => $fila['mail'],
		]
	]);
} else {
	echo json_encode([
		'status' => 0,
		'msg' => 'Usuario y/o password incorrectos.'
	]);
}