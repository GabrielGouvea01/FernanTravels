<?php
// Dados usados para encontrar o banco de dados PostgreSQL.
$host = "IP_SERVER";
$dbname = "NOME_DB";
$user = "SEU_USUARIO";
$pass = "SUA_SENHA";

// Abre a conexão e informa ao PDO para mostrar erros nas consultas.
$conexao = new PDO(
    "pgsql:host=$host;dbname=$dbname",
    $user,
    $pass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);