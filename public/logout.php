<?php
// pages/logout.php - Fazer logout
require_once __DIR__ . '/../modules/auth/auth.php';

session_start();

// Faz logout
fazerLogout();

// Redireciona para login
header('Location: ./login.php');
exit;