<?php
include '../php/conexion.php';
require '../php/config.php';

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
        $sql = $con->prepare("SELECT *, :cantidad AS cantidad FROM productos WHERE id=:id_producto");
        $sql->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $sql->bindParam(':id_producto', $clave, PDO::PARAM_INT);
        $sql->execute();
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $total = $_SESSION['total'];

    $sql = $con->prepare("INSERT INTO pedidos (id_cliente, total, telefono, direccion, fecha) VALUES (?, ?, ?, ?, NOW())");

    $con->beginTransaction();

    try {
        $sql->execute([$id_cliente, $total, $telefono, $direccion]);
        $pedido_id = $con->lastInsertId(); // Obtiene el ID del pedido insertado

        $detalle_sql = $con->prepare("INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad) VALUES (?, ?, ?)");

        foreach ($lista_carrito as $producto) {
            $id_producto = $producto['id'];
            $cantidad = $producto['cantidad'];
            $detalle_sql->execute([$pedido_id, $id_producto, $cantidad]);
        }
        $con->commit();
        unset($_SESSION['carrito']);

    } catch (PDOException $e) {
        $con->rollback();
        echo "Error al insertar los datos en la base de datos: " . $e->getMessage();
    }
}
header("Location: inicio.php");
exit;
