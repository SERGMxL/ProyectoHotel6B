<?php
session_start();
require_once 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['nombre_usuario'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombre_usuario = ?");
    $stmt->execute([$usuario]);
    $usuario_db = $stmt->fetch();

    if ($usuario_db && password_verify($contraseña, $usuario_db['contraseña'])) {
        $_SESSION['user_id'] = $usuario_db['id_usuario'];
        $_SESSION['nombre_usuario'] = $usuario_db['nombre_usuario'];
        $_SESSION['rol'] = $usuario_db['rol'];
        header("Location: inicio.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Hotel El Sol</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="form-contenedor">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="nombre_usuario">Nombre de usuario:</label>
            <input type="text" name="nombre_usuario" required>

            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" required>

            <button type="submit">Entrar</button>
        </form>

        <!-- Botón para acceder a la verificación de admin -->
        <form method="GET" action="proteger_admin.php" style="margin-top: 10px;">
            <button type="submit">Acceso Admin</button>
        </form>

        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
