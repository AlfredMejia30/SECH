<?php
$host = 'localhost'; // Tu servidor de base de datos
$db   = 'colegiohuetamo'; // El nombre de tu base de datos
$user = 'root'; // Tu usuario de base de datos
$pass = 'root'; // Tu contraseña de base de datos
$charset = 'utf8mb4'; // El charset que estás utilizando

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
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
    
    <title>Reporte Aministrador</title>
</head>
<body >

 <div class="contanier text-center encabezado">
    <div class="row ">
      <div class="col ">
        <img class="logo float-start img-fluid  " src="../imagenes/logoSEP.png"  alt="">
          
      </div>
      
      <div class="col text-center">
        <h1 class="tit">COLEGIO HUETAMO</h1>
      </div>
      <div class="col ">
        <img class="logoc img-fluid rounded" src="../imagenes/LogoColegio.png" height="25%" alt=""  >
      </div>
    </div>

  </div>

 

  <div class="entrega2">
  <nav class="nav flex-column menu" >
    
    <a class="nav-link " href="./admin.php">Inicio</a>
    
    
    <a class="nav-link " href="../close.php">Salir</a>
     
  </nav>
 
  <div class="card registro" style="width: 80%;">
    <div class="card-header reg">
    <?php
    // Asegúrate de establecer el valor de $materiaId de manera segura.
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $materiaId = intval($_GET['id']);
} else {
  // Manejar el error o redirigir al usuario a otra página.
  exit('Error: ID de la materia no proporcionado o no es válido.');
}

$stmt = $pdo->prepare('SELECT materias.nombre AS nombre_materia, grupos.nombre AS nombre_grupo
                     FROM materia_grupo
                     JOIN materias ON materias.id = materia_grupo.id_materia
                     JOIN grupos ON grupos.id = materia_grupo.id_grupo
                     WHERE materias.id = :materiaId');
$stmt->execute(['materiaId' => $materiaId]);

$materia = $stmt->fetch();
if($materia) {
echo '<h3>' . $materia['nombre_materia'] . '</h3>';
echo'</div>';
echo'<ul>';
echo '<li class="list-group-item">GRUPO: ' . $materia['nombre_grupo'] . '</li>';
} else {
// Manejar error, la materia no existe.
exit('Error: La materia no existe.');
}
    ?>
        <li class="list-group-item">CLAVE C.T:16PES0035L</li>
        <li class="list-group-item">TURNO: Matutino</li>
        <li class="list-group-item">CICLO ESCOLAR: 2022-2023</li>
        
    
    </ul>

        <table class="table table-sm">
           
            <tr>
              <th>No. Control</th>
              <th>PRIMER APELLIDO     </th>
              <th>SEGUNDO APELLIDO</th>
              <th>NOMBRE (S)</th>
              <th>Calificación</th>
            
             
            </tr>
           <?php

$stmt = $pdo->prepare('
SELECT 
    usuarios.username AS no_control, 
    student.nombre, 
    student.primer_apellido, 
    student.segundo_apellido,
    AVG(calificaciones.calificacion) AS promedio
FROM student
LEFT JOIN usuarios ON usuarios.id = student.id_usuario
LEFT JOIN calificaciones ON calificaciones.id_student = student.id
LEFT JOIN actividades ON actividades.id = calificaciones.id_actividad
WHERE actividades.id_materia = :materiaId 
GROUP BY student.id
');
$stmt->execute(['materiaId' => $materiaId]);


while($row = $stmt->fetch()) {
echo '<tr>';
echo '<td>' . $row['no_control'] . '</td>'; // Mostrando No. de control del estudiante
echo '<td>' . $row['primer_apellido'] . '</td>';
echo '<td>' . $row['segundo_apellido'] . '</td>';
echo '<td>' . $row['nombre'] . '</td>';
echo '<td>' . (is_null($row['promedio']) ? 'N.A.' : round($row['promedio'], 2)) . '</td>';
echo '</tr>';
}

        ?>
            
           
          </table>
          <a href="download.php?id=<?php echo $materiaId; ?>" class="btn btn-primary btn-sm botoncito">Descargar</a>
</div>

</div>
</body>
</html>