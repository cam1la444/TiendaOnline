<?php
define("SITE_URL", "http://localhost:8081/tiendaOnline/");
define("CLIENTE_ID", "Aa4mmJEFZs7fq20i1o2OKmGTNGZIYUMDVUy-cwjNtHzsCqacqoOUsBN3jT2cdm0dIoj1QKPEL1ufvE74");
//define("CLIENTE_SECRET", "EJ7xGaiuZHXwc8-JiJ8JMxKiUFGad0r_jUczUy0n73_lfzdayemPwg9DcAhXnaux1qOJOMTDe6LzZd5-");
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