<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo '<script>
            alert("Por favor inicie sesión");
            window.location = "index.php";
        </script>';
    session_destroy();
    die();
}
//session_destroy();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos_admin.css">
    <title>Perfil</title>
</head>

<body>
    <nav>
        <a href="admin.php">Productos</a>
        <a href="admin_descuentos.php">Descuentos</a>
        <a href="admin_pedidos.php">Pedidos</a>
        <a href="admin_perfil.php">Perfil</a>
        <a href="php/cerrar_sesion.php">Cerrar sesión</a>
        <div class="animation start-perfil"></div>
    </nav>
</body>

</html>