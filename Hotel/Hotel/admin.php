<?php
session_start();
require_once 'includes/conexion.php';

$tabla = $_GET['tabla'] ?? null;
$resultado = [];

if ($tabla === 'usuarios') {
    $stmt = $pdo->query("SELECT nombre_usuario, nombre_completo FROM usuario");
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($tabla === 'admin') {
    $stmt = $pdo->query("SELECT * FROM contraseña_admin");
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f1f1;
            background-image: url('../img/fondo-tile.jpg');
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
            font-size: 32px;
            font-weight: bold;
        }
        .botones {
            margin: 40px auto;
            text-align: center;
        }
        .botones form {
            display: inline-block;
            margin: 0 15px;
        }
        .botones button {
            background-color: #FF7F50;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        .botones button:hover {
            background-color: #e06645;
        }
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
    </style>
</head>
<body>
    <div class="navbar">
        <div class="titulo">Panel de Administrador</div>
        <div class="nav-botones">
            <a href="logout.php" style="color:white; text-decoration:none;">Cerrar sesión</a>
        </div>
    </div>

    <div class="botones">
        <form method="GET">
            <input type="hidden" name="tabla" value="usuarios">
            <button type="submit">Ver Usuarios</button>
        </form>
        <form method="GET">
            <input type="hidden" name="tabla" value="admin">
            <button type="submit">Ver Claves Admin</button>
        </form>
    </div>

    <?php if (!empty($resultado)): ?>
        <table>
            <thead>
                <tr>
                    <?php foreach (array_keys($resultado[0]) as $columna): ?>
                        <th><?= htmlspecialchars($columna) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $fila): ?>
                    <tr>
                        <?php foreach ($fila as $valor): ?>
                            <td><?= htmlspecialchars($valor) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($tabla): ?>
        <p style="text-align:center; margin-top:20px;">No se encontraron resultados.</p>
    <?php endif; ?>
</body>
</html>
