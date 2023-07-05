<?php
include 'php/conexion.php';
require 'php/config.php';

$db = new DataBase();
$con = $db->conectar();

$id = $_SESSION['id'];
$sql = $con->prepare("SELECT * FROM usuarios WHERE id=?");
$sql->execute([$id]);
$row = $sql->fetch(PDO::FETCH_ASSOC);
$id_cliente = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores actualizados de los campos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Actualizar la información del usuario en la base de datos
    $sql = $con->prepare("UPDATE usuarios SET usuario=?, correo=?, telefono=?, direccion=? WHERE id=?");
    $sql->execute([$nombre, $correo, $telefono, $direccion, $id_cliente]);

    // Redirigir a la página del perfil o mostrar un mensaje de éxito
    header('Location: perfil-cliente.php');
    exit();
}
