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

$sql = $con->prepare("SELECT * FROM saborcercano.productos;");
$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

print_r($_SESSION);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos_cliente.css">
    <link rel="stylesheet" href="estilos_productos.css">
    <title>Cliente</title>
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
                    <div class="imgBx" style="background: url(<?php echo $img ?>);">
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
    <script src="funcion-audio.js"></script>

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
                        let elemento = document.getElementById("numCart")
                        elemento.innerHTML = data.numero
                    }
                })
        }
    </script>
</body>

</html>