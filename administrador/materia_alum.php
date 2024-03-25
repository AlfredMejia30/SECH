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

    <title>Menu administrador</title>
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
      <nav class="nav flex-column menu"style="float: left; margin-left:2%; margin-top: 20px;" >
        <a class="nav-link " aria-current="page" href="./repDirectora.php">Atras</a>
        <a class="nav-link " href="../close.php">Salir</a>
      </nav>

      <?php
    require '../vendor\autoload.php'; //Llamamos el autoload.php
      

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "colegiohuetamo";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
      die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el ID del grupo y la materia de la URL
    $grupo_id = $_GET['grupo_id'];
    $materia_id = $_GET['materia_id'];

    // Inicializar las variables
    $nombre_grupo = "";
    $nombre_materia = "";

    // Realizar la consulta SQL para obtener el nombre del grupo
    $sql_grupo = "SELECT nombre FROM grupos WHERE id = " . $grupo_id;
    $result_grupo = $conn->query($sql_grupo);

    // Realizar la consulta SQL para obtener el nombre de la materia
    $sql_materia = "SELECT nombre FROM materias WHERE id = " . $materia_id;
    $result_materia = $conn->query($sql_materia);

    // Obtén el nombre de la materia
    if ($result_materia->num_rows > 0) {
      while($row_materia = $result_materia->fetch_assoc()) {
        $nombre_materia = $row_materia['nombre'];
      }
    } else {
      echo "No se encontró la materia";
    }

    // Crea un nuevo objeto Spreadsheet y establece las propiedades del documento
    $spreadsheet = new Spreadsheet();
    $spreadsheet->getProperties()->setCreator('You')
        ->setLastModifiedBy('You')
        ->setTitle('Office 2007 XLSX Document')
        ->setSubject('Office 2007 XLSX Document')
        ->setDescription('Document for Office 2007 XLSX, generated using PHP classes.')
        ->setKeywords('office 2007 openxml php')
        ->setCategory('Result file');
      
    // Define el estilo para el nombre del grupo y de la materia
    $styleArray = [
        'font' => [
            'bold' => true,
            'size' => 15
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
        ],
    ];
    $sql_grupo = "SELECT nombre FROM grupos WHERE id = " . $grupo_id;
    $result_grupo = $conn->query($sql_grupo);
    
    if ($result_grupo->num_rows > 0) {
        while($row_grupo = $result_grupo->fetch_assoc()) {
          $nombre_grupo = $row_grupo['nombre'];
        }
    } else {
        echo "No se encontró el grupo";
    }
    // Agrega los encabezados al archivo de Excel
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Grupo: ')
        ->setCellValue('B1', $nombre_grupo)
        ->setCellValue('C1', 'Materia: ')
        ->setCellValue('D1', $nombre_materia)
        ->setCellValue('A3', 'Nombre')
        ->setCellValue('B3', 'Primer Apellido')
        ->setCellValue('C3', 'Segundo Apellido');

    // Aplica el estilo definido a las celdas con el nombre del grupo y la materia
    $spreadsheet->getActiveSheet()->getStyle('A1:B1')->applyFromArray($styleArray);
    $spreadsheet->getActiveSheet()->getStyle('C1:D1')->applyFromArray($styleArray);

    

    // Realiza la consulta SQL para obtener los estudiantes de este grupo
    $sql = "SELECT nombre, primer_apellido, segundo_apellido FROM student WHERE id_grupo = " . $grupo_id;
    $result = $conn->query($sql);

    // Verifica si la consulta devolvió algún resultado
    $i = 4; // Lleva el control de la fila actual en el archivo de Excel
    if ($result->num_rows > 0) {
        // Imprime la información de cada estudiante
        while($row = $result->fetch_assoc()) {
            echo "<p>Estudiante: " . $row["nombre"] . " " . $row["primer_apellido"] . " " . $row["segundo_apellido"] . "</p>";

            // Agrega los datos del estudiante al archivo de Excel
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $row["nombre"])
                ->setCellValue('B'.$i, $row["primer_apellido"])
                ->setCellValue('C'.$i, $row["segundo_apellido"]);
            $i++;
        }  
    } else {
        echo "No hay estudiantes en este grupo";
    }

    $conn->close();

    // Asigna el nombre al archivo de Excel
    $filename = 'Reporte de ' . date('Y-m-d') . ' - ' . $nombre_grupo . ' - ' . $nombre_materia . '.xlsx';

    // Configura la hoja activa al índice 0
    $spreadsheet->setActiveSheetIndex(0);

   // Guarda el archivo de Excel
   $filename = 'Reporte de ' . date('Y-m-d') . ' - ' . $nombre_grupo . ' - ' . $nombre_materia . '.xlsx';
   $writer = new Xlsx($spreadsheet);
   $writer->save($filename);

   // Proporciona un enlace para descargar el archivo
   echo "<a href='".$filename."'>Descargar el archivo</a>";
   ?>

</body>
</html>
