<?php 

class Database{
    private $hostname = "localhost";
    private $database = "tiendaonline";
    private $username = "root";
    private $password = "";
    private $charset = "utf8";

    function conectar (){
        try{
    //cadena de conexion
            $conexion = "mysql:host=" . $this->hostname . "; dbname=" . $this->database . "; charset=" . $this->charset;

            //PDO define un interfaz ligera para poder acceder a bases de datos en PHP .
            $options = [
                PDO:: ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION,
                PDO:: ATTR_EMULATE_PREPARES => false
            ];
            $pdo = new PDO ($conexion, $this->username, $this->password, $options);
            return $pdo;
        } catch(PDOException $e){
            echo 'Error conexion: ' . $e->getMessage();
            exit;
        }
    }
}
?>