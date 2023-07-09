<?php
$codigo = $_POST['codigo_descuento'] ?? null;

if (empty($codigo)) {
    // Redirigir directamente a pago.php
    header("Location: pago.php");
    exit();
} else {

    // Conectarse a la base de datos
    include '../php/conexion.php';
    require '../php/config.php';
    $db = new DataBase();
    $con = $db->conectar();

    // Consultar la base de datos para validar el código de descuento
    $sql = $con->prepare("SELECT * FROM descuentos WHERE codigo = ?");
    $sql->execute([$codigo]);
    $descuento = $sql->fetch(PDO::FETCH_ASSOC);

    // Verificar si el código de descuento existe en la base de datos
    if ($descuento) {
        // Aplicar el descuento al total de la compra
        $porcentaje_descuento = $descuento['porcentaje'];
        $total = $_SESSION['total']; // Obtener el total de la compra de la sesión
        $descuento_aplicado = ($porcentaje_descuento / 100) * $total;
        $total_con_descuento = $total - $descuento_aplicado;
        // Guardar el descuento aplicado en la sesión
        $_SESSION['total'] = $total_con_descuento;
        // Redirigir de vuelta a la página del carrito
        echo '<script>
    alert("Código de descuento válido");
    window.location = "pago.php";
    </script>';
        //header('Location: pago.php');
        exit();
    } else {
        echo '<script>
    alert("Código de descuento no válido");
    window.location = "checkout.php";
    </script>';
    }
}
