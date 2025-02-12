<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body class="<?php echo fondo();?>">

        <?php 
        session_start();
        require_once "connectBDD.php";

        function fondo(){
            if(isset($_POST['crear'])){ 
                return "image4";
            }
            if(isset($_POST['mostrar'])){
                return "image7";
            }
            if(isset($_POST['eliminar']) || isset($_SESSION['eliminar'])){
                return "image5";
            }
            if(isset($_POST['modificar']) || isset($_SESSION['modificar'])){
                return "image6";
            }
        }

        if(isset($_POST['crear']) && isset($_SESSION['usuario'])){
            ?>
            <div class="form_caja">
                
                <h2><?php echo strtoupper($_SESSION['usuario']);?><br> Introduce la información del artista</h2>
                
                <div class="form">

                    <form action="gestion_artistas.php" method="post">
                        
                            <div>
                                <label for="nombre">Nombre: </label>
                                <input type="text" placeholder="Introduce su nombre" name="nombre" required>
                            </div>
                            <div>
                                <label for="instrumento">Instrumento: </label>
                                <input type="text" placeholder="Cual es su talento musical" name="instrumento" >
                            </div>
                            <div>
                                <label for="nacionalidad">Nacionalidad: </label>
                                <input type="text" placeholder="Donde nacio" name="nacionalidad" required>
                            </div>
                            <div>
                                <label for="website">Website: </label>
                                <input type="url" placeholder="Website personal" name="website" >
                            </div>
                            <div>
                                <label for="biografia">Biografia: </label>
                                <input type="text" placeholder="Cuentanos su vida" name="biografia" >
                            </div>
                            <div class="botones">
                                <input class="boton" type="submit" value="crear artista" name="crear">
                        
                    </form>
                    <form action="menu.php">
                        <input class="boton botonMenu" type="submit" value="volver al menu">
                    </form>
                            </div>
                </div> 
            </div>
            <?php   
            }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['mostrar']) && isset($_SESSION['usuario'])){
        
            $connection = connection("discografia");
            if(!$connection){
                header('Location: error.php?error=conexion');
                exit();
            }

            $consulta = "SELECT idartista, nombre, nacionalidad  FROM artistas";
            if($stmt = mysqli_prepare($connection, $consulta)){
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_bind_result($stmt, $idartista, $nombre, $nacionalidad);
                    ?>
                    <div class="form_caja">
                        <h2><?php echo strtoupper($_SESSION['usuario']);?><br> Selecciona el artista a mostrar</h2>
                        <form action="gestion_artistas.php" method="POST">
                        <select name="artistas" id="artistas">
                        <?php
                            echo "<option value='todos'>Mostrar todos</option>";
                            while (mysqli_stmt_fetch($stmt)){
                                echo '<option value="' . htmlspecialchars($idartista)
                                        . '">' . htmlspecialchars($nombre) 
                                        .' - '. htmlspecialchars($nacionalidad) 
                                        . '</option>';
                            }
                        ?>
                        </select>
                        <div class="botones">
                            <input type="submit" class="boton" name="mostrar" value="mostrar datos">
                        </form>
                            <form action="menu.php">
                                <input class="boton botonMenu" type="submit" value="volver al menu">
                            </form>
                        </div>
                    </div>
                    <?php  

                }else{
                    header('Location: error.php?error=ejecucion');
                    exit();
                }     
            }else{
                header('Location: error.php?error=consulta');
                exit();
            }
    
                mysqli_stmt_close($stmt);
                mysqli_close($connection);
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['eliminar']) && isset($_SESSION['usuario'])){

            $connection = connection("discografia");
            if(!$connection){
                header('Location: error.php?error=conexion');
                exit();
            }

            $consulta = "SELECT idartista, nombre, nacionalidad FROM artistas";

            if($stmt=mysqli_prepare($connection, $consulta)){
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_bind_result($stmt, $idartista, $nombre, $nacionalidad);
                    ?>
                    <div class="form_caja eliminarA">
                    <h2><?php echo strtoupper($_SESSION['usuario']) . "<br> Selecciona el artista a eliminar"?></h2>
                    <form action="gestion_artistas.php" method="POST">
                        <select name="artista" id="artista" required>
                            <option value="">selecciona un artista</option>
                            <?php 
                            while(mysqli_stmt_fetch($stmt)){
                                    echo '<option value="' . htmlspecialchars($idartista) 
                                    . '">' . htmlspecialchars($nombre) 
                                    . ' - ' . htmlspecialchars($nacionalidad)
                                    . ' </option>';
                            }
                            ?>
                        </select>
                            <div class="botones">
                                <input type="submit" class="boton" name="eliminar" value="eliminar artista">
                    </form>
                    <form action="menu.php">
                        <input class="boton botonMenu" type="submit" value="volver al menu">
                    </form>
                            </div>
                    </div>
                    <?php 


                }else{
                    header('Location: error.php?error=ejecucion');
                    exit();
                }
            }else{
                header('Location: error.php?error=consulta');
                exit();
            }
            mysqli_stmt_close($stmt);
            mysqli_close($connection);
        }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['modificar'])&& isset($_SESSION['usuario'])){


            $connection = connection('discografia');
            if(!$connection){
                header("Location: error.php?error=conexion");
                exit();
            }

            $consulta = "SELECT idartista, nombre, nacionalidad FROM artistas";

            if($stmt = mysqli_prepare($connection, $consulta)){
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_bind_result($stmt, $idartista, $nombre, $nacionalidad);
                        ?>
                        <div class="form_caja modificarA">
                            <h2><?php echo strtoupper($_SESSION['usuario']) ?><br> Selecciona el artista a modificar</h2>
                            <form action="gestion_artistas.php" method="POST">
                                <select name="artistas" id="artista" required>
                                    <option value="">selecciona un artista</option>
                                    <?php
                                        while(mysqli_stmt_fetch($stmt)){
                                            echo '<option value="'. htmlspecialchars($idartista)
                                            .'">'. htmlspecialchars($nombre)
                                            .' - '. htmlspecialchars($nacionalidad)
                                            .'</option>';
                                        }
                                    ?>
                                </select>
                                <div class="botones">
                                    <input class="boton" type="submit" value="modificar artista" name="modificar">
                            </form>
                            <form action="menu.php">
                                <input class="boton botonMenu" type="submit" value="volver al menu">
                            </form>
                            </div>
                        </div>
                        <?php
                }else{
                    header('Location: error.php?error=ejecución');
                    exit();
                }
            }else{
                header('Location: error.php?error=consulta');
                exit();
            }
            mysqli_stmt_close($stmt);
            mysqli_close($connection);
        }

        ?>
        
    </body>
</html>