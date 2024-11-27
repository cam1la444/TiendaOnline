<header>
    <div class="container" style="text-align: center;">
        <a href="index.html" class="logo">
            <img src="Logo.jpg" alt="Logo">
        </a>
        <h2 style="color: #ffffff; font-weight: bold;">Tienda en Línea MEVAS</h2>
    </div>

    <div class="menu-container">
        <nav>
            <div class="menu-icon" onclick="toggleMenu()">☰</div> <!-- Ícono de hamburguesa -->
            <ul id="menu-items">
                <li><a href="https://iglesiamevas.netlify.app/">Inicio</a></li>
                <li><a href="https://iglesiamevas.netlify.app/historia">Historia</a></li>
                <li><a href="https://iglesiamevas.netlify.app/vision">Visión y Misión</a></li>
                <li><a href="index.php">Tienda</a></li>
                <li><a href="https://calendarioiglesiamevas.netlify.app" target="_blank" rel="noopener noreferrer">Calendario</a></li>
                <li><a href="https://www.paypal.com/ncp/payment/RFUDKUC75TN52" target="_blank" rel="noopener noreferrer">Ofrendas</a></li>
               <!-- Espaciador para alinear los botones a la derecha -->
                <li style="margin-left: auto;">
                <a href="checkout.php" class="btn btn-primary me-2 btn-sm">Carrito <span id="num_cart" class="badge bg-secondary">
                <?php echo $num_cart; ?>
            </span></a>
                </li>
                <li>
                    <?php if(isset($_SESSION['user_id'])) { ?>
                        <div class="dropdown">
                            <button class="btn btn-warning btn-sm dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $_SESSION['user_name']; ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btn_session">
                                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                                <li><a class="dropdown-item" href="compras.php">Mis compras</a></li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <a href="login.php" class="btn btn-sm bg-warning">Ingresar</a>
                    <?php } ?>
                </li>
            </ul>
        </nav>
    </div>
    <section class="hero">
        <h3>Bienvenido a </h3>
        <h2>Iglesia Misión Evangelica Vóz de Alerta y Salvación</h2>
    </section>
    <script src="script.js"></script>
</header>
