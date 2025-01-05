<?php 
    require_once './config/database.php';
    require_once './models/Alojamiento.php';

    class AlojamientoController{
        public $alojamiento;
        public $db;

        public function __construct()
        {
            $database = new Database();
            $this->db = $database->getConnection();
            $this->alojamiento = new Alojamiento($this->db);
        }

        public function read(){
            // Logica para Leer productos
            $sentence = $this->alojamiento->read();
            $alojamientos = $sentence->fetchAll(PDO::FETCH_ASSOC);
            include './views/home.php';
        }

        public function create(){
            //Logica para crear productos
            if($_SERVER['REQUEST_METHOD'] == "POST" ){
                //print_r($_POST);
                $this->alojamiento->name = $_POST['nombre'];
                $this->alojamiento->description = $_POST['descripcion'];
                $this->alojamiento->location = $_POST['ubicacion'];
                $this->alojamiento->image_url = $_POST['image_url'];

                //print_r($this->alojamiento);
                $this->alojamiento->create();
            }
                include './views/create.php';
        }

        public function update($id){
                //Logica para actualizar alojamiento
                //echo $id;
                if($_SERVER['REQUEST_METHOD'] == "POST" ){
                    //print_r($_POST);
                    $this->alojamiento->name = $_POST['nombre'];
                    $this->alojamiento->description = $_POST['descripcion'];
                    $this->alojamiento->location = $_POST['ubicacion'];
                    $this->alojamiento->image_url = $_POST['image_url'];
                    $this->alojamiento->id = $id;
    
                    //print_r($this->alojamiento);
                    $this->alojamiento->update();
                }

                $sentence = $this->alojamiento->findOne($id);
                $alojamiento = $sentence->fetch(PDO::FETCH_ASSOC);
                include './views/edit.php';

        }

        public function delete($id){
            $this->alojamiento->delete($id);
            header('Location: /');
        }

    }

?>