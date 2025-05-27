<?php
session_start();

// --- Configuration for Email ---
// IMPORTANT: Corrected the typo in the email address.
$to_email = 'klausdepaepe@gmail.com'; // <--- CORRECTED: Removed extra ".com"
$subject_prefix = 'Problema de Contraseña - Hotel El Sol: ';
$from_email = 'serchortcast@gmail.com'; // Ensure this matches your sendmail.ini auth_username for Gmail

$message_sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'] ?? '';
    $problema_descripcion = $_POST['problema_descripcion'] ?? '';

    if (!empty($nombre_usuario) && !empty($problema_descripcion)) {
        $subject = $subject_prefix . 'Solicitud de recuperación de: ' . $nombre_usuario;
        $body = "Se ha recibido una solicitud de recuperación de contraseña.\n\n";
        $body .= "Nombre de usuario: " . $nombre_usuario . "\n\n";
        $body .= "Descripción del problema:\n" . $problema_descripcion . "\n\n";
        $body .= "--- Fin de la solicitud ---";

        $headers = 'From: ' . $from_email . "\r\n" .
                   'Reply-To: ' . $from_email . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        // Attempt to send the email
        if (mail($to_email, $subject, $body, $headers)) {
            $message_sent = true;
        } else {
            $error = "Error al enviar el correo. Por favor, inténtelo de nuevo más tarde. Verifique la configuración de su servidor de correo.";
            // It's still good practice to uncomment this for detailed server-side error logging:
            // error_log("Failed to send recovery email to " . $to_email . ": " . (error_get_last()['message'] ?? 'Unknown error'));
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña - Hotel El Sol</title>
    <style>
        /* CSS Styles embedded here (replicated from your login/register pages) */
        body {
            font-family: Arial, sans-serif;
            background-image: url('img/playa.jpg'); /* Make sure this path is correct */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
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

        /* Removed button-role from this specific page as they don't fit the context */
        /* If you still want content here, you might put a logo or a single "Back to Login" link */
        /* .button-role {
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
        } */

        /* Right Panel (Recovery Form) */
        .form-contenedor.login-panel {
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

        .success-message {
            color: #e6ffe6;
            background-color: #28a745;
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
        .form-contenedor.login-panel textarea {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            font-size: 1em;
            outline: none;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            resize: vertical;
            min-height: 80px;
        }

        .form-contenedor.login-panel input[type="text"]::placeholder,
        .form-contenedor.login-panel textarea::placeholder {
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
            <h1>¡Oh no!</h1>
            <p>Parece que tienes problemas para acceder.</p>
            <p>Describe tu situación y te ayudaremos a recuperarla.</p>
            </div>

        <div class="form-contenedor login-panel">
            <h2>¿Olvidaste tu Contraseña?</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if ($message_sent): ?>
                <p class="success-message">¡Solicitud enviada! Nos pondremos en contacto contigo pronto.</p>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="nombre_usuario">Tu Nombre de Usuario o Email:</label> <input type="text" name="nombre_usuario" placeholder="Ej: micuenta123 o tu@email.com" required>

                <label for="problema_descripcion">Describe tu problema:</label>
                <textarea name="problema_descripcion" placeholder="Ej: No recuerdo mi contraseña o mi cuenta está bloqueada." rows="5" required></textarea>

                <button type="submit">Enviar Solicitud</button>
            </form>
            <p>¿Recordaste tu contraseña? <a href="index.php">Volver a Iniciar Sesión</a></p>
        </div>
    </div>
</body>
</html>