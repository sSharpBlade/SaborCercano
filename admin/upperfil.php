<?php
include '../php/conexion.php';
if (isset($_POST['submit'])) {
    $db = new DataBase();
    $con = $db->conectar();
    $Name = $_POST['Nombre'];
    $Leyenda = $_POST['Leyenda'];
    $Texto = $_POST['Texto'];
    $Descuento = $_POST['Descuento'];

    if ($_FILES['img1']['name']) {
        $imgName1 = $_FILES['img1']['name'];
        $imgTmp1 = $_FILES['img1']['tmp_name'];

        // Obtener la extensión de la imagen
        $imgExt1 = strtolower(pathinfo($imgName1, PATHINFO_EXTENSION));

        // Validar la extensión de la imagen
        $allowedExtensions = array('jpg', 'jpeg', 'png');
        if (in_array($imgExt1, $allowedExtensions)) {
            // Ruta de destino para guardar la imagen
            $imgDestination1 = "../img/" . $imgName1;

            // Mover la imagen al destino
            if (!file_exists($imgDestination1)) {
                move_uploaded_file($imgTmp1, $imgDestination1);
            }

            // Actualizar el campo 'fondo1' en la base de datos
            $requete1 = $con->prepare("UPDATE datos 
                SET 
                fondo1 = :Img1
                ");
            $requete1->bindParam(':Img1', $imgName1);
            $res1 = $requete1->execute();
        } else {
            echo '<script>
                alert("Extensión de archivo no válida. Por favor, elija una imagen válida.");
                window.location = "admin_perfil.php";
            </script>';
            die();
        }
    }

    if ($_FILES['img2']['name']) {
        $imgName2 = $_FILES['img2']['name'];
        $imgTmp2 = $_FILES['img2']['tmp_name'];

        // Obtener la extensión de la imagen
        $imgExt2 = strtolower(pathinfo($imgName2, PATHINFO_EXTENSION));

        // Validar la extensión de la imagen
        $allowedExtensions = array('jpg', 'jpeg', 'png');
        if (in_array($imgExt2, $allowedExtensions)) {
            // Ruta de destino para guardar la imagen
            $imgDestination2 = "../img/" . $imgName2;

            // Mover la imagen al destino
            if (!file_exists($imgDestination2)) {
                move_uploaded_file($imgTmp2, $imgDestination2);
            }

            // Actualizar el campo 'fondo2' en la base de datos
            $requete2 = $con->prepare("UPDATE datos 
                SET 
                fondo2 = :Img2
                ");
            $requete2->bindParam(':Img2', $imgName2);
            $res2 = $requete2->execute();
        } else {
            echo '<script>
                alert("Extensión de archivo no válida. Por favor, elija una imagen válida.");
                window.location = "admin_perfil.php";
            </script>';
            die();
        }
    }
    $requete3 = $con->prepare("UPDATE datos 
            SET 
            nombre = :Nombre,
                leyenda = :Leyenda,
                texto = :Texto,
                descuento = :Descuento
            ");
    $requete3->bindParam(':Nombre', $Name);
    $requete3->bindParam(':Leyenda', $Leyenda);
    $requete3->bindParam(':Texto', $Texto);
    $requete3->bindParam(':Descuento', $Descuento);
    $res3 = $requete3->execute();
}
header("location: admin_perfil.php");
