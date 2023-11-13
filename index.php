<?php
// Inicio de la sesión
session_start();

// Variable para almacenar mensajes de error
$mensaje = '';

// Si el usuario ya está autenticado, redirigir a la página de sesión
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    header('Location: sesion.php');
    exit();
}

// Si el método de la solicitud es POST, procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Datos de inicio de sesión del usuario
        $usuario = 'foc';
        // Contraseña encriptada
        $contrasena_hash = password_hash('Fdwes!22', PASSWORD_DEFAULT);

        // Recoger los datos del formulario
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Comprobar si los datos del formulario coinciden con los datos de inicio de sesión
        if ($username === $usuario && password_verify($password, $contrasena_hash)) {
            // Iniciar la sesión y redirigir a la página de sesión
            $_SESSION['autenticado'] = true;
            header('Location: sesion.php');
            exit();
        } else {
            // Si los datos no coinciden, mostrar un mensaje de error
            $mensaje = 'Credenciales incorrectas';
        }
    } catch (Exception $e) {
        // Si ocurre un error, mostrar un mensaje de error
        $mensaje = 'Error en la autenticación: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login</title>
</head>

<body>
    <section class="formsection">
        <div class="signup">
            <form method="post">
                <h2>Login</h2>
                <input type="text" name="username" placeholder="Username" required="required">
                <input type="password" name="password" placeholder="Password" required="required">
                <button>Login</button>
            </form>
            <?php
            if (!empty($mensaje)) {
                echo '<p>' . $mensaje . '</p>';
            }
            if (isset($_GET['mensaje_borrado'])) {
                $mensaje_borrado = urldecode($_GET['mensaje_borrado']);
                echo '<p>' . $mensaje_borrado . '</p>';
            }
            
            ?>
        </div>
    </section>
</body>

</html>
