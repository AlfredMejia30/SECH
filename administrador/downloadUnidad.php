<?php
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$host = 'localhost';
$db   = 'colegiohuetamo';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$materiaId = $_GET['id']; // Obtienes el ID de la materia de la URL
$unidad = $_GET['unidad']; // Obtienes la unidad de la URL

$stmt = $pdo->prepare('SELECT materias.nombre AS nombre_materia, grupos.nombre AS nombre_grupo
                     FROM materia_grupo
                     JOIN materias ON materias.id = materia_grupo.id_materia
                     JOIN grupos ON grupos.id = materia_grupo.id_grupo
                     WHERE materias.id = :materiaId');
$stmt->execute(['materiaId' => $materiaId]);

$materia = $stmt->fetch();
if(!$materia) {
  // Manejar error, la materia no existe.
  exit('Error: La materia no existe.');
}

// Asigna los valores y aplica un estilo de fuente negrita
$sheet->setCellValue('A1', 'Materia: '.$materia['nombre_materia']);
$sheet->setCellValue('A2', 'Grupo: '.$materia['nombre_grupo']);
$sheet->setCellValue('A3', 'Unidad: '.$unidad);

$styleArray = [
    'font' => [
        'bold' => true,
    ]
];

$sheet->getStyle('A1:A3')->applyFromArray($styleArray);

// Colocar las cabeceras en la fila 5
$sheet->setCellValue('A5', 'No. Control');
$sheet->setCellValue('B5', 'Primer Apellido');
$sheet->setCellValue('C5', 'Segundo Apellido');
$sheet->setCellValue('D5', 'Nombre');
$sheet->setCellValue('E5', 'Calificación');

$stmt = $pdo->prepare('SELECT usuarios.username AS num_control, student.nombre, student.primer_apellido, student.segundo_apellido, 
CASE 
  WHEN ROUND(AVG(calificaciones.calificacion)) = AVG(calificaciones.calificacion)
  THEN FORMAT(ROUND(AVG(calificaciones.calificacion)), 0)
  ELSE ROUND(AVG(calificaciones.calificacion), 2)
END as promedio_calificacion
FROM calificaciones
JOIN actividades ON actividades.id = calificaciones.id_actividad
JOIN student ON student.id = calificaciones.id_student
JOIN usuarios ON usuarios.id = student.id_usuario
WHERE actividades.id_materia = :idMateria AND actividades.unidad = :unidad
GROUP BY num_control, nombre, primer_apellido, segundo_apellido');
$stmt->execute(['idMateria' => $materiaId, 'unidad' => $unidad]);

$rowNumber = 6; // La fila en la que se comienzan a agregar los datos
while($row = $stmt->fetch()) {
  $sheet->setCellValue('A' . $rowNumber, $row['num_control']);
  $sheet->setCellValue('B' . $rowNumber, $row['primer_apellido']);
  $sheet->setCellValue('C' . $rowNumber, $row['segundo_apellido']);
  $sheet->setCellValue('D' . $rowNumber, $row['nombre']);
  $sheet->setCellValue('E' . $rowNumber, $row['promedio_calificacion']);
  $rowNumber++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'reporte_unidad.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'. $filename .'"'); 
header('Cache-Control: max-age=0');

$writer->save('php://output'); // download file 
?>
