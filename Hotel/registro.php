<?php
session_start();
require_once 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'] ?? '';
    $nombre_completo = $_POST['nombre_completo'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';

    if ($nombre_usuario && $nombre_completo && $contraseña) {
        $rol = 'recepcionista'; // Rol asignado automáticamente
        $hash = password_hash($contraseña, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO usuario (nombre_usuario, contraseña, rol, nombre_completo) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre_usuario, $hash, $rol, $nombre_completo]);

        header("Location: index.php");
        exit();
    } else {
        $error = "Completa todos los campos.";
    }
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
    <div class="form-contenedor">
        <h2>Registro</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="nombre_usuario">Nombre de usuario:</label>
            <input type="text" name="nombre_usuario" required>

            <label for="nombre_completo">Nombre completo:</label>
            <input type="text" name="nombre_completo" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" required>

            <button type="submit">Registrar</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="index.php">Inicia sesión</a></p>
    </div>
</body>
</html>
