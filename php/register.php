<?php
    include 'conexion.php';
    
    $nombre = $_POST['usuario'];
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];
    $pass = hash('sha512', $pass);
    
    $query = "INSERT INTO usuarios(usuario, correo, pass) VALUE('$nombre','$correo','$pass')";

    $consulta = mysqli_query($conexion, $query);
    
    header("location: ../index.php");
    exit;
?>