<?php
session_start();

if (isset($_SESSION['id'])) {
    include 'php/conexion.php';
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM usuarios WHERE id='$id'";
    $consulta = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($consulta);
    if ($row) {
        if ($row['usuario'] != "admin") {
            header("location: client/inicio.php");
        } else {
            header("location: admin/admin.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sabor Cercano</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="icon" type="image/icon" href="img/coffee.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php
    include 'php/conexion.php';
    $db = new DataBase();
    $con = $db->conectar();
    $sql = $con->prepare("SELECT * FROM datos;");
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    if ($data) {
    ?>
        <div class="fondo" style="
    background: url(img/<?php echo $data['fondo1'] ?>) no-repeat;
    background-size: cover;
    background-position: center;"></div>
        <div class="container" style="
    background: url(img/<?php echo $data['fondo2'] ?>) no-repeat;
    background-size: cover;
    background-position: center;">
            <div class="contenido">
                <h2 class="logo"><?php echo $data['nombre'] ?></h2>
                <div class="texto">
                    <h2><?php echo $data['leyenda'] ?></h2>
                    <p><?php echo $data['texto'] ?></p>
                    <div class="social">
                        <a href="#"><i class='bx bxl-facebook-circle'></i></a>
                        <a href="https://www.instagram.com/edwin2lopez/" target="_blank"><i class='bx bxl-instagram-alt'></i></a>
                        <a href="#"><i class='bx bxl-tiktok'></i></a>
                    </div>
                </div>
            </div>

            <div class="login">
                <div class="formulario iniciar">
                    <form action="php/login.php" method="post">
                        <h2>Iniciar sesión</h2>
                        <div class="input-box">
                            <span class="icon"><i class='bx bxs-envelope'></i></span>
                            <input type="email" name="correo" required>
                            <label>correo electrónico</label>
                        </div>
                        <div class="input-box">
                            <span class="icon"><i class='bx bxs-key'></i></span>
                            <input type="password" name="pass" required>
                            <label>contraseña</label>
                        </div>

                        <div class="olvido">
                            <a href="https://www.youtube.com/shorts/6Y-fXu_bqvY">¿Olvidaste tus datos?</a>
                        </div>

                        <button type="submit" class="btn">Ingresar</button>

                        <div class="registrar">
                            <p>¿No tienes cuenta? <a href="#" class="registrar-enlace">Regístrate</a></p>
                        </div>
                    </form>
                </div>

                <div class="formulario registrar">
                    <form action="php/register.php" method="post">
                        <h2>Registrarse</h2>
                        <div class="input-box">
                            <span class="icon"><i class='bx bxs-user'></i></span>
                            <input type="text" required name="usuario">
                            <label>nombre de usuario</label>
                        </div>
                        <div class="input-box">
                            <span class="icon"><i class='bx bxs-envelope'></i></span>
                            <input type="email" required name="correo">
                            <label>correo electrónico</label>
                        </div>
                        <div class="input-box">
                            <span class="icon"><i class='bx bxs-key'></i></span>
                            <input type="password" required name="pass">
                            <label>contraseña</label>
                        </div>

                        <div class="olvido">
                            <label>
                                <input type="checkbox" required> Acepta los <a href="https://www.youtube.com/watch?v=mCdA4bJAGGk&ab_channel=sweetblue.">términos y condiciones</a>
                            </label>
                        </div>

                        <button type="submit" class="btn">Registrar</button>

                        <div class="registrar">
                            <p>¿Ya tienes una cuenta? <a href="#" class="iniciar-enlace">Iniciar sesión</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="js/funcion.js"></script>
    <?php  } ?>
</body>

</html>