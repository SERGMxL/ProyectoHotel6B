<?php
include 'includes/conexion.php';

// Obtener la última reserva con PDO
$stmt = $pdo->query("SELECT * FROM reservas ORDER BY id DESC LIMIT 1");
$reserva = $stmt->fetch();

$barcodeImageUrl = ''; // Initialize the variable for the barcode image URL
if ($reserva) {
    // Use urlencode() to properly prepare the data for the URL query string.
    $barcodeData = urlencode($reserva['id']);

    // --- CRITICAL ADJUSTMENT HERE ---
    // Increased modulewidth further to 0.35 and height to 80
    // These values often work well for short numeric IDs.
    $barcodeImageUrl = "https://barcode.tec-it.com/barcode.ashx?data=" . $barcodeData . "&code=Code128&multipledata=false&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23FFFFFF&modulewidth=0.35&height=80&eclevel=L";

    // --- TEMPORARY DIAGNOSTIC LINE (REMOVE AFTER FIXING) ---
    // This will print the full URL used for the barcode. Copy this and paste it
    // directly into your browser to see if the barcode loads there.
    // echo "";
    // --- END TEMPORARY DIAGNOSTIC LINE ---
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Reserva</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; /* Changed to a more ticket-like font */
            background-color: #f0f0f0; /* Lighter background */
            padding: 0;
            margin: 0;
            color: #333; /* Slightly softer black */
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh; /* Ensure it takes full viewport height for centering */
        }

        .navbar {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px 20px;
            background: none;
            border-bottom: 1px solid #ccc;
            text-align: left;
            box-sizing: border-box; /* Include padding in width */
        }

        .navbar a {
            text-decoration: none;
            color: #000;
            font-weight: bold;
            font-size: 16px;
        }

        .ticket-container {
            background-color: #fff;
            width: 300px; /* Much narrower for a ticket look */
            margin: 80px auto 30px auto; /* More margin on top to clear navbar */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            border: 1px solid #ccc; /* Subtle border */
        }

        .ticket-container::before,
        .ticket-container::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            height: 10px; /* Size of the perforation */
            background: repeating-linear-gradient(-45deg, #f0f0f0 0 5px, #fff 5px 10px); /* Dashed effect */
            background-size: 10px 10px;
            z-index: 1;
        }

        .ticket-container::before {
            top: 50px; /* Position of the top perforation line */
            transform: translateY(-50%);
        }

        .ticket-container::after {
            bottom: 120px; /* Position of the bottom perforation line */
            transform: translateY(50%);
        }


        h2 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 1.4em;
            color: #222;
            border-bottom: 1px dashed #eee; /* Light dashed separator */
            padding-bottom: 10px;
            text-transform: uppercase;
        }

        .ticket-details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 0.9em; /* Smaller font for details */
        }

        .ticket-details th, .ticket-details td {
            padding: 5px 0; /* Reduced padding */
            text-align: left;
            border-bottom: 1px dotted #eee; /* Dotted separator */
        }

        .ticket-details th {
            font-weight: bold;
            color: #555;
            width: 40%; /* Adjust width for labels */
        }

        .ticket-details td {
            width: 60%;
        }

        /* Styles for the barcode */
        .barcode-container {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
            padding: 10px;
            border-top: 1px dashed #ccc;
            border-bottom: 1px dashed #ccc;
            background-color: #fefefe;
        }

        .barcode-container img {
            max-width: 200px; /* Adjusted barcode width */
            height: auto;
            display: block;
            margin: 0 auto 5px auto; /* Reduced margin */
        }

        .barcode-container p {
            font-size: 0.9em; /* Smaller font for barcode text */
            font-weight: bold;
            color: #333;
            margin-top: 5px;
            margin-bottom: 0;
        }

        .ticket-number {
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
            color: #000;
            margin-top: 10px;
            margin-bottom: 20px;
            padding-top: 10px;
            border-top: 1px dashed #ccc; /* Separator for ticket number */
        }


        .btn-imprimir {
            display: block;
            width: calc(100% - 40px); /* Adjust for padding */
            margin: 20px auto 0 auto; /* Center the button below the ticket */
            padding: 10px;
            background: #eee;
            border: 1px solid #ddd;
            color: #555;
            text-align: center;
            font-size: 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-imprimir:hover {
            background-color: #e0e0e0;
        }

        @media print {
            body {
                background-color: #fff;
                margin: 0;
                padding: 0;
            }
            .navbar, .btn-imprimir {
                display: none;
            }
            .ticket-container {
                box-shadow: none;
                border: none;
                margin: 0 auto;
                width: 280px; /* Slightly narrower for print */
                padding: 15px;
            }
            .ticket-container::before,
            .ticket-container::after {
                background: none; /* Hide dashed effect in print */
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="inicio.php">← Volver</a>
    </div>

    <div class="ticket-container">
        <h2>Ticket de Reserva</h2>

        <?php if ($reserva): ?>
            <table class="ticket-details">
                <tr><th>ID:</th><td><?= htmlspecialchars($reserva['id']); ?></td></tr>
                <tr><th>Habitación:</th><td><?= htmlspecialchars($reserva['habitacion']); ?></td></tr>
                <tr><th>Personas:</th><td><?= htmlspecialchars($reserva['personas']); ?></td></tr>
                <tr><th>Noches:</th><td><?= htmlspecialchars($reserva['noches']); ?></td></tr>
                <tr><th>Servicios:</th><td><?= htmlspecialchars($reserva['servicios']); ?></td></tr>
                <tr><th>Fecha:</th><td><?= htmlspecialchars($reserva['fecha']); ?></td></tr>
            </table>

            <?php if ($barcodeImageUrl): ?>
                <div class="barcode-container">
                    <img src="<?= $barcodeImageUrl; ?>" alt="Código de barras de la reserva">
                    <p>¡Presenta este código!</p>
                </div>
            <?php else: ?>
                <p style="text-align: center; color: red; font-size: 0.9em;">No se pudo generar el código de barras.</p>
            <?php endif; ?>

            <div class="ticket-number">
                N° de Ticket: <strong><?= htmlspecialchars($reserva['id']); ?></strong>
            </div>

        <?php else: ?>
            <p style="text-align: center;">No se encontró ninguna reserva.</p>
        <?php endif; ?>
    </div>

    <button class="btn-imprimir" onclick="window.print()">🖨️ Imprimir Ticket</button>
</body>
</html>