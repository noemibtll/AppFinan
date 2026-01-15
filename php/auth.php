<?php
// auth.php
session_start();

$id = $_SESSION['id'];
$usuario = $_SESSION['usuario'];
// Verifica si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    // Si no hay sesión iniciada, redirige al login
    header("Location: ".PAGES_DIR."/login/");
    exit;
}
?>