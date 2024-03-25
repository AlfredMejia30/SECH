<?php
$host = 'localhost'; // o tu dirección del servidor de la base de datos
$db   = 'colegiohuetamo';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative; /* Se agrega para el posicionamiento absoluto de los hijos */
        }

        .contanier.encabezado {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10; /* Se asegura que esté por encima de otros elementos */
        }

        .nav {
            position: absolute;
            top: 10%;
            left: 2%;
        }

        .honor-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%;
          }
    </style>
    <title>Menu administrador</title>
</head>
<body>
<div class="contanier text-center encabezado">
        <div class="row ">
            <div class="col ">
                <img class="logo float-start img-fluid" src="../imagenes/logoSEP.png" alt="">
            </div>
            <div class="col text-center">
                <h1 class="tit">COLEGIO HUETAMO</h1>
            </div>
            <div class="col ">
                <img class="logoc img-fluid rounded" src="../imagenes/LogoColegio.png" height="25%" alt="">
            </div>
        </div>
    </div>  
    
    <nav class="nav flex-column menu" style="float: left; margin-left:2%; margin-top: 20px;">
    <br><br><br>
        <a class="nav-link" aria-current="page" href="./usAdmi.php">Registrar Usuarios</a>
        <a class="nav-link" href="./vista_grupos.php">Reportes</a>
        <a class="nav-link" href="./usAdmiMod.php">Modificar Usuarios</a>
        <a class="nav-link" href="./AsignMatDoc.php">Asignar Materias</a>
        <a class="nav-link" href="../close.php">Salir</a>
    </nav>
    <div class="main-container">
        <h2 class="tit">¡Bienvenido Administrador!</h2>
        <section class="newspaper">
            <header>
                <h1>Cuadro de Honor</h1>
                <p>Escuela Secundaria "Colegio Huetamo"</p>
                <div class="grade-switcher">
                    <button onclick="showGrade(1)">1</button>
                    <button onclick="showGrade(2)">2</button>
                    <button onclick="showGrade(3)">3</button>
                </div>
            </header>
            <?php

$stmt = $pdo->prepare("SELECT 
    s.id AS student_id,
    s.id_grupo,
    g.nombre AS grupo_nombre,
    CONCAT(s.nombre, ' ', s.primer_apellido, ' ', s.segundo_apellido) AS nombre_completo,
    AVG(cf.calificacion_final) AS promedio_final,
    s.foto AS foto,
    s.mime_type AS mime_type
FROM 
    student s
JOIN 
    calificacion_final cf ON s.id = cf.id_student
JOIN
    grupos g ON s.id_grupo = g.id
WHERE 
    cf.periodo = :periodo
GROUP BY 
    s.id
ORDER BY 
    promedio_final DESC");


$periodoEspecificado = "1";

$stmt->execute(['periodo' => $periodoEspecificado]);

$students = $stmt->fetchAll();


// Llenar el cuadro de honor dinámicamente
function displayStudent($student) {
  echo '<div class="student">';
  echo '  <figure>';
 
  if ($student['foto']) {
      echo '      <img src="data:'.$student['mime_type'].';base64,'.base64_encode($student['foto']).'" alt="' . $student['nombre_completo'] . '" style="width:100px;">';
  } else {
     echo '      <img src="placeholder.jpg"  width="100" alt="Imagen no disponible">';
 }
  echo '      <figcaption>' . $student['nombre_completo'] . '<br>Promedio: ' . $student['promedio_final'] . '</figcaption>';
  echo '  </figure>';
  echo '  <p>Lorem ipsum...</p>';
  echo '</div>';
}



?>

<div id="grade-1" class="grade-content">
    <?php
    foreach ($students as $student) {
        if (strpos($student['grupo_nombre'], '1ro') !== false) { // Filtrar estudiantes de primer grado
            displayStudent($student);
        }
    }
    ?>
</div>

<div id="grade-2" class="grade-content" style="display: none;">
    <?php
    foreach ($students as $student) {
        if (strpos($student['grupo_nombre'], '2do') !== false) { // Filtrar estudiantes de segundo grado
            displayStudent($student);
        }
    }
    ?>
</div>

<div id="grade-3" class="grade-content" style="display: none;">
    <?php
    foreach ($students as $student) {
        if (strpos($student['grupo_nombre'], '3ro') !== false) { // Filtrar estudiantes de tercer grado
            displayStudent($student);
        }
    }
    ?>
</div>

    </section>
    <script>
        function showGrade(gradeNumber) {
            // Ocultar todos los contenidos de grados primero
            document.querySelectorAll('.grade-content').forEach(el => {
                el.style.display = 'none';
            });

            // Mostrar el contenido del grado seleccionado
            document.getElementById(`grade-${gradeNumber}`).style.display = 'block';
        }
    </script>
</body>
</html>