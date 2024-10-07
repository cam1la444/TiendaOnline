<?php
define("CLIENTE_ID", "AXUJPlFDYKUgda8epgQAKYRHD0UT4EqLl0zXQidVEugPHlYdfVM7Da4jW7xefX-OH-irw5ulCp2fLlBT");
define("CURRENCY", "USD");
define("KEY_TOKEN", "ABC.cnco-2015*");
define("MONEDA", "$");

session_start();
$num_cart=0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>