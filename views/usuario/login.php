<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si ya está logueado, redirigir a la cuenta
if (isset($_SESSION['usuario_id'])) {
    header('Location: /alojamientos_mvc/views/usuario/cuenta.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Iniciar Sesión</title>
</head>

<body>
    <h1>Inicio de Sesión</h1>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <form action="./index.php?action=login" method="POST">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br><br>
        <button type="submit">Iniciar Sesión</button>
    </form>

    <br>
    <p>¿Aún no tienes cuenta?</p>
    <button type="submit"><a href="/alojamientos_mvc/views/usuario/index.php?action=register">Registrarse</a></button>

</body>

</html>