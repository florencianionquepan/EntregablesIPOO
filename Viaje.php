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
    private $importe;
    private $idaVuelta;

    public function __construct($codigo,$destino,$cantMaximaPasajeros,$pasajeros,$responsableV, $importe, $idaVuelta){
        $this->codigo=$codigo;
        $this->destino=$destino;
        $this->cantMaximaPasajeros=$cantMaximaPasajeros;
        $this->pasajeros=$pasajeros;
        $this->responsableV=$responsableV;
        $this->importe=$importe;
        $this->idaVuelta=false;
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

    public function modificarPasajero($ind,$nombre,$apellido,$dni,$tel){
        $arrayPasajeros=$this->getPasajeros();
        $objModificar=$arrayPasajeros[$ind];
        $objModificar->setNombre($nombre);
        $objModificar->setApellido($apellido);
        $objModificar->setDni($dni);
        $objModificar->setTelefono($tel);
        $arrayPasajeros[$ind]=$objModificar;
        $this->setPasajeros($arrayPasajeros);
        return $arrayPasajeros;
    }

    public function __toString(){
        return "Codigo del viaje: " .$this->getCodigo(). ". Destino: " .$this->getDestino().
        ".Limite de pasajeros: ".$this->getCantMaximaPasajeros().".Datos de Pasajeros:\n".$this->verPasajeros().
        "Datos del responsable de viaje: ".$this->getResponsableV()."El importe es: ".$this->getImporte().
        "Es ida y vuelta?:".$this->getIdaVuelta()? "SI\n":"NO\n";
    }

    public function getResponsableV(){
        return $this->responsableV;
    }

    public function setResponsableV($responsableV){
        $this->responsableV = $responsableV;
    }

    public function getImporte(){
        return $this->importe;
    }

    public function setImporte($importe){
        $this->importe = $importe;
    }

    public function getIdaVuelta(){
        return $this->idaVuelta;
    }

    public function setIdaVuelta($idaVuelta){
        $this->idaVuelta = $idaVuelta;
    }
}

?>