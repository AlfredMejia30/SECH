<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <title>Registro de Docentes</title>
</head>
<body>

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
    <a class="nav-link " aria-current="page" href="./usAdmi.php">Atras</a>
    <a class="nav-link " href="modDocentes.php">Modificar</a>
    <a class="nav-link " href="./vista_grupos.php">Reportes</a>
    <a class="nav-link " href="./AsignMatDoc.php">Asignar Materias</a>
    <a class="nav-link " href="../close.php">Salir</a>

  </nav>
  
  <form action="registDocentes.php" method="post" >
   <div class="card registro text-center" style="margin-top: 60px; width: 75%; position: absolute; top: 50%; left: 45%; transform: translate(-50%, -50%);">
    <div class="card-header reg">
      <h3>Registro de Docentes</h3>
    </div>
    <div class="row f1">
    <div class="col">No. usuario
      <input type="text" class="form-control" name="noUsuario" aria-label="No.Control">
    </div>
    <div class="col">Nombre
      <input type="text" class="form-control" name="nombre" aria-label="Nombre">
    </div>
    <div class="col">Primer apellido
      <input type="text" class="form-control" name="primerApellido" aria-label="Apellido paterno">
    </div>
    <div class="col">Segundo apellido
      <input type="text" class="form-control" name="segundoApellido" aria-label="Apellido materno">
    </div>
    
    </div>
  
    <div class="row f1">
   
    <div class="col">Correo
      <input type="text" class="form-control" name="correo" aria-label="Correo">
    </div>
    <div class="col">Contraseña
      <input type="text" class="form-control" name="contrasena" aria-label="Contraseña">
    </div>
    <div class="col"> No.Cel
      <input type="text" class="form-control" name="telefono" aria-label="Cel">
    </div>
    <div class="col">Nivel de estudio
      <input type="text" class="form-control" name="nivelEstudios" aria-label="grado de estudio">
    </div> 
    </div>
    <input id="seccion-destino" type="submit" name="submit" value="Guardar" class="btn btn-primary btn-sm botoncito" />
   </div>
  </form>
</body>
</html>