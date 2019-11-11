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
	
	$db = new mysqli(
				$cleardb_server,
				$cleardb_username,
				$cleardb_password,
				$cleardb_db) or false;
				
	print_r($db);
	
	print_r(doctores($db));
	
	function doctores($db){
			
			$query="SELECT doctor.*, doctorxespecialidad.cod_especialidad, especialidad.nombre AS 'nombre_esp' FROM doctor
				LEFT JOIN doctorxespecialidad ON doctorxespecialidad.cod_doctor=doctor.codigo
				LEFT JOIN especialidad ON especialidad.codigo = doctorxespecialidad.cod_especialidad";

			$doctores_keys=[];
			$doctores=[];

			$result = $db->query($query);
			
			if($result){
				while($row = $result->fetch_assoc()){
					$cod = $row['codigo'];
					if(!array_key_exists($cod,$doctores)){ //Agregar
						$doctores[$cod]=[
							'codigo'=>$row['codigo'],
							'nombre'=>$row['nombre'],
							'apellidos'=>$row['apellidos'],
							'telefono'=>$row['telefono'],
							'correo'=>$row['correo'],
							'jvpm'=>$row['jvpm'],
							'especialidades'=>($row['cod_especialidad']?[$row['nombre_esp']]:array())
						];
					}else{
						
						if($row['cod_especialidad']){
							array_push($doctores[$cod]['especialidades'],$row['nombre_esp']);
						}
					}
					
				}
			}

			return array_values($doctores);
		}
	
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