<?php
session_start(); 
include_once('conexion.php');
if (isset($_POST['edit'])) {
    $database = new ConectarDB();
    $db = $database-> open();
    try {
        $id = $_GET['id'];
        $nombrec=$_POST['nombrecontacto'];
        $telefonoc=$_POST['celular'];
        $correoc=$_POST['email'];
        $direccionc=$_POST['direccion'];

        $sql= "UPDATE personas SET Nombre = '$nombrec', Telefono = '$telefonoc', Correo = '$correoc', Direccion = '$direccionc' WHERE idPersona = '$id'";
        
        $_SESSION['message']=($db -> exec($sql)) ? 'Contacto Actualizado' : 'ERROR, no se puedo actualizar el contacto';
    } catch (PDOException $e) {
        $_SESSION['message']= $e->getMessage();    
    } 
    $database->close();
}
else {
    $_SESSION['message']= 'Llene el formulario';
}
header('location: index.php');
?>