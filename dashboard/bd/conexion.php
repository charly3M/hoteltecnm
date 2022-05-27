<?php 
class Conexion{	  
    public static function Conectar() {        
        define('servidor', 'blqeu6jvwlfnjbhvg3px-mysql.services.clever-cloud.com');
        define('nombre_bd', 'blqeu6jvwlfnjbhvg3px');
        define('usuario', 'ud5lqcpg2hcvlwn7');
        define('password', 'PEb7yL61tnlFAb8VnbHz');					        
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');			
        try{
            $conexion = new PDO("mysql:host=".servidor."; dbname=".nombre_bd, usuario, password, $opciones);			
            return $conexion;
        }catch (Exception $e){
            die("El error de Conexión es: ". $e->getMessage());
        }
    }
}