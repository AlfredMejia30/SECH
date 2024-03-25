<?php
$host = "localhost";
$db = "colegiohuetamo";
$user = "root";
$pass = "root";

// Crear conexión
$conexion = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["button"]) && $_POST["button"] == "Guardar cambios") {
        // Toma los datos del POST
        $id_usuario = $_POST['id_usuario'];
        $numeroControl = $_POST['numeroControl'];
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $telefono = $_POST['telefono'];
        $password = $_POST['password']; // Asegúrate de enviar este dato desde el formulario

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Prepara la consulta de actualización
        $query = "UPDATE tutor 
                  SET  nombre = ?, primer_apellido = ?, segundo_apellido = ?, telefono = ?  
                  WHERE id_usuario = ?";
    
    $queryUsuarios = "UPDATE usuarios
    SET password = ?
    WHERE id = ?";
 // Prepara y ejecuta la consulta
$stmt = $conexion->prepare($query);
$stmt->bind_param('ssssi', $nombre, $apellido1, $apellido2,  $telefono, $id_usuario);

$stmtUsuarios = $conexion->prepare($queryUsuarios);
        $stmtUsuarios->bind_param('si', $passwordHash, $id_usuario);
    
        if($stmt->execute()){
            echo json_encode(['success' => 'El alumno ha sido actualizado correctamente.']);
        } else {
            echo json_encode(['error' => 'Ocurrió un error durante la actualización.']);
        }
    }
    elseif (isset($_POST["button"]) && $_POST["button"] == "Eliminar") {
        // Toma el id del usuario del POST
        $id_usuario = $_POST['id_usuario'];

        // Prepara la consulta de eliminación para la tabla student
        $queryStudent = "DELETE FROM tutor WHERE id_usuario = ?";

        // Prepara y ejecuta la consulta
        $stmtStudent = $conexion->prepare($queryStudent);
        $stmtStudent->bind_param('i', $id_usuario);

        if($stmtStudent->execute()){
            // Si el estudiante fue eliminado correctamente, ahora elimina al usuario
            // Prepara la consulta de eliminación para la tabla usuarios
            $queryUsuarios = "DELETE FROM usuarios WHERE id = ?";

            // Prepara y ejecuta la consulta
            $stmtUsuarios = $conexion->prepare($queryUsuarios);
            $stmtUsuarios->bind_param('i', $id_usuario);

            if($stmtUsuarios->execute()){
                echo json_encode(['success' => 'El alumno y su usuario han sido eliminados correctamente.']);
            } else {
                echo json_encode(['error' => 'Ocurrió un error durante la eliminación del usuario.']);
            }
        } else {
            echo json_encode(['error' => 'Ocurrió un error durante la eliminación del alumno.']);
        }
    }
}

$conexion->close();

?>
