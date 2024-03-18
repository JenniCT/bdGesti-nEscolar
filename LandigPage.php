<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#212529;
            margin: 0;
            padding: 0;
            color: white;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            text-align: center;
        }
        h1 {
            color: white;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido</h1>
        <p>¿Cómo desea acceder?</p>
        <a href="menuUsuarios.php" class="btn">Acceder como Administrador</a>
        <a href="login.php?type=user" class="btn">Acceder como Otro Usuario</a>
    </div>
</body>
</html>
