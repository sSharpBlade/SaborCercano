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
//print_r($_SESSION);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos_cliente.css">
    <link rel="stylesheet" href="css/estilos_perfil.css">
    <title>Perfil</title>
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
        <div class="formulario">
            <form action="actualizar_cliente.php" method="post">
                <p class="text">Usuario:</p>
                <input type="text" id="nombre" value="<?php echo $row['usuario']; ?>" name="nombre" required placeholder="Ingrese un nombre de usuario">
                <br><br>
                <p class="text">Correo:</p>
                <input type="email" name="correo" value="<?php echo $row['correo']; ?>" required placeholder="Ingrese un correo electrónico">
                <br><br>
                <p class="text">Contraseña:</p>
                <div class="contra">
                    <button class="pass-btn" type="button" id="toggleButton" onclick="togglePasswordVisibility()">Mostrar</button>
                    <input type="password" id="passwordInput" value="<?php echo $row['pass']; ?>" required placeholder="Ingrese una contraseña">
                </div>
                <br>
                <p class="text">Teléfono:</p>
                <input type="text" name="telefono" value="<?php echo $row['telefono']; ?>" placeholder="Ingrese un número de teléfono">
                <br><br>
                <p class="text">Dirección:</p>
                <input type="text" name="direccion" value="<?php echo $row['direccion']; ?>" placeholder="Ingrese una dirección">
                <br><br>
                <hr>
                <br>
                <button class="uCliente" type="submit">Guardar cambios</button>
            </form>
        </div>
    </main>
    <script src="js/funcion-audio.js"></script>
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