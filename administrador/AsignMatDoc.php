<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <title>Asignación materias</title>
</head>
<body>


<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "colegiohuetamo";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Realizar la consulta
    $stmt1 = $conn->prepare("SELECT * FROM grupos");
    $stmt1->execute();
    $stmt = $conn->prepare("SELECT * FROM teacher");
    $stmt->execute();
    $stmt2 = $conn->prepare("SELECT materias.* FROM materias LEFT JOIN materia_grupo ON materias.id = materia_grupo.id_materia WHERE materia_grupo.id_materia IS NULL");
    $stmt2->execute();
     // obtener los grupos
    $materia= $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $grupos = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    $docente = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conn = null;
}
?>
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
  <nav class="nav flex-column menu"style="float: left; margin-left: 2%; margin-top: 20px;">
    <a class="nav-link " aria-current="page" href="usAdmi.php">Usuarios</a>
    <a class="nav-link " href="../close.php">Salir</a>
  </nav>
  <form action="AsigMat.php" method="post" > 
  <div  class="card registro text-center" style="margin-top: 60px; width: 75%; position: absolute; top: 50%; left: 45%; transform: translate(-50%, -50%);">
    <div class="card-header reg">
      <h3>Asignación de Materias</h3>
    </div>
    <div class="row f1">
        <div class="col">Materia  
        <select class="form-select form-select-sm mb-3 " name="materia" aria-label="Ejemplo de .form-select-lg">
    <?php foreach($materia as $materia): ?>
      <option value="<?php echo $materia['id']; ?>"><?php echo $materia['nombre']; ?></option>
    <?php endforeach; ?>
  </select>
      </div>
      <div class="col">Grado
      <select class="form-select form-select-sm mb-3 " name="grupo" aria-label="Ejemplo de .form-select-lg">
    <?php foreach($grupos as $grupo): ?>
      <option value="<?php echo $grupo['id']; ?>"><?php echo $grupo['nombre']; ?></option>
    <?php endforeach; ?>
  </select>
  </div>
  <div class="col">Docente
  <select class="form-select form-select-sm mb-3 " name="docente" aria-label="Ejemplo de .form-select-lg">
    <?php foreach($docente as $docente): ?>
      <option value="<?php echo $docente['id']; ?>"><?php echo $docente['nombre'] . " " . $docente['primer_apellido'] . " " . $docente['segundo_apellido']; ?>
</option>
    <?php endforeach; ?>
  </select>
</div>
      </div>
      <div class="botoncitos">
      <input id="seccion-destino" type="submit" name="submit" value="Asignar" class="btn btn-primary btn-sm botoncito" />
        </div>
  </div>  
    </form>
</body>
</html>