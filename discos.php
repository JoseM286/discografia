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
            if(isset($_POST['crear']) || isset($_POST['crear_disco']) || isset($_POST['crear_cancion'])){ 
                return "image11";
            }
            if(isset($_POST['mostrar'])){
                return "image10";
            }
            if(isset($_POST['eliminar']) || isset($_SESSION['eliminar'])){
                return "image12";
            }
            if(isset($_POST['modificar']) || isset($_SESSION['modificar'])){
                return "image15";
            }
            
        }

        if((isset($_POST['crear_disco']) || isset($_POST['crear_cancion'])) && isset($_SESSION['usuario'])){

            if(isset($_POST['crear_disco'])){

                $titulo = trim($_POST['titulo']);

                $connection = connection('discografia');
                if(!$connection){
                    header('Location: error.php?error=conexion');
                    exit();
                }

                $consulta01 = "SELECT `titulo` FROM `discos` WHERE `titulo` = ?";   //Busco si hay discos con el mismo
                $stmt01 = $connection->prepare($consulta01);                        //titulo en la BDD, si lo hay:
                if (!$stmt01) {                                                     //error: "ya existe
                    header('Location: error.php?error=conexion');
                    exit();
                }
                $stmt01->bind_param('s', $titulo);
                $stmt01->execute();
                $stmt01->bind_result($titulo_buscado);
                if ($stmt01->fetch()) {
                    $stmt01->close();
                    $connection->close();
                    header('Location: error.php?error=disco_existente&disco='.$titulo);
                    exit();
                }
                $stmt01->close();
            
                $cubierta_content = 'Sin cubierta';
                if(isset($_FILES['cubierta']) && $_FILES['cubierta']['error'] === UPLOAD_ERR_OK){
                    $cubierta_image = $_FILES['cubierta']['tmp_name'];          
                    $cubierta_content = file_get_contents($cubierta_image);     //Contenido binario de la img
                }

                $_SESSION['datos_disco'] = [
                    'titulo'       => trim($_POST['titulo']),
                    'anyo'         => intval($_POST['anyo']),
                    'idsello'      => intval($_POST['sellos']),
                    'cubierta'     => $cubierta_content,
                    'descripcion'  => trim($_POST['descripcion']),
                    'idgrupo'      => intval($_POST['grupos']),
                    'numCanciones' => intval($_POST['numCanciones'])
                ];
                if(!isset($_SESSION['cantidad_canciones'])){                            
                    $_SESSION['cantidad_canciones'] = intval($_POST['numCanciones']);   //Establecemos cantidad de canciones
                }
                if(!isset($_SESSION['numero_cancion'])){
                    $_SESSION['numero_cancion'] = 1;                //Establecemos el numero de la cancion actual
                }
                $connection->close();
            }

 /*           if(isset($_POST['crear_cancion'])){

                $cancion_existe = false;                            //booleano que determinara si la cancion existe
                $titulo_cancion = $_POST['titulo'];                 //para poder entrar a guardar los datos de la cancion

                $connection = connection('discografia');
                if(!$connection){
                    header('Location: error.php?error=conexion');
                    exit();
                }
                $consulta02 = "SELECT `titulo` FROM `canciones` WHERE `titulo` = ?";
                $stmt02 =$connection->prepare($consulta02);
                if(!$stmt02){
                    header('Location: error.php?error=conexion');
                    exit();
                }
                $stmt02->bind_param("s", $titulo_cancion);
                $stmt02->execute();
                $stmt02->bind_result($titulo_buscado_cancion);
                if ($stmt02->fetch()) {
                    $cancion_existe = true;
                    echo "
                    <script language='javascript'>
                        alert('La canción '.$titulo_cancion.' ya existe. Se copiarán los datos de la canción existente.');
                    </script>";

                }
                $stmt02->close();
            }*/
            
            if (isset($_POST['crear_cancion']) && !empty($_POST['titulo'])/* && $cancion_existe === false*/) {
                if (!isset($_SESSION['ultima_cancion']) || $_SESSION['ultima_cancion'] !== $_POST['titulo']) {
                    $_SESSION['canciones'][] = [
                        'titulo'         => $_POST['titulo'],
                        'duracion'       => $_POST['duracion'],
                        'autor'          => $_POST['autor'],
                        'fecha'          => $_POST['fecha'],
                        'letra'          => $_POST['letra']
                    ];                                            //Grabo datos en un array de arrays SESSION
                    $_SESSION['numero_cancion']++;
                    $_SESSION['ultima_cancion'] = $_POST['titulo'];
                }
            }

            if($_SESSION['numero_cancion'] > $_SESSION['cantidad_canciones']){
                unset($_SESSION['numero_cancion']);
                unset($_SESSION['cantidad_canciones']);
                header("Location: gestion_discos.php?disco=creado");
                exit();
            }

            if($_SESSION['numero_cancion'] == 1){

                $titulo = $_POST['titulo'];
                $idgrupo = $_POST['grupos'];
                $anyo = $_POST['anyo'];

                $connection = connection('discografia');
                if(!$connection){
                    header('Location: error.php?error=conexion');
                    exit();
                }

                $consulta = "SELECT iddisco FROM discos WHERE titulo = ? AND idgrupo = ? AND anyo = ?";  //Busco si hay
                if (!$stmt = mysqli_prepare($connection, $consulta)) {                              //discos con el 
                    mysqli_close($connection);                                                      //mismo titulo,
                    header('Location: error.php?error=consulta');                                   //grupo y anyo
                    exit();                                                                         //
                }

                    
                mysqli_stmt_bind_param($stmt, "sii", $titulo, $idgrupo, $anyo); //Vinculo parametros
                if (!mysqli_stmt_execute($stmt)) {                              //con los obtenidos en
                    mysqli_stmt_close($stmt);                                   //el form anterior
                    mysqli_close($connection);                                  //
                    header('Location: error.php?error=ejecucion');              //      
                    exit();
                }

                
                mysqli_stmt_store_result($stmt);             // Obtengo el resultado
                if (mysqli_stmt_num_rows($stmt) > 0) {       // Si devuelve alguna linea
                    mysqli_stmt_close($stmt);                // el disco ya existe
                    mysqli_close($connection);
                    header('Location: error.php?error=disco_existente'); 
                    exit();
                } else {
                    mysqli_stmt_close($stmt);                // El disco no existe, procedo a insertarlo
                }
            }

            ?>
            <div class="form_caja">
                
                <h2><?php echo strtoupper($_SESSION['usuario']);?><br> Introduce los datos de la canción 
                    <?php echo strtoupper($_SESSION['numero_cancion']);?></h2>
                
                <div class="form">

                    <form action="discos.php" method="post">
                        
                        <div>
                            <label for="titulo">Título: </label>
                            <input type="text" placeholder="Introduce el título" name="titulo" required>
                        </div>
                        <div>
                            <label for="duracion">Duración: </label>
                            <input type="number" min="1" max="1000" placeholder="En segundos" name="duracion" required>
                        </div>
                        <div>
                            <label for="autor">Autor: </label>
                            <input type="text" placeholder="Introduce el autor" name="autor" required>
                        </div>
                        <div>
                            <label for="fecha">Fecha de grabación: </label>
                            <input type="date" name="fecha" required>
                        </div>
                            <div class="desc">
                            <label id="descLabelD" for="letra">Letra: </label>
                            <textarea id="descTextD" placeholder="Letra de la canción" name="letra" 
                            rows="4" cols="50" required></textarea>
                        </div>
                        <div class="botones">
                            <input class="boton" type="submit" value="crear cancion" name="crear_cancion">
                        
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
        if(isset($_POST['crear']) && isset($_SESSION['usuario'])){
            $connection = connection('discografia');
            if(!$connection){
                header('Location: error.php?error=conexion');
                exit();
            }
            ?>
            <div class="form_caja">
                
                <h2><?php echo strtoupper($_SESSION['usuario']);?><br> Introduce la información del disco</h2>
                
                <div class="form">

                    <form action="discos.php" method="post" enctype="multipart/form-data"> <!--enctype para añadir pasar files-->
                        
                        <div>
                            <label for="titulo">Nombre: </label>
                            <input type="text" placeholder="Introduce su titulo" name="titulo" required>
                        </div>
                        <div>
                            <label for="anyo">Año: </label>
                            <input type="number" step="1" min="0" placeholder="En que año salio el disco" name="anyo" required>
                        </div>

                        <?php 

                            $connection = connection("discografia");
                            if(!$connection){
                                header('Location: error.php?error=conexion');
                                exit();
                            }
                            $consulta = "SELECT `idsello`, `nombre`  FROM `sellos`";

                            if(!$stmt = mysqli_prepare($connection, $consulta)){
                                mysqli_close($connection);
                                header('Location: error.php?error=consulta');
                                exit();
                            }
                            if(!mysqli_stmt_execute($stmt)){
                                mysqli_stmt_close($stmt);
                                mysqli_close($connection);
                                header('Location: error.php?error=ejecucion');
                                exit();
                            }
                                mysqli_stmt_bind_result($stmt, $idsello, $nombre);
                            ?>
                            <label for="sellos">Sello:</label>
                            <select name="sellos" id="sellos" required>
                            <?php
                            echo "<option value='4'>Otro sello</option>";
                            while (mysqli_stmt_fetch($stmt)){
                                echo '<option value="' . htmlspecialchars($idsello)
                                        . '">' . htmlspecialchars($nombre) 
                                        . '</option>';
                            }
                            mysqli_stmt_close($stmt);
                            mysqli_close($connection);
                            ?>
                            </select>

                        <div>
                            <label for="cubierta">Cubierta: </label>
                            <input type="file"  name="cubierta" accept="image/*">
                        </div>
                        <div class="desc">
                            <label id="descLabelD" for="descripcion">Descripción: </label>
                            <textarea id="descTextD" placeholder="Descripción del disco" name="descripcion" 
                            rows="4" cols="50" required></textarea>
                        </div>
                        <div>
                        <?php 

                            $connection = connection("discografia");
                            if(!$connection){
                                header('Location: error.php?error=conexion');
                                exit();
                            }
                            $consulta = "SELECT `idgrupo`, `nombre`  FROM `grupos`";

                            if(!$stmt = mysqli_prepare($connection, $consulta)){
                                mysqli_close($connection);
                                header('Location: error.php?error=consulta');
                                exit();
                            }
                            if(!mysqli_stmt_execute($stmt)){
                                mysqli_stmt_close($stmt);
                                mysqli_close($connection);
                                header('Location: error.php?error=ejecucion');
                                exit();
                            }
                                mysqli_stmt_bind_result($stmt, $idgrupo, $nombre);
                            ?>
                            <label for="grupos">Grupo:</label>
                            <select name="grupos" id="grupos" required>
                            <?php
                            echo "<option value='7'>Otro grupo</option>";
                            while (mysqli_stmt_fetch($stmt)){
                                echo '<option value="' . htmlspecialchars($idgrupo)
                                        . '">' . htmlspecialchars($nombre) 
                                        . '</option>';
                            }
                            mysqli_stmt_close($stmt);
                            mysqli_close($connection);
                            ?>
                            </select>
                        </div>
                        <div>
                            <label for="numCanciones">Canciones: </label>
                            <input type="number" min="0" max="20" placeholder="Cuantas canciones tiene" name="numCanciones">
                        </div>
                        <div class="botones">
                            <input class="boton" type="submit" value="crear disco" name="crear_disco">               
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['mostrar']) && isset($_SESSION['usuario'])){
        
            $connection = connection("discografia");
            if(!$connection){
                header('Location: error.php?error=conexion');
                exit();
            }

            $consultaGrupos = "SELECT idgrupo, nombre, nacionalidad  FROM grupos";
            
            if(!$stmtGrupos = mysqli_prepare($connection, $consultaGrupos)){
                mysqli_close($connection);
                header('Location: error.php?error=consulta');
                exit();
            }
            if(!mysqli_stmt_execute($stmtGrupos)){
                mysqli_stmt_close($stmtGrupos);
                mysqli_close($connection);
                header('Location: error.php?error=ejecucion');
                exit();
            }
            mysqli_stmt_bind_result($stmtGrupos, $idgrupo, $nombre, $nacionalidad);

            $grupos = [];                               //Me toca hacer el array $grupo para meter los datos de fetch, porque
            while (mysqli_stmt_fetch($stmtGrupos)){     //cuando llamas a fetch llamas al ultimo fetch que se ha creado
                $grupos[] = [                           //dando igual el nombre de la variable
                    "id" => $idgrupo,
                    "nombre" => $nombre,
                    "nacionalidad" => $nacionalidad
                ];
            }
            mysqli_stmt_close($stmtGrupos);
            mysqli_close($connection);

            ?>
            <div class="form_caja">
                <h2><?php echo strtoupper($_SESSION['usuario']);?><br> Que disco quieres ver</h2>
                <form action="gestion_discos.php" method="POST" onsubmit="return validarSeleccion()">
                <select name="gruposMostrar" id="gruposMostrar" onchange="cargarDiscos()">
                <?php
                    echo "<option value=''>Selecciona un grupo</option>";
                    foreach ($grupos as $grupo){            //Me toca hacer un foreach para pasar los datos de $grupo
                    echo '<option value="' . htmlspecialchars($grupo['id'])
                            . '">' . htmlspecialchars($grupo['nombre']) 
                            .' - '. htmlspecialchars($grupo['nacionalidad']) 
                            . '</option>';
                    }
                ?>
                </select>

                <select name="discosMostrar" id="discosMostrar">

                    <option value=''>Selecciona un disco</option>
                    <!-- Los discos se cargarán aquí dinámicamente -->              
                </select>

                <div class="checkbox">
                    <input type="checkbox" name="checkbox" id="checkbox" value="incluir">
                    <label for="checkbox" id="checklabel">Incluir canciones</label>
                </div>

                <div class="botones">
                    <input type="submit" class="boton" name="mostrar" value="mostrar datos">
                </form>
                    <form action="menu.php">
                        <input class="boton botonMenu" type="submit" value="volver al menu">
                    </form>
                </div>
            </div>
            <?php  

        ?>    
        <script>
            function validarSeleccion(){
                const selGrupo = document.getElementById('gruposMostrar').value;
                const selDisco = document.getElementById('discosMostrar').value;

                if(selGrupo === '' && selDisco === ''){
                    alert('Tienes que seleccionar alguna opcion');
                    return false;
                }/*if(selGrupo !== '' && selDisco !== ''){
                    alert('No puedes seleccionar en grupos y discos a la vez');
                    return false;
                }*/

                return true;
                
            }

            function cargarDiscos(){
                const idGrupo = document.getElementById('gruposMostrar').value;
                const discosSelect = document.getElementById('discosMostrar');

                discosSelect.innerHTML = '<option value="">Selecciona un disco</option>'; //Limpiar select de discos

                if (idGrupo === '') {
                    return; // No hacer nada si no se selecciona un grupo
                }
                
                // Enviar una solicitud AJAX para obtener los discos del grupo seleccionado
                fetch(`obtener_discos.php?idgrupo=${idGrupo}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Error al cargar discos");
                        }
                        return response.json();
                    })
                    .then(data => {
                        data.forEach(disco => {
                            let option = document.createElement('option');
                            option.value = disco.iddisco;
                            option.textContent = `${disco.titulo} - ${disco.anyo}`;
                            discosSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error(error));
            }

        </script>
        <?php
        }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['eliminar']) && isset($_SESSION['usuario'])){

            $connection = connection("discografia");
            if(!$connection){
                header('Location: error.php?error=conexion');
                exit();
            }

            $consulta = "SELECT iddisco, titulo, anyo FROM discos";

            if($stmt=mysqli_prepare($connection, $consulta)){
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_bind_result($stmt, $iddisco, $titulo, $anyo);
                    ?>
                    <div class="form_caja eliminarA">
                    <h2><?php echo strtoupper($_SESSION['usuario']) . "<br> selecciona el disco a eliminar"?></h2>
                    <form action="gestion_discos.php" method="POST">
                        <select name="discos" id="discos">
                            <option value="">selecciona un disco</option>
                            <?php 
                            while(mysqli_stmt_fetch($stmt)){
                                    echo '<option value="' . htmlspecialchars($iddisco) 
                                    . '">' . htmlspecialchars($titulo) 
                                    . ' - ' . htmlspecialchars($anyo)
                                    . ' </option>';
                            }
                            ?>
                        </select>
                            <div class="botones">
                                <input type="submit" class="boton" name="eliminar" value="eliminar disco">
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            if(isset($_POST['modificar']) && isset($_SESSION['usuario'])){


                $connection = connection('discografia');
                if(!$connection){
                    header("Location: error.php?error=conexion");
                    exit();
                }

                $consulta = "SELECT `iddisco`, `titulo`, `anyo` FROM discos
                            ORDER BY `anyo`
                            ";

                if($stmt = mysqli_prepare($connection, $consulta)){
                    if(mysqli_stmt_execute($stmt)){
                        mysqli_stmt_bind_result($stmt, $iddisco, $titulo, $anyo);
                            ?>
                            <div class="form_caja modificarA">
                                <h2><?php echo strtoupper($_SESSION['usuario']) ?><br> selecciona el disco a modificar</h2>
                                <form action="gestion_discos.php" method="POST">
                                    <select name="discos" id="discos" required>
                                        <option value="">selecciona un disco</option>
                                        <?php
                                            while(mysqli_stmt_fetch($stmt)){
                                                echo '<option value="'. htmlspecialchars($iddisco)
                                                .'">'. htmlspecialchars($titulo)
                                                .' - '. htmlspecialchars($anyo)
                                                .'</option>';
                                            }
                                        ?>
                                    </select>
                                    <div class="botones">
                                        <input class="boton" type="submit" value="modificar disco" name="modificar">
                                </form>
                                <form action="menu.php">
                                    <input class="boton botonMenu" type="submit" value="volver al menu">
                                </form>
                                </div>
                            </div>
                            <?php
                            mysqli_stmt_close($stmt);
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
                mysqli_close($connection);
            }
            ?>
            
    </body>
</html>