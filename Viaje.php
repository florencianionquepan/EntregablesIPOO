<?php
/**
 * Modificar la clase Viaje para que ahora los pasajeros sean un objeto 
 * que tenga los atributos nombre, apellido, numero de documento y teléfono. 
 * El viaje ahora contiene una referencia a una colección de objetos de la clase Pasajero. 
 * También se desea guardar la información de la persona responsable de realizar el viaje, 
 * para ello cree una clase ResponsableV que registre el número de empleado, número de licencia, nombre y apellido.
 *  La clase Viaje debe hacer referencia al responsable de realizar el viaje.
 */


class Viaje{
    private $codigo;
    private $destino;
    private $cantMaximaPasajeros;
    private $pasajeros;
    private $responsableV;
    private $objEmpresa;
    private $importe;
    private $tipoAsiento;
    private $idaVuelta;
    private $mensajeoperacion;

    public function __construct(){
        $this->codigo="";
        $this->destino="";
        $this->cantMaximaPasajeros="";
        $this->pasajeros=[];
        $this->responsableV=new ResponsableV;
        $this->objEmpresa=new Empresa;
        $this->importe="";
        $this->tipoAsiento="";
        $this->idaVuelta="";
    }

    public function cargar($destino,$cantMaximaPasajeros,$responsableV,
                            $objEmpresa,$importe,$tipoAsiento,$idaVuelta){
        $this->setDestino($destino);
        $this->setCantMaximaPasajeros($cantMaximaPasajeros);
        $this->setResponsableV($responsableV);
        $this->setObjEmpresa($objEmpresa);
        $this->setImporte($importe);
        $this->setTipoAsiento($tipoAsiento);
        $this->setIdaVuelta($idaVuelta);
    }
 
    public function cargarConId($codigo,$destino,$cantMaximaPasajeros,$responsableV,
                                $objEmpresa,$importe,$tipoAsiento,$idaVuelta){
        $this->setCodigo($codigo);
        $this->setDestino($destino);
        $this->setCantMaximaPasajeros($cantMaximaPasajeros);
        $this->setResponsableV($responsableV);
        $this->setObjEmpresa($objEmpresa);
        $this->setImporte($importe);
        $this->setTipoAsiento($tipoAsiento);
        $this->setIdaVuelta($idaVuelta);
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function setCodigo($codigo){
        $this->codigo = $codigo;
    }

    public function getDestino(){
        return $this->destino;
    }

    public function setDestino($destino){
        $this->destino = $destino;
    }
 
    public function getCantMaximaPasajeros(){
        return $this->cantMaximaPasajeros;
    }

    public function setCantMaximaPasajeros($cantMaximaPasajeros){
        $this->cantMaximaPasajeros = $cantMaximaPasajeros;
    }
 
    public function getPasajeros(){
        return $this->pasajeros;
    }

    public function setPasajeros($pasajeros){
        $this->pasajeros = $pasajeros;
    }

    public function getResponsableV(){
        return $this->responsableV;
    }

    public function setResponsableV($responsableV){
        $this->responsableV = $responsableV;
    }

    public function getObjEmpresa(){
        return $this->objEmpresa;
    }

    public function setObjEmpresa($objEmpresa){
            $this->objEmpresa = $objEmpresa;
    }

    public function getImporte(){
            return $this->importe;
    }

    public function setImporte($importe){
            $this->importe = $importe;
    }

    public function getTipoAsiento(){
            return $this->tipoAsiento;
    }

    public function setTipoAsiento($tipoAsiento){
            $this->tipoAsiento = $tipoAsiento;
    }

    public function getIdaVuelta(){
            return $this->idaVuelta;
    }

    public function setIdaVuelta($idaVuelta){
            $this->idaVuelta = $idaVuelta;
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }
 
    //setea un pasajero creado a su coleccion de pasajeros:
    function setearPasajeroUnoaUno($pasajero){
        $arrayPasajeros=$this->getPasajeros();
        array_push($arrayPasajeros,$pasajero);
        $this->setPasajeros($arrayPasajeros);
    }

    
    //Recorre la lista de Pasajeros y va mostrando la información de cada uno de ellos:
    public function verPasajeros(){
        $personas=[];
        $personas=$this->getPasajeros();
        $infoPersonas="";
        if(count($personas)>0){
            $infoPersonas="Datos de Pasajeros:\n";
        }
        for ($i=0;$i<count($personas);$i++){
            $infoPersonas=$infoPersonas.$personas[$i]; 
        }
        return $infoPersonas;
    }

    public function __toString(){
        return "Codigo del viaje: " .$this->getCodigo(). ". Destino: " .$this->getDestino().
        ".Limite de pasajeros: ".$this->getCantMaximaPasajeros().
        ". \nDatos del responsable de viaje: ".$this->getResponsableV()."Empresa:".$this->getObjEmpresa(). 
        "Importe del viaje:".$this->getImporte().". Tipo de asiento:".$this->getTipoAsiento().
        ".Ida y vuelta:".$this->getIdaVuelta()."\n".$this->verPasajeros()."\n";
    }
    
    

    //Me retorna el pasajero encontrado por dni, y el indice en el que se encuentra en el array:
    public function buscarPasajero($dni){
        $arrayPasajeros=$this->getPasajeros();
        $i=0;
        $encontrado=false;
        $total=count($arrayPasajeros);
        while ($i<$total && !$encontrado){
            $dniPasajero=$arrayPasajeros[$i]->getDni();

            if ($dniPasajero==$dni){
                $encontrado=true;
                $pasajero=$arrayPasajeros[$i];
                $indice=$i;
                $datos=[$pasajero,$indice];
            }
            $i++;

        }
        if ($i==$total && !$encontrado){
            $datos="error";
        }
        return $datos;
    }

    /*
    //setea un pasajero modificado a su coleccion de pasajeros:
    function setearPasajeroUnoaUno($objModificar, $ind){
        $arrayPasajeros=$this->getPasajeros();
        $arrayPasajeros[$ind]=$objModificar;
        $this->setPasajeros($arrayPasajeros);
    }
*/

    //METODOS PARA BD

		
    public function Buscar($idviaje){
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje where idviaje=".$idviaje;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){
				if($row2=$base->Registro()){					
				    $this->setCodigo($idviaje);
					$this->setDestino($row2['vdestino']);
					$this->setCantMaximaPasajeros($row2['vcantmaxpasajeros']);
                    $idEmpresa=$row2['idempresa'];
                    $objEmpresa=new Empresa();
                    $objEmpresa->Buscar($idEmpresa);
				    $this->setObjEmpresa($objEmpresa);
                    $numEmpleado=$row2['rnumeroempleado'];
                    $objResponsableV=new ResponsableV();
                    $objResponsableV->Buscar($numEmpleado);
                    $this->setResponsableV($objResponsableV);
                    $this->setImporte($row2['vimporte']);
                    $this->setTipoAsiento($row2['tipoAsiento']);
                    $this->setIdaVuelta($row2['idayvuelta']);
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
    
//me devuelve el array de viajes, pero no con los objetos empresa y responsable sino con sus id:
//como en el test no voy a tener un array de viajes, no me preocupo por modificar este metodo en esta clase POR AHORA
	public function listar($condicion=""){
	    $arregloViaje = null;
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje ";
		if ($condicion!=""){
		    $consultaViaje=$consultaViaje.' where '.$condicion;
		}
		$consultaViaje.=" order by idviaje ";
		//echo $consultaViaje;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){				
				$arregloViaje= array();
				while($row2=$base->Registro()){
					
					$id=$row2['idviaje'];
/* 					$destino=$row2['vdestino'];
                    $maxPas=$row2['vcantmaxpasajeros'];
                    $idEmpresa=$row2['idempresa'];
                    $numEmp=$row2['rnumeroempleado'];
					$importe=$row2['vimporte'];
					$tipoAsiento=$row2['tipoAsiento'];
                    $idaVuelta=$row2['idayvuelta']; */
				
					$viaje=new Viaje();
                    $viaje->Buscar($id);
					//$viaje->cargarConId($id,$destino,$maxPas,$numEmp,$idEmpresa,$importe,$tipoAsiento, $idaVuelta);
					array_push($arregloViaje,$viaje);
				}
		 	}else {
		 		$this->setmensajeoperacion($base->getError());
			}
		 }else {
		 	$this->setmensajeoperacion($base->getError());
		}	
		return $arregloViaje;
	}	

    //Retorna el ultimo id generado:
    public function obtenerUltimoId(){
        $base=new BaseDatos();
		$consultaViaje="Select MAX(idviaje) from viaje";
        if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){	
                if($row2=$base->Registro()){
                    $resp=$row2['MAX(idviaje)'];
                }
		 	}else {
		 		$this->setmensajeoperacion($base->getError());
			}
		 }else {
		 	$this->setmensajeoperacion($base->getError());
		}
        return $resp;
    }

    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, 
                            rnumeroempleado, vimporte, tipoAsiento, idayvuelta) 
				VALUES ('".$this->getDestino()."',".$this->getCantMaximaPasajeros().",".$this->getObjEmpresa()->getIdEmpresa().
                ",".$this->getResponsableV()->getNumEmpleado().",".$this->getImporte().",'".$this->getTipoAsiento()."','".$this->getIdaVuelta()."')";
		
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
		$consultaModifica="UPDATE viaje SET vdestino='".$this->getDestino()."',vcantmaxpasajeros='".$this->getCantMaximaPasajeros().
                            "',vimporte='".$this->getImporte()."',tipoAsiento='".$this->getTipoAsiento()."',idayvuelta='".$this->getIdaVuelta().
                            "'WHERE idviaje=". $this->getCodigo();
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
				$consultaBorra="DELETE FROM viaje WHERE idviaje=".$this->getCodigo();
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