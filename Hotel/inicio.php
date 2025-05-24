<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hotel El Sol - Bienvenido</title>
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
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        .card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 4px solid #FF7F50;
        }
        .card h3 {
            font-size: 24px;
            margin: 20px 0;
            color: #333;
        }
        .card p {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            padding: 0 15px;
        }
        .lista-servicios {
            list-style: none;
            padding: 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }
        .lista-servicios li {
            font-size: 18px;
            color: #555;
            display: flex;
            align-items: center;
        }
        .lista-servicios li::before {
            content: '✓';
            color: #FF7F50;
            margin-right: 10px;
        }
        .contacto-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            font-size: 18px;
            color: #333;
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
            <a href="reservar.php">Reservar</a>
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div>

    <!-- Hero Section -->
    <header class="hero">
        <div class="hero-texto">
            <h1>Escápate al Paraíso</h1>
            <p>Bienvenido al Hotel El Sol, frente a las playas de Cancún</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="contenedor-central">
        <!-- Habitaciones -->
        <section id="habitaciones" class="seccion">
            <h2>Habitaciones</h2>
            <div class="grid">
                <div class="card">
                    <img src="img/habitación1.jpg" alt="Habitación estándar">
                    <h3>Estándar</h3>
                    <p>Comodidad y precio accesible con vista al jardín.</p>
                </div>
                <div class="card">
                    <img src="img/habitación2.jpg" alt="Habitación con vista al mar">
                    <h3>Vista al Mar</h3>
                    <p>Despierta frente a las olas en nuestra habitación premium.</p>
                </div>
                <div class="card">
                    <img src="img/habitación3.jpg" alt="Suite de lujo">
                    <h3>Suite de Lujo</h3>
                    <p>Jacuzzi privado, terraza y todos los lujos que mereces.</p>
                </div>
            </div>
        </section>

        <!-- Servicios -->
        <section id="servicios" class="seccion">
            <h2>Servicios</h2>
            <ul class="lista-servicios">
                <li>Desayuno buffet incluido</li>
                <li>Piscina infinita frente al mar</li>
                <li>Acceso a playa privada</li>
                <li>Spa y masajes relajantes</li>
                <li>Wi-Fi gratis en todo el hotel</li>
            </ul>
        </section>

        <!-- Galería -->
        <section id="galeria" class="seccion">
            <h2>Galería</h2>
            <div class="grid">
                <div class="card">
                    <img src="img/piscina.jpg" alt="Piscina">
                    <h3>Piscina</h3>
                </div>
                <div class="card">
                    <img src="img/playa.jpg" alt="Playa privada">
                    <h3>Playa privada</h3>
                </div>
                <div class="card">
                    <img src="img/restaurante.jpg" alt="Restaurante">
                    <h3>Restaurante</h3>
                </div>
                <div class="card">
                    <img src="img/spa.jpg" alt="Spa">
                    <h3>Spa</h3>
                </div>
            </div>
        </section>

        <!-- Contacto -->
        <section id="contacto" class="seccion">
            <h2>Contacto</h2>
            <div class="contacto-info">
                <p>Teléfono: +52 814 213 7730</p>
                <p>Email: klausdepaepe@gmail.com</p>
                <p>Dirección: Blvd. Kukulcán, Zona Hotelera, Cancún, México</p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Hotel El Sol. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
