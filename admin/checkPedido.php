<?php
include '../php/conexion.php';
$id = $_GET['Id'];

if (isset($id)) {
    $db = new DataBase();
    $con = $db->conectar();
    $stmt = $con->prepare("UPDATE `saborcercano`.`pedidos` SET `estado` = '1' WHERE (`id` = '$id');");
    $stmt->execute();
}
header('location:admin_pedidos.php');
