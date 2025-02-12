<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>

    <?php

    require_once 'connectBDD.php';
    session_start();



        if(isset($_POST["crearU"])){

            $connection = connection("discografia");
            $usuario = mysqli_real_escape_string($connection, $_POST["nombre"]);
            $pwd = mysqli_real_escape_string($connection, $_POST["pwd"]);
            $pwd_cifrado = password_hash($pwd, PASSWORD_DEFAULT);
            $tipo = $_POST['tipo'];
        
            $consulta = "INSERT INTO usuarios (nombre, pwd, tipo) VALUES ('$usuario', '$pwd_cifrado', '$tipo')";
        
            $resultado = mysqli_query($connection, $consulta);
        
            if(!$resultado){
                //die('Error en la consulta: ' . mysqli_error($connection));
                /*echo "<script language='javascript'>
            
                alert('El usuario $usuario ya existe');
                window.location.href= 'menu.php';
                
                </script>";*/
                header("Location: error.php?error=usuario_existente");
                exit();
            }else{
                $id_usuario = mysqli_insert_id($connection); //Obtengo el id del artista insertado
                header("Location:correcto.php?crear=usuario&usuario=" . $id_usuario);
                exit();
            }
                mysqli_close($connection);
        }

        
        if(isset($_POST['eliminarU'])){

            $connection = connection("discografia");

            $usuario = $_POST['usuarios'];
            $consulta = "DELETE FROM usuarios WHERE codigo = '$usuario'";
            $resultado = mysqli_query($connection, $consulta);

            if(!$resultado){
                header("Location: error.php?error=consulta");
                exit();
            }else{
                header("Location: correcto.php?eliminar=usuario&usuario=". $usuario);
                exit();
            }
                mysqli_close($connection);
        }
        
        if(isset($_POST["modificarPW"])){

            $connection = connection("discografia");
            $usuario = $_SESSION['usuario'];
            
            if (empty($_POST["pwd1"]) || empty($_SESSION['usuario'])) {
                header("Location: error.php?error=consulta");
                exit();
            }

            $pwd = $_POST["pwd1"];
            $pwd_cifrado = password_hash($pwd, PASSWORD_DEFAULT);
        
            $consulta = "UPDATE usuarios SET pwd = ? WHERE nombre = ?"; //
        
            if ($stmt = mysqli_prepare($connection, $consulta)) {

                mysqli_stmt_bind_param($stmt, "ss", $pwd_cifrado, $usuario);
                
                if(mysqli_stmt_execute($stmt)){
                    header("Location: correcto.php?cambio=password");
                    exit();
                } else {
                    header("Location: error.php?error=consulta");
                    exit();
                }
                mysqli_stmt_close($stmt);
            }else{
                echo "Error al preparar la consulta: ". mysqli_error($connection);
            }
                mysqli_close($connection);
        }
        ?>
    </body>
</html>