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
            background-repeat: repeat; /* Repite la imagen de fondo */
            color: #333;
        }
        .navbar {
            background-color: rgba(255, 127, 80, 0.9); /* Fondo semitransparente */
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
            border: 3px solid #FF7F50; /* Resaltar con borde */
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
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="titulo">Hotel El Sol</div>
        <div class="nav-botones">
            <a href="index.php">Inicio</a>
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
                <form action="reservar_proceso.php" method="POST">
                    
                    <!-- Habitaciones -->
                    <label for="habitacion">Elige una habitación:</label>
                    <div class="habitaciones">
                        <div class="habitacion" id="habitacion1" onclick="selectOption('habitacion1')">
                            <img src="img/habitación1.jpg" alt="Habitación Estándar">
                            <label>Habitación Estándar</label>
                            <p class="precio">$100 por noche</p>
                        </div>
                        <div class="habitacion" id="habitacion2" onclick="selectOption('habitacion2')">
                            <img src="img/habitación2.jpg" alt="Vista al Mar">
                            <label>Vista al Mar</label>
                            <p class="precio">$150 por noche</p>
                        </div>
                        <div class="habitacion" id="habitacion3" onclick="selectOption('habitacion3')">
                            <img src="img/habitación3.jpg" alt="Suite de Lujo">
                            <label>Suite de Lujo</label>
                            <p class="precio">$300 por noche</p>
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
                            <p class="precio">$50</p>
                        </div>
                        <div class="servicio" id="buffet" onclick="selectOption('buffet')">
                            <img src="img/restaurante.jpg" alt="Buffet">
                            <label>Buffet</label>
                            <p class="precio">$30</p>
                        </div>
                        <div class="servicio" id="pedidos_ilimitados" onclick="selectOption('pedidos_ilimitados')">
                            <img src="img/pedidos.jpg" alt="Pedidos Ilimitados">
                            <label>Pedidos Ilimitados</label>
                            <p class="precio">$20</p>
                        </div>
                        <div class="servicio" id="todo_incluido" onclick="selectOption('todo_incluido')">
                            <img src="img/all.jpg" alt="Paquete Todo Incluido">
                            <label>Todo Incluido</label>
                            <p class="precio">$100</p>
                        </div>
                    </div>

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
        function selectOption(optionId) {
            // Alterna la clase 'active' en la opción seleccionada
            const option = document.getElementById(optionId);
            option.classList.toggle('active');
        }
    </script>
</body>
</html>
