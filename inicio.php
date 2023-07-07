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

include 'php/conexion.php';
require 'php/config.php';
$db = new DataBase();
$con = $db->conectar();

$sql = $con->prepare("SELECT * FROM saborcercano.productos;");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

//print_r($_SESSION);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos_cliente.css">
    <link rel="stylesheet" href="estilos_productos.css">
    <title>Inicio</title>
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
                <!-- <div class="progress-bar">
                    <div class="progress"></div>
                </div> -->
            </div>
        </nav>
    </header>
    <main>
        <div class="favoritos">
            <?php
            $db = new DataBase();
            $con = $db->conectar();
            $id_cliente = $_SESSION['id'];
            $fav = $con->query("SELECT p.*, COUNT(dp.id_producto) AS total_compras
            FROM detalle_pedido dp
            JOIN pedidos pe ON dp.id_pedido = pe.id
            JOIN productos p ON dp.id_producto = p.id
            WHERE pe.id_cliente = $id_cliente
            GROUP BY dp.id_producto, p.id, p.name
            ORDER BY total_compras DESC
            LIMIT 3;
            ");
            if ($fav->rowCount() !== 0) {
            ?>
                <h2>Más comprados</h2>
            <?php
            }

            foreach ($fav as $value) { ?>
                <div class="card">
                    <?php
                    $id = $value['id'];
                    $img = "img/productos/$id.jpg";
                    if (!file_exists($img)) {
                        $img = "img/cafe.jpg";
                    }
                    ?>
                    <div class="imgBx" style="
                        background: url(img/productos/<?php echo $value['img'] ?>); 
                        background-size: cover;
                        background-position: center;
                        background-repeat: no-repeat;">
                    </div>
                    <div class="content">
                        <span class="price">
                            <button type="button" class="a" onclick="addProducto(<?php echo $value['id']; ?>, '<?php echo hash_hmac('sha1', $value['id'], KEY_TOKEN); ?>')">$<?php echo $value['price'] ?></button>
                        </span>
                        <h4><?php echo $value['name'] ?></h4>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!--<?php if ($result) { ?> <h2 class="current">Productos actuales</h2> <?php } ?> -->

        <div class="contCards">
            <?php foreach ($result as $row) { ?>
                <div class="card">
                    <?php
                    $id = $row['id'];
                    $img = "img/productos/$id.jpg";
                    if (!file_exists($img)) {
                        $img = "img/cafe.jpg";
                    }
                    ?>
                    <div class="imgBx" style="
                    background: url(img/productos/<?php echo $row['img'] ?>); 
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;">
                    </div>
                    <div class="content">
                        <span class="price">
                            <button type="button" class="a" onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">$<?php echo $row['price'] ?></button>
                        </span>
                        <h4><?php echo $row['name'] ?></h4>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
    <script src="js/funcion-audio.js"></script>

    <script>
        function addProducto(id, token) {
            let url = 'carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let elemento = document.getElementById("num_cart")
                        elemento.innerHTML = data.numero
                    }
                })
        }
    </script>
</body>

</html>