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
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $password = $_POST['password']; // Asegúrate de enviar este dato desde el formulario
     //   if(empty($password)){
      //      die(json_encode(['error' => 'La contraseña no puede estar vacía.']));
      //  }
        
        // Hashea la contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
        // Prepara la consulta de actualización para la tabla teacher
        $queryTeacher = "UPDATE teacher 
                  SET nombre = ?, primer_apellido = ?, segundo_apellido = ?, correo_electronico = ?, telefono = ? 
                  WHERE id_usuario = ?";
    
        // Prepara la consulta de actualización para la tabla usuarios
        $queryUsuarios = "UPDATE usuarios
                          SET password = ?
                          WHERE id = ?";
    
        // Prepara y ejecuta la consulta para la tabla teacher
        $stmtTeacher = $conexion->prepare($queryTeacher);
        $stmtTeacher->bind_param('sssssi', $nombre, $apellido1, $apellido2, $correo, $telefono, $id_usuario);
    
        // Prepara y ejecuta la consulta para la tabla usuarios
        $stmtUsuarios = $conexion->prepare($queryUsuarios);
        $stmtUsuarios->bind_param('si', $passwordHash, $id_usuario);
    
        if($stmtTeacher->execute() && $stmtUsuarios->execute()){
            echo json_encode(['success' => 'El docente ha sido actualizado correctamente.']);
        } else {
            echo json_encode(['error' => 'Ocurrió un error durante la actualización.']);
        }
    }
  
    elseif (isset($_POST["button"]) && $_POST["button"] == "Eliminar") {
        // Toma el id del usuario del POST
        $id_usuario = $_POST['id_usuario'];
    
        // Prepara la consulta de eliminación para la tabla materia_grupo
        $queryMateriaGrupo = "DELETE FROM materia_grupo WHERE id_teacher = (SELECT id FROM teacher WHERE id_usuario = ?)";
        
        // Prepara y ejecuta la consulta
        $stmtMateriaGrupo = $conexion->prepare($queryMateriaGrupo);
        $stmtMateriaGrupo->bind_param('i', $id_usuario);
    
        if($stmtMateriaGrupo->execute()){
            // Si las materias del profesor se eliminaron correctamente, ahora elimina al profesor
            // Prepara la consulta de eliminación para la tabla teacher
            $queryTeacher = "DELETE FROM teacher WHERE id_usuario = ?";
    
            // Prepara y ejecuta la consulta
            $stmtTeacher = $conexion->prepare($queryTeacher);
            $stmtTeacher->bind_param('i', $id_usuario);
    
            if($stmtTeacher->execute()){
                // Si el profesor fue eliminado correctamente, ahora elimina al usuario
                // Prepara la consulta de eliminación para la tabla usuarios
                $queryUsuarios = "DELETE FROM usuarios WHERE id = ?";
    
                // Prepara y ejecuta la consulta
                $stmtUsuarios = $conexion->prepare($queryUsuarios);
                $stmtUsuarios->bind_param('i', $id_usuario);
    
                if($stmtUsuarios->execute()){
                    echo json_encode(['success' => 'El profesor, sus materias y su usuario han sido eliminados correctamente.']);
                } else {
                    echo json_encode(['error' => 'Ocurrió un error durante la eliminación del usuario.']);
                }
            } else {
                echo json_encode(['error' => 'Ocurrió un error durante la eliminación del profesor.']);
            }
        } else {
            echo json_encode(['error' => 'Ocurrió un error durante la eliminación de las materias del profesor.']);
        }
    }
    
}

$conexion->close();

?>
