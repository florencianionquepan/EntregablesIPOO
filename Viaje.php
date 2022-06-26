<?php
/**
 * Modificar la clase Viaje para que ahora los pasajeros sean un objeto 
 * que tenga los atributos nombre, apellido, numero de documento y teléfono. 
 * El viaje ahora contiene una referencia a una colección de objetos de la clase Pasajero. 
 * También se desea guardar la información de la persona responsable de realizar el viaje, 
 * para ello cree una clase ResponsableV que registre el número de empleado, número de licencia, nombre y apellido.
 *  La clase Viaje debe hacer referencia al responsable de realizar el viaje.
 */

 /**
  * La empresa de transporte desea gestionar la información correspondiente a los Viajes que pueden ser: 
    * Terrestres o Aéreos,   guardar su importe e indicar si el viaje es de ida y vuelta.
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
        $this->pasajeros="";
        $this->responsableV="";
        $this->$objEmpresa="";
        $this->$importe="";
        $this->$tipoAsiento="";
        $this->$idaVuelta="";
    }

    public function cargar($codigo,$destino,$cantMaximaPasajeros,$pasajeros,$responsableV,
                            $objEmpresa,$importe,$tipoAsiento,$idaVuelta){
        $this->setCodigo($codigo);
        $this->setDestino($destino);
        $this->setCantMaximaPasajeros($cantMaximaPasajeros);
        $this->setPasajeros($pasajeros);
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

    /*
    //Recorre la lista de Pasajeros y va mostrando la información de cada uno de ellos:
    public function verPasajeros(){
        $personas=[];
        $personas=$this->getPasajeros();
        $infoPersonas="";
        for ($i=0;$i<count($personas);$i++){
            $infoPersonas=$infoPersonas.$personas[$i]; 
        }
        return $infoPersonas;
    }


    //Me retorna el pasajero encontrado por dni, y el indice en el que se encuentra en el array:
    public function buscarPasajero($parametro){
        $arrayPasajeros=$this->getPasajeros();
        $i=0;
        $encontrado=false;
        while ($i<count($arrayPasajeros) && !$encontrado){
            $dniPasajero=$arrayPasajeros[$i]->getDni();
            //el parametro es el dni:
            if ($dniPasajero==$parametro){
                $encontrado=true;
                $pasajero=$arrayPasajeros[$i];
                $indice=$i;
                $datos=[$pasajero,$indice];
            }
            $i++;
        }
        if ($i>count($arrayPasajeros)){
            return "error";
        }
        return $datos;
    }

    public function __toString(){
        return "Codigo del viaje: " .$this->getCodigo(). ". Destino: " .$this->getDestino().
        ".Limite de pasajeros: ".$this->getCantMaximaPasajeros().".Datos de Pasajeros:\n".$this->verPasajeros().
        "Datos del responsable de viaje: ".$this->getResponsableV();
    }


     //El importe del pasaje a vender no se setea al atributo de la clase, ya que sino al vender un pasaje nuevo
    //el importe del atributo ya estaria afectado por las condiciones del viaje, y se volverían a aplicar los aumentos
    public function venderPasaje($pasajero){
        $coleccPasaj=$this->getPasajeros();
        if ($this->hayPasajeDisponible()){
            array_push($coleccPasaj,$pasajero);
            $this->setPasajeros($coleccPasaj);
            $importeNuevo=$this->aumentarImporte();
        }
        return $importeNuevo;
    }

    protected function hayPasajeDisponible(){
        $coleccPasaj=$this->getPasajeros();
        return count($coleccPasaj)<$this->getCantMaximaPasajeros();
    }

    //aumenta el importe en caso de ser un viaje de ida y vuelta:
    protected function aumentarImporte(){
        $importeNuevo=$this->getImporte();
        if ($this->getIdaVuelta()){
            $importeNuevo=$this->getImporte()*1.5;
        }
        return $importeNuevo;
    }

 

    //setea un pasajero modificado a su coleccion de pasajeros:
    function setearPasajeroModificado($objModificar, $ind){
        $arrayPasajeros=$this->getPasajeros();
        $arrayPasajeros[$ind]=$objModificar;
        $this->setPasajeros($arrayPasajeros);
    }
*/

    //METODOS PARA BD

    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, 
                            rnumeroempleado, vimporte, tipoAsiento, idayvuelta) 
				VALUES (".$this->getDestino().",'".$this->getCantMaximaPasajeros()."','".$this-> getObjEmpresa().
                        "','".$this->getResponsableV()."','".$this->getImporte()."','".$this->getTipoAsiento()."','".$this->getIdaVuelta()."')";
		
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
		$consultaModifica="UPDATE viaje SET vdestino='".$this->getDestino()."',vcantmaxpasajeros='".$this->getCantMaximaPasajeros();
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