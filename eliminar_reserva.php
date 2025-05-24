<?php
require_once 'includes/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM reservas WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: recepcionista.php?tabla=reservas");
exit;
