<?php
include 'conexion.php';

$username = $_GET['username'];  // Obtén el username del alumno de la petición

$query = "SELECT usuarios.id as id_usuario, usuarios.username, student.nombre, student.primer_apellido, student.segundo_apellido, student.correo_electronico 
          FROM usuarios 
          INNER JOIN student 
          ON usuarios.id = student.id_usuario
          WHERE usuarios.username = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$resultado = $stmt->get_result();

header('Content-Type: application/json');
if($resultado->num_rows > 0){
    $alumno = $resultado->fetch_assoc();
    echo json_encode($alumno);  // Devuelve los datos del alumno como JSON
} else {
    echo json_encode(['error' => 'No se encontró al alumno']);
}
