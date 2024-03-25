<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <title>Modificacion de Alumnos</title>
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
  <nav class="nav flex-column menu" style="float: left; margin-left: 2%; margin-top: 20px;">
  <a class="nav-link " href="admin.php">Inicio</a>  
  <a class="nav-link " href="regAlumno.php">Registrar</a>
    <a class="nav-link " href="../close.php">Salir</a>
  </nav>
  

  <div class="card registro text-center" style="margin-top: 60px; width: 75%; position: absolute; top: 50%; left: 45%; transform: translate(-50%, -50%);">
    <div class="card-header reg">
      <h3>Modificación de Alumnos</h3>
    </div>
    <input class="form-control me-2 busq" id="busqueda" type="search" placeholder="Buscar" aria-label="Buscar">
<form action="modiAlumnos.php" method="post" enctype="multipart/form-data">    
  <div class="row f1">
  <div class="col"> Número de control
  <input type="text" id="numeroControl" class="form-control" name="numeroControl" aria-label="No.Control">
  </div>
  <div class="col">Nombre
  <input type="text" id="nombre" class="form-control" name="nombre" aria-label="Nombre">
  </div>
  <div class="col">Primer Apellido
  <input type="text" id="apellido1" class="form-control" name="apellido1" aria-label="Apellido paterno">
  </div>
  <div class="col"> Segundo apellido
  <input type="text" id="apellido2" class="form-control" name="apellido2" aria-label="Apellido materno">
  </div>

  <input type="hidden" id="id_usuario" name="id_usuario">
  </div>
  
  <div class="row f1">
   
    <div class="col">Correo
      <input type="text" id="correo" class="form-control" name="correo" aria-label="Correo">
    </div>
    <div class="col">Contraseña
      <input type="text" id="password" class="form-control" name="password" aria-label="Contraseña">
    </div>
    <div class="col">Foto del Alumno
    <input type="file" class="form-control" name="foto" id="foto" accept="image/*">  
  </div>
  </div>
  <div class="botoncitos">
      <input class="button btn btn-primary btn-sm botoncito2" type="submit" name="deshacer" value="Deshacer" />
      <input class="button btn btn-primary btn-sm botoncito2" type="submit" name="submit" value="Guardar cambios"  />
      <input class="button btn btn-primary btn-sm botoncito2" style="background-color: rgb(87, 15, 15);" type="submit" name="eliminar" value="Eliminar" onclick="confirmDelete()" />
  </div>
  </div>
</form>
<script>
$(document).ready(function() {
    $('#busqueda').autocomplete({
        source: 'buscar_alumno.php',
        select: function(event, ui) {
            $.ajax({
                url: 'datos_alumno.php',
                data: { username: ui.item.value },
                dataType: 'json',
                type: 'get',
                success: function(data){
                    if(data.error){
                        alert(data.error);
                    } else {
                        $('#id_usuario').val(data.id_usuario);
                        $('#numeroControl').val(data.username);
                        $('#nombre').val(data.nombre);
                        $('#apellido1').val(data.primer_apellido);
                        $('#apellido2').val(data.segundo_apellido);
                        $('#correo').val(data.correo_electronico);
                    }
                },
                // Gestión de errores...
            });
        }
    });
    $('input[name="deshacer"]').on('click', function(e) {
        e.preventDefault();

        // Limpia los campos del formulario
        $('#id_usuario').val('');
        $('#numeroControl').val('');
        $('#nombre').val('');
        $('#apellido1').val('');
        $('#apellido2').val('');
        $('#correo').val('');
        $('#telefono').val('');
        $('foto').val('');
        // Limpia el campo de búsqueda
        $('#busqueda').val('');
    });
    $('form').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this); // Esto construirá FormData a partir del formulario
    formData.append('button', $(document.activeElement).val()); // Aquí obtienes el valor del botón presionado

    $.ajax({
        url: 'modiAlumnos.php',
        data: formData,
        dataType: 'json',
        type: 'post',
        contentType: false, // Esto es necesario para enviar archivos
        processData: false, // Esto es necesario para enviar archivos
        success: function(data){
            if(data.success) {
                alert(data.success);
                // Aquí puedes limpiar los campos del formulario si la operación fue exitosa
                $('#id_usuario').val('');
                $('#numeroControl').val('');
                $('#nombre').val('');
                $('#apellido1').val('');
                $('#apellido2').val('');
                $('#correo').val('');
                $('#telefono').val('');
                $('#password').val('');
                $('#busqueda').val('');
                $('#foto').val(''); // Esto limpiará el input del archivo
            } else if(data.error) {
                alert(data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('Ocurrió un error durante la actualización');
        }
    });
});

})
</script>

<script>
    function confirmDelete() {
        var confirmation = prompt("Por favor, escribe 'Confirmar' para eliminar al alumno.");

        if (confirmation === "Confirmar") {
            var id_usuario = $('#id_usuario').val();
            $.ajax({
                url: 'modiAlumnos.php',
                data: {
                    button: 'Eliminar',
                    id_usuario: id_usuario
                },
                dataType: 'json',
                type: 'post',
                success: function(data){
                    if(data.success) {
                        alert(data.success);
                        $('#id_usuario').val('');
                    $('#numeroControl').val('');
                    $('#nombre').val('');
                    $('#apellido1').val('');
                    $('#apellido2').val('');
                    $('#correo').val('');
                    $('#telefono').val('');
                    $('#password').val('');
                    $('#busqueda').val('');
                    } else if(data.error) {
                        alert(data.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('Ocurrió un error durante la eliminación');
                }
            });
        } else {
            alert("La eliminación del docente ha sido cancelada.");
        }
    }
</script>
</body>
</html>