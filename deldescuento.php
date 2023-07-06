<?php
include 'php/conexion.php';
$id = $_GET['Id'];

if (isset($id)) {
    $db = new DataBase();
    $con = $db->conectar();
    $stmt = $con->prepare("DELETE FROM descuentos WHERE id=$id");
    $stmt->execute();
}
header('location:admin_descuentos.php');
