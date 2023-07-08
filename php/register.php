<?php
include 'conexion.php';

$nombre = $_POST['usuario'];
$correo = $_POST['correo'];
$pass = $_POST['pass'];
//$pass = hash('sha512', $pass);

// Verificar si el nombre o el correo ya existen en la base de datos
$query_check = "SELECT COUNT(*) AS count FROM usuarios WHERE usuario='$nombre' OR correo='$correo'";
$result_check = mysqli_query($conexion, $query_check);
$row_check = mysqli_fetch_assoc($result_check);

if ($row_check['count'] > 0) {
    // El nombre o el correo ya existen en la base de datos, mostrar una notificación
    echo '<script>
    alert("El nombre o el correo ya existen en la base de datos. Por favor, elija otro.");
    window.location = "../index.php";
    </script>';
} else {
    $query = "INSERT INTO usuarios(usuario, correo, pass) VALUES ('$nombre','$correo','$pass')";
    $consulta = mysqli_query($conexion, $query);
    header("location: ../index.php");
    exit;
}
