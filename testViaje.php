<?php


/* Una empresa de transporte desea gestionar la información correspondiente a los viajes que
realiza. De los pasajeros se conoce su nombre, apellido, número de documento y teléfono. El
viaje ahora contiene una referencia a una colección de objetos de la clase Pasajero. También se
desea guardar la información de la persona responsable de realizar el viaje, para ello cree una
clase ResponsableV que registra el número de empleado, número de licencia, nombre y apellido.
La clase Viaje debe hacer referencia al responsable de realizar el viaje.
 */

include "Pasajero.php";
include "ResponsableV.php";
include "Viaje.php";

$objPasajero1=new Pasajero();
$objPasajero1->cargar("Igor","Gatito","36192","462643");
$objPasajero2=new Pasajero();
$objPasajero2->cargar("Lana","Gatita","13823","462643");
$objPasajero3=new Pasajero();
$objPasajero3->cargar("Luna","Perrita","92425","462034");
$objPasajero4=new pasajero();
$objPasajero4->cargar("Mia","Pinina","11391","461087");
$pasajeros=[$objPasajero1,$objPasajero2,$objPasajero3,$objPasajero4];

$objResponsable=new ResponsableV("1540","97029","Pepe","Fredes");

//$codigo,$destino,$cantMaximaPasajeros,$pasajeros,$responsableV, $importe, $idaVuelta
$objViaje=new Viaje("123","Isla de los pininos",5,$pasajeros,$objResponsable,5000,true);



//Se crea el menú de forma de utilizarlo con el objeto precargado o bien crear uno nuevo:
    function menuOpciones($objViaje){
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
                case 1:$objViaje=cargarViaje();break;
                //Estas dos opciones pueden ejecutarse tanto con el viaje precargado como con uno nuevo que cree el usuario:
                case 2:modificarViaje($objViaje);break;
                case 3:echo $objViaje;break;
                case 4: echo "Usted ha salido del menú de opciones";break;
                default: echo "elección ingresada no valida, por favor ingrese otra\n";break;
                }
        }while($eleccion!=4);
    }


//Solicita todos los valores de los atributos de la nueva instancia de la clase Viaje:
function cargarViaje(){
    echo "Ingrese codigo del viaje: ";
    $cod = trim(fgets(STDIN));
    echo "Ingrese destino del viaje: ";
    $destino = trim(fgets(STDIN));
    echo "Ingrese la capacidad máxima de pasajeros: ";
    $capMaxima=trim(fgets(STDIN));
    $listaPasajeros=cargarDatos($capMaxima);
    echo "Ingrese los datos del responsable del viaje: ";
    $objResponsable=cargarResponsable();
    $objViaje=new Viaje($cod,$destino,$capMaxima,$listaPasajeros,$objResponsable);
    echo $objViaje;
    return $objViaje;
}

//Se cargan los datos de los pasajeros en el caso de estar creando un nuevo objeto de clase Viaje:
function cargarDatos($capMaxima){
    $listaPasajeros=[];
    $cont=-1;
    do{
        $cont+=1;
        if(($cont+1)>$capMaxima){
            echo "Ha llegado al número de pasajeros máximo permitido \n";
            $resp="no";
        }else{
            $listaPasajeros[$cont]=solicitarDatosPersona($cont,$listaPasajeros);
            echo "Desea sumar otro pasajero? (si/no): ";
            $resp=trim(fgets(STDIN));
        }
    }
    while ($resp=="si");
    return $listaPasajeros;
}

//Se solicitan los datos de un solo pasajero:
function solicitarDatosPersona($cont,$listaPasajeros){
    echo "Ingrese el nombre del pasajero ".($cont+1).": ";
    $nombre=trim(fgets(STDIN));
    echo "Ingrese el apellido del pasajero ".($cont+1).": ";
    $apellido=trim(fgets(STDIN));
    echo "Ingrese el dni del pasajero ".($cont+1).": ";
    $dni=trim(fgets(STDIN));
    echo "Ingrese el telefono del pasajero ".($cont+1).": ";
    $telefono=trim(fgets(STDIN));
    if (!pasajeroCargado($dni,$listaPasajeros) && $cont>0){
        $objPasajero=new Pasajero();
        $objPasajero->cargar($nombre,$apellido,$dni,$telefono);
        return $objPasajero;
    }elseif($cont==0){
        $objPasajero=new Pasajero();
        $objPasajero->cargar($nombre,$apellido,$dni,$telefono);
        return $objPasajero;
    }elseif(pasajeroCargado($dni,$listaPasajeros)){
        echo "El dni ingresado pertenece a un pasajero ya ingresado, por favor ingrese un pasajero distinto\n";
    }
}

function pasajeroCargado($dni,$listaPasajeros){
    //se hace un recorrido parcial de la lista de pasajeros cargada hasta el momento:
    // si encuentra un obj. con el dni, corta el recorrido y devuelve true
    //sino devuelve false;
    $result=false;
    $j=0;
    while ($result==false && $j<count($listaPasajeros)){
        if ($listaPasajeros[$j]->getDni()==$dni){
            $result=true;
        }else{
            $j++;
        }
    }
    return $result;
}

function cargarResponsable(){
    echo "Ingrese numero del empleado: ";
    $num=trim(fgets(STDIN));
    echo "Ingrese licencia: ";
    $licencia=trim(fgets(STDIN));
    echo "Ingrese nombre: ";
    $nombre=trim(fgets(STDIN));
    echo "Ingrese apellido: ";
    $apellido=trim(fgets(STDIN));
    $objResp=new ResponsableV($num,$licencia,$nombre,$apellido);
    return $objResp;
}

function modificarViaje($obj){
    echo "Desea modificar codigo y destino y cantidad maxima?(si/no): ";
    $modifViaje=trim(fgets(STDIN));
    if ($modifViaje=="si"){
        modificarDatosViaje($obj);
    }
    echo "Desea modificar los datos de algun pasajero?(si/no): ";
    $modifPasajeros=trim(fgets(STDIN));
    if ($modifPasajeros=="si"){
        ingresarDatos($obj);
    }
}

function modificarDatosViaje($obj){
    echo "Ingrese el nuevo código del viaje: ";
    $codNuevo=trim(fgets(STDIN));
    $obj->setCodigo($codNuevo);
    echo "Ingrese el nuevo destino: ";
    $destNuevo=trim(fgets(STDIN));
    $obj->setDestino($destNuevo);
    $cantMaximaPasajeros=solicitarCapMaxima($obj);
    $obj->setCantMaximaPasajeros($cantMaximaPasajeros);
}

function solicitarCapMaxima($obj){
    $cantPasajeros=count($obj->getPasajeros());
    echo "Ingrese la capacidad máxima de pasajeros: ";
    $nuevaCapMaxima=trim(fgets(STDIN));
    while ($nuevaCapMaxima<$cantPasajeros){
        echo "Por favor, debe ingresar una capacidad mayor o igual a la cantidad actual de pasajeros. De lo contrario, cree un nuevo viaje: ";
        $nuevaCapMaxima=trim(fgets(STDIN));
    }
    return $nuevaCapMaxima;
}

function ingresarDatos($obj){
    echo "Ingrese el dni de la persona a modificar: ";
    $dni=trim(fgets(STDIN));
    $datos=$obj->buscarPasajero($dni);
    if ($datos=="error"){
        echo "No existe un pasajero con ese dato";
    }else{
        $pasajero=$datos[0];
        $ind=$datos[1];
        echo "Que dato desea modificar? Ingrese 1,2 o 3: \n"
                    ."1) Nombre.\n"
                    ."2) Apellido.\n"
                    ."3) Telefono.\n";
                    
        $eleccion = trim(fgets(STDIN));            
        
        switch($eleccion){
            case 1: echo "Ingrese el nombre correcto: ";
                    $nuevoNombre=trim(fgets(STDIN));
                    //ACA DEBERIA LLAMAR AL OBJETO PASAJERO YA QUE ESTA FUNCION DEBERIA ESTAR ALLI, YA LA PUSE EN ESE OBJETO:
                    $pasajeroModif=$pasajero->modificarPasajero($ind,$nuevoNombre,$pasajero->getApellido(),$pasajero->getDni(),$pasajero->getTelefono());
                    $obj->setearPasajeroModificado($pasajeroModif,$ind);
                    break;
            case 2:echo "Ingrese el Apellido correcto: ";
                    $nuevoApellido=trim(fgets(STDIN));
                    $pasajeroModif=$pasajero->modificarPasajero($ind,$pasajero->getNombre(), $nuevoApellido,$pasajero->getDni(),$pasajero->getTelefono());
                    $obj->setearPasajeroModificado($pasajeroModif,$ind);
                    break;
            case 3:echo "Ingrese el telefono correcto: ";
                    $nuevoTel=trim(fgets(STDIN));
                    $pasajeroModif=$pasajero->modificarPasajero($ind,$pasajero->getNombre(),$pasajero->getApellido(),$pasajero->getDni(),$nuevoTel);
                    $obj->setearPasajeroModificado($pasajeroModif,$ind);
                    break;
        }
    }
    
}




?>