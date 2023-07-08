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
    <title>Pedidos</title>
</head>


<body class="bg-content">
    <nav>
        <a href="admin.php" style="color: white;">Productos</a>
        <a href="admin_descuentos.php" style="color: white;">Descuentos</a>
        <a href="admin_pedidos.php" style="color: white;">Pedidos</a>
        <a href="admin_perfil.php" style="color: white;">Perfil</a>
        <a href="../php/cerrar_sesion.php" style="color: white;">Cerrar sesión</a>
        <div class="animation start-give"></div>
    </nav>
    <main class="dashboard">
        <div class="table-responsive">
            <table class="table student_list table-borderless">
                <thead>
                    <tr class="align-middle">
                        <th class="opacity-0">vide</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th class="opacity-0">list</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../php/conexion.php';
                    $db = new DataBase();
                    $con = $db->conectar();
                    $result = $con->query("SELECT pedidos.id AS pedido_id, pedidos.id_cliente, pedidos.total, pedidos.telefono, pedidos.direccion, detalle_pedido.id_producto, detalle_pedido.cantidad FROM pedidos JOIN detalle_pedido ON pedidos.id = detalle_pedido.id_pedido WHERE pedidos.estado = 0");

                    $current_pedido_id = null;
                    $current_cliente_id = null;
                    $current_total = null;
                    $current_telefono = null;
                    $current_direccion = null;

                    foreach ($result as $row) :
                        $pedido_id = $row['pedido_id'];
                        $cliente_id = $row['id_cliente'];
                        $producto = $row['id_producto'];
                        $cantidad = $row['cantidad'];
                        $total = $row['total'];
                        $telefono = $row['telefono'];
                        $direccion = $row['direccion'];

                        if ($current_pedido_id === null || $current_pedido_id !== $pedido_id) {
                            // Mostrar la fila del pedido solo una vez
                            $current_pedido_id = $pedido_id;
                            $current_cliente_id = $cliente_id;
                            $current_total = $total;
                            $current_telefono = $telefono;
                            $current_direccion = $direccion;
                    ?>
                            <tr class="bg-white align-middle">
                                <td></td>
                                <td><?php echo obtenerNombreCliente($current_cliente_id); ?></td>
                                <td><?php echo obtenerNombreProducto($producto); ?></td>
                                <td><?php echo $cantidad; ?></td>
                                <td><?php echo $current_total; ?></td>
                                <td><?php echo $current_telefono; ?></td>
                                <td><?php echo $current_direccion; ?></td>
                                <td class="d-md-flex gap-3 mt-3">
                                    <a href="checkPedido.php?Id=<?php echo $current_pedido_id; ?>"><i class="far fa-check"></i></a>
                                </td>
                            </tr>
                        <?php
                        } else {
                            // Mostrar las filas adicionales del mismo pedido
                        ?>
                            <tr class="bg-white align-middle">
                                <td></td>
                                <td></td>
                                <td><?php echo obtenerNombreProducto($producto); ?></td>
                                <td><?php echo $cantidad; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                    <?php
                        }
                    endforeach;

                    // Función para obtener el nombre del cliente según su ID
                    // Función para obtener el nombre del cliente según su ID
                    function obtenerNombreCliente($cliente_id)
                    {
                        $db = new DataBase();
                        $con = $db->conectar();
                        $sql = $con->prepare("SELECT usuario FROM usuarios WHERE id = ?");
                        $sql->execute([$cliente_id]);
                        $row = $sql->fetch(PDO::FETCH_ASSOC);

                        if ($row) {
                            return $row['usuario'];
                        } else {
                            return "Cliente desconocido"; // Si el ID no coincide con ningún cliente existente
                        }
                    }


                    // Función para obtener el nombre del producto según su ID
                    // Función para obtener el nombre del producto según su ID
                    function obtenerNombreProducto($producto_id)
                    {
                        $db = new DataBase();
                        $con = $db->conectar();
                        $sql = $con->prepare("SELECT name FROM productos WHERE id = ?");
                        $sql->execute([$producto_id]);
                        $row = $sql->fetch(PDO::FETCH_ASSOC);

                        if ($row) {
                            return $row['name'];
                        } else {
                            return "Producto desconocido"; // Si el ID no coincide con ningún producto existente
                        }
                    }

                    ?>
                </tbody>
            </table>

        </div>
        </div>
    </main>
</body>

</html>