<?php

include 'conexion.php';

$correo = $_POST['correo'];
$pass = $_POST['pass'];
//$pass = hash('sha512', $pass);

$db = new DataBase();
$con = $db->conectar();

$sql = $con->prepare("SELECT * FROM usuarios WHERE correo='$correo' AND pass='$pass'");
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);

if ($row) {
    session_start();
    $name = $row['usuario'];
    $_SESSION['id'] = $row['id'];
    if ($name == "admin") {
        header("location: ../admin.php");
        exit;
    }
    header("location: ../inicio.php");
    exit;
} else {
    header("location: ../index.php");
    exit;
}
