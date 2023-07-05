<?php
include 'php/conexion.php';
require 'php/config.php';

session_start();

if (!isset($_SESSION['id'])) {
    echo '<script>
            alert("Por favor inicie sesión");
            window.location = "index.php";
        </script>';
    session_destroy();
    die();
} else {
    $id = $_SESSION['id'];
    $db = new DataBase();
    $con = $db->conectar();
    $sql = $con->prepare("SELECT * FROM usuarios WHERE id=?");
    $sql->execute([$id]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $id_cliente = $row['id'];
}
//session_destroy();

$db = new DataBase();
$con = $db->conectar();

$producto = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

//print_r($_SESSION);

$lista_carrito = array();

if ($producto != null) {
    foreach ($producto as $clave => $cantidad) {
        $sql = $con->prepare("SELECT *, $cantidad AS cantidad FROM productos WHERE id=?");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("Location: inicio.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos_cliente.css">
    <link rel="stylesheet" href="estilos_carrito.css">
    <title>Terminar pago</title>
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <a href="inicio.php">Catálogo</a>
            <a href="checkout.php">Carrito <span id="num_cart"><?php echo $num_cart; ?></span></a>
            <a href="perfil-cliente.php">Perfil</a>
            <a href="php/cerrar_sesion.php" class="cs">Cerrar sesión</a>
            <audio loop id="miAudio" src="music/spider.mp3" type="audio/mpeg"></audio>
            <div class="audio-controls">
                <button id="playButton" class="play-button"></button>
            </div>
        </nav>
    </header>
    <main>
        <form action="insertar_compra.php" method="post">
            <div class="contenedor">
                <div class="row">
                    <div class="map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63821.72752710952!2d-78.69535478165557!3d-1.2571425592900651!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d381a37fef551f%3A0x7a2dbc24d832161b!2sAmbato!5e0!3m2!1ses-419!2sec!4v1688335422248!5m2!1ses-419!2sec" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="paga">
                        <div class="table_res">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($lista_carrito == null) {
                                        echo '<tr><td colspan="5" class="text-center"><b>Lista Vacia</b></td></tr>';
                                    } else {
                                        $total = 0;
                                        foreach ($lista_carrito as $producto) {
                                            $_id = $producto['id'];
                                            $nombre = $producto['name'];
                                            $precio = $producto['price'];
                                            $cantidad = $producto['cantidad'];
                                            $subtotal = $cantidad * $precio;
                                            //$total += $subtotal;
                                    ?>
                                            <tr>
                                                <td><?php echo $nombre; ?></td>
                                                <td>
                                                    <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?></div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="1"></td>
                                            <td>
                                                <p id="total">Total: <?php echo MONEDA . number_format($_SESSION['total'], 2, '.', ','); ?></p>
                                            </td>
                                        </tr>
                                </tbody>
                            <?php } ?>
                            </table>
                            <div class="formulario">
                                <p class="text">Teléfono:</p>
                                <input type="text" id="telefono" value="<?php echo $row['telefono'] ?>" required name="telefono">
                                <br><br>
                                <p class="text">Dirección:</p>
                                <input type="text" id="direccion" value="<?php echo $row['direccion'] ?>" required name="direccion">
                            </div>
                        </div>
                        <?php if ($lista_carrito != null) { ?>
                            <div class="pago">
                                <button type="submit" class="btn_pago">Completar compra</button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <script src="funcion-audio.js"></script>
</body>

</html>