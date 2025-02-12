<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////C:\xampp\apache\logs\error.log      //Aqui se pueden ver los errores de xamp, incluido mysqli///////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$server = "localhost";
$user = "root";
$pw = "";
$bdd = "discografia"; 

mysqli_report(MYSQLI_REPORT_OFF);

/*$connection = @mysqli_connect($server, $user, $pw, $bdd); //Con el @ suprimimos cualquier 
                                                            //advertencia proveniente de esta funcion
if(!$connection){                                           //Aqui iniciamos la conexion directamente     
    echo "Error al conectar a la BDD";                      //es decir:
}else{                                                      //se debera importar el archivo
    echo "Conectado a la BDD"; 
}*/


function connection($bdd){                                                          //Aqui hacemos una funcion con la conexion
    $connection = @mysqli_connect('localhost', 'root', '', $bdd );                  //es decir: "include_once" o "require_once"
                                                                                    //importamos 1 vez este archivo
    if(!$connection){                                                               //en el archivo que vayamos 
        die("Error al conectar con la base de datos: " . mysqli_connect_error());   //a necesitar conexiones 
    }                                                                               //y luego cada vez que queramos conectar
return $connection;                                                                 //llamamos a la función
}                                                                                   //si en todo el proyecto se llama a la 
                                                                                //misma bdd podemos pasar la funcion sin parametros
?>  