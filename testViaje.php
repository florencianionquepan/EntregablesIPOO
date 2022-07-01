<?php

include "BaseDatos.php";
include "Pasajero.php";
include "ResponsableV.php";
include "Viaje.php";
include "Empresa.php";

$objViaje=new Viaje();
$ultimoIdViaje=$objViaje->obtenerUltimoId();

menuEmpresas();

function menuEmpresas(){
    do{
        echo "\n------Menú de opciones Empresa------\n"
            ."1) Cargar nueva empresa.\n"
            ."2) Mostrar todas las empresas.\n"
            ."3) Modificar empresa.\n"
            ."4) Borrar una empresa. \n"
            ."5) Ir al menú de viajes \n"
            ."6) Salir \n";

            echo "Ingrese su eleccion: ";
            $eleccion = trim(fgets(STDIN));            
    
            switch($eleccion){
                case 1:$idEmpresa=crearEmpresa();break;
                case 2:echo listarEmpresas();break;
                case 3:modificarEmpresa();break;
                case 4:eliminarEmpresa();break;
                case 5:menuViajes();break;
                case 6: echo "Usted ha salido del menú de empresa";break;
                default: echo "elección ingresada no valida, por favor ingrese otra\n";break;
            }
    }while($eleccion!=6);
}

/*
 * FUNCION QUE PERMITEN CREAR UNA EMPRESA: 
 */
function crearEmpresa(){
    echo "Ingrese Nombre: ";
    $nombre=trim(fgets(STDIN));
    echo "Ingrese direccion: ";
    $dire=trim(fgets(STDIN));
    $objE=new Empresa();
    $objE->cargar($nombre,$dire);
    $resultadoE=$objE->insertar();
    echo $resultadoE?"Empresa cargada ok \n":$objE->getmensajeoperacion();
    $idEmpresa=$objE->obtenerUltimoId();
    $objE->Buscar($idEmpresa);
    echo $objE;
    return $objE;
}

/*
 * FUNCIONES QUE PERMITEN LISTAR LAS EMPRESAS CON SUS VIAJES: 
 */
function listarEmpresas(){
    $empresa=new Empresa();
    $coleccEmpresas=$empresa->listar();
    $empresasConViajes=[];
    foreach($coleccEmpresas as $emp){
        $empresaConViajes=setearViajes($emp->getIdEmpresa());
        array_push($empresasConViajes,$empresaConViajes);
    }
    $empresasString=arrayToString($empresasConViajes);
    return $empresasString;
}

function setearViajes($id){
    $objViaje=new Viaje();
    $viajes=$objViaje->listar("idempresa=".$id);
    $empresa=new Empresa;
    $empresa->Buscar($id);
    $empresa->setColeccViajes($viajes);
    return $empresa;
}

/*
 * FUNCIONES QUE PERMITEN MODIFICAR NOMBRE Y DIRECCION DE EMPRESA
 */
function modificarEmpresa(){
    echo "Escriba el id. de la empresa a modificar:\n";
    $id=trim(fgets(STDIN));
    $objEmpresa=seleccionarEmpresa($id);
    echo "Escriba el nuevo nombre:\n";
    $nuevoNom=trim(fgets(STDIN));
    echo "Escriba la nueva direccion: \n";
    $nuevaDire=trim(fgets(STDIN));
    //actualizo el obj. en PHP
    $objEmpresa->setNombre($nuevoNom);
    $objEmpresa->setDireccion($nuevaDire);
    $resp=$objEmpresa->modificar();
    echo $resp?"La empresa se modifico OK \n":$objEmpresa->getmensajeoperacion();
    echo $objEmpresa;
}

/*
 * FUNCIONES QUE PERMITEN ELIMINAR UNA EMPRESA. SI POSEE VIAJES DESDE ESTE MENÚ NO SE PUEDE ELIMINAR.
 */
function eliminarEmpresa(){
    echo "Escriba el id. de la empresa a eliminar:\n";
    $id=trim(fgets(STDIN));
    $objEmpresa=seleccionarEmpresa($id);
    $tieneViajes=tieneViajes($id);
    if($tieneViajes){
        echo "La empresa seleccionada posee viajes. No se puede eliminar. Si lo desea, dirijase al menú de viajes y elimine primero aquellos viajes que posea.\n";
    }else{
        $resp=$objEmpresa->eliminar();
        echo $resp?"La empresa fue eliminada OK":$objEmpresa->getmensajeoperacion();   
    }
}

function tieneViajes($id){
    $viajes=$objViaje->listar("idempresa=".$id);
    $tieneViajes=false;
    if(count($viajes)>0){
        $tieneViajes=true;
    }
    return $tieneViajes;
}

/*
 * MENU VIAJES: 
 */

function menuViajes(){
    do{
        echo "------Menú de opciones Viajes------\n"
            ."1) Cargar información de un nuevo viaje.\n"
            ."2) Mostrar todos los viajes.\n"
            ."3) Modificar viaje.\n"
            ."4) Borrar un viaje. \n"
            ."5) Agregar pasajeros a un viaje \n"
            ."6) Eliminar pasajeros de un viaje \n"
            ."7) Salir de menú de viajes \n";

            echo "Ingrese su eleccion: ";
            $eleccion = trim(fgets(STDIN));            
    
            switch($eleccion){
                case 1:cargarViaje();break;
                case 2:echo listarViajes();break;
                case 3:modificarViaje();break;
                case 4:eliminarViaje();break;
                case 5:agregarPasajeros();break;
                case 6:eliminarPasajeros();break;
                case 7: echo "Usted ha salido del menú de viajes";break;
                default: echo "elección ingresada no valida, por favor ingrese otra\n";break;
            }
    }while($eleccion!=7);
}

/**
 * FUNCIONES PARA LISTAR LOS VIAJES
 */
function arrayToString($arreglo){
    $msn="";
    for ($i=0;$i<count($arreglo);$i++){
        $msn=$msn.$arreglo[$i]; 
    }
    return $msn;
}

function listarViajes(){
    $objViaje=new Viaje();
    $coleccViajes=$objViaje->listar();
    $viajesConPasaj=[];
    foreach($coleccViajes as $viaje){
        $viajeConPasaj=setearPasajeros($viaje->getCodigo());
        array_push($viajesConPasaj,$viajeConPasaj);
    }
    $viajesString=arrayToString($viajesConPasaj);
    return $viajesString;
}


function mostrarViaje($id){
    $objViaje=setearPasajeros($id);
    echo $objViaje;
}

/**
 * FUNCIONES PARA BORRAR UN VIAJE
 */

 function eliminarViaje(){
    echo "Escriba el codigo del viaje a eliminar: ";
    $idBorrar=trim(fgets(STDIN));
    $existe=existeViaje($idBorrar);
    if($existe){
        $objPasajero=new Pasajero();
        $coleccPasajeros=$objPasajero->listar("idviaje=".$idBorrar);
        if(count($coleccPasajeros)>0){
            eliminarViajeConPasajeros($idBorrar,$coleccPasajeros);
        }else{
            $objViaje=new Viaje();
            $objViaje->Buscar($id);
            $resp=$objViaje->eliminar();
            echo $resp?"Se ha eliminado correctamente el viaje\n":$objViaje->getmensajeoperacion();
        }
    }else{
        echo "No existe el viaje con el id. ingresado\n";
    }
 }

 function eliminarViajeConPasajeros($idBorrar,$coleccPasajeros){
    $objViaje=setearPasajeros($idBorrar);
    echo "Se borrará el siguiente viaje y los pasajeros siguientes: \n";
    echo $objViaje;
    echo "Desea continuar?(si/no): \n";
    $rta=trim(fgets(STDIN));
    if($rta=="si"){
        borrarPasajeros($coleccPasajeros);
        $resp=$objViaje->eliminar();
        echo $resp?"Se ha eliminado correctamente el viaje\n":$objViaje->getmensajeoperacion();
    }else{
        echo "No se ha eliminado el viaje \n";
    }
 }

 //esto esta al dope me parece
 function existeViaje($id){
    $viaje=new Viaje();
    $viajes=$viaje->listar();
    $existe=false;
    $i=0;
    while($i<count($viajes) & !$existe){
        if($viajes[$i]->getCodigo()==$id){
            $existe=true;
        }
        $i++;
    }
    return $existe;
 }

 function borrarPasajeros($pasajeros){
    for($i=0;$i<count($pasajeros);$i++){
        $pasajeros[$i]->eliminar();
    }
    echo "Se han eliminado los pasajeros \n";
 }

//Esta funcion busca todos los pasajeros con el idViaje que le paso por parámetro, los setea a ese objViaje
//Y me retorna el viaje con la coleccion de pasajeros
function setearPasajeros($id){
    $objPasajero=new Pasajero();
    $coleccPasajeros=$objPasajero->listar("idviaje=".$id);
    //AHORA A ESE VIAJE LE SETEO LA COLECCION PARA PODER MOSTRARLO
    $objViaje=new Viaje();
    $objViaje->Buscar($id);
    $objViaje->setPasajeros($coleccPasajeros);
    return $objViaje;
}

/**
 * FUNCIONES QUE PERMITEN CREAR UN VIAJE 
 */

//Solicita todos los valores de los atributos de la nueva instancia de la clase Viaje:
function cargarViaje(){
    echo "Ingrese destino del viaje: ";
    $destino = trim(fgets(STDIN));
    existeDestino($destino);
    if(existeDestino($destino)){
        echo "No es posible crear un viaje con un destino ya creado \n";
    }else{
        echo "Destino ingresado correctamente \n";
        echo "Ingrese la capacidad máxima de pasajeros: ";
        $capMaxima=intval(trim(fgets(STDIN)));
    
        echo "Escoja alguna empresa de viaje:\n";
        verEmpresas();
        echo "Ingrese el numero de empresa elegido o 0 para crear una nueva: \n";
        $codE=trim(fgets(STDIN));
        if($codE==0){
            echo "Ingrese los datos de la nueva empresa: ";
            $objEmpresa=crearEmpresa();
        }else{
            $objEmpresa=seleccionarEmpresa($codE);
        }
    
        echo "Escoja algún responsable de viaje: \n";
        verResponsables();
        echo "Ingrese el numero del responsable elegido o 0 para crear uno nuevo: \n";
        $codigoResp=trim(fgets(STDIN));
        if($codigoResp==0){
            echo "Ingrese los datos del responsable del viaje: ";
            $objResponsable=cargarResponsable();
        }else{
            $objResponsable=ingresarResponsable($codigoResp);
        }
        echo "Ingrese importe del viaje: ";
        $importe = intval(trim(fgets(STDIN)));
        echo "Ingrese tipo de asiento del viaje: ";
        $tipo = trim(fgets(STDIN));
        echo "Ingrese si es ida y vuelta (SI/NO): ";
        $idaVuelta=trim(fgets(STDIN));
    
        //$destino,$cantMaximaPasajeros,$responsableV,$objEmpresa,$importe,$tipoAsiento,$idaVuelta
        $objViaje=new Viaje();
        $objViaje->cargar($destino,$capMaxima,$objResponsable,$objEmpresa,$importe,$tipo,$idaVuelta);
        $resultadoViajeCreado=$objViaje->insertar();
        echo $resultadoViajeCreado?"Viaje creado ok, desea agregar pasajeros? (si/no): \n":$objViaje->getmensajeoperacion();
        $sumarPasajeros=trim(fgets(STDIN));
        $idViaje=$objViaje->obtenerUltimoId();
        $objViaje->Buscar($idViaje);
        if ($sumarPasajeros=="si"){
            cargarDatos($capMaxima,$objViaje);
            setearPasajeros($objViaje);
        }
        echo $objViaje;
        return $idViaje;
    }

}

function existeDestino($destinoIng){
    $objViaje=new Viaje();
    $viajesCargados=$objViaje->listar();
    $existeDestino=false;
    $i=0;
    $totalViajes=count($viajesCargados);
    while($i<$totalViajes && !$existeDestino){
        if($viajesCargados[$i]->getDestino()==$destinoIng){
            $existeDestino=true;
        }
        $i++;
    }
    return $existeDestino;
}

function verEmpresas(){
    $empresa=new Empresa;
    $coleccEmpresas=$empresa->listar();
    echo arrayToString($coleccEmpresas);
}

function seleccionarEmpresa($id){
    $objEmpresa=new Empresa();
    $existe=$objEmpresa->Buscar($id);
    while(!$existe){
        echo "Por favor, escoja un id. válido: ";
        $codE=trim(fgets(STDIN));
        $objEmpresa=new Empresa();
        $existe=$objEmpresa->Buscar($codE);
    }
    return $objEmpresa;
}

//Aca me muestra los responsables de viajes eliminados. Los que ya tienen un viaje asignado no pueden tener
//otro viaje. Asi se mantiene la relacion 1 a 1. 
function verResponsables(){
    $resp=new ResponsableV;
    $coleccResponsableV=$resp->listar();
    $objViaje=new Viaje();
    $viajes=$objViaje->listar();
    $responsablesMostrar=[];
    $i=0;
    //voy haciendo la verificacion de tieneViaje con cada empleado.
    //sino la tiene la incluyo en un array
    foreach($coleccResponsableV as $respo){
        if (!tieneViaje($respo,$viajes)){
            array_push($responsablesMostrar,$respo);
        }
    }
    if(count($responsablesMostrar)==0){
        echo "No hay empleados libres. Deberá crear uno nuevo \n";
    }
    echo arrayToString($responsablesMostrar);
}

function tieneViaje($empleado,$viajes){
    $tieneViaje=false;
    $i=0;
    while(!$tieneViaje && $i<count($viajes)){
        if($viajes[$i]->getResponsableV()->getNumEmpleado()==$empleado->getNumEmpleado()){
            $tieneViaje=true;
        }
        $i++;
    }
    return $tieneViaje;
}

function cargarResponsable(){
    echo "Ingrese licencia: ";
    $licencia=trim(fgets(STDIN));
    echo "Ingrese nombre: ";
    $nombre=trim(fgets(STDIN));
    echo "Ingrese apellido: ";
    $apellido=trim(fgets(STDIN));
    $objResp=new ResponsableV();
    $objResp->cargar($licencia,$nombre,$apellido);
    $resultadoRespo=$objResp->insertar();
    echo $resultadoRespo?"Responsable cargado ok \n":$objResp->getmensajeoperacion();
    $objResp->BuscarPorLic($licencia);
    return $objResp;
}

function ingresarResponsable($numEmp){
    $objResp=new ResponsableV();
    $existe=$objResp->Buscar($numEmp);
    while(!$existe){
        echo "Por favor, escoja un numero de empleado válido: ";
        $numEmp=trim(fgets(STDIN));
        $objResp=new ResponsableV();
        $existe=$objResp->Buscar($numEmp);
    }
    return $objResp;
}

//Se cargan los datos de los pasajeros en el caso de estar creando un nuevo objeto de clase Viaje:
function cargarDatos($capMaxima,$objViaje){
    $cont=count($objViaje->getPasajeros())-1;
    do{
        $cont+=1;
        if(($cont+1)>$capMaxima){
            echo "Ha llegado al número de pasajeros máximo permitido \n";
            $resp="no";
        }else{
            solicitarDatosPersona($cont,$objViaje);
            echo "Desea sumar otro pasajero? (si/no): ";
            $resp=trim(fgets(STDIN));
        }
    }
    while ($resp=="si");
}

//Se solicitan los datos de un solo pasajero:
function solicitarDatosPersona($cont,$objViaje){
    echo "Ingrese el nombre del pasajero ".($cont+1).": ";
    $nombre=trim(fgets(STDIN));
    echo "Ingrese el apellido del pasajero ".($cont+1).": ";
    $apellido=trim(fgets(STDIN));
    echo "Ingrese el dni del pasajero ".($cont+1).": ";
    $dni=trim(fgets(STDIN));
    echo "Ingrese el telefono del pasajero ".($cont+1).": ";
    $telefono=trim(fgets(STDIN));
    //le tengo que pasar el objero viaje del codigo que cree:
    if (!pasajeroCargado($dni)){
        $objPasajero=new Pasajero();
        $objPasajero->cargar($nombre,$apellido,$dni,$telefono,$objViaje);
        $resultadoPasajero=$objPasajero->insertar();
        //Tambien los voy seteando al objeto para luego de creado el viaje al hacer el echo me los muestre:
        $objViaje->setearPasajeroUnoaUno($objPasajero);
        echo $resultadoPasajero?"Pasajero cargado ok\n":$objPasajero->getmensajeoperacion();
    }elseif(pasajeroCargado($dni)){
        echo "El dni ingresado pertenece a un pasajero ya ingresado, por favor ingrese un pasajero distinto\n";
        solicitarDatosPersona($cont,$objViaje);
    }
}

function pasajeroCargado($dni){
    //se recorre la lista en la BD:
    $pasajero=new Pasajero();
    $existe=$pasajero->Buscar($dni);
    return $existe;
} 

/**
 * FUNCIONES QUE PERMITEN MODIFICAR UN VIAJE EXISTENTE.. 
 */
function modificarViaje(){
    echo "Seleccione el codigo del viaje a modificar: ";
    $id=trim(fgets(STDIN));
    $existe=existeViaje($id);
    if($existe){
        echo "Desea modificar destino, cantidad maxima, importe, tipo de asiento, y si es ida y vuelta?(si/no): ";
        $modifViaje=trim(fgets(STDIN));
        if ($modifViaje=="si"){
            modificarDatosViaje($id);
        }
        $viaje=setearPasajeros($id);
        if (count($viaje->getPasajeros())>0){
            echo "Desea modificar los datos de algun pasajero?(si/no): ";
            $modifPasajeros=trim(fgets(STDIN));
            if ($modifPasajeros=="si"){
                ingresarDatos($id);
            } 
        }else{
            echo "El viaje no posee pasajeros. Para agregarlos elija en el menú Viajes la opción 6, y el id: ".$id.
            "\nRecuerde que la capacidad máxima del viaje es de".$viaje->getCantMaximaPasajeros()." pasajeros.\n \n";
        }
    }else{
        echo "No existe el viaje con el id. ingresado \n";
    }
}

function modificarDatosViaje($id){
    //Primero traemos al objeto que vamos a modificar:
    $obj=new Viaje();
    $obj->Buscar($id);
    //Luego pedimos los datos, los seteamos en php, al final modificamos en la bd:
    echo "Ingrese el nuevo destino: ";
    $destNuevo=trim(fgets(STDIN));
    $obj->setDestino($destNuevo);

    $cantMaximaPasajeros=solicitarCapMaxima($id);
    $obj->setCantMaximaPasajeros($cantMaximaPasajeros);

    echo "Ingrese el nuevo importe: ";
    $impNuevo=trim(fgets(STDIN));
    $obj->setImporte($impNuevo);

    echo "Ingrese el tipo de asiento(cama/semicama): ";
    $tipoAs=trim(fgets(STDIN));
    $obj->setTipoAsiento($tipoAs);

    echo "Ingrese si es ida y vuelta:(SI/NO): ";
    $IV=trim(fgets(STDIN));
    $obj->setIdaVuelta($IV);

    $viajeModificado=$obj->modificar();
    echo $viajeModificado?"Viaje modificado ok\n":$obj->getmensajeoperacion();
}

function solicitarCapMaxima($id){
    $objPasajero=new Pasajero();
    $coleccPasajeros=$objPasajero->listar("idviaje=".$id);
    $cantPasajeros=count($coleccPasajeros);
    //echo $cantPasajeros;
    echo "Ingrese la capacidad máxima de pasajeros: ";
    $nuevaCapMaxima=trim(fgets(STDIN));
    while ($nuevaCapMaxima<$cantPasajeros){
        echo "Por favor, debe ingresar una capacidad mayor o igual a la cantidad actual de pasajeros. De lo contrario, cree un nuevo viaje: ";
        $nuevaCapMaxima=trim(fgets(STDIN));
    }
    return $nuevaCapMaxima;
}

function ingresarDatos($id){
    $objViaje=setearPasajeros($id);
    echo "Ingrese el dni de la persona a modificar: ";
    $dni=trim(fgets(STDIN));
    $datos=$objViaje->buscarPasajero($dni);
    if ($datos=="error"){
        echo "No existe un pasajero con ese dato, desea volver a buscar con otro dni? (si/no): ";
        $resp=trim(fgets(STDIN));
        if($resp=='si'){
            ingresarDatos($id);
        }
    }else{
        $pasajero=$datos[0];
        $ind=$datos[1];
        //traer ese pasajero de la BD:
        $resPasajero=$pasajero->Buscar($dni);
        echo $resPasajero?"Pasajero encontrado en BD OK \n":$pasajero->getmensajeoperacion();
        echo "Pasajero a modificar: ".$pasajero;

        echo "Ingrese el nombre correcto: ";
        $nuevoNombre=trim(fgets(STDIN));
        echo "Ingrese el Apellido correcto: ";
        $nuevoApellido=trim(fgets(STDIN));

        echo "Ingrese el telefono correcto: ";
        $nuevoTel=trim(fgets(STDIN));

        $pasajeroModif=$pasajero->modificarPasajero($nuevoNombre,$nuevoApellido,$pasajero->getDni(),$nuevoTel);
        $resPasajeroModif=$pasajero->modificar();
        echo $resPasajeroModif?"Pasajero modificado ok\n":$pasajero->getmensajeoperacion();

    }
    
}

/**
 * FUNCIONES PARA AGREGAR Y BORRAR PASAJEROS
 */
function agregarPasajeros(){
    echo "Por favor ingrese el id. del viaje al cual agregarle pasajeros:\n";
    $idViaje=trim(fgets(STDIN));
    $existe=existeViaje($idViaje);
    if($existe){
        $viaje=new Viaje();
        $viaje=setearPasajeros($idViaje);
        //asi obtengo el obj. viaje con los pasajeros
        $totalPasaj=count($viaje->getPasajeros());
        $capMaxima=$viaje->getCantMaximaPasajeros();
        if($totalPasaj<$capMaxima){
            cargarDatos($capMaxima,$viaje);
        }else{
            echo "El viaje se encuentra lleno \n";
        }
    }  else{
    echo "No existe el viaje con el id. ingresado \n";
    }
    echo $viaje;
}

function eliminarPasajeros(){
    echo "Por favor ingrese el id. del viaje al cual eliminarle pasajeros:\n";
    $idViaje=trim(fgets(STDIN));
    $existe=existeViaje($idViaje);
    if($existe){
        $viaje=new Viaje();
        $viaje=setearPasajeros($idViaje);
        //asi obtengo el obj. viaje con los pasajeros
        echo $viaje;
        eliminaPasajero($viaje);
    }else{
        echo "No existe el viaje con el id. ingresado \n";
    }
}

function eliminaPasajero($viaje){
    echo "Ingrese el dni del pasajero a eliminar:\n";
    $dniBorrar=trim(fgets(STDIN));
    $datos=$viaje->buscarPasajero($dniBorrar);
    if ($datos=="error"){
        echo "No existe en este viaje un pasajero con ese dato, desea eliminar un pasajero con otro dni? (si/no): ";
        $resp=trim(fgets(STDIN));
        if($resp=='si'){
            eliminaPasajero($viaje);
        }
    }else{
        $pasajero=$datos[0];
        //traer ese pasajero de la BD:
        $resPasajero=$pasajero->eliminar();
        echo $resPasajero?"Pasajero eliminado \n":$pasajero->getmensajeoperacion();
        //ahora seteo nuevamente en php con la coleccion actualizada de la bd:
        $idViaje=$viaje->getCodigo();
        $viaje=setearPasajeros($idViaje);
        echo $viaje;
    }
}

        
?>