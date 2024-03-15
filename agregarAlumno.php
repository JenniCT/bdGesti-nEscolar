<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Estilos/style.css">
    <title>Agregar Alumno</title>
</head>
<body style="background-color: #212529; font-family:'Tw Cen MT Condensed'; color:white; text-align:center; ">

    <!--Botón Salida-->
    <nav  class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="frm_alumnos.php" id="Regresar"><img src="img/salida.png" alt="Regresar" style="width: 25px; padding-top: 2px; align-text:left;" title="Regresar">Regresar</a> 
        </div>
    </nav>

    <!--Formuario-->
    <div class="container" style="padding: 10px;">
        <div class="row">
            <div class="col"></div>
                <div class="formu">
                    <!-- Encabezado -->
                    <h1>Agregar nuevo alumno</h1>

                    <form action="" method="post">
                        <div class="row g-3">
                            <div class="col">
                                <input type="number" class="form-control" placeholder="Número" aria-label="Número" id="numero" name="numero" required>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Matricula" aria-label="Matricula" id="matricula" name="matricula" required>
                            </div>
                        </div>
                            <br>
                        <div class="row g-3">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Nombre" aria-label="Nombre" id="nombre" name="nombre" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Apellido Paterno" aria-label="Apellido Paterno" id="aPaterno" name="aPaterno" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Apellido Materno" aria-label="Apellido Materno" id="aMaterno" name="aMaterno" required>
                            </div>
                        </div>
                        <br>
                        <select class="form-select" aria-label="Default select example" id="idGrado" name="idGrado" required>
                            <option value="" selected disabled>Grado y Grupo</option>
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
                            <button type="submit" class="btn btn-primary">Agregar Alumno</button>
                    </form>
                    <?php
                    // Verificamos si se ha enviado el formulario
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        // Crear conexión
                        $conexion = new mysqli("localhost", "root", "i27bg2hhV_", "bd_gestionescolar");

                        // Verificar conexión
                        if ($conexion->connect_error) {
                            die("Error en la conexión: " . $conexion->connect_error);
                        }

                        // Obtener los datos del formulario
                        $matricula = $_POST["matricula"];
                        $nombre = $_POST["nombre"];
                        $aPaterno = $_POST["aPaterno"];
                        $aMaterno = $_POST["aMaterno"];
                        $idGrado = $_POST["idGrado"];

                        // Verificar si la matrícula ya existe en la base de datos
                        $consulta = "SELECT nombre, aPaterno, aMaterno FROM t_alumnos WHERE matricula = '$matricula'";
                        $resultado = $conexion->query($consulta);

                        if ($resultado->num_rows > 0) {
                            // La matrícula ya existe, obtener el nombre del alumno
                            $fila = $resultado->fetch_assoc();
                            $nombreExistente = $fila["nombre"] . " " . $fila["aPaterno"] . " " . $fila["aMaterno"];
                            echo "<p style='color:red; font-size:16px;'>'$matricula' ¡Ya existe! <br> Pertenece a:  $nombreExistente.</p>";
                        } else {
                            // Preparar la consulta SQL para insertar el alumno
                           // Obtener el número ingresado en el formulario
                            $numero = $_POST["numero"];

                            // Preparar la consulta SQL para insertar el alumno
                            $sql = "INSERT INTO t_alumnos (numero, matricula, nombre, aPaterno, aMaterno, idgrado) VALUES ('$numero', '$matricula', '$nombre', '$aPaterno', '$aMaterno', '$idGrado')";


                            if ($conexion->query($sql) === TRUE) {
                                echo "Alumno agregado correctamente.";
                            } else {
                                echo "Error al agregar el alumno: " . $conexion->error;
                            }
                        }

                        // Cerrar conexión
                        $conexion->close();
                    }
                    ?>

                </div>
            <div class="col"></div>
        </div>
</body>
</html>

