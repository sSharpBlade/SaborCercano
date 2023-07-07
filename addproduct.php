<?php
include 'php/conexion.php';


if (isset($_POST['submit'])) {
    $db = new DataBase();
    $con = $db->conectar();
    $image = $_FILES['img']['name'];
    $tempname = $_FILES['img']['tmp_name'];
    $folder = "img/productos/" . $image;

    if (move_uploaded_file($tempname, $folder)) {
        echo 'images est uplade';
    }

    $Name = $_POST['Name'];
    $Price = $_POST['Price'];

    $requete = $con->prepare("INSERT INTO productos(img,name,price) VALUES('$image','$Name','$Price')");
    //$requete->execute(array($image,$Name,$Email,$Phone,$EnrollNumber,$DateOfAdmission));
    $requete->execute();
}
header('location:admin.php');
