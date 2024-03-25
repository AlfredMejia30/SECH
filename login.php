<?php

session_start();  // Iniciar la sesión

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "colegiohuetamo";
$redirectOnError = "Location: index.php"; // Redirección en caso de error

try {
    // Crear conexión PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configurar el modo de error de PDO a excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los datos enviados desde el formulario de inicio de sesión
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST["username"];
        $contraseña = $_POST["password"];

        // Consultar la base de datos para obtener el hash de contraseña almacenado, el rol y el ID del usuario
        $stmt = $conn->prepare("SELECT id, password, role FROM usuarios WHERE username = :usuario");
        $stmt->bindParam(":usuario", $usuario);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $userId = $row["id"];
            $hashContraseña = $row["password"];
            $rol = $row["role"];

            // Verificar la contraseña ingresada
            if (password_verify($contraseña, $hashContraseña)) {
                // Contraseña válida, inicio de sesión exitoso
                // Almacenar el ID de usuario en la sesión
                $_SESSION['id'] = $userId; // Descomentar esta línea
                switch ($rol) {
                    case "Admin":
                        header("Location: administrador\admin.php");
                        break;
                    case "Alumno":
                        $_SESSION['alumn_id'] = $userId;
                        header("Location: alumno\student.php?userId=$userId");
                        break;
                    case "Docente":
                        header("Location: docente\ateacher.php");
                        break;
                    case "Tutor":
                        header("Location: tutor\atutor.php?userId=$userId");
                        break;
                    default:
                        echo "Rol no válido";
                        header($redirectOnError);
                        die();
                }
                die(); // Terminar el script inmediatamente después de la redirección
            } else {
                $_SESSION['error'] = "Contraseña incorrecta";
                header($redirectOnError);
                die();
            }
        } else {
            // El usuario no existe
            $_SESSION['error'] = "Usuario no encontrado";
            header($redirectOnError); // Redirigir al usuario a index.php
            die();
        }
    }
} catch(PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
    header($redirectOnError);
    die();
} finally {
    // Cerrar conexión de manera segura
    $conn = null;
}
?>
