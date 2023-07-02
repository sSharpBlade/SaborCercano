<?php
session_start();

include 'php/conexion.php';
require 'php/config.php';

if (!isset($_SESSION['usuario'])) {
    echo '<script>
            alert("Por favor inicie sesión");
            window.location = "index.php";
        </script>';
    session_destroy();
    die();
} else {
    $name = $_SESSION['usuario'];
    $db = new DataBase();
    $con = $db->conectar();
    $sql = $con->prepare("SELECT * FROM usuarios WHERE usuario=?");
    $sql->execute([$name]);
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
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos_cliente.css">
    <link rel="stylesheet" href="estilos_perfil.css">
    <title>Perfil</title>
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <a href="inicio.php">Catálogo</a>
            <a href="checkout.php">Carrito <span id="num_cart"><?php echo $num_cart; ?></span></a>
            <a href="perfil-cliente.php">Perfil</a>
            <a href="php/cerrar_sesion.php">Cerrar sesión</a>
            <audio loop id="miAudio" src="music/spider.mp3" type="audio/mpeg"></audio>
            <div class="audio-controls">
                <button id="playButton" class="play-button"></button>
            </div>
        </nav>
    </header>
    <main>
        <div class="formulario">
            <p class="text">Usuario:</p>
            <input type="text" id="usuario" value="<?php echo $row['usuario'] ?>">
            <br><br>
            <p class="text">Correo:</p>
            <input type="mail" id="correo" value="<?php echo $row['correo'] ?>">
            <br><br>
            <p class="text">Contraseña:</p>
            <button type="button" id="toggleButton" onclick="togglePasswordVisibility()">Mostrar</button>
            <input type="password" id="passwordInput">
            <br><br>
            <hr>
        </div>
    </main>
    <script src="funcion-audio.js"></script>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("passwordInput");
            var toggleButton = document.getElementById("toggleButton");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.textContent = "Ocultar";
            } else {
                passwordInput.type = "password";
                toggleButton.textContent = "Mostrar";
            }
        }
    </script>
</body>

</html>