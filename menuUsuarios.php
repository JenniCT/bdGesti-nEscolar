<?php
session_start(); // Iniciar la sesión

// Establecer la conexión a la base de datos
$conexion = new mysqli("localhost", "root", "i27bg2hhV_", "bd_gestionescolar");

// Recuperar datos del formulario
$vcorreo = isset($_POST['correo']) ? $_POST['correo'] : "";
$vcontrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : "";

// Verificar la conexión
if ($conexion->connect_error) {
    die(json_encode(['success' => false, 'message' => 'La conexión falló: ' . $conexion->connect_error]));
}

// Consultar la base de datos
$sql = "SELECT * FROM usuarios WHERE correo = '$vcorreo'";
$result = $conexion->query($sql);

// Definir estilos dinámicamente
$inputStyle = isset($_SESSION['message']) ? 'border: 1px solid red;' : '';
$messageStyle = isset($_SESSION['message']) ? 'color: red;' : '';

if ($result) {
    // Verificar si se encontró un registro
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Comparar contraseñas
        if ($row['contrasena'] == $vcontrasena) {
            // Las contraseñas coinciden
            $_SESSION['message'] = '¡Inicio de sesión exitoso!';
            $_SESSION['correo_usuario'] = $vcorreo;  // Guardar el correo en la variable de sesión
            header('Location: frm_alumnos.php');
            exit();
        } else {
            // Las contraseñas no coinciden
            $_SESSION['message'] = 'Contraseña incorrecta';
        }
    } else {
        // No se encontró un usuario con ese correo
        $_SESSION['message'] = 'Correo no registrado';
    }
} else {
    // Error en la consulta
    $_SESSION['message'] = 'Error en la consulta: ' . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Estilos/style.css">
    <title>Usuarios</title>
</head>
<body>

    <!-- Formulario -->
    <div class="container" style="padding: 100px;">
        <div class="row">
            <div class="col"></div>
                <div class="formu">
                    <!-- Encabezado -->
                    <h1>Menú de usuario</h1>

                    <form action="" method="post" >
                        
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="nDirección de correo electrónico" name="correo" >
                            <label for="floatingInput" style="width: 100%">Dirección de correo electrónico</label>
                        </div>
                        
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="contrasena">
                            <label for="floatingPassword" style="width: 100%">Contraseña</label>
                        </div>

                        <?php
                        // Verificar si se envió el formulario y hay un error en el inicio de sesión
                            if (isset($_POST['correo']) && isset($_POST['contrasena']) && isset($_SESSION['message'])) {
                                echo '<p style="color:#DC3545;' . $messageStyle . '">' . $_SESSION['message'] . '</p>';
                                // Limpiar el mensaje para evitar que se muestre en cargas de página subsiguientes
                                unset($_SESSION['message']);
                            } else {
                                echo '';
                            }

                        ?>

                        <br><button type="submit" class="btn btn-primary">Entrar</button>

                    </form>
                </div>
            <div class="col"></div>
        </div>
    </div>
</body>
</html>