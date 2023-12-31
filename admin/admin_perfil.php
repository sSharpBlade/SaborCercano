<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo '<script>
            alert("Por favor inicie sesión");
            window.location = "../index.php";
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
    <link rel="stylesheet" href="../css/estilos_admin.css">
    <title>Perfil</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
    <nav>
        <a href="admin.php" style="color: white;">Productos</a>
        <a href="admin_descuentos.php" style="color: white;">Descuentos</a>
        <a href="admin_pedidos.php" style="color: white;">Pedidos</a>
        <a href="admin_perfil.php" style="color: white;">Perfil</a>
        <a href="admin_historial.php" style="color: white;">Historial</a>
        <a href="../php/cerrar_sesion.php" style="color: white;">Cerrar sesión</a>
        <div class="animation start-perfil" style="color: white;"></div>
    </nav>
    <?php
    include '../php/conexion.php';
    $db = new DataBase();
    $con = $db->conectar();
    $statement = $con->prepare("SELECT * FROM datos");
    $statement->execute();
    $table = $statement->fetch();

    ?>
    <div class="container w-50">
        <form method="POST" action="upperfil.php" enctype="multipart/form-data">
            <div class="">
                <label for="recipient-name" class="col-form-label">Fondo 1:</label>
                <input type="file" class="form-control" id="recipient-name" accept=".jpg,.png,.jpeg" name="img1">
            </div>
            <div class="">
                <label for="recipient-name" class="col-form-label">Fondo 2:</label>
                <input type="file" class="form-control" id="recipient-name" accept=".jpg,.png,.jpeg" name="img2">
            </div>
            <div class="">
                <label for="recipient-name" class="col-form-label">Nombre:</label>
                <input type="text" class="form-control" id="recipient-name" name="Nombre" value="<?php echo $table['nombre'] ?>">
            </div>
            <div class="">
                <label for="recipient-name" class="col-form-label">Leyenda:</label>
                <input type="text" class="form-control" id="recipient-name" name="Leyenda" value="<?php echo $table['leyenda'] ?>">
            </div>
            <div class="">
                <label for="recipient-name" class="col-form-label">Texto:</label>
                <input type="text" class="form-control" id="recipient-name" name="Texto" value="<?php echo $table['texto'] ?>">
            </div>
            <div class="">
                <label for="recipient-name" class="col-form-label">Precio mínimo:</label>
                <input type="text" class="form-control" id="recipient-name" name="Descuento" value="<?php echo $table['descuento'] ?>">
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-primary">Actualizar perfil</button>
            </div>
        </form>
    </div>
    <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>