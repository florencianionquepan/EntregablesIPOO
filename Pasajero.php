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
        $this->objViaje="";
    }

    public function cargar($nombre, $apellido, $dni, $telefono){
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setDni($dni);
        $this->setTelefono($telefono);
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
                ". DNI:".$this->getDni().". Telefono:".$this->getTelefono().$this->getObjViaje()."\n";
    }


    public function getMensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function setMensajeoperacion($mensajeoperacion){
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
                        .$this->getTelefono()."','".$this->getObjViaje()."')";
        
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
        $consultaModifica="UPDATE pasajero SET pnombre='".$this->getNombre()."',papellido='".$this->getApellido()."'
                        ,ptelefono='".$this->getTelefono()."' WHERE rdocumento=". $this->getDni();
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

    	/**
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
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
                    $this->setObjViaje($row2['idviaje']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
}


?>