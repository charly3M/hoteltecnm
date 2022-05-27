<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
// Recepción de los datos enviados mediante POST desde el JS   


$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';

$domicilio = (isset($_POST['domicilio'])) ? $_POST['domicilio'] : '';
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';

//$idusuario = (isset($_POST['idusuario'])) ? $_POST['idusuario'] : '';
//$idhabitacion = (isset($_POST['idhabitacion'])) ? $_POST['idhabitacion'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$fechaentrada = (isset($_POST['fechaentrada'])) ? $_POST['fechaentrada'] : '';
$fechasalida = (isset($_POST['fechasalida'])) ? $_POST['fechasalida'] : '';
$ocupacion = (isset($_POST['ocupacion'])) ? $_POST['ocupacion'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';


$consulta = "SELECT * FROM clientes WHERE idcliente=(SELECT max(idcliente) FROM clientes)";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$res=$resultado->fetch(PDO::FETCH_ASSOC);
$idcliente=$res["idcliente"]+1;
$idultimo=$res["idcliente"];



switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO clientes (nombre, domicilio, telefono, idusuario) VALUES ('$nombre', '$domicilio', '$telefono', '2')";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "INSERT INTO reservas (fechaentrada, fechasalida, ocupacion, idcliente, idhabitacion, cantidad) VALUES('$fechaentrada', '$fechasalida', '$ocupacion', '$idcliente', '2','$cantidad') ";			 
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT idreserva, nombre, fechaentrada, fechasalida,telefono,cantidad FROM clientes INNER JOIN reservas ON clientes.idcliente = reservas.idcliente ORDER BY idreserva DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE clientes SET nombre='$nombre', domicilio='$domicilio', telefono='$telefono' WHERE idcliente='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();     
        
        $consulta = "UPDATE reservas SET fechaentrada='$fechaentrada', fechasalida='$fechasalida', ocupacion='$ocupacion', idcliente='$id', idhabitacion='2', cantidad='$cantidad' WHERE idreserva='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();     
        
        
        $consulta = "SELECT idreserva, nombre, fechaentrada, fechasalida,telefono,cantidad FROM clientes INNER JOIN reservas ON clientes.idcliente = reservas.idcliente WHERE clientes.idcliente='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "DELETE FROM reservas WHERE idreserva='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                         
        
        $consulta = "ALTER TABLE reservas AUTO_INCREMENT = $idultimo";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        
        $consulta = "DELETE FROM clientes WHERE idcliente='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                         
        
        
        $consulta = "ALTER TABLE clientes AUTO_INCREMENT = $idultimo";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();     
        break;    
        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
