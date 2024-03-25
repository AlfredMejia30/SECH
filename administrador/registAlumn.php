<?php
// Este es un ejemplo de código, deberás modificarlo para adaptarlo a tus necesidades y para manejar posibles errores o casos especiales.

// Primero, necesitaremos conectarnos a la base de datos.
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'colegiohuetamo';
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Comprobamos la conexión
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recogemos los datos de los formularios
// Para el tutor
$noUsuario = $conn->real_escape_string($_POST['noUsuario']);
$nombreTutor = $conn->real_escape_string($_POST['nombreTutor']);
$primerApellidoTutor = $conn->real_escape_string($_POST['primerApellidoTutor']);
$segundoApellidoTutor = $conn->real_escape_string($_POST['segundoApellidoTutor']);
$telefono = $conn->real_escape_string($_POST['telefono']);
$passwordTutor = password_hash($conn->real_escape_string($_POST['passwordTutor']), PASSWORD_DEFAULT); // Encriptamos la contraseña con password_hash
// Para el alumno
$noControl = $conn->real_escape_string($_POST['noControl']);
$curp = $conn->real_escape_string($_POST['curp']);
$nombreAlumno = $conn->real_escape_string($_POST['name']);
$primerApellidoAlumno = $conn->real_escape_string($_POST['firstLastname']);
$segundoApellidoAlumno = $conn->real_escape_string($_POST['secundLastname']);
$email = $conn->real_escape_string($_POST['email']);
$passwordAlumno = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT); // Encriptamos la contraseña con password_hash
$idTutor = $conn->real_escape_string($_POST['idTutor']);
$grupo = $conn->real_escape_string($_POST['grupo']);

// Primero registramos al tutor en la tabla de usuarios
$stmt = $conn->prepare("INSERT INTO usuarios (username, password, role) VALUES (?, ?, 'Tutor')");
$stmt->bind_param("ss", $noUsuario, $passwordTutor);
$stmt->execute();
$last_id_tutor_usuario = $stmt->insert_id; // Obtenemos el último ID insertado, este es el id del tutor en la tabla usuarios

// Ahora registramos al tutor en la tabla de tutores
$stmt = $conn->prepare("INSERT INTO tutor (id_usuario, nombre, primer_apellido, segundo_apellido, telefono, num_con_hijo) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssss", $last_id_tutor_usuario, $nombreTutor, $primerApellidoTutor, $segundoApellidoTutor, $telefono, $noControl);
$stmt->execute();
$last_id_tutor = $stmt->insert_id; // Obtenemos el último ID insertado, este es el id del tutor en la tabla tutor

// Registramos al alumno en la tabla de usuarios
$stmt = $conn->prepare("INSERT INTO usuarios (username, password, role) VALUES (?, ?, 'Alumno')");
$stmt->bind_param("ss", $noControl, $passwordAlumno);
$stmt->execute();
$last_id_alumno_usuario = $stmt->insert_id; // Obtenemos el último ID insertado, este es el id del alumno en la tabla usuarios

// Ahora registramos al alumno en la tabla de alumnos
// Primero, obtenemos el ID del grupo a partir de su nombre
$grupo_stmt = $conn->prepare("SELECT id FROM grupos WHERE nombre = ?");
$grupo_stmt->bind_param("s", $grupo);
$grupo_stmt->execute();
$grupo_result = $grupo_stmt->get_result();
$grupo_row = $grupo_result->fetch_assoc();
$id_grupo = $grupo_row['id']; // Aquí tienes el ID del grupo



// Registrar al alumno en la tabla de alumnos
if ($foto) {
    $stmt = $conn->prepare("INSERT INTO student (id_usuario, curp, nombre, primer_apellido, segundo_apellido, correo_electronico, id_grupo, id_tutor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $last_id_alumno_usuario, $curp, $nombreAlumno, $primerApellidoAlumno, $segundoApellidoAlumno, $email, $id_grupo, $last_id_tutor, );
} else {
    $stmt = $conn->prepare("INSERT INTO student (id_usuario, curp, nombre, primer_apellido, segundo_apellido, correo_electronico, id_grupo, id_tutor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssi", $last_id_alumno_usuario, $curp, $nombreAlumno, $primerApellidoAlumno, $segundoApellidoAlumno, $email, $id_grupo, $last_id_tutor);
}

header("Location: regAlumno.php");
exit();

$stmt->close();
$conn->close();
?>
