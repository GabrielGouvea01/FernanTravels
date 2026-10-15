<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Mostrar Cotações</title>
</head>
<body>
    <h1>Cotações</h1>
    <?php 
    require_once './includes/functions.php';
    include '../includes/header.php';
    historico_geral($conexao);
    include '../includes/footer.php'
     ?>
    
</body>
</html>