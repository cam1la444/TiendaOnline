<?php
require 'config/config.php';
require 'config/database.php';
require 'clases/clientesFunciones.php';
$db = new Database();
$con = $db->conectar();

$proceso = isset($_GET['pago']) ? 'pago' : 'login';

$errors = [];

if(!empty($_POST)){
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $proceso = $_POST['proceso'] ?? 'login';

    if(esNulo([$usuario, $password])){
        $errors[] = "Debe de llenar todos los campos";
    }

    if(count($errors)==0){
        $errors[]= login($usuario, $password, $proceso, $con);
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda En Linea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" type="x-icon" href="Logo2.png">
    <style>
        :root {
            --primary-color: #07598C;
            --text-color: #fff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Centrar el logo en el contenedor */
        /* Asegúrate de que el contenedor sea cuadrado */
        .navbar-brand {
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center; /* Centra verticalmente */
            text-align: center; /* Centra el contenido de texto */
        }

        /* Ajuste del logo para que sea cuadrado y redondo */
        .navbar-brand img {
            width: 60px; /* Asegúrate de que ancho y altura sean iguales */
            height: 60px; /* Asegúrate de que ancho y altura sean iguales */
            border-radius: 50%; /* Hace la imagen redonda */
            object-fit: cover; /* Asegura que la imagen llene el contenedor sin distorsionarse */
        }


        .custom-container {
        max-width: 1200px; /* Puedes ajustar este valor según el ancho que desees */
        margin: 0 auto; /* Centra el contenedor */
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            transition: color 0.3s ease;
            text-decoration: none;
            color: #F2F2F2; /* Color claro para enlaces */
            padding: 5px 10px;
            transition: background-color 0.3s; 
        }

        .nav-link:hover {
            color: white !important;
            background-color: #F2CC0F; /* Color amarillo al pasar el mouse */
    border-radius: 5px;
        }

        .menu-icon {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
        }

        .menu-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #menu-items {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        #menu-items li {
            margin: 0 10px;
        }

        @media (max-width: 991px) {
            .menu-icon {
                display: block;
            }

            #menu-items {
                display: none;
                flex-direction: column;
                background-color: var(--primary-color);
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
                padding: 10px 0;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            #menu-items li {
                margin: 10px 0;
                text-align: center;
            }
        }
    </style>
</head>
<body>
<?php include 'menu.php'; ?>

<main class="form-login m-auto pt-4">
    <h2>Iniciar sesión</h2>
    <?php mostrarMensajes($errors); ?>

    <form class="row g-3" action="login.php" method="POST" autocomplete="off">

    <input type="hidden" name="proceso" value="<?php echo $proceso; ?>">
        <div class="form-floating">
            <input class="form-control" type="text" name="usuario" id="usuario" placeholder="Usuario" required>
            <label for="usuario">Usuario</label>
        </div>

        <div class="form-floating">
            <input class="form-control" type="password" name="password" id="password" placeholder="Contraseña" required>
            <label for="password">Contraseña</label>
        </div>

        <div class="col-12">
            <a href="recupera.php">¿Olvidaste tu contraseña?</a>
        </div>

        <div class="d-grid gap-3 col-12">
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </div>

        <hr>
        <div class="col-12">
            ¿No tienes cuenta? <a href="registro.php">Registrate aqui</a>
        </div>

    </form>    
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
<?php include 'footer.php'; ?>
</html> 