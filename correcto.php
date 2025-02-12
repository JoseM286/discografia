<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body class="imageC">
        
        <div class="cajaC">
            <div class="correcto">
                <?php

                session_start();

                if(isset($_GET["cambio"]) && $_GET["cambio"] === "password"){
                    echo "<h2>Felicidades ". $_SESSION['usuario']."</h2>";
                    echo "<h2> Has cambiado la contraseña </h2>";
                }
                else if(isset($_GET["eliminar"]) && $_GET["eliminar"] === "usuario"){
                    echo "<h2>Felicidades ". $_SESSION['usuario']."</h2>";
                    echo "<h2> Has eliminado al usuario ". $_GET['usuario'] ."</h2>";
                }
                else if(isset($_GET["crear"]) && $_GET["crear"] === "usuario"){
                    echo "<h2>Felicidades ". $_SESSION['usuario']."</h2>";
                    echo "<h2> Has creado al usuario ". $_GET['usuario'] ."</h2>";
                }
                else if(isset($_GET["crear"]) && $_GET["crear"] === "artista"){
                    echo "<h2>Felicidades ". $_SESSION['usuario']."</h2>";
                    echo "<h2> Has creado al artista ". $_GET['artista'] ."</h2>";
                }
                else if(isset($_GET["eliminar"]) && $_GET["eliminar"] === "artista"){
                    echo "<h2>Felicidades ". $_SESSION['usuario']."</h2>";
                    echo "<h2> Has eliminado al artista ". $_GET['artista'] ."</h2>";
                }
                else if(isset($_GET["modificar"]) && $_GET["modificar"] === "artista"){
                    echo "<h2>Felicidades ". $_SESSION['usuario']."</h2>";
                    echo "<h2> Has modificado al artista ". $_GET['artista'] ."</h2>";
                }else if(isset($_GET["crear"]) && $_GET["crear"] === "disco"){
                    echo "<h2>Felicidades ". $_SESSION['usuario']."</h2>";
                    echo "<h2> Has creado el disco ". $_GET['disco'] ."</h2>";
                }else if(isset($_GET["modificar"]) && $_GET["modificar"] === "disco"){
                    echo "<h2>Felicidades ". $_SESSION['usuario']."</h2>";
                    echo "<h2> Has modificado el disco ". $_GET['disco'] ."</h2>";
                }else if(isset($_GET["eliminar"]) && $_GET["eliminar"] === "disco"){
                    echo "<h2>Felicidades ". $_SESSION['usuario']."</h2>";
                    echo "<h2> Has eliminado el disco ". $_GET['disco'] ."</h2>";
                }

                ?>

            </div>

            <div class="botones correctobtn">
            <form action="menu.php">
                <input class="boton" type="submit" value="volver al menu">
            </form>
            </div>
        </div>

        <?php
        //header("refresh:5; url=menu.php");
        ?>

    </body>
</html>