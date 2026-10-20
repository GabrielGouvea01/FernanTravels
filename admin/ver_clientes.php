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
    require_once __DIR__ . '/../login/verifica_user.php';
    require_once __DIR__ . '/../includes/functions.php';
    include __DIR__ . '/../includes/header.php';
    ?>
    <h1>Clientes</h1>
    <?php
    mostrar_usuarios($conexao);
    ?>
    <h4>listar todos os clientes, baseados na sua conta, e listar quantas cotaçoes ja aforam feitas por eles</h4>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    
</body>
</html>