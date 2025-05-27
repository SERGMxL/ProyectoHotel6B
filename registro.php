<?php
session_start();
require_once 'includes/conexion.php'; // Make sure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'] ?? '';
    $nombre_completo = $_POST['nombre_completo'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';

    if ($nombre_usuario && $nombre_completo && $contraseña) {
        $rol = 'Usuario'; // Rol assigned automatically
        $hash = password_hash($contraseña, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO usuario (nombre_usuario, contraseña, rol, nombre_completo) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre_usuario, $hash, $rol, $nombre_completo]);

            // Optional: Log the user in immediately after registration
            // $_SESSION['user_id'] = $pdo->lastInsertId();
            // $_SESSION['nombre_usuario'] = $nombre_usuario;
            // $_SESSION['rol'] = $rol;

            header("Location: index.php"); // Redirect to login page after successful registration
            exit();
        } catch (PDOException $e) {
            // Check for duplicate entry error (e.g., if nombre_usuario is unique)
            if ($e->getCode() == '23000') { // Common SQLSTATE for integrity constraint violation
                $error = "El nombre de usuario ya existe. Por favor, elige otro.";
            } else {
                error_log("Database error during registration: " . $e->getMessage());
                $error = "Ocurrió un error al intentar registrarte. Por favor, inténtelo de nuevo más tarde.";
            }
        }
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
    <style>
        /* CSS Styles embedded here */
        body {
            font-family: Arial, sans-serif;
            /* --- Background Image Styles --- */
            background-image: url('img/playa.jpg'); /* <--- MAKE SURE THIS PATH IS CORRECT for your background image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            /* --- End Background Image Styles --- */

            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #fff;
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

        /* Styling for the role buttons, now they are links */
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

        /* Right Panel (Registration Form) */
        .form-contenedor.login-panel { /* Using login-panel to apply similar right-side styles */
            background-color: #fff; /* White background for the form part */
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
            max-width: 350px; /* Adjust max width for form elements */
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
            <p>Registrate para tener una cuenta y poder reservar una de nuestras lujosas habitaciones.</p>
            <a href="proteger_recepcionista.php" class="button-role">Recepción</a>
            <a href="proteger_admin.php" class="button-role">Administrador</a>
        </div>

        <div class="form-contenedor login-panel">
            <h2>Crear Cuenta</h2> <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="nombre_usuario">Nombre de usuario:</label>
                <input type="text" name="nombre_usuario" placeholder="Ej: micuenta123" required>

                <label for="nombre_completo">Nombre completo:</label>
                <input type="text" name="nombre_completo" placeholder="Ej: Juan Pérez" required>

                <label for="contraseña">Contraseña:</label>
                <input type="password" name="contraseña" placeholder="Mínimo 6 caracteres" required>

                <button type="submit">Registrarme</button> </form>
            <p>¿Ya tienes cuenta? <a href="index.php">Inicia sesión aquí</a></p> </div>
    </div>
</body>
</html>