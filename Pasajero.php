<?php

/**
 * Modificar la clase Viaje para que ahora los pasajeros sean un objeto 
 * que tenga los atributos nombre, apellido, numero de documento y teléfono. 
 */

class Pasajero{
    private $nombre;
    private $apellido;
    private $dni;
    private $telefono;
    private $objViaje;
    private $mensajeoperacion;

    public function __construct(){
        $this->nombre = "";
        $this->apellido = "";
        $this->dni = "";
        $this->telefono="";
        $this->objViaje=new Viaje();
    }

    public function cargar($nombre, $apellido, $dni, $telefono,$objViaje){
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setDni($dni);
        $this->setTelefono($telefono);
        $this->setObjViaje($objViaje);
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

    public function getDni(){
        return $this->dni;
    }
 
    public function setDni($dni){
        $this->dni = $dni;
    }
 
    public function getTelefono(){
        return $this->telefono;
    }

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function getObjViaje(){
        return $this->objViaje;
    }

    public function setObjViaje($objViaje){
        $this->objViaje = $objViaje;
    }

    public function __toString(){
        return "Nombre:".$this->getNombre().". Apellido:".$this->getApellido().
                ". DNI:".$this->getDni().". Telefono:".$this->getTelefono().".\n";
    }


    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }


    public function modificarPasajero($nombre,$apellido,$dni,$tel){
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setDni($dni);
        $this->setTelefono($tel);
        return $this;
    }
/**
 * METODOS NECESARIOS PARA COMUNICAR CON LA BD:
 */

    public function insertar(){
        $base=new BaseDatos();
        $resp= false;
        $consultaInsertar="INSERT INTO pasajero(rdocumento, pnombre, papellido,  ptelefono, idviaje) 
                VALUES (".$this->getDni().",'".$this->getNombre()."','".$this->getApellido()."','"
                        .$this->getTelefono()."','".$this->getObjViaje()->getCodigo()."')";
        
        if($base->Iniciar()){
            if($base->Ejecutar($consultaInsertar)){
                $resp=  true;
            }else {
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
        $consultaModifica="UPDATE pasajero SET pnombre='".$this->getNombre()."',papellido='".$this->getApellido().
                            "',ptelefono='".$this->getTelefono()."' WHERE rdocumento=". $this->getDni();
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
                $consultaBorra="DELETE FROM pasajero WHERE rdocumento=".$this->getDni();
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
	
    public function Buscar($dni){
		$base=new BaseDatos();
		$consultaPersona="Select * from pasajero where rdocumento=".$dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){					
				    $this->setDni($dni);
					$this->setNombre($row2['pnombre']);
					$this->setApellido($row2['papellido']);
					$this->setTelefono($row2['ptelefono']);
                    $idViaje=$row2['idviaje'];
                    $objViaje=new Viaje();
                    $objViaje->Buscar($idViaje);
                    $this->setObjViaje($objViaje);
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
	    $arregloPersona = null;
		$base=new BaseDatos();
		$consultaPersonas="Select * from pasajero ";
		if ($condicion!=""){
		    $consultaPersonas=$consultaPersonas.' where '.$condicion;
		}
		$consultaPersonas.=" order by papellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersonas)){				
				$arregloPersona= array();
				while($row2=$base->Registro()){
					
					$dni=$row2['rdocumento'];
					$nombre=$row2['pnombre'];
					$apellido=$row2['papellido'];
					$telefono=$row2['ptelefono'];
                    $idViaje=$row2['idviaje'];
                    $objViaje=new Viaje();
                    $objViaje->Buscar($idViaje);

					$pasajero=new Pasajero();
					$pasajero->cargar($nombre,$apellido,$dni,$telefono,$objViaje);
					array_push($arregloPersona,$pasajero);
				}
		 	}else{
		 		$this->setmensajeoperacion($base->getError());
			}
		}else {
		 	$this->setmensajeoperacion($base->getError()); 	
		}	
		return $arregloPersona;
	}	


}


?>