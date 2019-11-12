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


	require_once('connection.php');
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	header("Allow: GET, POST, OPTIONS, PUT, DELETE");
	$method = $_SERVER['REQUEST_METHOD'];
	if($method == "OPTIONS") {
    		die();
	}

	$result = array(
		'status'	=>	'ok',
		'message'	=>	'',
		'data'		=>	''
	);

	if(isset($_POST['oh-action'])){

		$db = new MODEL();
		$db->connect();

		if($db->isActive()) {
			$action = $_POST['oh-action'];

			switch($action){
				case 'getDoctores':
					$data = $db->doctores();
					if($data){
						$result['data']=$data;
					}
					break;

				case 'getPacientes':
				$data = $db->pacientes();
					if($data){
						$result['data']=$data;
					}
					break;

				case 'getCitasAll':
				$data = $db->citasA();
					if($data){
						$result['data']=$data;
					}
					break;

				case 'newDoctor':
					$data = (isset($_POST['data'])?$_POST['data']:null);
					if($data && $db->addDoctor($data)){
						$result['message']='Doctor agregado exitosamente';
					}else{
						$result['status']='error';
						$result['message']='Error con el registro';
					}
					unset($result['data']);
					break;
				case 'newPaciente':
					$data = (isset($_POST['data'])?$_POST['data']:null);
					if($data && $db->addPaciente($data)){
						$result['message']='Paciente agregado exitosamente';
					}else{
						$result['status']='error';
						$result['message']='Error con el registro';
					}
					unset($result['data']);
					break;
				
				
			}
		}else{
			$result['status']='error';
			$result['message']='No se puede conectar con la base de datos';
			unset($result['data']);
		}
	}else{
		$result['status']='error';
		$result['message']='ACCION NO PERMITIDA';
		unset($result['data']);
	}
	
	print(json_encode($result));

?>
