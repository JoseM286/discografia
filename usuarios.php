<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body class="<?php echo fondo(); ?>">

        <?php
        session_start();
        require_once 'connectBDD.php';
        function fondo(){
            if(isset($_POST['crear'])){
                return "image1";
            }
            if(isset($_POST['mostrar'])){
                return "image2";
            }
            if(isset($_POST['eliminar'])){
                return "image3";
            }
            if(isset($_POST['modificarPW'])){
                return "imageS";
            }
        }

        if(isset($_POST['crear']) && isset($_SESSION['usuario'])){
        ?>
            <div class="form_caja">
                
                <h2><?php echo strtoupper($_SESSION['usuario']);?><br> Introduce la información del usuario</h2>
                
                <div class="form">

                    <form action="gestion_usuarios.php" method="post">
                        
                            <div>
                                <label for="nombre">Nombre: </label>
                                <input type="text" placeholder="Introduce el nombre" name="nombre" required>
                            </div>
                            <div>
                                <label for="pwd">Contraseña: </label>
                                <input type="password" placeholder="Introduce la contraseña" name="pwd" required>
                            </div>
                            <div>
                                <label for="tipo">Tipo: </label>
                                <select name="tipo" id="tipo" required>
                                    <option value=0>normal</option>
                                    <option value=1>admin</option>
                                </select>
                            </div>
                            <div class="botones">
                                <input class="boton" type="submit" value="crear usuario" name="crearU">
                        
                    </form>
                    <form action="menu.php">
                        <input class="boton botonMenu" type="submit" value="volver al menu">
                    </form>
                            </div>
                </div> 
            </div>
        <?php   
            }

        if(isset($_POST['mostrar']) && isset($_SESSION['usuario'])){

            $connection = connection("discografia");


            $consulta = "SELECT nombre, tipo FROM usuarios";

            $resultado = mysqli_query($connection, $consulta);

            ?>
            <div class="form_caja">
                <h2><?php echo strtoupper($_SESSION['usuario']);?><br> Aqui tienes los usuarios dados de alta</h2>
                
                <?php

                if(!$resultado){
                    header("Location: error.php?error=consulta");
                    exit();
                }else{
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>nombre</th>
                                <th>tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = mysqli_fetch_assoc($resultado)){
                                echo "<tr>";
                                echo "<td>" . $row['nombre'] ."</td> <td>".($row['tipo'] == 1?'admin':'normal'). "</td>";
                                echo" </tr>";
                                }
                                mysqli_close($connection);
                            } 
                            ?>
                        </tbody>
                    
                    </table>
            <form action="menu.php">
                <input class="boton botonMenu" type="submit" value="volver al menu">
            </form>
            </div>
        <?php   
            }
        
        if (isset($_POST['eliminar']) && isset($_SESSION['usuario'])) {

            $connection = connection("discografia");

            $consulta = "SELECT codigo, nombre FROM usuarios";
            $resultado = mysqli_query($connection, $consulta);

            if (!$resultado) {
                header("Location: error.php?error=consulta");
                exit();
            } else {
                ?>
                <div class="form_caja">
                    <h2><?php echo strtoupper($_SESSION['usuario']);?><br> Selecciona un usuario para eliminar</h2>
                    <form action="gestion_usuarios.php" method="POST">
                        <select name="usuarios" id="usuarios">
                        <?php
                            while ($row = mysqli_fetch_assoc($resultado)) {
                                echo '<option value="' . $row['codigo'] . '">' . $row['nombre'] . '</option>';
                            }
                        ?>
                        </select>
                    
                    <div class="botones">
                        <input type="submit" class="boton" name="eliminarU" value="eliminar">
                    </form>
                        <form action="menu.php">
                            <input class="boton botonMenu" type="submit" value="volver al menu">
                        </form>
                    </div>
                </div>
                <?php   
                mysqli_close($connection);
            }
        }

        if(isset($_POST['modificarPW']) && isset($_SESSION['usuario'])){
        ?>
            <div class="form_caja">
                
                <h2><?php echo strtoupper($_SESSION['usuario']);?><br> Introduce la nueva contraseña dos veces </h2>
                
                <div class="form">

                    <form action="gestion_usuarios.php" method="post" onsubmit="return validarContraseñas();">
                        
                            <div>
                                <label for="pwd1">Contraseña: </label>
                                <input type="password" id="pwd1" placeholder="Introduce la contraseña" name="pwd1" required>
                            </div>
                            <div>
                                <label for="pwd2">Contraseña: </label>
                                <input type="password" id="pwd2"placeholder="Repite la contraseña" name="pwd2" required>
                            </div>
                            <div class="botones">
                                <input class="boton" type="submit" value="modificar" name="modificarPW">
                        
                    </form>
                    <form action="menu.php">
                        <input class="boton botonMenu" type="submit" value="volver al menu" name="modificar">
                    </form>
                            </div>
                </div> 
            </div>
            <script>
                function validarContraseñas() {
                    // Obtener los valores de los inputs
                    const pwd1 = document.getElementById('pwd1').value;
                    const pwd2 = document.getElementById('pwd2').value;

                    // Verificar si las contraseñas coinciden
                    if (pwd1 !== pwd2) {
                        alert('Las contraseñas no son iguales.');
                        return false; // Detiene el envío del formulario
                    }
                    return true; // Permite enviar el formulario si coinciden
                }
            </script>
        <?php   
            }
        ?> 
    </body>
</html>