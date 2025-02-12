<?php

require_once 'connectBDD.php';

$sentencia1 = "ALTER TABLE `integrantes`
  ADD CONSTRAINT `integrantes_ibfk_1` FOREIGN KEY (`idgrupo`) REFERENCES `grupos` (`idgrupo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `integrantes_ibfk_2` FOREIGN KEY (`idartista`) REFERENCES `artistas` (`idartista`) ON UPDATE CASCADE,
  ADD CONSTRAINT `integrantes_ibfk_3` FOREIGN KEY (`idrol`) REFERENCES `roles` (`idrol`) ON UPDATE CASCADE;";

$sentencia2 = "ALTER TABLE `integrantes`
  ADD PRIMARY KEY (`idgrupo`,`idartista`, `idrol`),
  ADD KEY `idgrupo` (`idgrupo`),
  ADD KEY `idartista` (`idartista`),
  ADD KEY `idrol` (`idrol`);";
  
$sentencia3 = "CREATE TABLE `usuarios` (
  `codigo` int AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(50) UNIQUE,
  `pwd` varchar(100) NOT NULL,
  `tipo` int NOT NULL CHECK (tipo in (0,1))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$sentencia4 = "INSERT INTO `usuarios` (`nombre`, `pwd`, `tipo`) VALUES ('Jos', 'jos', 1);";

$result1 = mysqli_query($connection, $sentencia1);
$result2 = mysqli_query($connection, $sentencia2);
$result3 = mysqli_query($connection, $sentencia3);
$result4 = mysqli_query($connection, $sentencia4);

mysqli_close($connection);

?>


