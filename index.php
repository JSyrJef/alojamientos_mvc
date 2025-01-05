<?php 
require_once './controller/AlojamientoController.php';
require_once './controller/UsuarioController.php';
require_once './config/database.php';
$database = new Database();
$pdo = $database->getConnection();

session_start();
// Instancias de los controladores
$alojamientoController = new AlojamientoController();
$usuarioController = new UsuarioController();

// Esto podría ir al inicio de tu controlador, antes de cargar la vista
if (isset($_GET['action']) == 'select' && isset($_GET['id'])) {
    $alojamiento_id = $_GET['id'];
    
    // Verifica que la sesión del usuario esté iniciada
    if (isset($_SESSION['usuario_id'])) {
        $usuario_id = $_SESSION['usuario_id'];  // Toma el usuario_id desde la sesión

        // Insertar en la tabla usuarios_alojamientos
        $query = "INSERT INTO usuarios_alojamientos (usuario_id, alojamiento_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$usuario_id, $alojamiento_id]);
        echo "Redirigiendo a cuenta.php";
        header('Location: /alojamientos_mvc/views/usuario/cuenta.php');  // Redirigir a la cuenta para que vea su alojamiento seleccionado
        exit();
    } else {
        // Si no está logueado, redirigir al login
        header('Location: /alojamientos_mvc/views/usuario/login.php');
        exit();
    }
}

// Obtener acción y parámetros
$action = isset($_GET['action']) ? $_GET['action'] : 'login';
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Rutas del sistema
switch ($action) {
    // Rutas para Usuario
    case 'login':
        $usuarioController->login();
        break;
    case 'register':
        $usuarioController->register();
        break;
    case 'logout':
        $usuarioController->logout();
        break;
    case 'cuenta':
        $usuarioController->cuenta();
        break;

    // Rutas para Alojamiento
    case 'read':
        $alojamientoController->read();
        break;
    case 'create':
        $alojamientoController->create();
        break;
    case 'update':
        $alojamientoController->update($id);
        break;
    case 'delete':
        $alojamientoController->delete($id);
        break;

    // Acción por defecto si no se encuentra la ruta
    default:
        header('Location: /?action=login');
        exit();
}
?>