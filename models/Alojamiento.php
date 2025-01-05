<?php
    class Alojamiento {
        public $id;
        public $name;
        public $description;
        public $location;
        public $image_url;
        private $connection;
        private $table_name = "alojamientos";

        public function __construct($db) {
            $this->connection = $db;
        }

        // Métodos para CRUD: Create,Read,Update,Delete

        public function create(){
            //Logica para crear un nuevo alojamiento
            $query = "INSERT INTO {$this->table_name} (nombre,descripcion,ubicacion,image_url) VALUES (?,?,?,?)";
            $sentence = $this->connection->prepare($query);

            $sentence->execute([$this->name,$this->description,$this->location,$this->image_url]);

            return $sentence;
        }

        public function read(){
            //Logica para leer los alojamientos
            $query = "SELECT * FROM {$this->table_name}";
            $sentence = $this->connection->prepare($query);
            $sentence->execute();
            return $sentence;
        }

        public function update(){
            //Logica para actualizar un alojamiento
            //$query = "UPDATE {$this->table_name} SET $campo=$valor WHERE id = {$this->id} ";
        
            $query = "UPDATE {$this->table_name} SET nombre = ? , descripcion= ? , ubicacion= ? , image_url= ? WHERE id = {$this->id}";

            $sentence = $this->connection->prepare($query);

            $sentence->execute([$this->name,$this->description,$this->location,$this->image_url]);

            return $sentence;
        }

        public function findOne($id){
            //Logica para buscar un alojamiento
            $query = "SELECT * FROM {$this->table_name} WHERE id = $id";
            $sentence = $this->connection->prepare($query);
            $sentence->execute();
            return $sentence;

        }

        public function delete($id){
            $query = "DELETE FROM {$this->table_name} WHERE id = $id";
            $sentence = $this->connection->prepare($query);
            return $sentence->execute();
            
        }
    }
?>
