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
  <a class="nav-link " href="./vista_grupos.php">Atras</a>
    <a class="nav-link " aria-current="page" href="./usAdmi.php">Usuarios</a>
    <a class="nav-link " href="../close.php">Salir</a>
  </nav>
  <h2 class="tit"></h2>
  <div class="card registro text-center" style="margin-top: 60px; width: 75%; position: absolute; top: 50%; left: 45%; transform: translate(-50%, -50%);">
    <div class="card-header reg">
      <h3>Materias</h3>
    </div>
    <div class="botoncitos">

  <?php
$id = $_GET['id']; // Obtienes el ID del grupo de la URL

$stmt = $pdo->prepare('SELECT materias.* FROM materias 
                       JOIN materia_grupo ON materias.id = materia_grupo.id_materia 
                       WHERE materia_grupo.id_grupo = ?');
$stmt->execute([$id]);
$materias = $stmt->fetchAll();

echo "<table class='table table-bordered'>";
$contador = 0;
  
foreach ($materias as $materia) {
  if ($contador % 3 == 0) {
    echo "<tr>";
  }
  
  echo "<button type='button' class='btn btn-primary btn-sm botoncito2' onclick='getGrupoId(" . $materia['id'] . ")'><a class='nav-link' href='vistamenu.php?id=" . $materia['id'] . "'>" . $materia['nombre'] . "</a></button>";

  if ($contador % 3 == 2) {
    echo "</tr>";
  }
  
  $contador++;
}
  
echo "</table>";
?>

<script>
function getMateriaId(id) {
  window.location.href = "vistamenu.php?id=" + id;
}
</script>


</body>
</html>