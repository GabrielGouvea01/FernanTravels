<?php
// Dados usados para encontrar o banco de dados PostgreSQL.
$host = "192.168.10.21";
$dbname = "fernantravels";
$user = "fernantravels";
$pass = "fernantravels";

// Abre a conexão e informa ao PDO para mostrar erros nas consultas.
$conexao = new PDO(
    "pgsql:host=$host;dbname=$dbname",
    $user,
    $pass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);