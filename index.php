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
	
	print_r(getenv("CLEARDB_DATABASE_URL"));
	die();

	require_once('connection.php');
	
	$db = new MODEL();
	$db->connect();

	if(!$db->isActive()) die('Conexión fallida');
	print_r($db);

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