<?php
session_start();
require_once 'includes/conexion.php';

$tabla = $_GET['tabla'] ?? null;
$resultado = [];

// Procesar eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar_usuario'])) {
        $usuario = $_POST['nombre_usuario'];
        $stmt = $pdo->prepare("DELETE FROM usuario WHERE nombre_usuario = ?");
        $stmt->execute([$usuario]);
    } elseif (isset($_POST['eliminar_reserva'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM reservas WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Consultar tabla
if ($tabla === 'usuarios') {
    $stmt = $pdo->query("SELECT nombre_usuario, nombre_completo FROM usuario");
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($tabla === 'admin') {
    $stmt = $pdo->query("SELECT * FROM contraseña_admin");
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($tabla === 'reservas') {
    $stmt = $pdo->query("SELECT * FROM reservas");
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
            background-color:rgb(255, 255, 255);
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
        form.eliminar-form {
            display: inline;
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
        <form method="GET">
            <input type="hidden" name="tabla" value="reservas">
            <button type="submit">Ver Reservaciones</button>
        </form>
    </div>

    <?php if (!empty($resultado)): ?>
        <table>
            <thead>
                <tr>
                    <?php foreach (array_keys($resultado[0]) as $columna): ?>
                        <th><?= htmlspecialchars($columna) ?></th>
                    <?php endforeach; ?>
                    <?php if ($tabla === 'usuarios' || $tabla === 'reservas'): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $fila): ?>
                    <tr>
                        <?php foreach ($fila as $valor): ?>
                            <td><?= htmlspecialchars($valor) ?></td>
                        <?php endforeach; ?>

                        <?php if ($tabla === 'usuarios'): ?>
                            <td>
                                <form method="POST" class="eliminar-form" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                    <input type="hidden" name="nombre_usuario" value="<?= htmlspecialchars($fila['nombre_usuario']) ?>">
                                    <button type="submit" name="eliminar_usuario">Eliminar</button>
                                </form>
                            </td>
                        <?php elseif ($tabla === 'reservas'): ?>
                            <td>
                                <form method="POST" class="eliminar-form" onsubmit="return confirm('¿Eliminar esta reserva?');">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($fila['id']) ?>">
                                    <button type="submit" name="eliminar_reserva">Eliminar</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($tabla): ?>
        <p style="text-align:center; margin-top:20px;">No se encontraron resultados.</p>
    <?php endif; ?>
</body>
</html>
