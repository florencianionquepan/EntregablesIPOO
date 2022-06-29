<?php


/* Una empresa de transporte desea gestionar la información correspondiente a los viajes que
realiza. De los pasajeros se conoce su nombre, apellido, número de documento y teléfono. El
viaje ahora contiene una referencia a una colección de objetos de la clase Pasajero. También se
desea guardar la información de la persona responsable de realizar el viaje, para ello cree una
clase ResponsableV que registra el número de empleado, número de licencia, nombre y apellido.
La clase Viaje debe hacer referencia al responsable de realizar el viaje.
 */

include "BaseDatos.php";
include "Pasajero.php";
include "ResponsableV.php";
include "Viaje.php";
include "Empresa.php";

$objResponsable=new ResponsableV();
$objResponsable->cargar("97029","Pepe","Flores");
$objResponsable->Buscar(3);

$objEmpresa=new Empresa();
$objEmpresa->cargar("Empresa1","Av. Argentina 311");
$objEmpresa->Buscar(1);

/*METODOS CON LOS QUE CREE RESPONSABLE Y EMPRESA EN BD:
$resultado1=$objResponsable->insertar();
echo $resultado1?"SI":$objResponsable->getmensajeoperacion();

$resultadoE=$objEmpresa->insertar();
echo $resultadoE?"SI":$objEmpresa->getmensajeoperacion();
*/

$objViaje1=new Viaje();
$objViaje1->cargar("Puerto Madryn",10,$objResponsable,$objEmpresa,8000,"semicama","NO");
$objViaje2=new Viaje();
$objViaje2->cargar("Buenos Aires",5,$objResponsable,$objEmpresa,20000,"cama","SI");
$objViaje3=new Viaje();
$objViaje3->cargar("Bariloche",5,$objResponsable,$objEmpresa,20000,"cama","SI");

/*METODOS CON LOS QUE CREE Y LUEGO MODIFIQUE DOS INSTANCIAS DE VIAJE
$resV1=$objViaje1->insertar();
echo $resV1?"SI":$objViaje1->getmensajeoperacion();
$resMod1=$objViaje1->modificar();
echo $resMod1?"SI":$objViaje1->getmensajeoperacion();
$resV2=$objViaje2->insertar();
echo $resV2?"SI":$objViaje2->getmensajeoperacion();
$resMod2=$objViaje2->modificar();
echo $resMod2?"SI":$objViaje2->getmensajeoperacion();
OTRA PRUEBA:
$resultadoViajar=$objViaje3->insertar();
echo $resultadoViajar?"OK":$objViaje3->getmensajeoperacion();
 */

$objPasajero1=new Pasajero();
$objPasajero1->cargar("Igor","Gatito","36192","462643", $objViaje2);
$objPasajero2=new Pasajero();
$objPasajero2->cargar("Lana","Gatita","13823","462643",$objViaje2);
$objPasajero3=new Pasajero();
$objPasajero3->cargar("Luna","Perrita","92425","462034",$objViaje2);
$objPasajero4=new pasajero();
$objPasajero4->cargar("Mia","Pinina","11391","461087",$objViaje2);

$objViaje=new Viaje();
$ultimoViaje=$objViaje->obtenerUltimoId();
/*METODOS PARA CREAR PASAJEROS EN BD: 
$resultadoP1=$objPasajero1->insertar();
$resultadoP2=$objPasajero2->insertar();
$resultadoP3=$objPasajero3->insertar();
$resultadoP4=$objPasajero4->insertar();
 */

menuOpciones($ultimoViaje);

//Se crea el menú de forma de utilizarlo con el objeto precargado (el ultimo creado en la BD) o bien crear uno nuevo:
function menuOpciones($idViaje){
    do{
        echo "------Menú de opciones------\n"
            ."1) Cargar información de un viaje.\n"
            ."2) Modificar Viaje.\n"
            ."3) Mostrar Viaje.\n"
            ."4) Salir.\n";
                
            echo "Ingrese su eleccion: ";
            $eleccion = trim(fgets(STDIN));            
    
            switch($eleccion){
                //En el caso1, se tendra la opción de cargar un viaje nuevo y sobreescribir al precargado:
                case 1:$idViaje=cargarViaje();break;
                //Estas dos opciones pueden ejecutarse tanto con el viaje precargado como con uno nuevo que cree el usuario:
                case 2:modificarViaje($idViaje);break;
                case 3:mostrarViaje($idViaje);break;
                case 4: echo "Usted ha salido del menú de opciones";break;
                default: echo "elección ingresada no valida, por favor ingrese otra\n";break;
            }
    }while($eleccion!=4);
}

function mostrarViaje($id){
    $objViaje=setearPasajeros($id);
    echo $objViaje;
}

//Esta funcion busca todos los pasajeros con el idViaje que le paso por parámetro, los setea a ese objViaje
//Y me retorna el viaje con la coleccion de pasajeros
function setearPasajeros($id){
    $objPasajero=new Pasajero();
    $coleccPasajeros=$objPasajero->listar("idviaje=".$id);
    //AHORA A ESE VIAJE LE SETEO LA COLECCION PARA PODER MOSTRARLO
    $objViaje=new Viaje();
    $objViaje->Buscar($id);
    //ACA PODRIA CONTROLAR QUE EL id EXISTA
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
    echo "Ingrese la capacidad máxima de pasajeros: ";
    $capMaxima=intval(trim(fgets(STDIN)));

    echo "Escoja alguna empresa de viaje:\n";
    verEmpresas();
    $objEmpresa=ingresarEmpresa();

    echo "Ingrese los datos del responsable del viaje: ";
    $objResponsable=cargarResponsable();

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
    echo $resultadoViajeCreado?"Viaje creado ok, ahora es momento de los pasajeros: \n":$objViaje->getmensajeoperacion();
    $idViaje=$objViaje->obtenerUltimoId();
    $objViaje->Buscar($idViaje);
    if($resultadoViajeCreado){
        cargarDatos($capMaxima,$objViaje);
        setearPasajeros($objViaje);
    }
    echo $objViaje;
    return $idViaje;
}

function verEmpresas(){
    $empresa=new Empresa;
    //cuando muestre la empresa deberia mostrar la coleccion de viajes que tengo en la misma:
    $coleccEmpresas=$empresa->listar();
    $msn="";
    for ($i=0;$i<count($coleccEmpresas);$i++){
/*         $idEmpresa=$coleccEmpresas[$i]->getIdEmpresa();
        $viaje=new Viaje;
        $arregloViaje=$viaje->listar('idempresa='.$idEmpresa);
        $coleccEmpresas[$i]->setColeccViajes($arregloViaje); */
        $msn=$msn.$coleccEmpresas[$i];
    }
    echo $msn;
}

function ingresarEmpresa(){
    echo "Ingrese codigo de empresa: ";
    $codE=trim(fgets(STDIN));
    $objEmpresa=new Empresa();
    $existe=$objEmpresa->Buscar($codE);
    while(!$existe){
        echo "Por favor, escoja un codigo de empresa válido: ";
        $codE=trim(fgets(STDIN));
        $objEmpresa=new Empresa();
        $existe=$objEmpresa->Buscar($codE);
    }
    return $objEmpresa;
}
//Se cargan los datos de los pasajeros en el caso de estar creando un nuevo objeto de clase Viaje:
function cargarDatos($capMaxima,$objViaje){
    $cont=-1;
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

    /* //se hace un recorrido parcial de la lista de pasajeros cargada hasta el momento:
    // si encuentra un obj. con el dni, corta el recorrido y devuelve true
    //sino devuelve false;
    $result=false;
    $j=0;
    $objPasajero=new Pasajero();
    $objPasajero->listar();
    while ($result==false && $j<count($listaPasajeros)){
        if ($listaPasajeros[$j]->getDni()==$dni){
            $result=true;
        }else{
            $j++;
        }
    }
    return $result; */
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
    echo $resultadoRespo?"Responsable cargado ok \n":$resultadoRespo->getmensajeoperacion();
    $objResp->BuscarPorLic($licencia);
    return $objResp;
}


/**
 * FUNCIONES QUE PERMITEN MODIFICAR UN VIAJE EXISTENTE. AHORA EL PARAMETRO ES id. ACTUALIZAR.
 */
function modificarViaje($id){
    echo "Desea modificar destino, cantidad maxima, importe, tipo de asiento, y si es ida y vuelta?(si/no): ";
    $modifViaje=trim(fgets(STDIN));
    if ($modifViaje=="si"){
        modificarDatosViaje($id);
    }
    echo "Desea modificar los datos de algun pasajero?(si/no): ";
    $modifPasajeros=trim(fgets(STDIN));
    if ($modifPasajeros=="si"){
        ingresarDatos($id);
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
 




?>