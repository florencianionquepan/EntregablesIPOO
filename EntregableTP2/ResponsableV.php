<?php
/**
 * También se desea guardar la información de la persona responsable de realizar el viaje, 
 * para ello cree una clase ResponsableV que registre el número de empleado, número de licencia, nombre y apellido.
 *La clase Viaje debe hacer referencia al responsable de realizar el viaje.
 */

class ResponsableV{
    private $numEmpleado;
    private $NumLicencia;
    private $nombre;
    private $apellido;

    public function __construct($numEmpleado, $NumLicencia, $nombre, $apellido){
        $this->numEmpleado = $numEmpleado;
        $this->NumLicencia = $NumLicencia;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
    }

    
    public function getNumEmpleado(){
        return $this->numEmpleado;
    }

    public function setNumEmpleado($numEmpleado){
        $this->numEmpleado = $numEmpleado;
    }
 
    public function getNumLicencia(){
        return $this->NumLicencia;
    }

    public function setNumLicencia($NumLicencia){
        $this->NumLicencia = $NumLicencia;
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

    public function __toString(){
        return "Numero de empleado: ".$this->getNumEmpleado().".Numero de licencia: ".$this->getNumLicencia().
                ".Nombre: ".$this->getNombre().".Apellido: ".$this->getApellido()."\n";
    }
}

?>