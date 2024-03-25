<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "colegiohuetamo";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Tomar los datos de POST
        $materia_id = $_POST['materia'];
        $grupo_id = $_POST['grupo'];
        $docente_id = $_POST['docente'];

        // Preparar la sentencia SQL e insertar los datos
        $stmt = $conn->prepare("INSERT INTO materia_grupo (id_materia, id_grupo, id_teacher) VALUES (?, ?, ?)");
        $stmt->execute([$materia_id, $grupo_id, $docente_id]);

        // Redireccionar al usuario de vuelta a la página principal
        header("Location: AsignMatDoc.php");
        exit;
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conn = null;
}
?>
