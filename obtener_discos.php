<?php
session_start();
require_once 'connectBDD.php';

// Evitar errores de acceso
if (!isset($_SESSION['usuario'])) {
    http_response_code(403);
    echo json_encode(["error" => "Acceso no autorizado"]);
    exit();
}

if (!isset($_GET['idgrupo']) || !is_numeric($_GET['idgrupo'])) {
    http_response_code(400);
    echo json_encode(["error" => "Parámetros inválidos"]);
    exit();
}

$idgrupo = intval($_GET['idgrupo']);

$connection = connection('discografia');
if (!$connection) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión"]);
    exit();
}

$consultaDiscos = "SELECT iddisco, titulo, anyo FROM discos WHERE idgrupo = ?";
$stmt = mysqli_prepare($connection, $consultaDiscos);
if (!$stmt) {
    mysqli_close($connection);
    http_response_code(500);
    echo json_encode(["error" => "Error en la consulta"]);
    exit();
}

mysqli_stmt_bind_param($stmt, "i", $idgrupo);
if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
    http_response_code(500);
    echo json_encode(["error" => "Error en la ejecución"]);
    exit();
}

mysqli_stmt_bind_result($stmt, $iddisco, $titulo, $anyo);

$discos = [];
while (mysqli_stmt_fetch($stmt)) {
    $discos[] = [
        'iddisco' => $iddisco,
        'titulo' => $titulo,
        'anyo' => $anyo
    ];
}

mysqli_stmt_close($stmt);
mysqli_close($connection);

// Asegurar que el contenido sea JSON puro
header('Content-Type: application/json');
echo json_encode($discos);
exit();
?>