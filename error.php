<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body class="imageE">
    
        <div class="error">
        <?php

        if(isset($_GET["error"]) && $_GET["error"] === "usuario_existente"){
            echo "<h2>¡¡El usuario ya existe!!</h2>";
        }elseif(isset($_GET["error"]) && $_GET["error"] === "consulta"){
            echo "<h2>Error en la consulta</h2>";// . mysqli_error($connection);
        }elseif(isset($_GET['error']) && $_GET['error'] === 'conexion'){
            echo "<h2>Error en la conexion</h2>";
        }elseif(isset($_GET['error']) && $_GET['error'] === 'ejecucion'){
            echo "<h2>Error en la ejecución</h2>";
        }elseif(isset($_GET['error']) && $_GET['error'] === 'disco_existente'){
            echo "<h2>¡¡El disco ".(isset($_GET['disco'])?$_GET['disco']:"")." ya existe!!</h2>";
        }elseif(isset($_GET['error']) && $_GET['error'] === 'transaccion'){
            echo "<h2>¡¡Error en la transacción!!<br>". $_GET['detalles'] . "</h2>";
        }elseif(isset($_GET["error"]) && $_GET["error"] === "parametros"){
            echo "<h2>Error en los parámetros dados</h2>";
        }
        ?>
        </div>

        <div class="botones errorbtn">
        <form action="menu.php">
            <input class="boton" type="submit" value="volver al menu">
        </form>
        </div>
    </body>
</html>

