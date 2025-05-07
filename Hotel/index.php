<?php
session_start();
require 'includes/conexion.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Correo o contraseña incorrectos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Hotel El Sol</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Iniciar sesión</h2>
            <form action="index.php" method="POST">
                <?php if (isset($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required><br>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required><br>
                <button type="submit" class="btn">Iniciar sesión</button>
            </form>
            <p>No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>
