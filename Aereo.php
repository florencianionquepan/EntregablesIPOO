<?php
/**
 * De los viajes aéreos se conoce el número del vuelo, 
 * la categoría del asiento (primera clase o no), 
 * nombre de la aerolínea, 
 * y la cantidad de escalas del vuelo en caso de tenerlas. 
 */

 class Aereo extends Viaje{
    private $nroVuelo;
    private $categoriaAsiento;
    private $nombreAerolinea;
    private $cantEscalas;

    public function __construct($codigo,$destino,$cantMaximaPasajeros,$pasajeros,$responsableV, $importe, $idaVuelta,
                                $nroVuelo,$categoriaAsiento,$nombreAerolinea,$cantEscalas){
        parent:: __construct($codigo,$destino,$cantMaximaPasajeros,$pasajeros,$responsableV, $importe, $idaVuelta);
        $this->nroVuelo=$nroVuelo;
        $this->categoriaAsiento=$categoriaAsiento;
        $this->nombreAerolinea=$nombreAerolinea;
        $this->cantEscalas=$cantEscalas;
    }

    public function getNroVuelo(){
        return $this->nroVuelo;
    }

    public function setNroVuelo($nroVuelo){
        $this->nroVuelo = $nroVuelo;
    }

    public function getCategoriaAsiento(){
        return $this->categoriaAsiento;
    }

 
    public function setCategoriaAsiento($categoriaAsiento){
        $this->categoriaAsiento = $categoriaAsiento;
    }

     public function getNombreAerolinea(){
        return $this->nombreAerolinea;
    }

    public function setNombreAerolinea($nombreAerolinea){
        $this->nombreAerolinea = $nombreAerolinea;
    }

    public function getCantEscalas(){
        return $this->cantEscalas;
    }

    public function setCantEscalas($cantEscalas){
        $this->cantEscalas = $cantEscalas;
    }

    public function __toString(){
        return parent::__toString()."El numero de vuelo es:".$this->getNroVuelo().
        ". La categoria del asiento:".$this->getCategoriaAsiento().
        ". El nombre de la aerolinea:".$this->getNombreAerolinea().
        ". Cantidad de escalas:".$this->getCantEscalas()."\n";
    }

    public function venderPasaje($pasajero){
        if (parent::hayPasajeDisponible()){
            $importeNuevo=parent::venderPasaje($pasajero);
            if ($this->getCategoriaAsiento()=="primera clase"){
                if ($this->getCantEscalas()==0){
                    $importeNuevo=$importeNuevo*1.4;
                }else if($this->getCantEscalas()>0){
                    $importeNuevo=$importeNuevo*1.6;
                }
            }
            return  $importeNuevo;
        }
    }
 }



?>