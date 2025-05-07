<?php
session_start();
require_once 'includes/conexion.php'; // Incluye la conexión correcta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $nombre_completo = $_POST['nombre_completo'];
    $contraseña = $_POST['contraseña'];
    $rol = $_POST['rol'];

    // Encriptar la contraseña antes de almacenarla
    $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT);

    // Preparar la consulta para insertar el nuevo usuario
    $stmt = $pdo->prepare("INSERT INTO usuario (nombre_usuario, contraseña, rol, nombre_completo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre_usuario, $contraseña_encriptada, $rol, $nombre_completo]);

    // Redirigir al login o mostrar mensaje de éxito
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Hotel El Sol</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Registrarse</h2>
            <form action="registro.php" method="POST">
                <label for="nombre_usuario">Nombre de usuario:</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" required><br><br>

                <label for="nombre_completo">Nombre completo:</label>
                <input type="text" id="nombre_completo" name="nombre_completo" required><br><br>

                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" required><br><br>

                <label for="rol">Rol:</label>
                <select name="rol" id="rol" required>
                    <option value="recepcionista">Recepcionista</option>
                    <option value="administrador">Administrador</option>
                </select><br><br>

                <button type="submit">Registrar</button>
            </form>

            <p>Ya tienes cuenta? <a href="index.php">Inicia sesión aquí</a></p>
        </div>
    </div>
</body>
</html>
