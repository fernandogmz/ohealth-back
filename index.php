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

	$result = array(
		'status'	=>	'',
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
						$result['status']='ok';
						$result['data']=$data;
					}
					break;
				
			}
		}else{
			$result['status']='error';
			$result['message']='No se puede conectar con la base de datos';
		}
	}else{
		$result['status']='error';
		$result['message']='ACCION NO PERMITIDA';
		unset($result['data']);
	}
	
	print(json_encode($result));

?>