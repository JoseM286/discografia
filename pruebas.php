            <?php
            $consulta01 = " SELECT `nombre` FROM `grupos` WHERE `nombre` = `Otro grupo`";
            if(!$resultado01 = mysqli_query($connection, $consulta01)){
                $consulta03 = "INSERT IGNORE INTO grupos (nombre) VALUES ('Otro grupo')";
                $resultado03 = mysqli_query($connection, $consulta03);
            }
            $consulta02 = " SELECT `nombre` FROM `sellos` WHERE `nombre` = `Otro sello`";
            if(!$resultado02 = mysqli_query($connection, $consulta02)){
                $consulta02 = "INSERT IGNORE INTO sellos (nombre) VALUES ('Otro sello')";
                $resultado02 = mysqli_query($connection, $consulta02);
            }

            /*$consulta01 = "INSERT IGNORE INTO grupos (nombre) VALUES ('Otro grupo')";
            $resultado01 = mysqli_query($connection, $consulta01);
            $consulta02 = "INSERT IGNORE INTO sellos (nombre) VALUES ('Otro sello')";
            $resultado02 = mysqli_query($connection, $consulta02);
            */
            $consulta05 = "SELECT idgrupo FROM grupos WHERE nombre = 'Otro grupo'";
            $resultado05 = mysqli_query($connection, $consulta05);
            $consulta06 = "SELECT idsello FROM sellos WHERE nombre = 'Otro sello'";
            $resultado06 = mysqli_query($connection, $consulta06);

            $idgrupo = mysqli_fetch_assoc($resultado03)['idgrupo'];
            $idsello = mysqli_fetch_assoc($resultado04)['idsello'];
  
            mysqli_close($connection);

            ?>