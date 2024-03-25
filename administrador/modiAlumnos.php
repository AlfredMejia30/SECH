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
function getTutorId($id_student) {
    global $conexion;

    $query = "SELECT id_tutor FROM student WHERE id = ?";

    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id_student);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id_tutor'];
    } else {
        return null;
    }
}
function getTutorUsuarioId($id_tutor) {
    global $conexion;

    $query = "SELECT id_usuario FROM tutor WHERE id = ?";

    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id_tutor);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id_usuario'];
    } else {
        return null;
    }
}
function getUsuarioId($id_student) {
    global $conexion;

    $query = "SELECT id_usuario FROM student WHERE id = ?";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param('i', $id_student);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return $row['id_usuario'];
                }
            } else {
                echo json_encode(['error' => 'No se encontró el usuario del estudiante']);
            }
        } else {
            echo json_encode(['error' => 'Ha ocurrido un error al intentar obtener el usuario del estudiante']);
        }
    } else {
        echo json_encode(['error' => 'Ha ocurrido un error al preparar la consulta para obtener el usuario del estudiante']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["button"]) && $_POST["button"] == "Guardar cambios") {
            $id_usuario = $_POST['id_usuario'];
            $numeroControl = $_POST['numeroControl'];
            $nombre = $_POST['nombre'];
            $apellido1 = $_POST['apellido1'];
            $apellido2 = $_POST['apellido2'];
            $correo = $_POST['correo'];
            $password = $_POST['password'] ?? null;
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            
            $foto = null;
            $mime_type = null;
            
            // Manejo de la subida de foto
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $foto = file_get_contents($_FILES['foto']['tmp_name']);
                $mime_type = mime_content_type($_FILES['foto']['tmp_name']);
            } else {
                echo "Error al subir el archivo: " . $_FILES['foto']['error'];
            }
            
            if ($foto && $mime_type) {
                $query = "UPDATE student 
                          SET nombre = ?, primer_apellido = ?, segundo_apellido = ?, correo_electronico = ?, foto = ?, mime_type = ? 
                          WHERE id_usuario = ?";
                $stmt = $conexion->prepare($query);
                $stmt->bind_param('ssssssi', $nombre, $apellido1, $apellido2, $correo, $foto, $mime_type, $id_usuario);
               
                if (!$stmt->execute()) {
                    echo json_encode(['error' => 'Ocurrió un error durante la actualización.']);
                    exit;
                }
            } else {
                $query = "UPDATE student 
                          SET nombre = ?, primer_apellido = ?, segundo_apellido = ?, correo_electronico = ? 
                          WHERE id_usuario = ?";
                $stmt = $conexion->prepare($query);
                $stmt->bind_param('ssssi', $nombre, $apellido1, $apellido2, $correo, $id_usuario);
                
                if (!$stmt->execute()) {
                    echo json_encode(['error' => 'Ocurrió un error durante la actualización.']);
                    exit;
                }
            }
    
            if ($password) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                
                $queryUsuarios = "UPDATE usuarios SET password = ? WHERE id = ?";
                $stmtUsuarios = $conexion->prepare($queryUsuarios);
                $stmtUsuarios->bind_param('si', $passwordHash, $id_usuario);
                
                if (!$stmtUsuarios->execute()) {
                    echo json_encode(['error' => 'Ocurrió un error al actualizar la contraseña.']);
                    exit;
                }
            }
    
            echo json_encode(['success' => 'El alumno ha sido actualizado correctamente.']);
        }
    }
    
    elseif (isset($_POST["button"]) && $_POST["button"] == "Eliminar") {
        $id_usuario = $_POST['id_usuario'];
        
        $id_tutor = getTutorId($id_usuario);
        $id_usuario_student = getUsuarioId($id_usuario);
    
        // Primero eliminar las calificaciones del estudiante
        $queryCalificaciones = "DELETE FROM calificaciones WHERE id_student = ?";
    
        $stmtCalificaciones = $conexion->prepare($queryCalificaciones);
        $stmtCalificaciones->bind_param('i', $id_usuario);
    
        if ($stmtCalificaciones->execute()){
            // Segundo, eliminar las calificaciones finales del estudiante
            $queryCalificacionFinal = "DELETE FROM calificacion_final WHERE id_student = ?";
    
            $stmtCalificacionFinal = $conexion->prepare($queryCalificacionFinal);
            $stmtCalificacionFinal->bind_param('i', $id_usuario);
    
            if ($stmtCalificacionFinal->execute()){
                // Luego eliminar al estudiante
                $queryStudent = "DELETE FROM student WHERE id_usuario = ?";
    
                $stmtStudent = $conexion->prepare($queryStudent);
                $stmtStudent->bind_param('i', $id_usuario);
    
                if($stmtStudent->execute()){
                    // Eliminar el usuario del estudiante
                    $queryUsuarioStudent = "DELETE FROM usuarios WHERE id = ?";
    
                    $stmtUsuarioStudent = $conexion->prepare($queryUsuarioStudent);
                    $stmtUsuarioStudent->bind_param('i', $id_usuario);
    
                    if($stmtUsuarioStudent->execute()){
                        // Luego eliminar al tutor
                        $queryTutor = "DELETE FROM tutor WHERE id = ?";
    
                        $stmtTutor = $conexion->prepare($queryTutor);
                        $stmtTutor->bind_param('i', $id_tutor);
    
                        if($stmtTutor->execute()){
                            // Finalmente, eliminar el usuario del tutor
                            $queryUsuarios = "DELETE FROM usuarios WHERE id = ?";
    
                            $stmtUsuarios = $conexion->prepare($queryUsuarios);
                            $stmtUsuarios->bind_param('i', $id_usuario_tutor);
    
                            if($stmtUsuarios->execute()){
                                echo json_encode(['success' => 'El alumno, sus calificaciones, sus calificaciones finales, el usuario del alumno, el tutor y el usuario del tutor han sido eliminados correctamente.']);
                            } else {
                                echo json_encode(['error' => 'Ha ocurrido un error al eliminar el usuario del tutor.']);
                            }
                        } else {
                            echo json_encode(['error' => 'Ha ocurrido un error al eliminar el tutor.']);
                        }
                    } else {
                        echo json_encode(['error' => 'Ha ocurrido un error al eliminar el usuario del estudiante.']);
                    }
                } else {
                    echo json_encode(['error' => 'Ha ocurrido un error al eliminar el estudiante.']);
                }
            } else {
                echo json_encode(['error' => 'Ha ocurrido un error al eliminar las calificaciones finales del estudiante.']);
            }
        } else {
            echo json_encode(['error' => 'Ha ocurrido un error al eliminar las calificaciones del estudiante.']);
        }
   }
}

$conexion->close();

?>
