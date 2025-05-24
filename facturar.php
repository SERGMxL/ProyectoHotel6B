<?php
// Configuración de la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "hotel";

// Establecer conexión
$conn = new mysqli($host, $usuario, $contrasena, $basedatos);
if ($conn->connect_error) {
    die("<div class='error'>Error de conexión: " . $conn->connect_error . "</div>");
}

// Obtener ID de reserva desde la URL
$reserva_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Precios de habitaciones y servicios
$precios = [
    'habitaciones' => [
        'habitacion1' => 100,
        'habitacion2' => 150,
        'habitacion3' => 300
    ],
    'servicios' => [
        'spa' => 50,
        'buffet' => 30,
        'pedidos_ilimitados' => 20,
        'todo_incluido' => 100
    ]
];

// Variables para controlar el flujo
$mostrar_formulario = true;
$mensaje_exito = '';

// Procesar generación de factura
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generar_factura'])) {
    $metodo_pago = $conn->real_escape_string($_POST['metodo_pago']);
    $detalles = $conn->real_escape_string($_POST['detalles']);
    
    // Obtener datos de la reserva
    $query_reserva = "SELECT * FROM reservas WHERE id = ?";
    $stmt = $conn->prepare($query_reserva);
    $stmt->bind_param("i", $reserva_id);
    $stmt->execute();
    $reserva = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    
    if ($reserva) {
        // Calcular totales
        $subtotal_habitacion = $precios['habitaciones'][$reserva['habitacion']] * $reserva['noches'];
        
        $servicios = explode(", ", $reserva['servicios']);
        $subtotal_servicios = 0;
        foreach ($servicios as $servicio) {
            if (isset($precios['servicios'][$servicio])) {
                $subtotal_servicios += $precios['servicios'][$servicio];
            }
        }
        
        $subtotal = $subtotal_habitacion + $subtotal_servicios;
        $impuestos = $subtotal * 0.16; // 16% de IVA
        $total = $subtotal + $impuestos;
        
        // Insertar factura en la base de datos
        $query = "INSERT INTO facturas (reserva_id, subtotal, impuestos, total, metodo_pago, detalles) 
                 VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("idddss", $reserva_id, $subtotal, $impuestos, $total, $metodo_pago, $detalles);
        
        if ($stmt->execute()) {
            $mostrar_formulario = false;
            $mensaje_exito = '
            <div class="mensaje-exito">
                <h2>✅ Factura Generada Exitosamente</h2>
                <p>La factura para la reserva #'.$reserva_id.' ha sido registrada en el sistema.</p>
                <div class="botones">
                    <a href="inicio.php" class="boton-inicio">🏠 Volver al Inicio</a>
                </div>
            </div>';
        } else {
            $error = "Error al generar factura: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Reserva no encontrada";
    }
}

// Obtener datos de la reserva para mostrar en el formulario
$reserva = [];
if ($reserva_id > 0) {
    $query = "SELECT * FROM reservas WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $reserva_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reserva = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar Factura - Hotel El Sol</title>
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
        .contenedor-central {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }
        .formulario-factura {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .detalles-reserva {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .mensaje-exito {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .mensaje-exito h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #FF7F50;
            color: white;
        }
        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }
        select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button, .boton-inicio {
            background-color: #FF7F50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
        }
        button:hover, .boton-inicio:hover {
            background-color: #e67347;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .botones {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="titulo">Hotel El Sol</div>
        <div class="nav-botones">
            <a href="inicio.php" style="color: white; text-decoration: none;">Inicio</a>
        </div>
    </div>

    <!-- Contenido principal -->
    <main class="contenedor-central">
        <h1>Generar Factura</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($mensaje_exito)): ?>
            <?php echo $mensaje_exito; ?>
        <?php elseif (!empty($reserva) && $mostrar_formulario): ?>
        <div class="formulario-factura">
            <div class="detalles-reserva">
                <h2>Detalles de la Reserva #<?php echo $reserva_id; ?></h2>
                <table>
                    <tr>
                        <th>Habitación</th>
                        <td><?php echo htmlspecialchars($reserva['habitacion']); ?></td>
                    </tr>
                    <tr>
                        <th>Personas</th>
                        <td><?php echo htmlspecialchars($reserva['personas']); ?></td>
                    </tr>
                    <tr>
                        <th>Noches</th>
                        <td><?php echo htmlspecialchars($reserva['noches']); ?></td>
                    </tr>
                    <tr>
                        <th>Servicios</th>
                        <td><?php echo htmlspecialchars($reserva['servicios']); ?></td>
                    </tr>
                </table>
            </div>
            
            <form action="" method="POST">
                <input type="hidden" name="reserva_id" value="<?php echo $reserva_id; ?>">
                
                <label for="metodo_pago">Método de Pago:</label>
                <select id="metodo_pago" name="metodo_pago" required>
                    <option value="">Seleccione un método</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                    <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                    <option value="Transferencia">Transferencia Bancaria</option>
                </select>
                
                <label for="detalles">Detalles Adicionales:</label>
                <textarea id="detalles" name="detalles" rows="3"></textarea>
                
                <button type="submit" name="generar_factura">Generar Factura</button>
            </form>
        </div>
        <?php elseif (empty($reserva)): ?>
        <div class="error">
            <p>No se encontró la reserva especificada.</p>
            <a href="inicio.php" class="boton-inicio">Volver al inicio</a>
        </div>
        <?php endif; ?>
    </main>
</body>
</html>
<?php
$conn->close();
?>