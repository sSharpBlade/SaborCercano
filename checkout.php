<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '<script>
            alert("Por favor inicie sesión");
            window.location = "index.php";
        </script>';
    session_destroy();
    die();
}
//session_destroy();

include 'php/conexion.php';
require 'php/config.php';
$db = new DataBase();
$con = $db->conectar();

$producto = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

print_r($_SESSION);

$lista_carrito = array();

if ($producto != null) {
    foreach ($producto as $clave => $cantidad) {
        $sql = $con->prepare("SELECT *, $cantidad AS cantidad FROM productos WHERE id=?");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
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
    <title>Carrito</title>
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <a href="inicio.php">Catálogo</a>
            <a href="checkout.php">Carrito <span id="num_cart"><?php echo $num_cart; ?></span></a>
            <a href="#">Perfil</a>
            <a href="php/cerrar_sesion.php">Cerrar sesión</a>
            <audio loop id="miAudio" src="music/Metro Boomin - Calling (Spider-Man_ Across the Spider-Verse).mp3" type="audio/mpeg"></audio>
            <div class="audio-controls">
                <button id="playButton" class="play-button"></button>
                <div class="progress-bar">
                    <div class="progress"></div>
                </div>
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
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
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
                                $total += $subtotal;
                        ?>
                                <tr>
                                    <td><?php echo $nombre; ?></td>
                                    <td><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></td>
                                    <td>
                                        <input type="number" min="1" max="20" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                                    </td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?></div>
                                    </td>
                                    <td><a id="eliminar" class="btn" btn-bs-id="<?php echo $_id; ?>" data-bs-toogle="modal" data-bs-target="eliminaModal" onclick="eliminar(<?php echo $_id; ?>)">Eliminar</a></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    <p id="total">Total: <?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                                </td>
                            </tr>
                    </tbody>
                <?php } ?>
                </table>
            </div>
            <?php if ($lista_carrito != null) { ?>
                <div class="pago">
                    <button type="button" class="btn_pago">Completar compra</button>
                </div>
            <?php } ?>
        </div>
    </main>
    <script src="funcion-audio.js"></script>
    <script>
        function actualizaCantidad(cantidad, id) {
            let url = 'actualizar_carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('cantidad', cantidad)
            formData.append('action', 'agregar')

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let divSubtotal = document.getElementById('subtotal_' + id)
                        divSubtotal.innerHTML = data.sub

                        let total = 0.00
                        let list = document.getElementsByName('subtotal[]')
                        for (let i = 0; i < list.length; i++) {
                            total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
                        }
                        total = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2
                        }).format(total)
                        document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total
                    }
                })
        }

        let eliminarModal = document.getElementById('eliminar')

        function eliminar(id) {
            let url = 'actualizar_carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('action', 'eliminar')

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    location.reload()
                })
        }
    </script>
</body>

</html>