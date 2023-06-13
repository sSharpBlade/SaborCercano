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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos_cliente.css">
    <title>Cliente</title>
</head>
<body onclick = "PlayAudio">
    <header class="header">
        <nav class="navbar">
            <a href="#">Catálogo</a>
            <a href="#">Carrito</a>
            <a href="#">Perfil</a>
            <a href="php/cerrar_sesion.php">Cerrar sesión</a>
        </nav>
    </header>
    
    <audio controls id="musica1" src="music/Metro Boomin - Calling (Spider-Man_ Across the Spider-Verse).mp3" type="audio/mp3 "></audio>

    <script>
        function PlayAudio(){
            document.getElementById("musica1").play();
        }
    </script>

    <br>
    
    

    <?php
        include 'php/conexion.php';
        $name = $_SESSION['usuario'];
        $sql = "SELECT * FROM usuarios WHERE usuario='$name'";
        $consulta = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_assoc($consulta);
        if ($row) {
            echo "Usuario: " . $row['usuario'] . "<br>";
            echo "Correo: " . $row['correo'] . "<br>";
        } else {
            echo "No se encontraron resultados.";
        }
    ?>
    
</body>
</html>