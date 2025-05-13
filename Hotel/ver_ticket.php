<?php
include 'includes/conexion.php';

// Obtener la última reserva con PDO
$stmt = $pdo->query("SELECT * FROM reservas ORDER BY id DESC LIMIT 1");
$reserva = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 0;
            margin: 0;
            color: #000;
        }

        .navbar {
            width: 100%;
            padding: 10px 20px;
            background: none;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        .navbar a {
            text-decoration: none;
            color: #000;
            font-weight: bold;
            font-size: 16px;
        }

        .container {
            background-color: #fff;
            max-width: 600px;
            margin: 30px auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-weight: bold;
        }

        .btn-imprimir {
            display: block;
            width: 100%;
            padding: 12px;
            background: none;
            border: 1px solid #000;
            color: #000;
            text-align: center;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-imprimir:hover {
            background-color: #eee;
        }

        @media print {
            .navbar, .btn-imprimir {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="inicio.php">← Volver</a>
    </div>

    <div class="container">
        <h2>Ticket de Reserva</h2>

        <?php if ($reserva): ?>
            <table>
                <tr><th>ID</th><td><?= $reserva['id']; ?></td></tr>
                <tr><th>Habitación</th><td><?= $reserva['habitacion']; ?></td></tr>
                <tr><th>Personas</th><td><?= $reserva['personas']; ?></td></tr>
                <tr><th>Noches</th><td><?= $reserva['noches']; ?></td></tr>
                <tr><th>Servicios</th><td><?= $reserva['servicios']; ?></td></tr>
                <tr><th>Fecha</th><td><?= $reserva['fecha']; ?></td></tr>
            </table>

            <button class="btn-imprimir" onclick="window.print()">🖨️ Imprimir Ticket</button>
        <?php else: ?>
            <p>No se encontró ninguna reserva.</p>
        <?php endif; ?>
    </div>
</body>
</html>
