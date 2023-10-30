<?php

    session_start();
    
    class Conectar{
        
        protected $dbh;
        
        protected function Conexion(){
            
            try{
                $conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=proyectoint2", "root", ""); //Conexion Tipica
                //$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=proyectoint2", "sebastian", "Sebastian1");  //Conexion Javier
                return $conectar;
            } catch (Exception $e){
                print "Error DB!: " . $e->getMessage()."<br/>";
                die();
            }
            
        }
        
        public function set_names(){
            return $this->dbh->query("SET NAMES 'utf8'");
        }
        
        /* TODO: Ruta o Link del proyecto */
        public static function ruta(){
            return "http://localhost/ProyectoIntegrador2/";
	}
        
    }


?>