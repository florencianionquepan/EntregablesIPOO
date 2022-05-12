<?php

/**
 * De los viajes terrestres se conoce la comodidad del asiento, si es semicama o cama.
 */

class Terrestre extends Viaje{
    private $comodidadAsiento;

    public function __construct($codigo,$destino,$cantMaximaPasajeros,$pasajeros,$responsableV, $importe, $idaVuelta, $comodidadAsiento){
        parent::__construct($codigo,$destino,$cantMaximaPasajeros,$pasajeros,$responsableV, $importe, $idaVuelta);
        $this->comodidadAsiento=$comodidadAsiento;
    }

    public function getComodidadAsiento(){
        return $this->comodidadAsiento;
    }

    public function setComodidadAsiento($comodidadAsiento){
        $this->comodidadAsiento = $comodidadAsiento;
    }

    public function _toString(){
        return parent::_toString()."Comodidad del asiento:".$this->getComodidadAsiento()."\n";
    }
}


?>