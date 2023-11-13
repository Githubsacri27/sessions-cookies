<?php
// Inicio de la sesión
session_start();
// para mostrar mensajes de error
$mensaje = '';
// Si el usuario no está autenticado, redirigir a la página de inicio de sesión
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header('Location: index.php');
    exit();
}

// Validar solicitud POST

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['grabar'])) { // Si se ha pulsado el botón de grabar
        // Guardar los datos del formulario en la sesión
        $telefono = ($_POST['telefono']); // Recupero los datos del formulario
        $email = ($_POST['email']);
        //notifico que los datos se han grabado en sesión
        $mensaje = 'Datos grabados en sesión';

        if (!empty($telefono) && !empty($email)) {
            $_SESSION['telefono'] = $telefono;
            $_SESSION['email'] = $email;
        }
    }
    // Si se ha pulsado el botón de borrar
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrar'])) {
        // Borrar los datos de la sesión
        session_destroy();
        //notifico que los datos se han borrado de sesión 
        $_SESSION['mensaje_borrado'] = 'Datos de la sesión borrados';
        // Redirigir a la página de inicio de sesión con el mensaje
        header('Location: index.php?mensaje_borrado=' . urlencode('Datos de la sesión borrados'));
    }
    // Si se ha pulsado el botón de borrar cookie
    if (isset($_POST['borrarcookie'])) {
        session_unset();
        // Establece la cookie a un valor vacío y una fecha de expiración en el pasado
        setcookie('horario', '', time() - 3600, '/');
    }
}
// Recuperar los datos de la sesión
$telefono = isset($_SESSION['telefono']) ? $_SESSION['telefono'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

$horario = ''; // Variable para almacenar el horario seleccionado
// Si existe la cookie con el nombre horario
if (isset($_COOKIE['horario'])) {
    // Asigno el valor de la cookie 
    $horario = $_COOKIE['horario'];
}
// Si se ha pulsado el botón de grabar horario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['grabar_horario'])) {
    // Guardar el horario seleccionado en la cookie
    $horario_seleccionado = filter_var($_POST['horario']);
    //modifico la cookie con el nuevo valor y la guardo durante una hora (3600 segundos)
    setcookie('horario', $horario_seleccionado, time() + 3600, '/');
    $horario = $horario_seleccionado;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/sesion.css">
    <title>Sesión</title>
</head>

<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form method="POST">
                <label for="chk" aria-hidden="true">Sesión</label>
                <input type="text" name="telefono" placeholder="Teléfono" value="<?php echo isset($telefono) ? $telefono : ''; ?>" required>
                <input type="email" name="email" placeholder="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
                <button name="grabar" value="Grabar">Grabar</button>
                <button name="borrar" value="Borrar">Borrar</button>
            </form>
            <?php
            if (!empty($mensaje)) {
                echo '<p>' . $mensaje . '</p>';
            }
            ?>
        </div>

        <div class="horario">
            <form method="POST">
                <label for="chk" aria-hidden="true">Horario</label>
                <label class="selectTime" for="horario">Seleccionar Horario:</label>
                <select name="horario">
                    <option value="Mañana" <?php if ($horario === 'Mañana') echo 'selected'; ?>>Mañana</option>
                    <option value="Tarde" <?php if ($horario === 'Tarde') echo 'selected'; ?>>Tarde</option>
                    <option value="Noche" <?php if ($horario === 'Noche') echo 'selected'; ?>>Noche</option>
                </select>
                <button name="grabar_horario" value="Grabar horario">Grabar horario</button>
                <button name="borrarcookie" value="Borrar">Borrar</button>
            </form>
            </section>
        </div>
</body>

</html>