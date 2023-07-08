<?php
session_start();
$id = $_SESSION['descuento'];
include 'php/conexion.php';

if (isset($_POST['submit'])) {
    $db = new DataBase();
    $con = $db->conectar();

    $Codigo = $_POST['Codigo'];
    $Porcentaje = $_POST['Porcentaje'];

    // Verificar si el código ya existe en la base de datos, excluyendo el descuento actual
    $sql_check = $con->prepare("SELECT COUNT(*) AS count FROM descuentos WHERE codigo=? AND id <> ?");
    $sql_check->execute([$Codigo, $id]);
    $result_check = $sql_check->fetch(PDO::FETCH_ASSOC);

    if ($result_check['count'] > 0) {
        // El código ya existe en la base de datos, mostrar una notificación
        echo '<script>
    alert("El código ya existe en la base de datos. Por favor, elija otro.");
    window.location = "admin_descuentos.php";
    </script>';
    } else {
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
}
