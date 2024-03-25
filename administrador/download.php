<?php
require '../vendor/autoload.php'; // Asegúrate de que esta ruta apunte al autoload.php de composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


// Aquí va tu código para obtener los datos de la base de datos
// por ejemplo:


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
$stmt = $pdo->prepare('SELECT usuarios.username AS no_control, student.nombre, student.primer_apellido, student.segundo_apellido,
AVG(calificaciones.calificacion) AS promedio
FROM student
LEFT JOIN usuarios ON usuarios.id = student.id_usuario
LEFT JOIN calificaciones ON calificaciones.id_student = student.id
LEFT JOIN actividades ON actividades.id = calificaciones.id_actividad
WHERE actividades.id_materia = :materiaId OR actividades.id_materia IS NULL
GROUP BY student.id');
$stmt->execute(['materiaId' => $materiaId]);

// Encabezado
$sheet->setCellValue('A1', $materia['nombre_materia'] );
$sheet->setCellValue('B1', $materia['nombre_grupo']);


// Cabeceras
$sheet->setCellValue('A3', 'No. Control');
$sheet->setCellValue('B3', 'PRIMER APELLIDO');
$sheet->setCellValue('C3', 'SEGUNDO APELLIDO');
$sheet->setCellValue('D3', 'NOMBRE (S)');
$sheet->setCellValue('E3', 'Calificación');

// Por cada fila, añade una fila a la hoja de cálculo
$rowNum = 4; // Comienza en la segunda fila, ya que la primera se usa para las cabeceras
while($row = $stmt->fetch()) {
  $sheet->setCellValue('A'.$rowNum, $row['no_control']);
  $sheet->setCellValue('B'.$rowNum, $row['primer_apellido']);
  $sheet->setCellValue('C'.$rowNum, $row['segundo_apellido']);
  $sheet->setCellValue('D'.$rowNum, $row['nombre']);
  $sheet->setCellValue('E'.$rowNum, is_null($row['promedio']) ? 'N.A.' : round($row['promedio'], 2));
  $rowNum++;
}

// Escribe el archivo de Excel y lo descarga
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="reporte.xlsx"');
$writer->save('php://output');
