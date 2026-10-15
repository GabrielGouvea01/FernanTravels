<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Mostrar Clientes</title>
</head>
<body>
    <?php 
    include '../includes/header.php';
    require_once './includes/functions.php';
    ?>
    <h1>Clientes</h1>
    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        mostrar_usuarios($conexao);
    } 
    ?>
    <h4>listar todos os clientes, baseados na sua conta, e listar quantas cotaçoes ja aforam feitas por eles</h4>
    <?php include '../includes/footer.php'?>
    
</body>
</html>