<?php
include '../php/conexion.php';
require '../php/config.php';

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
    $pass = $_POST['pass'];

    // Verificar si el nombre o el correo ya existen en la base de datos, excluyendo al usuario actual
    $sql_check = $con->prepare("SELECT COUNT(*) AS count FROM usuarios WHERE (usuario=? OR correo=?) AND id <> ?");
    $sql_check->execute([$nombre, $correo, $id_cliente]);
    $result_check = $sql_check->fetch(PDO::FETCH_ASSOC);
    if ($result_check['count'] > 0) {
        // El nombre o el correo ya existen en la base de datos, mostrar una notificación
        echo '<script>
    alert("El nombre o el correo ya existen en la base de datos. Por favor, elija otro.");
    window.location = "perfil-cliente.php";
    </script>';
    } else {
        // Actualizar la información del usuario en la base de datos
        $sql_update = $con->prepare("UPDATE usuarios SET usuario=?, correo=?, telefono=?, direccion=?, pass=? WHERE id=?");
        $sql_update->execute([$nombre, $correo, $telefono, $direccion, $pass, $id_cliente]);
        header("Location: ./perfil-cliente.php");
        exit();
    }
}
