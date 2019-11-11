<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>

</body>
</html>
<?php
	$cleardb_server   = getenv("DB_HOST");
	$cleardb_username = getenv("DB_USERNAME");
	$cleardb_password = getenv("DB_PASSWORD");
	$cleardb_db       = getenv("DB_NAME");
	
	print_r($cleardb_server);
	print_r($cleardb_username);
	print_r($cleardb_password);
	print_r($cleardb_db);
	
	die();
	require_once('connection.php');
	
	$db = new MODEL();
	$db->connect();

	if(!$db->isActive()) die('Conexión fallida');

	print_r(json_encode($db->doctores()));

	/**
	* OBTENIENDO STRING JSON
	$data='{"codigo":"XTEST","nombre":"Edmund","apellidos":"McKenzie","telefono":"860-326-5800","correo":"(910)440-1686","jvpm":"80800659"}';

	print_r($db->addDoctor($data));
	*/
	
	/**
	* OBTENIENDO PARAMETROS POR POST
	$data = array(
		"codigo"=>"XTEST",
		"nombre"=>"Edmund",
		"apellidos"=>"McKenzie",
		"telefono"=>"860-326-5800",
		"correo"=>"(910)440-1686",
		"jvpm"=>"80800659"
	);

	print_r($db->addDoctor(json_encode($data));
	*/


?>