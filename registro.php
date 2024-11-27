<?php
require 'config/config.php';
require 'config/database.php';
require 'clases/clientesFunciones.php';
$db = new Database();
$con = $db->conectar();

$errors = [];

if(!empty($_POST)){
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $dui = trim($_POST['dui']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if(esNulo([$nombres, $apellidos, $email, $telefono, $dui, $usuario, $password, $repassword])){
        $errors[] = "Debe de llenar todos los campos";
    }

    if(!esEmail($email)){
        $errors[] = "La dirección de correo no es válida";
    }

    if(!validaPassword($password, $repassword)){
        $errors[] = "Las contraseñas no coinciden";
    }

    if(usuarioExiste($usuario, $con)){
        $errors[] = "El nombre de usuario $usuario ya existe";
    }

    if(emailExiste($email, $con)){
        $errors[] = "El correo electronico $email ya existe";
    }

    if(telExiste($telefono, $con)){
        $errors[] = "El número de teléfono $telefono ya existe";
    }

    if(duiExiste($dui, $con)){
        $errors[] = "El número de DUI $dui ya existe";
    }

    if(count($errors) == 0){
        $id= registraCliente([$nombres, $apellidos, $email, $telefono, $dui], $con);
        
        if($id >0){

            require 'clases/Mailer.php';
            $mailer = new Mailer();
            $token = generarToken();
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);

            $idUsuario = registraUsuario([$usuario, $pass_hash, $token, $id], $con);
            if($idUsuario >0){
                $url = SITE_URL . 'activa_cliente.php?id='. $id .'&token='. $token;
                $asunto = "Activar cuenta - Tienda en Linea";
                $cuerpo = "Estimado $nombres: <br>Para continuar con el proceso de registro es indespensable dar click en el siguiente link <a href='$url'>Activar cuenta</a>"; 

                if($mailer->enviarEmail($email, $asunto, $cuerpo)){
                    echo "Para terminar el proceso de registro siga las indicaciones que se le ha enviado al correo electronico $email";
                    exit;
                }
            } else{
                $errors[] = "Error al registrar usuario";
            }
    } else{
        $errors[] = "Error al registrar cliente";
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda En Linea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/estilo.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" type="x-icon" href="Logo2.png">
</head>
<body>
<?php include 'menu.php'; ?>

<main>
    <!--codigo para autogenerar la imagen, informacion y detalles de los productos por el FOREACH sin repertir codigo-->
    <div class="container">
        <h2>Datos del cliente</h2>
        <?php mostrarMensajes($errors); ?>

        <form class="row g-3" actions="registro.php" method="post" autocomplete="off">
            <div class="col-md-6">
                <label for="nombres"><span class="text-danger">*</span> Nombres</label>
                <input type="text" name="nombres" id="nombres" class="form-control" value="<?php echo isset($_POST['nombres']) ? htmlspecialchars($_POST['nombres']) : ''; ?>">
            </div>

            <div class="col-md-6">
                <label for="apellidos"><span class="text-danger">*</span> Apellidos</label>
                <input type="text" name="apellidos" id="apellidos" class="form-control" value="<?php echo isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : ''; ?>">
            </div>

            <div class="col-md-6">
                <label for="email"><span class="text-danger">*</span> Correo Electronico</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <span id="validaEmail" class="text-danger"></span>
                <span id="validarEmail" class="text-danger"></span>
            </div>

            <div class="col-md-6">
                <label for="telefono"><span class="text-danger">*</span> Teléfono</label>
                <input type="tel" name="telefono" id="telefono" class="form-control" value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>" placeholder="00000000">
                <span id="validaTel" class="text-danger"></span>
            </div>

            <div class="col-md-6">
                <label for="dui"><span class="text-danger">*</span> DUI</label>
                <input type="text" name="dui" id="dui" class="form-control" value="<?php echo isset($_POST['dui']) ? htmlspecialchars($_POST['dui']) : ''; ?>" placeholder="000000000">
                <span id="validaDUI" class="text-danger"></span>
            </div>

            <div class="col-md-6">
                <label for="usuario"><span class="text-danger">*</span> Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
                <span id="validaUsuario" class="text-danger"></span>
            </div>

            <div class="col-md-6">
                <label for="password"><span class="text-danger">*</span> Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" requireda>
                <span id="validaPassword" class="text-danger"></span>
            </div>

            <div class="col-md-6">
                <label for="repassword"><span class="text-danger">*</span> Verificar contraseña</label>
                <input type="password" name="repassword" id="repassword" class="form-control" requireda>
            </div>

            <i><b>Nota: </b> Todos los campos son obligatorios</i>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>

        </form>
    
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script>
    let txtUsuario = document.getElementById('usuario')
    txtUsuario.addEventListener("blur", function(){
        existeUsuario(txtUsuario.value)
    },false)

    let txtEmail = document.getElementById('email')
    txtEmail.addEventListener("blur", function(){
        existeEmail(txtEmail.value)
    },false)

    let EmailText = document.getElementById('email')
    EmailText.addEventListener("blur", function(){
        verificarEmail(txtEmail.value)
    }, false)

    let txtTel = document.getElementById('telefono')
    txtTel.addEventListener("blur", function(){
        verificarTel(txtTel.value)
    }, false)

    let txtDui = document.getElementById('dui');
    txtDui.addEventListener("blur", function () {
        verificarDui(txtDui.value);
    }, false);

    let txtPassword =document.getElementById('password');
    txtPassword.addEventListener("blur", function(){
        verificarPassword(txtPassword.value)
    }, false)

    function verificarPassword(password) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        // Verifica que la contraseña cumpla con todas las condiciones
        if (!regex.test(password)) {
            document.getElementById('validaPassword').innerHTML = 'La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una minúscula, un número y un carácter especial.';
        } else {
            document.getElementById('validaPassword').innerHTML = ''; // Borra cualquier mensaje previo si es válida
        }
    }

    function verificarEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        // Verifica el formato del correo electrónico
        if (!regex.test(email)) {
            document.getElementById('validarEmail').innerHTML = 'El formato del correo electrónico no es válido';
        } else {
            document.getElementById('validarEmail').innerHTML = ''; // Borra cualquier mensaje previo si es válido
        }
    }

    function verificarDui(dui) {
        const regex = /^[0-9]{9}$/;

        // Verifica el formato del DUI
        if (!regex.test(dui)) {
            document.getElementById('validaDUI').innerHTML = 'El formato del número de DUI debe ser 000000000';
            return; // Sale de la función si el formato no es válido
        } else {
            document.getElementById('validaDUI').innerHTML = ''; // Borra cualquier mensaje previo
        }

        // Realiza la solicitud AJAX si el formato es válido
        let url = "clases/clienteAjax.php";
        let formData = new FormData();
        formData.append("dui", dui);

        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
            .then(data => {
                if (data.ok) {
                    document.getElementById('dui').value = ''; // Limpia el campo si ya está registrado
                    document.getElementById('validaDUI').innerHTML = 'El número de DUI ya está registrado.';
                } else {
                    document.getElementById('validaDUI').innerHTML = ''; // Limpia el mensaje si no está registrado
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                document.getElementById('validaDUI').innerHTML = 'Error al verificar el número de DUI.';
            });
    }

    function verificarTel(telefono){

        const regex = /^[0-9]{8}$/;

        if (!regex.test(telefono)) {
            document.getElementById('validaTel').innerHTML = 'El formato del número de teléfono debe ser 00000000';
            return; // Salir de la función si el formato no es válido
            }

        let url= "clases/clienteAjax.php"
        let formData = new FormData();
        formData.append("telefono", telefono)

        fetch(url, {
            method: 'POST',
            body:formData
        }).then(response=> response.json())
        .then(data =>{
            if (data.ok) {
            document.getElementById('telefono').value = '';
            document.getElementById('validaTel').innerHTML = 'El número de teléfono ya está registrado.';
        } else {
            document.getElementById('validaTel').innerHTML = '';
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
        document.getElementById('validaTel').innerHTML = 'Error al verificar el número de teléfono.';
    });
    }

    function existeEmail(email){
        let url = "clases/clienteAjax.php"
        let formData = new FormData();
        formData.append("action", "exiteEmail");
        formData.append("email", email)

        fetch(url,{
            method: 'POST',
            body: formData
        }).then(response=> response.json())
        .then(data => {
            if(data.ok){
                document.getElementById('email').value = ''
                document.getElementById('validaEmail').innerHTML = 'Email no disponinle'
            } else{
                document.getElementById('validaEmail').innerHTML = ''
            }
        })
    }

    function existeUsuario(usuario){
        let url = "clases/clienteAjax.php"
        let formData = new FormData();
        formData.append("action", "existeUsuario");
        formData.append("usuario", usuario)

        fetch(url,{
            method: 'POST',
            body: formData
        }).then(response=> response.json())
        .then(data => {
            if(data.ok){
                document.getElementById('usuario').value = ''
                document.getElementById('validaUsuario').innerHTML = 'Usuario no disponinle'
            } else{
                document.getElementById('validaUsuario').innerHTML = ''
            }
        })
    }
</script>
</body>
<?php include 'footer.php'; ?>
</html> 