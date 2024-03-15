<?php
session_start();

$conexion = new mysqli("localhost", "root", "i27bg2hhV_", "bd_gestionescolar");

// Verificar si hay una sesión activa y si la variable de sesión correo_usuario está definida
if (isset($_SESSION['correo_usuario'])) {
    $correo_usuario = $_SESSION['correo_usuario'];
} else {
    // Redirigir si no hay una sesión activa o la variable de sesión no está definida
    header('Location: menuUsuarios.php');
    exit();
}

/// Función para eliminar un alumno por su número
function eliminarAlumno($conexion, $numero) {
    $sql = "DELETE FROM t_alumnos WHERE numero = $numero";
    $result = $conexion->query($sql);

    return $result;
}

// Verificar si se ha enviado el formulario de eliminación
if (isset($_POST['btnEliminar']) && isset($_POST['numero'])) {
    $numero_a_eliminar = $_POST['numero'];
    if (eliminarAlumno($conexion, $numero_a_eliminar)) {
        $_SESSION['message'] = 'Alumno eliminado correctamente.';
    } else {
        $_SESSION['message'] = 'Error al eliminar el alumno.';
    }
}


    // Definir la función de consulta
    function consulta($t_alumnos, $conexion, $filtro) {
    // Realizar la consulta a la base de datos con el filtro
    $sql = "SELECT * FROM t_alumnos WHERE matricula LIKE '%$filtro%' OR nombre LIKE '%$filtro%' OR aPaterno LIKE '%$filtro%' OR numero LIKE '%$filtro%' OR idGrado LIKE '%$filtro%'";
    $result = $conexion->query($sql);

    // Verificar si la consulta fue exitosa
    if ($result) {
        $resultados = array();

        // Obtener los resultados como un array asociativo
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row;
        }

        return $resultados;
    } else {
        // Manejar el error si la consulta falla
        echo "Error en la consulta: " . $conexion->error;
        return array();
    }
}


// Verificar si se envió el formulario de búsqueda
if (isset($_POST['btnBuscar'])) {
    $filtro = $_POST['buscar'];
    $registros = consulta("t_alumnos", $conexion, $filtro);
} else {
    // Si no se envió la búsqueda, mostrar todos los registros
    $registros = consulta("t_alumnos", $conexion, '');
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Estilos/frm_alumnos.css">
    <title>Alumnos</title>
</head>
<body>

    <!------Encabezado-->
    <header> 
        <h1 style="font-size:18px; text-align:center; padding-top: 20px; color:white;"> REGISTRO DE ALUMNOS</h1>
    </header>

    <!------opciones de menú-->
    <nav  class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand">
                <p style="font-size:15px">Bienvenido, <?php echo $correo_usuario; ?>.</p>
            </a>
            <form class="d-flex" role="search" method="post" action="frm_alumnos.php"> <!-- Agregado el método y la acción -->

                <input style="font-size:14px" class="form-control me-1" type="search" placeholder="Buscar" aria-label="Search" name="buscar">
                
                <button style=" margin-right: 10px; font-size:14px" class="btn btn-outline-success" type="submit" name="btnBuscar">Buscar</button>
                
                <a  style="font-size:14px" href="ReporteGeneral.php" id="ReporteG" class="btn btn-outline-info" title="ReporteG">Reporte</a>

                <a  style="font-size:14px" href="agregarAlumno.php" id="Añadir" class="btn btn-outline-primary" title="Añadir">Añadir</a>
                
                <a href="menuUsuarios.php" id="Salir"><img src="img/salida.png" alt="Salir" style="width: 25px; padding-top:5px" title="Salir"></a> 

                
            </form>
        </div>
    </nav>

    
    <!--cuerpo de la página-->
    <table>
        <tr>
            <th>Número</th>
            <th>Matrícula</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Grado y Grupo</th>
            <th>Modificar</th>
            <th>Eliminar</th>
            <th>Reporte</th>
        </tr>
        <?php
        
            $numero = 1;

            foreach ($registros as $registro) {
                echo "<tr>";
                echo "<td>" . $registro['numero'] . "</td>";
                echo "<td>" . $registro['Matricula'] . "</td>";
                echo "<td>" . $registro['Nombre'] . "</td>";
                echo "<td>" . $registro['aPaterno'] . "</td>";
                echo "<td>" . $registro['aMaterno'] . "</td>";
                echo "<td>" . $registro['idGrado'] . "</td>";
                echo "<td> <a class='btn btn-outline-warning' href='modificarAlumno.php?numero=" . $registro['numero'] . "&matricula=" . $registro['Matricula'] . "&nombre=" . $registro['Nombre'] . "&aPaterno=" . $registro['aPaterno'] . "&aMaterno=" . $registro['aMaterno'] . "&idGrado=" . $registro['idGrado'] . "' style='padding:4px; font-size:14px'>Modificar</a>
                </td>";
                echo "<td>
                <form method='post' action='frm_alumnos.php'>
                    <input type='hidden' name='numero' value='" . $registro['numero'] . "'>
                    <button class='btn btn-outline-danger' type='submit' name='btnEliminar' style='padding:4px; font-size:14px'>Eliminar</button>
                </form>
                </td>";
                echo "<td><a class='btn btn-outline-info' href='ReporteAlumno.php?numero=" . $registro['numero'] . "&matricula=" . $registro['Matricula'] . "&nombre=" . $registro['Nombre'] . "&aPaterno=" . $registro['aPaterno'] . "&aMaterno=" . $registro['aMaterno'] . "&idGrado=" . $registro['idGrado'] . "' style='padding:4px; font-size:14px'>Reporte</a></td>";

                $numero = $numero + 1;
                echo "</tr>";
            }

            // Cerrar la conexión a la base de datos
            $conexion->close();
        ?>
    </table>
    
    

</body>
</html>
