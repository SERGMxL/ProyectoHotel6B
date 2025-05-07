<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva - Hotel El Sol</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .formulario-reserva h2 {
            text-align: center;
        }

        .card input[type="radio"] {
            display: none;
        }

        .card input[type="radio"]:checked + img {
            outline: 4px solid #ffa500;
            border-radius: 10px;
        }

        .card input[type="radio"]:checked ~ h3,
        .card input[type="radio"]:checked ~ p {
            color: #ffa500;
            font-weight: bold;
        }

        .formulario-reserva {
            margin-top: 50px;
        }

        .grid .card {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="titulo">Hotel El Sol</div>
        <div class="nav-botones">
            <a href="inicio.php">Inicio</a>
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div>

    <header class="hero">
        <div class="hero-texto">
            <h1>Reserva tu Estancia</h1>
            <p>Completa los datos para asegurar tu lugar en el paraíso</p>
        </div>
    </header>

    <main class="contenedor-central">
        <form action="procesar_reserva.php" method="POST" class="formulario-reserva">
            <h2>Selecciona tu habitación</h2>
            <div class="grid">
                <label class="card">
                    <input type="radio" name="habitacion" value="Estandar" required>
                    <img src="img/habitación1.jpg" alt="Habitación Estándar">
                    <h3>Estándar</h3>
                    <p>Comodidad básica con vista al jardín.</p>
                    <p>Cupo maximo 2 Personas.</p>
                    <p><strong>Precio: $800 MXN por noche</strong></p>
                </label>

                <label class="card">
                    <input type="radio" name="habitacion" value="Vista al Mar">
                    <img src="img/habitación2.jpg" alt="Habitación Vista al Mar">
                    <h3>Vista al Mar</h3>
                    <p>Despierta frente a las olas.</p>
                    <p>Cupo maximo 4 Personas.</p>
                    <p><strong>Precio: $1200 MXN por noche</strong></p>
                </label>

                <label class="card">
                    <input type="radio" name="habitacion" value="Suite de Lujo">
                    <img src="img/habitación3.jpg" alt="Suite de Lujo">
                    <h3>Suite de Lujo</h3>
                    <p>Jacuzzi privado y terraza.</p>
                    <p>Cupo maximo 6 Personas.</p>
                    <p><strong>Precio: $2000 MXN por noche</strong></p>
                </label>
            </div>

            <h2>Detalles de la Reserva</h2>
            <label for="personas">Número de Personas:</label>
            <input type="number" name="personas" id="personas" min="1" max="9" required><br><br>

            <label for="noches">Número de Noches:</label>
            <input type="number" name="noches" id="noches" min="1" required><br><br>

            <fieldset>
                <legend>Servicios adicionales:</legend>
                <label><input type="checkbox" name="servicios[]" value="spa"> Spa (+$500)</label><br>
                <label><input type="checkbox" name="servicios[]" value="buffet"> Acceso buffet (+$300 por día)</label><br>
                <label><input type="checkbox" name="servicios[]" value="room_service"> Servicio ilimitado a la habitación (+$400)</label><br>
                <label><input type="checkbox" name="servicios[]" value="todo_incluido"> Todo Incluido (ahorra 15%)</label>
                <legend>*Todos los precios son por acceso en el tiempo de estancia en el hotel*</legend>
            </fieldset>

            <br>
            <button type="submit" class="btn">Confirmar Reserva</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 Hotel El Sol. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
