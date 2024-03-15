<?php
// Recuperar los datos del alumno de la URL o del formulario
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Recuperar los datos del alumno de la URL si se envían por GET
    $numero = $_GET['numero'] ?? '';
    $matricula = $_GET['matricula'] ?? '';
    $nombre = $_GET['nombre'] ?? '';
    $aPaterno = $_GET['aPaterno'] ?? '';
    $aMaterno = $_GET['aMaterno'] ?? '';
    $idGrado = $_GET['idGrado'] ?? '';

    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "i27bg2hhV_", "bd_gestionescolar");

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Consulta SQL para obtener los datos de correo, dirección y teléfono según el número del alumno
    $sql = "SELECT correo, Direccion, Telefono FROM t_alumnos WHERE numero = $numero";
    $resultado = $conexion->query($sql);

    // Verificar si la consulta fue exitosa
    if ($resultado->num_rows > 0) {
        // Obtener los datos del alumno
        $fila = $resultado->fetch_assoc();
        $correo = $fila['correo'];
        $direccion = $fila['Direccion'];
        $telefono = $fila['Telefono'];
    } else {
        echo "No se encontraron datos para el alumno.";
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario si se envían por POST
    $numero = $_POST["numero"];
    $matricula = $_POST["matricula"];
    $nombre = $_POST["nombre"];
    $aPaterno = $_POST["aPaterno"];
    $aMaterno = $_POST["aMaterno"];
    $correo = $_POST["correo"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $idGrado = $_POST["idGrado"];

    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "i27bg2hhV_", "bd_gestionescolar");

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Consulta SQL para actualizar los datos del alumno
    $sql = "UPDATE t_alumnos SET matricula='$matricula', Nombre='$nombre', aPaterno='$aPaterno', aMaterno='$aMaterno', correo='$correo', Direccion='$direccion', Telefono='$telefono', idGrado='$idGrado' WHERE numero='$numero'";

    // Ejecutar la consulta
    if ($conexion->query($sql) === TRUE) {
        echo "Los datos del alumno se han actualizado correctamente.";
    } else {
        echo "Error al actualizar los datos del alumno: " . $conexion->error;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Estilos/style.css">
    <title>Modificar Alumno</title>
</head>
<body style="background-color: #212529; font-family:'Tw Cen MT Condensed'; color:white; text-align:center; ">

    <!--Botón Salida-->
    <nav  class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="frm_alumnos.php" id="Regresar"><img src="img/salida.png" alt="Regresar" style="width: 25px; padding-top: 0px; align-text:left;" title="Regresar">Regresar</a> 
        </div>
    </nav>

    <!--Formuario-->
    <div class="container" style="padding:5px;">
        <div class="row">
            <div class="col"></div>
                <div class="formu">
                    <!-- Encabezado -->
                    <h1>Modificar alumno</h1>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="row g-3">
                            <div class="col">
                                <input type="hidden" name="numero" value="<?php echo $numero; ?>" class="form-control" placeholder="Número" aria-label="Número" id="numero" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <input type="text" name="matricula" value="<?php echo $matricula; ?>" class="form-control" placeholder="Matricula" aria-label="Matricula" id="matricula" required>
                            </div>
                        </div>
                            <br>
                        <div class="row g-3">
                            <div class="col">
                                <input type="text" name="nombre" value="<?php echo $nombre; ?>" class="form-control" placeholder="Nombre" aria-label="Nombre" id="nombre" required>
                            </div>
                            <div class="col">
                                <input type="text" name="aPaterno" value="<?php echo $aPaterno; ?>" class="form-control" placeholder="Apellido Paterno" aria-label="Apellido Paterno" id="aPaterno" required>
                            </div>
                            <div class="col">
                                <input type="text" name="aMaterno" value="<?php echo $aMaterno; ?>" class="form-control" placeholder="Apellido Materno" aria-label="Apellido Materno" id="aMaterno" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <input type="text" name="correo" value="<?php echo $correo; ?>" class="form-control" placeholder="Correo" aria-label="Correo" id="correo">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <input type="text" name="direccion" value="<?php echo $direccion; ?>" class="form-control" placeholder="Direccion" aria-label="Direccion" id="direccion">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <input type="text" name="telefono" value="<?php echo $telefono; ?>" class="form-control" placeholder="Telefono" aria-label="Telefono" id="telefono">
                            </div>
                        </div>
                        <br>
                        <select class="form-select" aria-label="Default select example" id="idGrado" name="idGrado" required>
                            <option value="" selected disabled><?php echo $idGrado; ?></option>
                            <option value="1J">1J</option>
                            <option value="1K">1K</option>
                            <option value="2J">2J</option>
                            <option value="2K">2K</option>
                            <option value="3J">3J</option>
                            <option value="3K">3K</option>
                            <option value="4J">4J</option>
                            <option value="4K">4K</option>
                            <option value="5J">5J</option>
                            <option value="6J">6J</option>
                            <option value="6K">6K</option>
                            <option value="7J">7J</option>
                            <option value="7K">7K</option>
                            <option value="8J">8J</option>
                            <option value="8K">8K</option>
                            <option value="9J">9J</option>
                        </select>
                            <br>
                            <button type="submit" class="btn btn-primary">Modificar Alumno</button>
                    </form>
                </div>
            <div class="col"></div>
        </div>
</body>
</html>
