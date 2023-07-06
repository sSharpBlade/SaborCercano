<?php
session_start();
$id = $_SESSION['descuento'];
include 'php/conexion.php';
if (isset($_POST['submit'])) {
    $db = new DataBase();
    $con = $db->conectar();
    $Codigo = $_POST['Codigo'];
    $Porcentaje = $_POST['Porcentaje'];
    $requete = $con->prepare("UPDATE descuentos 
    SET 
    codigo = :Codigo,
    porcentaje = :Porcentaje
    WHERE id = :id");
    $requete->bindParam(':Codigo', $Codigo);
    $requete->bindParam(':Porcentaje', $Porcentaje);
    $requete->bindParam(':id', $id);
    $res = $requete->execute();
    header("location:admin_descuentos.php");
}
