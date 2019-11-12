<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
    // whitelist of safe domains
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

}

	require_once('connection.php');

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
