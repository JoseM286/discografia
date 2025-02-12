<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="estilos.css">
    </head>

    <body class="indexImagen">

    <?php
    require_once 'connectBDD.php';

    session_start();

    if(!isset($_POST['aceptar'])){
        $_SESSION = [];     //vacia los datos de la sesion
        session_destroy();  //cierra la sesion pero sin borrar los datos, salvo si se combina con la anterior
    }

    if(isset($_POST["aceptar"])){

        $connection = connection("discografia");
        $usuario = mysqli_real_escape_string($connection, $_POST["usuario"]);
        $pwd = mysqli_real_escape_string($connection, $_POST["pw"]);

        $consulta = "SELECT nombre, pwd, tipo FROM usuarios";

        $resultado = mysqli_query($connection, $consulta);

        if(!$resultado){
            echo "Error en la consulta" . mysqli_error($connection);
        }else{
            while($row = mysqli_fetch_assoc($resultado)){
                if(($row['nombre'] == $usuario && password_verify($pwd, $row['pwd']) ) || ($usuario == "Jos" && $pwd == "jos")){
                    $_SESSION['usuario'] = $usuario;
                    if($usuario == "Jos"){
                        $_SESSION['tipo'] = 1;
                    }else{
                        $_SESSION['tipo'] = $row['tipo'];
                    }
                    mysqli_close($connection);
                    header("Location: menu.php");
                    exit();
                }
            }
        }
        mysqli_close($connection);

            echo "<script language='javascript'>
            
            alert('Usuario o contraseña incorrecto');
            window.location.href= 'index.php';
            
            </script>";

        }


    ?>
            
        <img class="notasVolando" src="imagenes/notas2.png" alt="notas musicales">
        <img class="notasVolando notasVolando2" src="imagenes/notas2.png" alt="notas musicales">
        
        

        <div class="form_caja">

            <h2>Introduzca un usuario y contraseña</h2>

            <form action="index.php" method="POST"">

                    <div class="form_fila">
                        <label for="usuario">Usuario: </label>
                        <input type="text" name="usuario">
                    </div>

                    <div class="form_fila">
                        <label for="pw">Contraseña: </label>
                        <input  type="password" name="pw">
                    </div>
                    <div class="botones">
                        <input class="boton" type="submit" name="aceptar" value="aceptar">
                    </div>
                        

            </form>
        </div>

    </body>
</html>

