<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'colegiohuetamo';
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$noUsuario = $conn->real_escape_string($_POST['noUsuario']);
$nombre = $conn->real_escape_string($_POST['nombre']);
$primerApellido = $conn->real_escape_string($_POST['primerApellido']);
$segundoApellido = $conn->real_escape_string($_POST['segundoApellido']);
$correo = $conn->real_escape_string($_POST['correo']);
$contrasena = password_hash($conn->real_escape_string($_POST['contrasena']), PASSWORD_DEFAULT);
$telefono = $conn->real_escape_string($_POST['telefono']);
$nivelEstudios = $conn->real_escape_string($_POST['nivelEstudios']);

$stmt = $conn->prepare("INSERT INTO usuarios (username, password, role) VALUES (?, ?, 'Docente')");
$stmt->bind_param("ss", $noUsuario, $contrasena);
$stmt->execute();
$last_id_docente_usuario = $stmt->insert_id;

$stmt = $conn->prepare("INSERT INTO teacher (id_usuario, nombre, primer_apellido, segundo_apellido, correo_electronico, telefono, nivel_estudios) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssss", $last_id_docente_usuario, $nombre, $primerApellido, $segundoApellido, $correo, $telefono, $nivelEstudios);

if ($stmt->execute()) {
    echo "<script type='text/javascript'>alert('El registro de docente se ha completado con éxito.'); window.location.href = 'regDocente.php';</script>";
} else {
    echo "Error: " . $stmt->error;
    exit();
}

$stmt->close();
$conn->close();
?>
