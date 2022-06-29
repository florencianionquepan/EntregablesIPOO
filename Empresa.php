<?php

class Empresa{
    private $idEmpresa;
    private $nombre;
    private $direccion;
	private $coleccViajes;
	private $mensajeoperacion;

    public function __construct(){
        $this->idEmpresa="";
        $this->nombre="";
        $this->direccion="";
		$this->coleccViajes=[];
    }

    public function cargar($nombre, $direccion){
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
    }

	public function cargarConId($id,$nombre,$direccion){
		$this->setIdEmpresa($id);
		$this->setNombre($nombre);
        $this->setDireccion($direccion);
	}

    public function getIdEmpresa(){
        return $this->idEmpresa;
    }

    public function setIdEmpresa($idEmpresa){
        $this->idEmpresa = $idEmpresa;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getDireccion(){
        return $this->direccion;
    }

    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }

	public function getmensajeoperacion(){
		return $this->mensajeoperacion;
	}

	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion = $mensajeoperacion;
	}

	public function getColeccViajes(){
		return $this->coleccViajes;
	}

	public function setColeccViajes($coleccViajes){
		$this->coleccViajes = $coleccViajes;
	}

	private function verViajes(){
		$msn="";
        $viajes=$this->getColeccViajes();
        for ($i=0;$i<count($viajes);$i++){
            $msn=$msn.$viajes[$i]; 
        }
        return $msn;
	}

    public function __toString(){
    return "id:".$this->getIdEmpresa().". Nombre:".$this->getNombre().". Dirección:".$this->getDireccion().
				$this->verViajes()."\n"; 
    }

    /**
	 * Recupera los datos de una empresa por id
	 */		
    public function Buscar($id){
		$base=new BaseDatos();
		$consultaPersona="Select * from empresa where idempresa=".$id;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){					
				    $this->setIdEmpresa($id);
					$this->setNombre($row2['enombre']);
					$this->setDireccion($row2['edireccion']);
					$resp= true;
				}				
		 	}else{
		 		$this->setmensajeoperacion($base->getError());
			}
		}else{
		 	$this->setmensajeoperacion($base->getError());
		}		
		return $resp;
	}	


	public function listar($condicion=""){
	    $arregloEmpresa = null;
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa ";
		if ($condicion!=""){
		    $consultaEmpresa=$consultaEmpresa.' where '.$condicion;
		}
		$consultaEmpresa.=" order by enombre ";
		//echo $consultaEmpresa;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){				
				$arregloEmpresa=array();
				while($row2=$base->Registro()){
					
					$id=$row2['idempresa'];
					$nombre=$row2['enombre'];
					$direccion=$row2['edireccion'];
				
					$empresa=new Empresa();
					$empresa->cargarConId($id,$nombre,$direccion);
					array_push($arregloEmpresa,$empresa);
				}
		 	}else {
		 		$this->setmensajeoperacion($base->getError());
		 		
			}
		}else {
		 	$this->setmensajeoperacion($base->getError());
		 	
		}	
		return $arregloEmpresa;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO empresa(enombre,  edireccion) 
				VALUES ('".$this->getNombre()."','".$this->getDireccion()."')";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());					
			}
		}else{
			$this->setmensajeoperacion($base->getError());	
		}
		return $resp;
	}
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE empresa SET enombre='".$this->getNombre()."',edireccion='".$this->getDireccion()."'
                           WHERE idempresa=". $this->getIdEmpresa();
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
				$consultaBorra="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa();
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