<?php
/**
* Implementar un script testViaje.php que cree una instancia de la clase Viaje y presente un menú 
* que permita cargar la información del viaje, modificar y ver sus datos. 
*/

include "Viaje.php";

$pers=[];
$pers[0]=["nombre"=>"Carlos", "apellido"=>"Gardel","dni"=>10485974];
$pers[1]=["nombre"=>"Pedro", "apellido"=>"Aznar","dni"=>12489510];
$pers[2]=["nombre"=>"Maria", "apellido"=>"Marta","dni"=>15874102];
$pers[3]=["nombre"=>"Pepe", "apellido"=>"Garcia","dni"=>13487540];

$objViaje=new Viaje(123,"San Blas", 5, $pers);

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
    $objViaje=new Viaje($cod,$destino,$capMaxima,$listaPasajeros);
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
            $listaPasajeros[$cont]=solicitarDatosPersona($cont);
            echo "Desea sumar otro pasajero? (si/no): ";
            $resp=trim(fgets(STDIN));
        }
    }
    while ($resp=="si");
    return $listaPasajeros;
}

//Se solicitan los datos de un solo pasajero:
function solicitarDatosPersona($cont){
    echo "Ingrese el nombre del pasajero ".($cont+1).": ";
    $nombre=trim(fgets(STDIN));
    echo "Ingrese el apellido del pasajero ".($cont+1).": ";
    $apellido=trim(fgets(STDIN));
    echo "Ingrese el dni del pasajero ".($cont+1).": ";
    $dni=trim(fgets(STDIN));
    $arrayPasajero=["nombre"=>$nombre,"apellido"=>$apellido,"dni"=>$dni];
    return $arrayPasajero;
}

//La modificación de un viaje no permite sumar pasajeros. Solo se permite cambiar los datos. 
//En ese caso podrá crearse un nuevo viaje con la opcion 1)
function modificarViaje($obj){
    echo "Desea modificar codigo y destino y cantidad maxima?(si/no): ";
    $modifViaje=trim(fgets(STDIN));
    if ($modifViaje=="si"){
        modificarDatosViaje($obj);
    }
    echo "Desea modificar los datos de algun pasajero?(si/no): ";
    $modifPasajeros=trim(fgets(STDIN));
    if ($modifPasajeros=="si"){
        modificarPasajero($obj);
    }
}

function modificarPasajero($obj){
    echo "Que dato desea modificar? Ingrese 1,2 o 3: \n"
            ."1) Nombre.\n"
            ."2) Apellido.\n"
            ."3) Dni.\n";
            
    $eleccion = trim(fgets(STDIN));            

    switch($eleccion){
    case 1:echo "Ingrese el dni de la persona a modificar el nombre: ";
            $dni=trim(fgets(STDIN));
            $datos=$obj->buscarPasajero($dni);
            if ($datos=="error"){
                echo "No existe un pasajero con ese dato";
                break;
            }
            $pasajero=$datos[0];
            $ind=$datos[1];
            echo "Ingrese el nombre correcto: ";
            $nuevoNombre=trim(fgets(STDIN));
            $obj->modificarPasajero($ind,$nuevoNombre,$pasajero["apellido"],$pasajero["dni"]);
            break;
    case 2:echo "Ingrese el dni de la persona a modificar el apellido: ";
            $dni=trim(fgets(STDIN));
            $datos=$obj->buscarPasajero($dni);
            if ($datos=="error"){
                echo "No existe un pasajero con ese dato";
                break;
            }
            $pasajero=$datos[0];
            $ind=$datos[1];
            echo "Ingrese el Apellido correcto: ";
            $nuevoApellido=trim(fgets(STDIN));
            $obj->modificarPasajero($ind,$pasajero["nombre"], $nuevoApellido,$pasajero["dni"]);
            break;
    case 3:echo "Ingrese el dni de la persona a modificar el dni: ";
            $dni=trim(fgets(STDIN));
            $datos=$obj->buscarPasajero($dni);
            if ($datos=="error"){
                echo "No existe un pasajero con ese dato";
                break;
            }
            $pasajero=$datos[0];
            $ind=$datos[1];
            echo "Ingrese el DNI correcto: ";
            $nuevoDni=trim(fgets(STDIN));
            $obj->modificarPasajero($ind,$pasajero["nombre"],$pasajero["apellido"],$nuevoDni);
            break;
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

menuOpciones($objViaje);

?>