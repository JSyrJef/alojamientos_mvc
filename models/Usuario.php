<?php
class Usuario {
    public $id;
    public $nombre;
    public $email;
    public $contraseña;
    public $tipo;
    private $connection;
    private $table_name = "usuarios";

    public function __construct($db) {
        $this->connection = $db;
    }

    // Registrar nuevo usuario (cifra la contraseña antes de guardarla)
    public function create() {
        $query = "INSERT INTO {$this->table_name} (nombre, email, contraseña, tipo) VALUES (?, ?, ?, ?)";
        $sentence = $this->connection->prepare($query);

        // Cifra la contraseña antes de guardarla
        $hashed_password = password_hash($this->contraseña, PASSWORD_DEFAULT);

        return $sentence->execute([$this->nombre, $this->email, $hashed_password, $this->tipo ?? 'usuario']);
    }

    // Verificar inicio de sesión (compara la contraseña sin cifrar con la cifrada en la base de datos)
    public function login($email, $contraseña) {
        $query = "SELECT * FROM {$this->table_name} WHERE email = ?";
        $sentence = $this->connection->prepare($query);
        $sentence->execute([$email]);

        $usuario = $sentence->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            // Asigna valores al objeto actual
            $this->id = $usuario['id'];
            $this->nombre = $usuario['nombre'];
            $this->email = $usuario['email'];
            $this->tipo = $usuario['tipo'];

            return true; // Login exitoso
        }
        return false; // Credenciales inválidas
    }

    // Actualizar un usuario (cifra la nueva contraseña antes de actualizarla)
    public function update() {
        $query = "UPDATE {$this->table_name} SET nombre = ?, email = ?, contraseña = ?, tipo = ? WHERE id = ?";
        $sentence = $this->connection->prepare($query);

        // Cifra la nueva contraseña antes de actualizarla
        $hashed_password = password_hash($this->contraseña, PASSWORD_DEFAULT);

        return $sentence->execute([$this->nombre, $this->email, $hashed_password, $this->tipo, $this->id]);
    }

    // Buscar por email
    public function findByEmail($email) {
        $query = "SELECT * FROM {$this->table_name} WHERE email = ?";
        $sentence = $this->connection->prepare($query);
        $sentence->execute([$email]);
        return $sentence;
    }
   // Obtener un usuario por ID
    public function findOne($id) {
        $query = "SELECT * FROM {$this->table_name} WHERE id = ?";
        $sentence = $this->connection->prepare($query);
        $sentence->execute([$id]);
        return $sentence->fetch(PDO::FETCH_ASSOC);
    }
}
?>

