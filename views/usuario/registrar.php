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
    <title>Registrar Usuario</title>
</head>

<body>
    <h1>Registro de Usuario</h1>
    <form action="./index.php?action=register" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required><br><br>

        <button type="submit">Registrar</button>

        <br>
        <p>¿Ya tienes cuenta?</p>
        <button type="submit"><a href="/alojamientos_mvc/views/usuario/index.php?action=login">Iniciar Sesion</a></button>

    </form>
</body>

</html>