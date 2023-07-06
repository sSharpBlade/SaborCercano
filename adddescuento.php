<?php
include 'php/conexion.php';


if (isset($_POST['submit'])) {
    $db = new DataBase();
    $con = $db->conectar();

    $Codigo = $_POST['Codigo'];
    $Porcentaje = $_POST['Porcentaje'];

    $requete = $con->prepare("INSERT INTO descuentos(codigo,porcentaje) VALUES('$Codigo','$Porcentaje')");
    //$requete->execute(array($image,$Name,$Email,$Phone,$EnrollNumber,$DateOfAdmission));
    $requete->execute();
}
header('location:admin_descuentos.php');
