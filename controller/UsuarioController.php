<?php
require_once './config/database.php';
require_once './models/Usuario.php';

class UsuarioController {
    public $usuario;
    public $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    // Registro de usuario
    public function register() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Si el usuario ya está logueado, redirigirlo a la cuenta
        if (isset($_SESSION['usuario_id'])) {
            header('Location: /alojamientos_mvc/views/usuario/cuenta.php');
            exit();
        }
    
        // Continuar con el registro si no está logueado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->usuario->nombre = $_POST['nombre'];
            $this->usuario->email = $_POST['email'];
            $this->usuario->contraseña = $_POST['contraseña'];  // Almacenamos la contraseña tal cual, sin cifrar
            $this->usuario->tipo = 'usuario'; // Por defecto, es un usuario normal
    
            $this->usuario->create();
            header('Location: ./views/usuario/login.php');
            exit();
        }
        
        include './views/usuario/registrar.php';
    }    

    // Iniciar sesión
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si el usuario ya está logueado, redirigirlo a la cuenta
        if (isset($_SESSION['usuario_id'])) {
            header('Location: /alojamientos_mvc/views/usuario/cuenta.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $contraseña = trim($_POST['contraseña']);
            // Validar los campos del formulario
            if (empty($_POST['email']) || empty($_POST['contraseña'])) {
                $error = 'Por favor, complete todos los campos.';
            } else {
                $sentence = $this->usuario->findByEmail($email);
                $usuario = $sentence->fetch(PDO::FETCH_ASSOC);
                if ($usuario) {
                    if (password_verify($contraseña, $usuario['contraseña'])) {
                        $_SESSION['usuario_id'] = $usuario['id'];
                        $_SESSION['usuario_nombre'] = $usuario['nombre'];
                        $_SESSION['usuario_email'] = $usuario['email'];
                        $_SESSION['usuario_tipo'] = $usuario['tipo'];
    
                        header('Location: /alojamientos_mvc/views/usuario/cuenta.php');
                        exit();
                    } else {
                        $error = 'Contraseña incorrecta.';
                    }
                } else {
                    $error = 'Usuario no encontrado.';
                }
            }
        }

        include './views/usuario/login.php';
    }

    public function cuenta() {
        
        // Verificar si el usuario está logueado
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /alojamientos_mvc/views/usuario/login.php');
            exit();
        }
    
        // Obtener los datos del usuario desde la base de datos
        $sentence = $this->usuario->findOne($_SESSION['usuario_id']);
    
        // Incluir la vista de cuenta y pasar los datos del usuario
        include './views/usuario/cuenta.php';
    }
    

    // Cerrar sesión
    public function logout() {
        session_start();
        session_destroy();
        header('Location: /alojamientos_mvc/views/usuario/login.php');
        exit();
    }
}
?>