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
    <a class="nav-link " aria-current="page" href="./usAdmi.php">Usuarios</a>
    <a class="nav-link " href="repDirectora.php">Reporte</a>
    <a class="nav-link " href="./admiMaterias.php">Materias</a>
    <a class="nav-link " href="../close.php">Salir</a>
  </nav>
  <?php
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

// Obtener el ID del grupo de la URL
$grupo_id = $_GET['grupo_id'];

// Realizar la consulta SQL para obtener el nombre del grupo
$sql = "SELECT nombre FROM grupos WHERE id = " . $grupo_id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Imprimir el nombre del grupo
  while($row = $result->fetch_assoc()) {
    echo "
    <div class='card registro text-center' style='width: 75%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);'>
        <div class='card-header reg'>
          <h3>".$row['nombre']."</h3>
        </div>";
  }
} else {
  echo "No se encontró el grupo";
}

// Realizar la consulta SQL para obtener las materias del grupo
$sql = "SELECT materias.id AS id_materia, materias.nombre FROM materias INNER JOIN materia_grupo ON materias.id = materia_grupo.id_materia WHERE materia_grupo.id_grupo = " . $grupo_id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Imprimir las materias del grupo
  echo "<div class='row align-items-center' style='height: 50vh;'>";
  echo "<div class='col text-center'>";
  while($row = $result->fetch_assoc()) {
    echo "<a href='#' data-grupo-id='".$grupo_id."' data-materia-id='".$row["id_materia"]."' class='btn btn-primary m-2 grupo'>".$row["nombre"]."</a>";
}
  echo "</div>"; // Cerrar el div de la columna
  echo "</div>"; // Cerrar el div de la fila
} else {
  echo "No hay materias asignadas a este grupo";
}

echo "</div>"; // Cerrar el div del grupo

$conn->close();
?>

<script>
document.querySelectorAll('.grupo').forEach(function(button) {
  button.addEventListener('click', function(event) {
    // Obtener el ID del grupo y el ID de la materia
    var grupoId = event.target.getAttribute('data-grupo-id');
    var materiaId = event.target.getAttribute('data-materia-id');

    // Ahora puedes utilizar ambos IDs
    console.log(grupoId, materiaId);

    // Si necesitas redirigir a una nueva página con estos valores
 window.location.href = `materia_alum.php?grupo_id=${grupoId}&materia_id=${materiaId}`;
  });
});
</script>




</body>
</html>