<?php
define("SITE_URL", "http://localhost:8081/tiendaOnline/");
define("CLIENTE_ID", "AXUJPlFDYKUgda8epgQAKYRHD0UT4EqLl0zXQidVEugPHlYdfVM7Da4jW7xefX-OH-irw5ulCp2fLlBT");
define("CURRENCY", "USD");
define("KEY_TOKEN", "ABC.cnco-2015*");
define("MONEDA", "$");

define("MAIL_HOST", "smtp.gmail.com");
define("MAIL_USER", "jennycho531@gmail.com" );
define("MAIL_PASS", "ubzeqzikjmlrrkdz" );
define("MAIL_PORT", 587);

session_start();
$num_cart=0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>