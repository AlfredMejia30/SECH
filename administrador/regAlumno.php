<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Registro de alumnos</title>
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
    $stmt = $conn->prepare("SELECT * FROM grupos");
    $stmt->execute();
    $grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
  <a class="nav-link " href="usAdmi.php">Atras</a>  
  <a class="nav-link " href="modAlumno.php">Modificar</a>
  <a class="nav-link " href="../close.php">Salir</a>
  </nav>  
<form action="registAlumn.php" id="aña" method="post" enctype="multipart/form-data">
  <div class="card registro text-center" style="margin-top: 60px; width: 75%; position: absolute; top: 50%; left: 45%; transform: translate(-50%, -50%);">
    <div class="card-header reg">
      <h3>Registro del Alumno</h3>
    </div>
  <div class="row f1">
    <div class="col">No. Control
      <input type="text" name="noControl" class="form-control"  required aria-label="No.Control">
    </div>
    <div class="col">CURP
    <input type="text" name="curp" class="form-control" style="text-transform: uppercase;" required pattern="[A-Z]{4}\d{6}[HM]{1}[A-Z]{2}[B-D|F-H|J-K|M-N|P-Q|R-T|V-Z]{3}\d{2}" aria-label="CURP">
</div>
    <div class="col">Nombre
      <input type="text" name="name" class="form-control"  required aria-label="Nombre">
    </div>
    <div class="col">Primer apellido
      <input type="text" name="firstLastname" class="form-control"  required aria-label="Apellido paterno">
    </div>
    <div class="col">Segundo apellido
      <input type="text" name="secundLastname" class="form-control"  required aria-label="Apellido materno">
    </div>
  </div>
  <div class="row f1">
    <div class="col">Correo
    <input type="email" name="email" class="form-control" required pattern="[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+" aria-label="Correo">
    </div>
    <div class="col">Contraseña
    <input type="password" name="password" class="form-control" required pattern=".{8,}" aria-label="Contraseña">
      </div> 
    <div class="col">Grupo
    <select class="form-select form-select-sm mb-3 " name="grupo" aria-label="Ejemplo de .form-select-lg">
    <?php foreach($grupos as $grupo): ?>
      <option value="<?php echo $grupo['nombre']; ?>"><?php echo $grupo['nombre']; ?></option>
    <?php endforeach; ?>
  </select>
    </div>   
  </div>
  <a href="#seccion-destino" class="btn btn-primary btn-sm botoncito">Siguiente</a>
  </div>
    <div class="card registro text-center" style="margin-top: 50%; width: 75%; left: 45%;  transform: translate(-50%, -50%);" >
    <div class="card-header reg">
      <h3>Registro del Tutor</h3>
    </div>
  <div class="row f1">
    <div class="col">No. Usuario
      <input type="text" class="form-control" name="noUsuario" required aria-label="No.Usuario">
    </div>
    <div class="col">Nombre
      <input type="text" class="form-control" name="nombreTutor" required aria-label="Nombre">
    </div>
    <div class="col">Primer apellido
      <input type="text" class="form-control" name="primerApellidoTutor" required aria-label="Apellido paterno">
    </div>
    <div class="col">Segundo apellido
      <input type="text" class="form-control" name="segundoApellidoTutor" required aria-label="Apellido materno">
    </div>
  </div>
  <div class="row f1">
    <div class="col">No. Cel
      <input type="text" class="form-control" name="telefono" required pattern="[0-9]{10}" aria-label="Numero Cel">
    </div>
    <div class="col">Contraseña
      <input type="text" class="form-control" name="passwordTutor" required pattern=".{8,}" aria-label="Contraseña">
    </div>
  </div>
  <input id="seccion-destino" type="submit" name="submit" value="Guardar" class="btn btn-primary btn-sm botoncito" />
  </div>
</form>
</body>
</html>