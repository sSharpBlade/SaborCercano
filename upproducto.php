<?php
session_start();
$id = $_SESSION['producto'];
include 'php/conexion.php';
if (isset($_POST['submit'])) {
    $db = new DataBase();
    $con = $db->conectar();
    $Name = $_POST['Name'];
    $Price = $_POST['Price'];

    if ($_FILES['img']['name']) {
        $imgName = $_FILES['img']['name'];
        $imgTmp = $_FILES['img']['tmp_name'];

        // Obtener la extensión de la imagen
        $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

        // Validar la extensión de la imagen
        $allowedExtensions = array('jpg', 'jpeg', 'png');
        if (in_array($imgExt, $allowedExtensions)) {
            // Ruta de destino para guardar la imagen
            $imgDestination = "img/productos/" . $imgName;

            // Mover la imagen al destino
            if (!file_exists($imgDestination)) {
                move_uploaded_file($imgTmp, $imgDestination);
            }

            // Actualizar el campo 'img' en la base de datos
            $requete = $con->prepare("UPDATE productos 
                SET 
                name = :Name,
                price = :Price,
                img = :Img
                WHERE id = :id");
            $requete->bindParam(':Img', $imgName);
            $requete->bindParam(':Name', $Name);
            $requete->bindParam(':Price', $Price);
            $requete->bindParam(':id', $id);
            $res = $requete->execute();
        } else {
            echo '<script>
                alert("Extensión de archivo no válida. Por favor, elija una imagen válida.");
                window.location = "admin.php";
            </script>';
            die();
        }
    } else {
        // No se seleccionó una nueva imagen, actualizar solo los campos 'name' y 'price'
        $requete = $con->prepare("UPDATE productos 
            SET 
            name = :Name,
            price = :Price
            WHERE id = :id");
        $requete->bindParam(':Name', $Name);
        $requete->bindParam(':Price', $Price);
        $requete->bindParam(':id', $id);
        $res = $requete->execute();
    }

    header("location:admin.php");
}
