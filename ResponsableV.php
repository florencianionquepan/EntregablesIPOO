<?php
/**
 * También se desea guardar la información de la persona responsable de realizar el viaje, 
 * para ello cree una clase ResponsableV que registre el número de empleado, número de licencia, nombre y apellido.
 *La clase Viaje debe hacer referencia al responsable de realizar el viaje.
 */

class ResponsableV{
    private $numEmpleado;
    private $numLicencia;
    private $nombre;
    private $apellido;
    private $mensajeoperacion;

    public function __construct(){
        $this->numEmpleado = "";
        $this->numLicencia = "";
        $this->nombre = "";
        $this->apellido = "";
    }

    public function cargar($numLicencia, $nombre, $apellido){
        $this->setNumLicencia($numLicencia);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
    }

	public function cargarConNum($numEmpleado,$numLicencia, $nombre, $apellido){
		$this->setNumEmpleado($numEmpleado);
		$this->setNumLicencia($numLicencia);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
	}
    
    public function getNumEmpleado(){
        return $this->numEmpleado;
    }

    public function setNumEmpleado($numEmpleado){
        $this->numEmpleado = $numEmpleado;
    }
 
    public function getNumLicencia(){
        return $this->numLicencia;
    }

    public function setNumLicencia($numLicencia){
        $this->numLicencia = $numLicencia;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getApellido(){
        return $this->apellido;
    }

    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function __toString(){
        return "Numero de empleado: ".$this->getNumEmpleado().".Numero de licencia: ".$this->getNumLicencia().
                ".Nombre: ".$this->getNombre().".Apellido: ".$this->getApellido()."\n";
    }

    	/**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($numEmpleado){
		$base=new BaseDatos();
		$consultaPersona="Select * from responsable where rnumeroempleado=".$numEmpleado;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){					
				    $this->setNumEmpleado($numEmpleado);
					$this->setNombre($row2['rnombre']);
					$this->setApellido($row2['rapellido']);
					$this->setNumLicencia($row2['rnumerolicencia']);
					$resp= true;
				}				
			
		 	}else {
		 		$this->setmensajeoperacion($base->getError());
		 		
			}
		}else {
		 	$this->setmensajeoperacion($base->getError());
		 	
		}		
		return $resp;
	}	
    
	public function BuscarPorLic($lic){
		$base=new BaseDatos();
		$consultaPersona="Select * from responsable where rnumerolicencia=".$lic;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){					
				    $this->setNumEmpleado($row2['rnumeroempleado']);
					$this->setNombre($row2['rnombre']);
					$this->setApellido($row2['rapellido']);
					$this->setNumLicencia($lic);
					$resp= true;
				}				
		 	}else {
		 		$this->setmensajeoperacion($base->getError());
			}
		}else {
		 	$this->setmensajeoperacion($base->getError());
		}		
		return $resp;
	}	

	public function listar($condicion=""){
	    $arregloPersona = null;
		$base=new BaseDatos();
		$consultaPersonas="Select * from responsable ";
		if ($condicion!=""){
		    $consultaPersonas=$consultaPersonas.' where '.$condicion;
		}
		$consultaPersonas.=" order by rapellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersonas)){				
				$arregloPersona= array();
				while($row2=$base->Registro()){
					//Esta tomando los datos de la BD para luego armar el objeto aca en php y armar la coleccion
                    //y al final mostrarlos como un ARRAY
					$nroEmpleado=$row2['rnumeroempleado'];
					$numLicencia=$row2['rnumerolicencia'];
					$nombre=$row2['rnombre'];
					$apellido=$row2['rapellido'];
				
					$responsable=new ResponsableV();
					$responsable->cargarConNum($nroEmpleado,$numLicencia,$nombre,$apellido);
					array_push($arregloPersona,$responsable);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloPersona;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO responsable(rnumerolicencia, rnombre, rapellido) 
				VALUES (".$this->getNumLicencia().",'".$this->getNombre()."','".$this->getApellido()."')";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE responsable SET rnumerolicencia='".$this->getNumLicencia()."',rnombre='".$this->getNombre()."'
                           ,rapellido='".$this->getApellido()."' WHERE rnumeroempleado=". $this->getNumEmpleado();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM responsable WHERE rnumeroempleado=".$this->getNumEmpleado();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
		
		}
		return $resp; 
	}


}

?>