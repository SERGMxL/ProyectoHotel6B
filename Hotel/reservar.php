<?php
// Procesar el formulario solo si se envió por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = "localhost";
    $usuario = "root";
    $contrasena = ""; 
    $basedatos = "hotel";

    $conn = new mysqli($host, $usuario, $contrasena, $basedatos);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $habitacion = isset($_POST['habitacion']) ? $_POST['habitacion'] : '';
    $personas = isset($_POST['personas']) ? intval($_POST['personas']) : 0;
    $noches = isset($_POST['noches']) ? intval($_POST['noches']) : 0;
    $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : '';

    if (is_array($servicios)) {
        $servicios = implode(", ", $servicios);
    }

    if (empty($habitacion) || $personas <= 0 || $noches <= 0) {
        echo "<script>alert('Datos incompletos o inválidos.');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO reservas (habitacion, personas, noches, servicios) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siis", $habitacion, $personas, $noches, $servicios);

        if ($stmt->execute()) {
            $reserva_id = $conn->insert_id;
            // Mostramos el mensaje de éxito con emojis y botones
            $mensaje_exito = '
            <div id="mensaje-exito" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(152, 114, 145, 0.8); z-index: 1000; display: flex; justify-content: center; align-items: center;">
                <div style="background: white; padding: 30px; border-radius: 10px; text-align: center; max-width: 500px; width: 90%;">
                    <h2 style="color: #FF7F50; margin-bottom: 20px;">¡Listo!</h2>
                    <p style="font-size: 18px; margin-bottom: 30px;">✅ Has hecho tu reserva exitosamente</p>
                    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px;">
                        <a href="ver_ticket.php" style="background: #4CAF50; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                            🖨️ Imprimir Ticket
                        </a>
                        <a href="inicio.php" style="background: #FF7F50; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-size: 16px; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                            🏠 Volver a Inicio
                        </a>
                    </div>
                </div>
            </div>
            <script>
                // Ocultar el formulario después de enviarlo
                document.querySelector(".formulario-reserva").style.display = "none";
            </script>
            ';
            echo $mensaje_exito;
        } else {
            echo "<script>alert('Error al realizar la reserva: " . addslashes($stmt->error) . "');</script>";
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar - Hotel El Sol</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f1f1;
            background-image: url('img/fondo-tile.jpg');
            background-repeat: repeat;
            color: #333;
        }
        .navbar {
            background-color: rgba(255, 127, 80, 0.9);
            color: #fff;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar .titulo {
            font-size: 36px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .nav-botones a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            margin-left: 30px;
            text-transform: uppercase;
            transition: color 0.3s;
        }
        .nav-botones a:hover {
            color: #f39c12;
        }
        .hero {
            background-image: url('img/playa.jpg');
            background-size: cover;
            background-position: center;
            height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
        }
        .hero-texto {
            position: relative;
            z-index: 2;
        }
        .hero-texto h1 {
            font-size: 60px;
            margin-bottom: 15px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .hero-texto p {
            font-size: 20px;
            margin-bottom: 30px;
        }
        .contenedor-central {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }
        .seccion {
            margin-bottom: 60px;
        }
        h2 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            color: #FF7F50;
            text-transform: uppercase;
        }
        .formulario-reserva {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .habitaciones, .servicios {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }
        .habitacion, .servicio {
            width: 30%;
            text-align: center;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s;
        }
        .habitacion:hover, .servicio:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .habitacion img, .servicio img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.3s;
        }
        .habitacion.active, .servicio.active {
            border: 3px solid #FF7F50;
        }
        .precio {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }
        .formulario-reserva label {
            font-size: 18px;
            display: block;
            margin-bottom: 10px;
        }
        .formulario-reserva input, .formulario-reserva select {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .formulario-reserva button {
            background-color: #FF7F50;
            color: #fff;
            font-size: 18px;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        .formulario-reserva button:hover {
            background-color: #f39c12;
        }
        .informacion-extra {
            text-align: center;
            font-size: 18px;
            margin-top: 30px;
            color: #555;
        }
        footer {
            background-color: #FF7F50;
            color: #fff;
            text-align: center;
            padding: 30px 0;
        }
        footer p {
            font-size: 18px;
        }
        
        @media print {
            .navbar, .hero, footer, .informacion-extra, button {
                display: none !important;
            }
            .formulario-reserva {
                box-shadow: none;
                padding: 20px;
            }
            body {
                background: white;
                color: black;
                font-size: 14px;
            }
            h2 {
                color: black !important;
                font-size: 24px !important;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="titulo">Hotel El Sol</div>
        <div class="nav-botones">
            <a href="inicio.php">Inicio</a>
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div>

    <!-- Hero Section -->
    <header class="hero">
        <div class="hero-texto">
            <h1>Reserva Tu Estancia</h1>
            <p>Disfruta de unas vacaciones inolvidables en el Hotel El Sol</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="contenedor-central">
        <section id="reserva" class="seccion">
            <h2>Formulario de Reserva</h2>
            <div class="formulario-reserva">
                <form action="" method="POST">
                    
                    <!-- Habitaciones -->
                    <label for="habitacion">Elige una habitación:</label>
                    <div class="habitaciones">
                        <div class="habitacion" id="habitacion1" onclick="selectOption('habitacion1')">
                            <img src="img/habitación1.jpg" alt="Habitación Estándar">
                            <label>Habitación Estándar</label>
                            <p class="precio">$2300 por noche</p>
                        </div>
                        <div class="habitacion" id="habitacion2" onclick="selectOption('habitacion2')">
                            <img src="img/habitación2.jpg" alt="Vista al Mar">
                            <label>Vista al Mar</label>
                            <p class="precio">$3200 por noche</p>
                        </div>
                        <div class="habitacion" id="habitacion3" onclick="selectOption('habitacion3')">
                            <img src="img/habitación3.jpg" alt="Suite de Lujo">
                            <label>Suite de Lujo</label>
                            <p class="precio">$4000 por noche</p>
                        </div>
                    </div>

                    <!-- Número de personas -->
                    <label for="personas">Número de personas:</label>
                    <input type="number" id="personas" name="personas" min="1" max="10" required>

                    <!-- Número de noches -->
                    <label for="noches">Número de noches:</label>
                    <input type="number" id="noches" name="noches" min="1" max="30" required>

                    <!-- Servicios adicionales -->
                    <label for="servicios">Servicios adicionales:</label>
                    <div class="servicios">
                        <div class="servicio" id="spa" onclick="selectOption('spa')">
                            <img src="img/spa.jpg" alt="Spa">
                            <label>Spa</label>
                            <p class="precio">$1500</p>
                        </div>
                        <div class="servicio" id="buffet" onclick="selectOption('buffet')">
                            <img src="img/restaurante.jpg" alt="Buffet">
                            <label>Buffet</label>
                            <p class="precio">$1000</p>
                        </div>
                        <div class="servicio" id="pedidos_ilimitados" onclick="selectOption('pedidos_ilimitados')">
                            <img src="img/pedidos.jpg" alt="Pedidos Ilimitados">
                            <label>Pedidos Ilimitados</label>
                            <p class="precio">$800</p>
                        </div>
                        <div class="servicio" id="todo_incluido" onclick="selectOption('todo_incluido')">
                            <img src="img/all.jpg" alt="Paquete Todo Incluido">
                            <label>Todo Incluido</label>
                            <p class="precio">$12000</p>
                        </div>
                    </div>

                    <!-- Hidden inputs -->
                    <input type="hidden" name="habitacion" id="habitacionSeleccionada">
                    <input type="hidden" name="servicios[]" id="serviciosSeleccionados">

                    <!-- Botón de Enviar -->
                    <button type="submit">Reservar Ahora</button>
                </form>
            </div>
        </section>

        <div class="informacion-extra">
            <p>¿Tienes dudas? Contáctanos para más información.</p>
            <p>klausedepaepe@gmail.com</p>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Hotel El Sol. Todos los derechos reservados.</p>
    </footer>

    <script>
        let habitacionActual = "";
        const habitacionInput = document.getElementById('habitacionSeleccionada');
        const serviciosInput = document.getElementById('serviciosSeleccionados');

        function selectOption(optionId) {
            const element = document.getElementById(optionId);

            // Habitaciones
            if (optionId.startsWith("habitacion")) {
                // Desactivar todas
                document.querySelectorAll('.habitacion').forEach(el => el.classList.remove('active'));
                // Activar seleccionada
                element.classList.add('active');
                habitacionActual = optionId;
                habitacionInput.value = optionId;
            }

            // Servicios (pueden ser múltiples)
            else {
                element.classList.toggle('active');
                // Obtener todos los seleccionados
                const serviciosActivos = Array.from(document.querySelectorAll('.servicio.active')).map(el => el.id);
                serviciosInput.value = serviciosActivos.join(',');
            }
        }

        // Validación antes de enviar el formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!habitacionInput.value) {
                alert('Por favor selecciona una habitación');
                e.preventDefault();
                return false;
            }
            
            if (!document.getElementById('personas').value || !document.getElementById('noches').value) {
                alert('Por favor completa todos los campos requeridos');
                e.preventDefault();
                return false;
            }
            
            return true;
        });
    </script>
</body>
</html>