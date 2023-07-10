<?php

include '../php/conexion.php';
require '../php/config.php';

session_start();

if (!isset($_SESSION['id'])) {
    echo '<script>
            alert("Por favor inicie sesión");
            window.location = "../index.php";
        </script>';
    session_destroy();
    die();
} else {
    $id = $_SESSION['id'];
    $db = new DataBase();
    $con = $db->conectar();
    $sql = $con->prepare("SELECT * FROM usuarios WHERE id=?");
    $sql->execute([$id]);
    $row1 = $sql->fetch(PDO::FETCH_ASSOC);
    $id_cliente = $row1['id'];
}
//session_destroy();
//print_r($_SESSION);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos_cliente.css">
    <link rel="stylesheet" href="../css/estilos_perfil.css">
    <link rel="stylesheet" href="../css/estilos_carrito.css">
    <title>Historial</title>
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <a href="inicio.php">Catálogo</a>
            <a href="checkout.php">Carrito <span id="num_cart"><?php echo $num_cart; ?></span></a>
            <a href="perfil-cliente.php">Perfil</a>
            <a href="historial.php">Historial</a>
            <a href="../php/cerrar_sesion.php" class="cs">Cerrar sesión</a>
            <audio loop id="miAudio" src="../music/spider.mp3" type="audio/mpeg"></audio>
            <div class="audio-controls">
                <button id="playButton" class="play-button"></button>
            </div>
        </nav>
    </header>
    <main>
        <div class="contenedor">
            <div class="table_res">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $db = new DataBase();
                        $con = $db->conectar();
                        $result = $con->query("SELECT pedidos.id AS pedido_id, pedidos.total, pedidos.telefono, pedidos.direccion, pedidos.fecha, detalle_pedido.id_producto, detalle_pedido.cantidad 
                        FROM pedidos JOIN detalle_pedido ON pedidos.id = detalle_pedido.id_pedido WHERE pedidos.id_cliente = $id_cliente");

                        $current_pedido_id = null;
                        $current_total = null;
                        $current_telefono = null;
                        $current_direccion = null;
                        $current_fecha = null;

                        foreach ($result as $row) :
                            $pedido_id = $row['pedido_id'];
                            $producto = $row['id_producto'];
                            $cantidad = $row['cantidad'];
                            $total = $row['total'];
                            $telefono = $row['telefono'];
                            $direccion = $row['direccion'];
                            $fecha = $row['fecha'];

                            if ($current_pedido_id === null || $current_pedido_id !== $pedido_id) {
                                // Mostrar la fila del pedido solo una vez
                                $current_pedido_id = $pedido_id;
                                $current_total = $total;
                                $current_telefono = $telefono;
                                $current_direccion = $direccion;
                                $current_fecha = $fecha;
                        ?>
                                <tr>
                                    <td><?php echo obtenerNombreProducto($producto); ?></td>
                                    <td><?php echo $cantidad; ?></td>
                                    <td><?php echo $current_total; ?></td>
                                    <td><?php echo $current_telefono; ?></td>
                                    <td><?php echo $current_direccion; ?></td>
                                    <td><?php echo $current_fecha; ?></td>
                                </tr>
                            <?php
                            } else {
                            ?>
                                <tr>
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
    <script src="../js/funcion-audio.js"></script>
</body>

</html>