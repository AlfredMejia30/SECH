<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "colegiohuetamo";

try {
    // Crear conexión PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configurar el modo de error de PDO a excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "¡Conexión exitosa!";
} catch(PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage();
} finally {
    // Cerrar conexión de manera segura
    $conn = null;
}
?>
<?php
session_start();
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']); // limpiar después de usarlo
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./estilos/estilos.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <title>Login</title>
</head>
<body>
  <div class="contanier text-center encabezado">
    <div class="row ">
      <div class="col ">
        <img class="logo float-start img-fluid  " src="./imagenes/logoSEP.png" alt="">
      </div>
      <div class="col text-center">
        <h1 class="tit">COLEGIO HUETAMO</h1>
      </div>
      <div class="col ">
        <img class="logoc img-fluid rounded" src="./imagenes/LogoColegio.png" height="25%" alt="">
      </div>
    </div>
  </div>
  <div class="card registro " style="width: 50%; margin-left: 25%; margin-top: 2%;">
    <div class="card-header reg ">
      <h3>Sistema de Evaluación Colegio Huetamo</h3>
    </div>
    <div class="row f1">
    <form action="login.php" method="post">
      <div class="col ">Usuario
          <input type="text" name="username" id="username" class="form-control cajita" placeholder="Usuario" aria-label="No.Control" />
      </div>
    </div>
    <div class="row f1">
      <div class="col">Contraseña
        <input type="password" id="password" name="password" class="form-control cajita" placeholder="Contraseña" aria-label="usuario" />
      </div>
    </div>
    <input type="submit" name="submit" value="Entrar" class="btn btn-primary btn-sm botoncito" />
  </div>
  </form>
</body>
</html>