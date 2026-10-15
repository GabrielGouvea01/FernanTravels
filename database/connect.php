<?php 
$host = "192.168.10.21";
$dbname = "fernantravels";
$user = "fernantravels";
$pass = "fernantravels";

try {
    $conexao = new PDO(
        "pgsql:host=$host;dbname=$dbname",$user,$pass
    );
} catch (PDOException $e) {
    echo "Erro: ". $e->getMessage();
}
?>