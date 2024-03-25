<?php
  // Iniciamos la sesión
  session_start();

  // Eliminamos todas las variables de la sesión
  $_SESSION = array();

  // Finalmente, destruimos la sesión
  session_destroy();

  // Redireccionamos al usuario a la página de inicio de sesión
  header("Location: index.php");
  exit;
?>
