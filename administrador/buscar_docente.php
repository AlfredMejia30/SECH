    <?php
    include 'conexion.php';

    $search = $_GET['term'];

    $stmt = $conn->prepare("SELECT username FROM usuarios WHERE role = 'Docente' AND username LIKE ?");
    $search_param = "%{$search}%"; 
    $stmt->bind_param('s', $search_param);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $alumnos = array();
    while($fila = $resultado->fetch_assoc()){
        $alumnos[] = $fila['username'];
    }

    echo json_encode($alumnos);
    ?>
