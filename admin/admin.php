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
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <title>Productos</title>
</head>


<body class="bg-content">
    <nav>
        <a href="admin.php" style="color: white;">Productos</a>
        <a href="admin_descuentos.php" style="color: white;">Descuentos</a>
        <a href="admin_pedidos.php" style="color: white;">Pedidos</a>
        <a href="admin_perfil.php" style="color: white;">Perfil</a>
        <a href="admin_historial.php" style="color: white;">Historial</a>
        <a href="../php/cerrar_sesion.php" style="color: white;">Cerrar sesión</a>
        <div class="animation start-product"></div>
    </nav>
    <main class="dashboard">
        <!-- start student list table -->
        <div class="student-list-header d-flex justify-content-between align-items-center py-2">
            <div class="btn-add d-flex gap-3 align-items-center">
                <?php include '../component/popupadd.php'; ?>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table student_list table-borderless">
                <thead>
                    <tr class="align-middle">
                        <th class="opacity-0">vide</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th class="opacity-0">list</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../php/conexion.php';
                    $db = new DataBase();
                    $con = $db->conectar();
                    $result = $con->query("SELECT * FROM productos");
                    foreach ($result as $row) :
                    ?>
                        <tr class="bg-white align-middle">
                            <td>
                                <?php
                                $img = $row['img'];
                                if ($img == null) {
                                    $img = "default.png";
                                } ?>
                                <img src="../img/productos/<?php echo $img ?>" alt="img" height="50" with="50">
                            </td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['price'] ?></td>
                            <td class="d-md-flex gap-3 mt-3">
                                <a href="modproduct.php?Id=<?php echo $row['id'] ?>"><i class="far fa-pen"></i></a>
                                <a href="delproducto.php?Id=<?php echo $row['id'] ?>"><i class="far fa-trash"></i></a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </div>
    </main>
    <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>