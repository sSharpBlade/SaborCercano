<?php
session_start();
$id = $_SESSION['producto'];
include 'php/conexion.php';
if (isset($_POST['submit'])) {
    $db = new DataBase();
    $con = $db->conectar();
    $Name = $_POST['Name'];
    $Price = $_POST['Price'];
    $requete = $con->prepare("UPDATE productos 
    SET 
    name = :Name,
    price = :Price
    WHERE id = :id");
    $requete->bindParam(':Name', $Name);
    $requete->bindParam(':Price', $Price);
    $requete->bindParam(':id', $id);
    $res = $requete->execute();
    header("location:admin.php");
}
