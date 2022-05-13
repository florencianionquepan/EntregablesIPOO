<?php

/**
 * De los viajes terrestres se conoce la comodidad del asiento, si es semicama o cama.
 */

class Terrestre extends Viaje{
    private $comodidadAsiento;

    public function __construct($codigo,$destino,$cantMaximaPasajeros,$pasajeros,$responsableV, $importe, $idaVuelta, 
                                $comodidadAsiento){
        parent::__construct($codigo,$destino,$cantMaximaPasajeros,$pasajeros,$responsableV, $importe, $idaVuelta);
        $this->comodidadAsiento=$comodidadAsiento;
    }

    public function getComodidadAsiento(){
        return $this->comodidadAsiento;
    }

    public function setComodidadAsiento($comodidadAsiento){
        $this->comodidadAsiento = $comodidadAsiento;
    }

    public function __toString(){
        return parent::__toString()."Comodidad del asiento:".$this->getComodidadAsiento()."\n";
    }

    public function venderPasaje($pasajero){
        if (parent::hayPasajeDisponible()){
            $importeNuevo=parent::venderPasaje($pasajero);
            if ($this->getComodidadAsiento()=="cama"){
                $importeNuevo=$importeNuevo*1.25;
            }
            return $importeNuevo;
        }
    }

}


?>