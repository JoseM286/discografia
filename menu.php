<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="estilos.css">
    </head>

    <body class="image0">

        <?php

        session_start();
        require_once 'connectBDD.php';

        if (!isset($_SESSION['usuario'])) {

            header("Location:index.php");
            exit();

        }  

        ?>

        <div class="form_caja">

            <h1>Bienvenido <?php echo ucwords(strtoupper($_SESSION['usuario']));?>, seleccione la opción deseada</h1>

            <?php
                if($_SESSION['tipo'] == 1){
            ?>
                    
                    <form action="usuarios.php" method= "post"> <!--form de usuarios-->
                        
                        <div class="botones">
                            <h2> Usuarios </h2>
                            <input class="boton" type="submit" value="crear" name="crear">
                            <input class="boton" type="submit" value="mostrar" name="mostrar">
                            <input class="boton" type="submit" value="eliminar" name="eliminar">
                            <input class="boton" type="submit" value="cambiar password" name="modificarPW">
                        </div>
                    </form>

                    <form action="artistas.php" method= "post"> <!--form de artistas-->
                        
                        <div class="botones">
                            <h2>Artistas&nbsp</h2> <!--Con el &nbsp creo un espacio en la linea-->
                            <input class="boton" type="submit" value="crear" name="crear">
                            <input class="boton" type="submit" value="mostrar" name="mostrar">
                            <input class="boton" type="submit" value="eliminar" name="eliminar">
                            <input class="boton" type="submit" value="modificar" name="modificar">
                        </div>
                    </form>

                <?php
                }else{
                ?>
                    <form action="artistas.php" method= "post"> <!--form de artistas-->
                        
                        <div class="botones">
                            <h2> Artistas </h2>
                            <input class="boton" type="submit" value="crear" name="crear">
                            <input class="boton" type="submit" value="mostrar" name="mostrar">
                        </div>
                    </form>
                    
                <?php 
                }
                ?>

                <form action="discos.php" method= "post"> <!--form de artistas-->
                    
                    <div class="botones">
                        <h2>Discos&nbsp&nbsp&nbsp&nbsp</h2> <!--Con el &nbsp creo un espacio en la linea-->
                        <input class="boton" type="submit" value="crear" name="crear">
                        <input class="boton" type="submit" value="mostrar" name="mostrar">
                        <input class="boton" type="submit" value="eliminar" name="eliminar">
                        <input class="boton" type="submit" value="modificar" name="modificar">
                    </div>
                </form>

                <div class="botones logoutG">
                    <form action="index.php">
                        <input class="boton logoutP" type="submit" value="logout" name="logout">
                    </form>
                </div>
        </div>
    </body>
</html>

