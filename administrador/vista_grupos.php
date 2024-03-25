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
    <a class="nav-link " href="./admin.php">Atras</a>
    <a class="nav-link " aria-current="page" href="./usAdmi.php">Registrar Usuarios</a>
    <a class="nav-link " href="./AsignMatDoc.php">Asignar Materias</a>
    <a class="nav-link " href="../close.php">Salir</a>
  </nav>
  <h2 class="tit"></h2>
  <div class="card registro text-center" style="margin-top: 60px; width: 75%; position: absolute; top: 50%; left: 45%; transform: translate(-50%, -50%);">
    <div class="card-header reg">
      <h3>Grupos</h3>
    </div>
    <div class="botoncitos">
  <?php
try {
  $stmt = $pdo->query('SELECT * FROM grupos ORDER BY nombre');
  $grupos = $stmt->fetchAll();

  $gruposPorColumna = array_chunk($grupos, ceil(count($grupos)/3));

  echo "<table class='table table-bordered'>";
  
  $numFilas = count($gruposPorColumna[0]);
  for($i = 0; $i < $numFilas; $i++) {
    echo "<tr>";
    for($j = 0; $j < 3; $j++) {
      if(isset($gruposPorColumna[$j][$i])) {
        $grupo = $gruposPorColumna[$j][$i];
        echo "<button type='button' class='btn btn-primary btn-sm botoncito2' onclick='getGrupoId(" . $grupo['id'] . ")'><a class='nav-link' href='vista_materias.php?id=" . $grupo['id'] . "'>" . $grupo['nombre'] . "</a></button>";

      } else {
        echo "<td></td>";
      }
    }
    echo "</tr>";
  }
  
  echo "</table>";
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}

?>
<script>
function getGroupId(id) {
  window.location.href = "vista_materias.php?id=" + id;
}
</script>
    </div>
  </div>
</body>
</html>