<?php
include 'php/conexion.php';
require 'php/config.php';

$id = $_SESSION['id'];
$db = new DataBase();
$con = $db->conectar();
$sql = $con->prepare("SELECT * FROM usuarios WHERE id=?");
$sql->execute([$id]);
$row = $sql->fetch(PDO::FETCH_ASSOC);
$id_cliente = $_SESSION['id'];

$producto = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if ($producto != null) {
    foreach ($producto as $clave => $cantidad) {
        $sql = $con->prepare("SELECT *, $cantidad AS cantidad FROM productos WHERE id=?");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $total = $_SESSION['total'];

    $sql = $con->prepare("INSERT INTO pedidos (id_usuario, id_producto, cantidad, total, telefono, direccion) VALUES (?, ?, ?, ?, ?, ?)");

    $con->beginTransaction();

    try {
        foreach ($lista_carrito as $producto) {
            $id_producto = $producto['id'];
            $cantidad = $producto['cantidad'];
            $sql->execute([$id_cliente, $id_producto, $cantidad, $total, $telefono, $direccion]);
        }
        $con->commit();

        unset($_SESSION['carrito']);

        exit;
    } catch (PDOException $e) {
        $con->rollback();
        echo "Error al insertar los datos en la base de datos: " . $e->getMessage();
    }
}
