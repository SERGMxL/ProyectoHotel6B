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
            background-color: #f1f1f1;
            padding: 30px;
            color: #333;
        }

        .container {
            background-color: #fff;
            max-width: 600px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #ffa500;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #ffa500;
            color: white;
        }

        .btn-imprimir {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #ffa500;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-imprimir:hover {
            background-color: #ffa500;
        }

        @media print {
            .btn-imprimir {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hotel El Sol - Ticket de Reserva</h2>

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
