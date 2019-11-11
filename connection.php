<?php

	class MODEL{

		private $SERVER='localhost';
		private $USER='root';
		private $PASSWORD='';
		private $DB_NAME='ohealth';

		private $db;
		private $result;
		private $result_array=[];


		public function connect(){
			$this->db = new mysqli($this->SERVER,$this->USER,$this->PASSWORD,$this->DB_NAME) or NULL;
		}

		public function isActive(){
			return ($this->db?true:false);
		}

		public function doctores(){
			
			$query="SELECT doctor.*, doctorxespecialidad.cod_especialidad, especialidad.nombre AS 'nombre_esp' FROM doctor
				LEFT JOIN doctorxespecialidad ON doctorxespecialidad.cod_doctor=doctor.codigo
				LEFT JOIN especialidad ON especialidad.codigo = doctorxespecialidad.cod_especialidad";

			$doctores_keys=[];
			$doctores=[];

			$this->result = $this->db->query($query);
			
			if($this->result){
				while($row = $this->result->fetch_assoc()){
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

		public function pacientes(){
			$query="SELECT * FROM paciente";
			$this->result = $this->db->query($query);
			
			$pacientes = [];

			if($this->result){
				while($row = $this->result->fetch_assoc()){
					$pacientes[]=$row;
				}
			}
			return $pacientes;
		}

		public function addDoctor($data){
			$data = json_decode($data);
			$query="INSERT INTO doctor VALUES (?,?,?,?,?,?)";
			$stmt=$this->db->prepare($query);
			$stmt->bind_param("ssssss",$codigo,$nombre,$apellidos,$telefono,$correo,$jvpm);

			$codigo=$data->codigo;
			$nombre=$data->nombre;
			$apellidos=$data->apellidos;
			$telefono=$data->telefono;
			$correo=$data->correo;
			$jvpm=$data->jvpm;

			$stmt->execute();
			return ($stmt->affected_rows>0?true:false);

		}

		public function addDocEsp($data){

		}

	}
	

?>