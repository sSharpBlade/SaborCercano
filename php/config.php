<?php
define("KEY_TOKEN", "UTAfiseiSW3");
define("MONEDA", "$");

error_reporting(E_ALL & ~E_NOTICE);

session_start();

$num_cart = 0;
if (isset($_SESSION['carrito']['productos'])) {
    $num_cart = count($_SESSION['carrito']['productos']);
}
