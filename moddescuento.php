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
    <title>Document</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/estilos_admin.css">
</head>

<body>
<nav>
        <a href="admin.php" style="color: white;">Productos</a>
        <a href="admin_descuentos.php" style="color: white;">Descuentos</a>
        <a href="admin_pedidos.php" style="color: white;">Pedidos</a>
        <a href="admin_perfil.php" style="color: white;">Perfil</a>
        <a href="php/cerrar_sesion.php" style="color: white;">Cerrar sesión</a>
        <div class="animation start-sale"></div>
    </nav>
    <?php
    include 'php/conexion.php';
    $_SESSION['descuento'] = $_GET['Id'];
    $id = $_SESSION['descuento'];
    $db = new DataBase();
    $con = $db->conectar();
    $statement = $con->prepare("SELECT * FROM descuentos WHERE id = $id");
    $statement->execute();
    $table = $statement->fetch();

    ?>
    <div class="container w-50">
        <form method="POST" action="updescuento.php" enctype="multipart/form-data">
            <div class="">
                <label for="recipient-name" class="col-form-label">Código:</label>
                <input type="text" class="form-control" id="recipient-name" name="Codigo" value="<?php echo $table['codigo'] ?>">
            </div>
            <div class="">
                <label for="recipient-name" class="col-form-label">Porcentaje:</label>
                <input type="text" class="form-control" id="recipient-name" name="Porcentaje" value="<?php echo $table['porcentaje'] ?>">
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-primary">Actualizar descuento</button>
            </div>
        </form>
    </div>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>