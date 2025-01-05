<?php
require_once '../../config/database.php';
$database = new Database();
$pdo = $database->getConnection();


session_start();

// Verificar si el usuario ya está logueado, si no redirigir a login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /alojamientos_mvc/views/usuario/login.php');
    exit();
}

// Consultar si el usuario tiene alojamientos seleccionados
$usuario_id = $_SESSION['usuario_id'];

// Consulta con INNER JOIN para obtener los alojamientos del usuario
$query = "
    SELECT a.id, a.nombre
    FROM alojamientos a
    INNER JOIN usuarios_alojamientos ua ON a.id = ua.alojamiento_id
    WHERE ua.usuario_id = ?
";

$stmt = $pdo->prepare($query);
$stmt->execute([$usuario_id]);

$alojamientos_seleccionados = $stmt->fetchAll(); // Obtener todos los resultados

$query_usuario = "SELECT * FROM usuarios WHERE id = ?";
$stmt_usuario = $pdo->prepare($query_usuario);
$stmt_usuario->execute([$usuario_id]);
$datos_usuario = $stmt_usuario->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mi Cuenta</title>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h1>
    <p>Correo: <?php echo htmlspecialchars($_SESSION['usuario_email']); ?></p>
    <p>Tipo de usuario: <?php echo htmlspecialchars($_SESSION['usuario_tipo']); ?></p>

    <h2>Alojamientos Seleccionados</h2>
    <?php if (!empty($alojamientos_seleccionados)): ?>
        <ul>
            <?php foreach ($alojamientos_seleccionados as $alojamiento): ?>
                <li>
                    <?php echo htmlspecialchars($alojamiento['nombre']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tienes alojamientos seleccionados. <a href="/alojamientos_mvc/views/home.php">Seleccionar Alojamientos</a></p>
    <?php endif; ?>
    <p>quieres agregar otro alojamiento? <a href="/alojamientos_mvc/views/home.php">Seleccionar Alojamientos</a></p>

    <a href="/alojamientos_mvc/views/usuario/index.php?action=logout">Cerrar Sesión</a>
</body>
</html>