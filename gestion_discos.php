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
            }elseif(isset($_POST['modificar']) || isset($_POST['modificar2'])){
                return "image14";
            }elseif(isset($_GET['disco']) && $_GET['disco'] === 'creado'){
                return "image9";
            }
        }


        if(isset($_GET['disco']) && $_GET['disco'] === 'creado' && isset($_SESSION['usuario']) && isset($_SESSION['datos_disco'])){

            $connection = connection('discografia');
            if(!$connection){
                header('Location: error.php?error=conexion');
                exit();
            }

            $error_msg = '';

            try{

                $titulo = $_SESSION['datos_disco']['titulo'];
                $anyo = $_SESSION['datos_disco']['anyo'];
                $idsello = $_SESSION['datos_disco']['idsello'];
                $cubierta = $_SESSION['datos_disco']['cubierta'];
                $descripcion = $_SESSION['datos_disco']['descripcion'];
                $idgrupo = $_SESSION['datos_disco']['idgrupo'];
                $numCanciones = $_SESSION['datos_disco']['numCanciones'];

                $connection->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT; //Configurar msqli para usar excepciones
                $connection->begin_transaction(); //Inicio transacción

                $stmt1 = $connection->prepare("INSERT INTO discos (`titulo`, `anyo`, `idsello`, `cubierta`, `descripcion`, `idgrupo`)
                                        VALUES (?, ?, ?, ?, ?, ?)");
                if(!$stmt1){
                    throw new Exception("Error al preparar la consulta stmt1: " . $stmt1->error);
                }

                $stmt1->bind_param('siissi', $titulo, $anyo, $idsello, $cubierta, $descripcion, $idgrupo);

                if(!$stmt1->execute()){
                    throw new Exception("Error al ejecutar la consulta stmt2: " . $stmt1->error);
                }

                $iddisco = $stmt1->insert_id;
                $stmt1->close();

                if (isset($_SESSION['canciones']) && !empty($_SESSION['canciones'])) {

                    $stmt2 = $connection->prepare("INSERT INTO canciones (`titulo`, `duracion`, `autor`, `fecha-grabacion`, `letra`)
                                            VALUES (?, ?, ?, ?, ?)");
                    if(!$stmt2){
                        throw new Exception("Error al preparar la consulta stmt2: " . $stmt2->error);
                    }

                                                
                    $stmt3 = $connection->prepare("INSERT INTO cancionesdisco (`iddisco`, `idcancion`)
                                            VALUES (?, ?)");
                    if(!$stmt3){
                        throw new Exception("Error al preparar la consulta stmt2: " . $stmt3->error);
                    }

                    foreach ($_SESSION['canciones'] as $index => $cancion) {
                        $titulo = $cancion['titulo'];
                        $duracion = $cancion['duracion'];
                        $autor = $cancion['autor'];
                        $fecha = $cancion['fecha'];
                        $letra = $cancion['letra'];

                        $stmt2->bind_param("sisss", $titulo, $duracion, $autor, $fecha, $letra);
                        if(!$stmt2->execute()){
                            throw new Exception("Error al ejecutar la consulta stmt2: " . $stmt2->error);
                        }

                        $idcancion = $stmt2->insert_id;  // Obtengo id de la cancion insertada en cada iteración

                        $stmt3->bind_param("ii", $iddisco, $idcancion);
                        if(!$stmt3->execute()){
                            throw new Exception("Error al ejecutar la consulta stmt3: " . $stmt3->error);
                        }
                    }
                    $stmt2->close();
                    $stmt3->close();
                }


                $connection->commit();    //Confirmo transacción
                header('Location: correcto.php?crear=disco&disco='. $iddisco);
                exit();
            }catch(Exception $e){
                $connection->rollback();
                $error_msg = urlencode($e->getMessage());
                header('Location: error.php?error=transaccion&detalles=' . $error_msg);
                exit();
            }finally{
                $connection->close();      
                unset($_SESSION['datos_disco']);
                unset($_SESSION['canciones']);
            }
            
        }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['gruposMostrar']) && !empty($_POST['gruposMostrar']) && 
            isset($_SESSION['usuario']) && empty($_POST['discosMostrar'])){

            $grupo = $_POST['gruposMostrar'];

            $connection = connection("discografia");
            if(!$connection){
                mysqli_stmt_close($stmt);
                mysqli_close($connection);
                header('Location: error.php?error=conexion');
                exit();
            }

            $consulta = "SELECT d.`iddisco`, d.`titulo`, d.`anyo`, d.`cubierta`, d.`descripcion`, g.`nombre`, s.`nombre`,
                        GROUP_CONCAT(DISTINCT c.`titulo` ORDER BY c.`titulo`) AS `nombre_canciones`
                        from `grupos` g
                        LEFT JOIN `discos` d ON g.`idgrupo` = d.`idgrupo`
                        LEFT JOIN `sellos` s ON d.`idsello` = s.`idsello`
                        LEFT JOIN `cancionesdisco` cd ON d.`iddisco` = cd.`iddisco`
                        LEFT JOIN `canciones` c ON cd.`idcancion` = c.`idcancion`
                        WHERE g.`idgrupo` = ?
                        GROUP BY d.`iddisco`
                        ORDER BY d.`titulo`
                        ";

            if(!$stmt = mysqli_prepare($connection, $consulta)){
                mysqli_close($connection);
                header('Location: error.php?error=ejecucion');
                exit();
            }
            mysqli_stmt_bind_param($stmt, 'i', $grupo);

            if(!mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                mysqli_close($connection);
                header('Location: error.php?error=consulta');
                exit();
            }else{
                mysqli_stmt_bind_result($stmt, $iddisco, $titulo, $anyo,
                    $cubierta, $descripcion, $nombre_grupo, $nombre_sello, $nombre_canciones);

                echo "<div class='tabla_mostrar'>";
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Titulo</th>
                            <th>Año</th>
                            <th>Cubierta</th>
                            <th>Descripcion</th>
                            <th>Grupo</th>
                            <th>Sello</th>
                            <?php echo (isset($_POST['checkbox']) ? "<th>Canciones</th>" : ''); ?> 
                        </tr>
                    </thead>
                    <tbody>
                <?php
                    while(mysqli_stmt_fetch($stmt)){
                        echo "<tr>";
                            echo   '<td>'. (($titulo == "" ) ? "-" : htmlspecialchars($titulo)).'</td>
                                    <td>'.(($anyo == "" ) ? "-" : htmlspecialchars($anyo)).'</td>
                                    <td>' . (($cubierta == "") ? "-" : '<img src="data:image/jpeg;base64,' . base64_encode($cubierta) 
                                    . '" alt="Cubierta" id="imgDiscos">') . '</td>
                                    <td>'.(($descripcion == "" ) ? "-" : htmlspecialchars($descripcion)).'</td>
                                    <td>'.(($nombre_grupo == "" ) ? "-" : htmlspecialchars($nombre_grupo)).'</td>
                                    <td>'.(($nombre_sello == "" ) ? "-" : htmlspecialchars($nombre_sello)).'</td>';
                            
                            if(isset($_POST['checkbox'])) {
                                echo "<td>";
                                if(empty($nombre_canciones)){
                                    echo "-";
                                }
                                else{
                                    $nombre_cancion = explode(',', $nombre_canciones);
                                    $contadorNC = ($nombre_cancion == "") ? "" : 1;
                                    foreach ($nombre_cancion as $nombre_cancion1){
                                        echo $contadorNC . " - " . htmlspecialchars($nombre_cancion1) . "<br>";
                                        $contadorNC++;
                                    }
                                }
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
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['mostrar'])){

            if(isset($_POST['discosMostrar']) && !empty($_POST['discosMostrar']) && isset($_SESSION['usuario'])){
                
                $iddisco = $_POST['discosMostrar'];
        
                $connection = connection("discografia");
                if(!$connection){
                    mysqli_close($connection);
                    header('Location: error.php?error=conexion');
                    exit();
                }
                
                $consulta = "SELECT d.`iddisco`, d.`titulo`, d.`anyo`, d.`cubierta`, d.`descripcion`, g.`nombre`, s.`nombre`,
                            GROUP_CONCAT(DISTINCT c.`titulo` ORDER BY c.`titulo`) AS `nombre_canciones`
                            from `discos` d
                            LEFT JOIN `grupos` g ON d.`idgrupo` = g.`idgrupo`
                            LEFT JOIN `sellos` s ON d.`idsello` = s.`idsello`
                            LEFT JOIN `cancionesdisco` cd ON d.`iddisco` = cd.`iddisco`
                            LEFT JOIN `canciones` c ON cd.`idcancion` = c.`idcancion`
                            WHERE d.`iddisco` = ? 
                            GROUP BY d.`iddisco`";  // Añadido GROUP BY para asegurar que solo se traiga un resultado
        
                if(!$stmt = mysqli_prepare($connection, $consulta)){
                    mysqli_close($connection);
                    header('Location: error.php?error=ejecucion');
                    exit();
                }
        
                mysqli_stmt_bind_param($stmt, 'i', $iddisco);
                
                if(!mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    mysqli_close($connection);
                    header('Location: error.php?error=consulta');
                    exit();
                }else{
                    mysqli_stmt_store_result($stmt);
                    mysqli_stmt_bind_result($stmt, $iddisco, $titulo, $anyo, $cubierta, $descripcion, $nombre_grupo, 
                    $nombre_sello, $nombre_canciones);
        
                    echo "<div class='tabla_mostrar'>";
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Titulo</th>
                                <th>Año</th>
                                <th>Cubierta</th>
                                <th>Descripcion</th>
                                <th>Grupo</th>
                                <th>Sello</th>
                                <?php echo (isset($_POST['checkbox']) ? "<th>Canciones</th>" : ''); ?> 
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    // Mostrar los resultados obtenidos de la consulta
                    if(mysqli_stmt_num_rows($stmt) > 0) {
                        while(mysqli_stmt_fetch($stmt)){
                            echo "<tr>";
                                echo   '<td>'. (($titulo == "" ) ? "-" : htmlspecialchars($titulo)).'</td>
                                        <td>'.(($anyo == "" ) ? "-" : htmlspecialchars($anyo)).'</td>
                                        <td>' . (($cubierta == "") ? "-" : "<img src='" . htmlspecialchars($cubierta) . 
                                        "' alt='Cubierta' id='imgDiscos'>") . '</td>
                                        <td>'.(($descripcion == "" ) ? "-" : htmlspecialchars($descripcion)).'</td>
                                        <td>'.(($nombre_grupo == "" ) ? "-" : htmlspecialchars($nombre_grupo)).'</td>
                                        <td>'.(($nombre_sello == "" ) ? "-" : htmlspecialchars($nombre_sello)).'</td>';
                                
                                if(isset($_POST['checkbox'])) {
                                    echo "<td>";
                                    if(empty($nombre_canciones)){
                                        echo "-";
                                    } else {
                                        $nombre_cancion = explode(',', $nombre_canciones);
                                        $contadorNC = 1;
                                        foreach ($nombre_cancion as $nombre_cancion1){
                                            echo $contadorNC . " - " . htmlspecialchars($nombre_cancion1) . "<br>";
                                            $contadorNC++;
                                        }
                                    }
                                    echo "</td>";
                                } 
                            echo "</tr>";
                        }
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
            }
        }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['eliminar']) && isset($_SESSION['usuario'])){
            
            $iddisco = $_POST['discos'];

            try{

                $connection = connection("discografia");
                if(!$connection){
                    header('Location: error.php?error=conexion');
                    exit();
                }

                $connection->begin_transaction();

                //Obtengo Ids de canciones asociadas al disco seleccionado
                $consultaObtenerCanciones = "SELECT idcancion FROM cancionesdisco WHERE iddisco = ?";
                if (!$stmtObtener = $connection->prepare($consultaObtenerCanciones)) {
                    throw new Exception("Error al preparar la consulta selec idcancion: " . $connection->error);
                }
                $stmtObtener->bind_param('i', $iddisco);
                $stmtObtener->execute();
                $stmtObtener->bind_result($idcancion);

                $cancionesAsociadas = [];
                while ($stmtObtener->fetch()) {
                    $cancionesAsociadas[] = $idcancion;
                }
                $stmtObtener->close();

                //Elimino relacion de la tabla cancionesdisco entre cancion y disco
                $consultaCanciones = "DELETE FROM `cancionesdisco` WHERE `iddisco` = ?";
                if(!$stmtCanciones = $connection->prepare($consultaCanciones)){
                    throw new Exception("Error al preparar la consulta de cancionesDisco: " . $connection->error);
                }
                $stmtCanciones->bind_param('i', $iddisco);
                if(!$stmtCanciones->execute()){
                    throw new Exception("Error al ejecutar la consulta de cancionesDisco: " . $connection->error);
                }
                $stmtCanciones->close();

                //Elimino los discos del id dado por el usuario
                $consulta = "DELETE FROM `discos` WHERE `iddisco` = ?";
                if(!$stmt = $connection->prepare($consulta)){
                    throw new Exception("Error al preparar la consulta de disco: " . $connection->error);
                }
                $stmt->bind_param('i', $iddisco);
                if(!$stmt->execute()){
                    throw new Exception("Error al preparar la consulta de disco: " . $stmt->error);      
                }
                $stmt->close();

                if (!empty($cancionesAsociadas)) {
                    $idsCancionesPlaceholder = implode(',', array_fill(0, count($cancionesAsociadas), '?'));
                    $consultaCancionesHuerfanas = "
                        DELETE FROM canciones 
                        WHERE idcancion IN ($idsCancionesPlaceholder) 
                        AND idcancion NOT IN (SELECT idcancion FROM cancionesdisco)";
                    
                    if (!$stmtCancionesHuerfanas = $connection->prepare($consultaCancionesHuerfanas)) {
                        throw new Exception("Error al preparar la consulta de eliminación de canciones huérfanas: " . $connection->error);
                    }
        
                    $stmtCancionesHuerfanas->bind_param(str_repeat('i', count($cancionesAsociadas)), ...$cancionesAsociadas);
                    $stmtCancionesHuerfanas->execute();
                    $stmtCancionesHuerfanas->close();
                }

                $connection->commit ();

                header('Location: correcto.php?eliminar=disco&disco=' . $iddisco);
                exit();
            } catch (Exception $e) {
                // Revertir cambios en caso de error
                if($connection){
                    $connection->rollback ();
                    $connection->close();
                }
                $error_msg = urlencode($e->getMessage());
                header("Location: error.php?error=transaccion&detalles=$error_msg");
                exit();
            } finally {
                if (isset($connection)) {
                    $connection->close();
                }   
            }
        }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['modificar']) && isset($_SESSION['usuario'])){

            $disco = $_POST['discos'];

            $connection = connection("discografia");
            if(!$connection){
                header('Location: error.php?error=conexion');
                exit();
            }

            try{

                
                $iddisco = $titulo = $anyo = $idsello = $cubierta = $descripcion = $idgrupo = $nombre_sello = $nombre_grupo = '';

                $consulta = "SELECT d.`iddisco`, d.`titulo`, d.`anyo`, d.`idsello`, d.`cubierta`,
                                d.`descripcion`, d.`idgrupo`, s.`nombre`, g.`nombre`
                                from `discos` d
                                LEFT JOIN `sellos` s ON d.`idsello` = s.`idsello`
                                LEFT JOIN `grupos` g ON d.`idgrupo` = g.`idgrupo`
                                WHERE d.`iddisco` = ?
                                ";
        
                if (!$stmt = mysqli_prepare($connection, $consulta)) {
                    throw new Exception("Error al preparar la consulta");
                }
        
                mysqli_stmt_bind_param($stmt, 'i', $disco);
        
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error al ejecutar la consulta");
                }

                mysqli_stmt_bind_result($stmt, $iddisco, $titulo, $anyo, $idsello, $cubierta, $descripcion,
                $idgrupo, $nombre_sello, $nombre_grupo);

                if (!mysqli_stmt_fetch($stmt)) {
                    throw new Exception("No se encontró el disco con ID $disco");
                }
                         
                $titulo_actual = $titulo;

                mysqli_stmt_close($stmt);

            }catch(Exception $e){
                $error_msg = urlencode($e->getMessage());
                header('Location: error.php?error=transaccion&detalles=' . $error_msg);
                exit();
            }finally{
                mysqli_close($connection);     
            }

            ?>
            <div class="form_caja">
                
                <h2><?php echo strtoupper($_SESSION['usuario']);?><br> Modifica la información del disco</h2>
                
                <div class="form">

                    <form action="gestion_discos.php" method="post">
                        
                            <input type="hidden" name="iddisco" value="<?php echo $iddisco?>">
                            <input type="hidden" name="titulo_actual" value="<?php echo $titulo_actual?>">
                            <div>
                                <label for="titulo">Titulo: </label>
                                <input type="text" value="<?php echo htmlspecialchars($titulo) ?>" name="titulo" required>
                            </div>
                            <div>
                                <label for="anyo">Año: </label>
                                <input type="text" value="<?php echo htmlspecialchars($anyo) ?>" name="anyo" >
                            </div>
                            <div>
                                <label for="sello">Sello: </label>
                                <input type="text" value="<?php echo htmlspecialchars($nombre_sello) ?>" name="sello" required>
                            </div>
                            <div>
                                <label for="cubierta">Website: </label>
                                <input type="text" value="<?php echo htmlspecialchars($cubierta) ?>" name="cubierta" >
                            </div>
                            </div>
                            <div class="desc">
                            <label id="descLabelD" for="descripcion">Letra: </label>
                            <textarea id="descTextD" name="descripcion" 
                            rows="4" cols="50" required>
                            <?php echo htmlspecialchars($descripcion); ?>
                            </textarea>
                        </div>
                            <div>
                                <label for="grupo">Grupo: </label>
                                <input type="text" value="<?php echo htmlspecialchars($nombre_grupo) ?>" name="grupo" >
                            </div>
                            <div class="botones">
                                <input class="boton" type="submit" value="modificar disco" name="modificar2">
                        
                    </form>
                    <form action="menu.php">
                        <input class="boton botonMenu" type="submit" value="volver al menu">
                    </form>
                            </div>
                </div> 
            </div>
            <?php   
            }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            if(isset($_POST['modificar2']) && isset($_SESSION['usuario'])){

                $connection = connection("discografia");
                if(!$connection){
                    header('Location: error.php?error=conexion');
                    exit();
                }
                $iddisco = intval($_POST['iddisco']);
                $titulo_actual = $_POST['titulo_actual'];

                $nombre_sello = trim($_POST['sello']);
                $nombre_grupo = trim($_POST['grupo']);

                $titulo = trim($_POST['titulo']);
                $anyo = intval($_POST['anyo']);
                $idsello = '';
                $cubierta = trim($_POST['cubierta']);
                $descripcion = trim($_POST['descripcion']);
                $idgrupo = '';

                $nombre_sello = trim($_POST['sello']); // Obtener el nombre del sello desde el formulario

                try {    //Conseguimos el id del nuevo sello puesto por el usuario si existe, sino creamos nueva entrada en sellos

                    mysqli_autocommit($connection, false);
                    if($titulo_actual !== $titulo){
                        $consultaT = "SELECT `titulo` FROM `discos` WHERE `titulo` = ?";
                        $stmtT = mysqli_prepare($connection, $consultaT);

                        if (!$stmtT) {
                            throw new Exception("Error al preparar la consulta de selección: " . mysqli_error($connection));
                        }

                        mysqli_stmt_bind_param($stmtT, 's', $titulo);
                        mysqli_stmt_execute($stmtT);
                        mysqli_stmt_bind_result($stmtT, $titulo_buscado);

                        if (mysqli_stmt_fetch($stmtT)) {
                            mysqli_stmt_close($stmtT);
                            throw new Exception("El nombre del disco ya existe");
                        }
                        mysqli_stmt_close($stmtT);
                    }
                    // Comprobar si el sello ya existe
                    $consultaS = "SELECT `idsello` FROM `sellos` WHERE `nombre` = ?";
                    $stmtS = mysqli_prepare($connection, $consultaS);
        
                    if (!$stmtS) {
                        throw new Exception("Error al preparar la consulta de selección: " . mysqli_error($connection));
                    }

                    mysqli_stmt_bind_param($stmtS, 's', $nombre_sello);
                    mysqli_stmt_execute($stmtS);
                    mysqli_stmt_bind_result($stmtS, $idsello);
                    
                    if (!mysqli_stmt_fetch($stmtS)) {
                        // Si no se encontró el sello, insertar uno nuevo
                        mysqli_stmt_close($stmtS); // Cerrar statement antes de una nueva consulta
                        
                        $insertSello = "INSERT INTO `sellos` (`nombre`) VALUES (?)";
                        $stmtInsert = mysqli_prepare($connection, $insertSello);
                        
                        if (!$stmtInsert) {
                            throw new Exception("Error al preparar la consulta de inserción: " . mysqli_error($connection));
                        }

                        mysqli_stmt_bind_param($stmtInsert, 's', $nombre_sello);
                        
                        if (!mysqli_stmt_execute($stmtInsert)) {
                            throw new Exception("Error al insertar el sello: " . mysqli_stmt_error($stmtInsert));
                        }

                        // Obtener el nuevo ID insertado
                        $idsello = mysqli_insert_id($connection);
                        
                        mysqli_stmt_close($stmtInsert);
                    }else{
                        mysqli_stmt_close($stmtS); // Cerrar la consulta de selección
                    }

                    // Comprobar si el grupo ya existe
                    $consultaG = "SELECT `idgrupo` FROM `grupos` WHERE `nombre` = ?";
                    $stmtG = mysqli_prepare($connection, $consultaG);
        
                    if (!$stmtG) {
                        throw new Exception("Error al preparar la consulta de selección: " . mysqli_error($connection));
                    }

                    mysqli_stmt_bind_param($stmtG, 's', $nombre_grupo);
                    mysqli_stmt_execute($stmtG);
                    mysqli_stmt_bind_result($stmtG, $idgrupo);
                    
                    if (!mysqli_stmt_fetch($stmtG)) {
                        // Si no se encontró el grupo, insertar uno nuevo
                        mysqli_stmt_close($stmtG); // Cerrar statement antes de una nueva consulta
                        
                        $insertGrupo = "INSERT INTO `grupos` (`nombre`) VALUES (?)";
                        $stmtInsert = mysqli_prepare($connection, $insertGrupo);
                        
                        if (!$stmtInsert) {
                            throw new Exception("Error al preparar la consulta de inserción: " . mysqli_error($connection));
                        }

                        mysqli_stmt_bind_param($stmtInsert, 's', $nombre_grupo);
                        
                        if (!mysqli_stmt_execute($stmtInsert)) {
                            throw new Exception("Error al insertar el sello: " . mysqli_stmt_error($stmtInsert));
                        }

                        // Obtener el nuevo ID insertado
                        $idgrupo = mysqli_insert_id($connection);
                        
                        mysqli_stmt_close($stmtInsert);
                    }else{
                        mysqli_stmt_close($stmtG); // Cerrar la consulta de selección
                    }

                    $consulta = "UPDATE `discos`
                                    SET 
                                        `titulo` = ?,
                                        `anyo` = ?,
                                        `idsello` = ?,
                                        `cubierta` = ?,
                                        `descripcion` = ?,
                                        `idgrupo` = ?
                                    WHERE `iddisco` = ?";

                    $stmt = mysqli_prepare($connection, $consulta);
                    if (!$stmt) {
                        throw new Exception("Error al preparar la consulta: " . mysqli_error($connection));
                    }
            
                    mysqli_stmt_bind_param($stmt, 'siissii', $titulo, $anyo, $idsello,
                    $cubierta, $descripcion, $idgrupo, $iddisco);

                    if (!mysqli_stmt_execute($stmt)) {
                        throw new Exception("Error al ejecutar la consulta: " . mysqli_stmt_error($stmt));
                    }
                    
                    $correcto = true;
                    // Confirmar transacción
                    mysqli_commit($connection);
                } catch (Exception $e) {
                    $correcto = false;
                    // Revertir cambios en caso de error
                    mysqli_rollback($connection);
                    $error_msg = urlencode($e->getMessage());
                    header("Location: error.php?error=transaccion&detalles=$error_msg");
                    exit();
                } finally {
                    if (isset($connection)) {
                        mysqli_close($connection);
                    }
                    if($correcto){
                        header('Location: correcto.php?modificar=disco&disco=' . $iddisco);
                        exit();
                        }
                }
                
            }

        ?>
    </body>
</html>