<?php
/**
 * La empresa de Transporte de Pasajeros “Viaje Feliz” quiere registrar la información referente a sus viajes. 
 * De cada viaje se precisa almacenar el código del mismo, destino, cantidad máxima de pasajeros y los pasajeros del viaje.
 * Realice la implementación de la clase Viaje e implemente los métodos necesarios para modificar 
 * los atributos de dicha clase (incluso los datos de los pasajeros). 
 * Utilice un array que almacene la información correspondiente a los pasajeros. 
 * Cada pasajero es un array asociativo con las claves “nombre”, “apellido” y “numero de documento”.
 * 
 * 
 * 
 */

class Viaje{
    private $codigo;
    private $destino;
    private $cantMaximaPasajeros;
    private $pasajeros;

    public function __construct($codigo,$destino,$cantMaximaPasajeros,$pasajeros){
        $this->codigo=$codigo;
        $this->destino=$destino;
        $this->cantMaximaPasajeros=$cantMaximaPasajeros;
        $this->pasajeros=$pasajeros;
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
            $infoPersonas=$infoPersonas. "\n El pasajero " .($i+1)." " ; 
            foreach($personas[$i] as $key=>$value){
                $infoPersonas=$infoPersonas."posee ". $key. ": " .$value. ". "; 
            }
        }
        return $infoPersonas;
    }

    public function modificarPasajero($ind,$nuevoNombre,$nuevoApellido,$nuevoDni){
        $arrayPasajeros=$this->getPasajeros();
        $fcModificar=$arrayPasajeros[$ind];
        $fcModificar["nombre"]=$nuevoNombre;
        $fcModificar["apellido"]=$nuevoApellido;
        $fcModificar["dni"]=$nuevoDni;
        $arrayPasajeros[$ind]=$fcModificar;
        $this->setPasajeros($arrayPasajeros);
        return $arrayPasajeros;
    }

    public function __toString(){
        return "Codigo del viaje: " .$this->getCodigo(). ". Destino: " .$this->getDestino().". Limite de pasajeros: ".$this->getCantMaximaPasajeros().". Datos de Pasajeros:".$this->verPasajeros()."\n"; 
    }

}

?>

