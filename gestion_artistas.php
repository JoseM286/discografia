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
            if(isset($_POST['mostrar'])){
                return "image8";
            }elseif(isset($_POST['modificar'])){
                return "image9";
            }
        }

        if(isset($_POST['crear']) && isset($_SESSION['usuario'])){

            $nombre = trim($_POST['nombre']);
            $nacionalidad = trim($_POST['nacionalidad']);
            $instrumento = trim($_POST['instrumento']);
            $biografia = trim($_POST['biografia']);
            $website = trim($_POST['website']);

            $connection = connection('discografia');
            if(!$connection){
                mysqli_close($connection);
                header('Location: error.php?error=conexion');
                exit();
            }

            $consulta = "INSERT INTO `artistas` (`nombre`, `nacionalidad`, `instrumento`, `biografia`, `website`)
                            VALUES (?,?,?,?,?)";

            if($stmt = mysqli_prepare($connection, $consulta)){
                mysqli_stmt_bind_param($stmt, 'sssss', $nombre, $nacionalidad, $instrumento, $biografia, $website);
                if(mysqli_stmt_execute($stmt)){
                    $id_artista = mysqli_insert_id($connection); //Obtengo el id del artista insertado
                    mysqli_stmt_close($stmt);
                    mysqli_close($connection);
                    header('Location: correcto.php?crear=artista&artista=' . $id_artista);
                    exit();
                }else{
                    mysqli_stmt_close($stmt);
                    mysqli_close($connection);
                    header('Location: error.php?error=ejecución');
                    exit();
                }
            }else{
                mysqli_close($connection);
                header('Location: error.php?error=consulta');
                exit();
            }

        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['mostrar']) && isset($_SESSION['usuario'])){
            
            $artista = $_POST['artistas'];

            $connection = connection("discografia");

            if(!$connection){
                mysqli_stmt_close($stmt);
                mysqli_close($connection);
                header('Location: error.php?error=conexion');
                exit();
            }

            if($artista === "todos"){

                $consulta = "SELECT a.`idartista`, a.`nombre` AS `nombre_artista`, 
                            a.`nacionalidad`, a.`instrumento`, a.`biografia`, a.`website`, 
                            GROUP_CONCAT(DISTINCT g.`nombre` ORDER BY g.`nombre`) AS `grupo`,
                            GROUP_CONCAT(DISTINCT d.`titulo` ORDER BY d.`titulo`) AS `disco`
                            from `artistas` a 
                            LEFT JOIN `integrantes` i ON a.`idartista` = i.`idartista` 
                            LEFT JOIN `grupos` g ON i.`idgrupo` = g.`idgrupo` 
                            LEFT JOIN `discos` d ON g.`idgrupo` = d.`idgrupo` 
                            GROUP BY a.`idartista` 
                            ORDER BY a.`nombre`;
                            ";
                if(!$stmt = mysqli_prepare($connection, $consulta)){
                    mysqli_stmt_close($stmt);
                    mysqli_close($connection);
                    header('Location: error.php?error=ejecucion');
                exit();
                }

            }else{
                
                $consulta = "SELECT a.`idartista`, a.`nombre` AS `nombre_artista`, 
                            a.`nacionalidad`, a.`instrumento`, a.`biografia`, a.`website`, 
                            GROUP_CONCAT(DISTINCT g.`nombre` ORDER BY g.`nombre`) AS `grupo`,
                            GROUP_CONCAT(DISTINCT d.`titulo` ORDER BY d.`titulo`) AS `disco`
                            from `artistas` a
                            LEFT JOIN `integrantes` i ON a.`idartista` = i.`idartista` 
                            LEFT JOIN `grupos` g ON i.`idgrupo` = g.`idgrupo`
                            LEFT JOIN `discos` d ON g.`idgrupo` = d.`idgrupo`
                            WHERE a.`idartista` = ?
                            ORDER BY a.`nombre`, g.`nombre`
                            ";
                if(!$stmt = mysqli_prepare($connection, $consulta)){
                    mysqli_stmt_close($stmt);
                    mysqli_close($connection);
                    header('Location: error.php?error=ejecucion');
                    exit();
                }
                mysqli_stmt_bind_param($stmt, 'i', $artista);
                
            }
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt, $idartista, $nombre_artista, $nacionalidad,
                    $instrumento, $biografia, $website, $grupo, $disco);
            }else{
                mysqli_stmt_close($stmt);
                mysqli_close($connection);
                header('Location: error.php?error=consulta');
                exit();
            }

            echo "<div class='tabla_mostrar'>";
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Nacionalidad</th>
                        <th>Instrumento</th>
                        <th>Biografia</th>
                        <th>Website</th>
                        <th>Grupo</th>
                        <th>Disco</th>
                    </tr>
                </thead>
                <tbody>
            <?php
                while(mysqli_stmt_fetch($stmt)){
                    echo "<tr>";
                    echo   '<td>'. (($nombre_artista == "" ) ? "-" : htmlspecialchars($nombre_artista)).'</td>
                            <td>'.(($nacionalidad == "" ) ? "-" : htmlspecialchars($nacionalidad)).'</td>
                            <td>'.(($instrumento == "" ) ? "-" : htmlspecialchars($instrumento)).'</td>
                            <td>'.(($biografia == "" ) ? "-" : htmlspecialchars($biografia)).'</td>
                            <td>'.(($website == "" ) ? "-" : htmlspecialchars($website)).'</td>';
                    

                    $grupos = explode(',', $grupo);
                    $contadorG = ($grupo == "") ? "" : 1;
                    $discos = explode(',', $disco);
                    $contadorD = ($disco == "") ? "" : 1;

                    echo "<td>";
                    foreach ($grupos as $grupo){
                        echo $contadorG . " - " . htmlspecialchars($grupo) . "<br>";
                        $contadorG++;
                    }
                    echo "</td>";

                    echo "<td class='artistasTD'>";
                    foreach ($discos as $disco){    
                        echo $contadorD . " - " . htmlspecialchars($disco) . "<br>";       
                        $contadorD++;
                    }
                    echo "</td>";

                    echo "</tr>";
                }

                mysqli_stmt_close($stmt);
                mysqli_close($connection);

                ?>
                </tbody>
            </table>
                
                    <div class="botones">
                        <form action="menu.php">
                            <input class="boton botonMenu" type="submit" value="volver al menu" name="volvermenu">
                        </form>
                    </div>
                <?php
            echo "</div>";  

        }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['eliminar']) && isset($_SESSION['usuario'])){
            
            $artista = $_POST['artista'];
            $connection = connection("discografia");
            if(!$connection){
                mysqli_close($connection);
                header('Location: error.php?error=conexion');
                exit();
            }

            $consulta = "DELETE FROM `artistas` WHERE `idartista` = ?";
            if(!$stmt = mysqli_prepare($connection, $consulta)){
                mysqli_stmt_close($stmt);
                mysqli_close($connection);
                header('Location: error.php?error=ejecucion');
                exit();
            }

            mysqli_stmt_bind_param($stmt, 'i', $artista);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                mysqli_close($connection);
                header("Location: correcto.php?eliminar=artista&artista=". $artista);
                exit();
            }else{
                mysqli_stmt_close($stmt);
                mysqli_close($connection);
                header('Location: error.php?error=consulta');
                exit();
            }
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['modificar']) && isset($_SESSION['usuario'])){

            $artista = $_POST['artistas'];

            $connection = connection("discografia");
            if(!$connection){
                mysqli_close($connection);
                header('Location: error.php?error=conexion');
                exit();
            }

            $consulta = "SELECT a.`idartista`, a.`nombre` AS `nombre_artista`, 
                            a.`nacionalidad`, a.`instrumento`, a.`biografia`, a.`website` 
                            from `artistas` a
                            WHERE a.`idartista` = ?
                            ORDER BY a.`nombre`
                            ";

            if(!$stmt = mysqli_prepare($connection, $consulta)){
                mysqli_stmt_close($stmt);
                mysqli_close($connection);
                header('Location: error.php?error=ejecucion');
                exit();
            }

            mysqli_stmt_bind_param($stmt, 'i', $artista);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt, $idartista, $nombre_artista, $nacionalidad, $instrumento, $biografia, $website);
                mysqli_stmt_fetch($stmt);
            }else{
                mysqli_stmt_close($stmt);
                mysqli_close($connection);
                header('Location: error.php?error=consulta');
                exit();
            }

            mysqli_stmt_close($stmt);
            mysqli_close($connection);

            ?>
            <div class="form_caja">
                
                <h2><?php echo strtoupper($_SESSION['usuario']);?><br> Modifica la información del artista</h2>
                
                <div class="form">

                    <form action="gestion_artistas.php" method="post">
                        
                            <input type="hidden" name="idartista" value="<?php echo $idartista?>">
                            <div>
                                <label for="nombre">Nombre: </label>
                                <input type="text" value="<?php echo $nombre_artista?>" name="nombre" required>
                            </div>
                            <div>
                                <label for="instrumento">Instrumento: </label>
                                <input type="text" value="<?php echo $instrumento?>" name="instrumento" >
                            </div>
                            <div>
                                <label for="nacionalidad">Nacionalidad: </label>
                                <input type="text" value="<?php echo $nacionalidad?>" name="nacionalidad" required>
                            </div>
                            <div>
                                <label for="website">Website: </label>
                                <input type="url" value="<?php echo $website?>" name="website" >
                            </div>
                            <div>
                                <label for="biografia">Biografia: </label>
                                <input type="text" value="<?php echo $biografia?>" name="biografia" >
                            </div>
                            <div class="botones">
                                <input class="boton" type="submit" value="modificar artista" name="modificarA">
                        
                    </form>
                    <form action="menu.php">
                        <input class="boton botonMenu" type="submit" value="volver al menu">
                    </form>
                            </div>
                </div> 
            </div>
            <?php   
            }

            if(isset($_POST['modificarA']) && isset($_SESSION['usuario'])){

                $artista = $_POST['idartista'];

                $connection = connection("discografia");
                if(!$connection){
                    mysqli_close($connection);
                    header('Location: error.php?error=conexion');
                    exit();
                }

                $consulta = "UPDATE `artistas`
                                SET 
                                    `nombre` = ?,
                                    `nacionalidad` = ?,
                                    `instrumento` = ?,
                                    `biografia` = ?,
                                    `website` = ?
                                WHERE `idartista` = ?";

                if(!$stmt = mysqli_prepare($connection, $consulta)){
                    mysqli_stmt_close($stmt);
                    mysqli_close($connection);
                    header('Location: error.php?error=ejecucion');
                    exit();
                }

                mysqli_stmt_bind_param($stmt, 'sssssi', $_POST['nombre'], $_POST['nacionalidad'], $_POST['instrumento'],
                                        $_POST['biografia'], $_POST['website'], $artista);

                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    mysqli_close($connection);
                    header("Location: correcto.php?modificar=artista&artista=". $artista);
                    exit();
                }else{
                    mysqli_stmt_close($stmt);
                    mysqli_close($connection);
                    header('Location: error.php?error=consulta');
                    exit();
                }
            }

        ?>

        
    </body>
</html>