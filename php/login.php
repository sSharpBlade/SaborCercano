<?php

include 'conexion.php';

$correo = $_POST['correo'];
$pass = $_POST['pass'];
$pass = hash('sha512', $pass);

$validar = mysqli_query($conexion, "SELECT * FROM usuarios  WHERE correo='$correo' AND pass='$pass'");

if (mysqli_num_rows($validar) == 1) {
        session_start();
        $data = mysqli_fetch_assoc($validar);
        $name = $_SESSION['usuario'] = $data['usuario'];
        if ($name == "admin") {
            header("location: ../admin.php");
            exit;    
        }
        header("location: ../inicio.php");
        exit;
    }else{
        header("location: ../index.php");
        exit;
    }
?>