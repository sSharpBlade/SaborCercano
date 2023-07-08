<?php
include '../php/conexion.php';

if (isset($_POST['submit'])) {
    $db = new DataBase();
    $con = $db->conectar();

    $Name = $_POST['Name'];
    $Price = $_POST['Price'];

    $sql_check = $con->prepare("SELECT COUNT(*) AS count FROM productos WHERE name=?");
    $sql_check->execute([$Name]);
    $result_check = $sql_check->fetch(PDO::FETCH_ASSOC);

    if ($result_check['count'] > 0) {
        echo '<script>
    alert("El nombre ya existe en la base de datos. Por favor, elija otro.");
    window.location = "admin.php";
    </script>';
    } else {
        $image = $_FILES['img']['name'];
        $tempname = $_FILES['img']['tmp_name'];
        $folder = "../img/productos/" . $image;

        if (move_uploaded_file($tempname, $folder)) {
            echo 'La imagen se ha subido correctamente';
        }

        $requete = $con->prepare("INSERT INTO productos(img, name, price) VALUES('$image','$Name','$Price')");
        $requete->execute();
        header('location:admin.php');
    }
}

