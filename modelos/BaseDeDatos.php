<?php
    class BaseDeDatos {
        static $host = "localhost";
        static $user = "root";
        static $password = "";
        static $db = "proyecto_juegos";
        static $conexion;

        public static function conectar(){
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db;
            try {
                self::$conexion = new PDO($dsn, self::$user, self::$password);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return self::$conexion;    
            } catch (PDOException $e) {
                echo "<p>Error en la conexion</p>";
                echo "<p>ERROR: " . $e->getMessage() . "</p>"; 
            }
        }
    }
?>