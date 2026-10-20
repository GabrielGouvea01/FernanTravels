<?php
$host = "192.168.10.21";
$dbname = "fernantravels";
$user = "fernantravels";
$pass = "fernantravels";

$conexao = new PDO(
    "pgsql:host=$host;dbname=$dbname",
    $user,
    $pass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);