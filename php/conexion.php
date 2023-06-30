<?php

$conexion = mysqli_connect("localhost", "root", "root", "saborcercano", "3306");
class DataBase
{
    private $hostname = "localhost";
    private $database = "saborcercano";
    private $username = "root";
    private $password = "root";
    private $charset = "utf8";

    function conectar()
    {
        try {
            $conexion = "mysql:host=" . $this->hostname . "; dbname=" . $this->database . "; charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            $pdo = new PDO($conexion, $this->username, $this->password, $options);
            return $pdo;
        } catch (PDOException $th) {
            echo 'Error ' . $th->getMessage();
            exit;
        }
    }
}
