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


}


?>