<?php
session_start();
require_once 'includes/conexion.php'; // Make sure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['nombre_usuario'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombre_usuario = ?");
        $stmt->execute([$usuario]);
        $usuario_db = $stmt->fetch();

        if ($usuario_db && password_verify($contraseña, $usuario_db['contraseña'])) {
            $_SESSION['user_id'] = $usuario_db['id_usuario'];
            $_SESSION['nombre_usuario'] = $usuario_db['nombre_usuario'];
            $_SESSION['rol'] = $usuario_db['rol'];
            header("Location: inicio.php"); // Redirect on successful login
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $error = "Ocurrió un error al intentar iniciar sesión. Por favor, inténtelo de nuevo más tarde.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Hotel El Sol</title>
    <style>
        /* estilos.css */

        body {
            font-family: Arial, sans-serif;
            /* --- Background Image Styles --- */
            background-image: url('img/playa.jpg'); /* <--- CHANGE THIS PATH to your image */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Do not repeat the image */
            background-attachment: fixed; /* Make the background fixed when scrolling (optional) */
            /* --- End Background Image Styles --- */

            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Full viewport height */
            margin: 0;
            color: #fff; /* Default text color, used for left panel */
        }

        .main-container {
            display: flex;
            background-color: rgba(255, 255, 255, 0.95); /* Slightly transparent white for the form block */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            max-width: 900px;
            width: 100%;
        }

        .left-panel {
            background-color: #3b8a6a; /* Greenish background from the left panel of the image */
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
            width: 40%;
            flex-shrink: 0;
        }

        .left-panel h1 {
            font-size: 2.8em;
            margin-bottom: 10px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .left-panel p {
            font-size: 1.1em;
            margin-bottom: 40px;
            line-height: 1.4;
        }

        .button-role {
            background-color: #fff;
            color: #333;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            margin: 10px 0;
            width: 200px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
            border: none;
            text-decoration: none;
            display: block;
        }

        .button-role:hover {
            background-color: #f0f0f0;
            transform: translateY(-2px);
        }

        /* Right Panel (Login Form) */
        .form-contenedor.login-panel {
            background-color: #fff; /* White background for the login part */
            padding: 30px 40px;
            width: 60%;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #333;
        }

        .form-contenedor.login-panel h2 {
            color: #333;
            text-align: left;
            width: 100%;
            margin-bottom: 25px;
            font-size: 1.8em;
            font-weight: bold;
        }

        .error {
            color: #ffe0e0;
            background-color: #c0392b;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-weight: bold;
            width: 100%;
            text-align: center;
        }

        .form-contenedor.login-panel form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
            max-width: 350px;
            margin-bottom: 20px;
        }

        .form-contenedor.login-panel label {
            color: #555;
            text-align: left;
            font-weight: normal;
            margin-top: 5px;
        }

        .form-contenedor.login-panel input[type="text"],
        .form-contenedor.login-panel input[type="password"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            font-size: 1em;
            outline: none;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-contenedor.login-panel input[type="text"]::placeholder,
        .form-contenedor.login-panel input[type="password"]::placeholder {
            color: #aaa;
        }

        .form-contenedor.login-panel button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            width: 100%;
        }

        .form-contenedor.login-panel button[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-contenedor.login-panel p {
            color: #777;
            margin-top: 10px;
            font-size: 0.9em;
        }

        .form-contenedor.login-panel p a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .form-contenedor.login-panel p a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        /* Optional: Adjust for smaller screens */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                max-width: 90%;
            }

            .left-panel, .form-contenedor.login-panel {
                width: 100%;
                border-radius: 10px;
            }

            .left-panel {
                padding-bottom: 20px;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }

            .form-contenedor.login-panel {
                padding-top: 20px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="left-panel">
            <h1>Hotel del Sol</h1>
            <p>Inicia sesión y reserva ya!</p>
            <a href="proteger_recepcionista.php" class="button-role">Recepción</a>
            <a href="proteger_admin.php" class="button-role">Administrador</a>
        </div>

        <div class="form-contenedor login-panel">
            <h2>Bienvenido Cliente</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="nombre_usuario">Email</label>
                <input type="text" name="nombre_usuario" placeholder="ejemplo123" required>

                <label for="contraseña">Contraseña</label>
                <input type="password" name="contraseña" required>

                <button type="submit">Iniciar Sesión</button>
            </form>

            <p><a href="recuperar_contrasena.php">¿Olvidaste tu contraseña?</a></p>

            <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>