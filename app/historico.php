<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Historico de Cotações</title>
</head>
<body>
    <?php 
    require_once '../login/verifica_user.php';
    require_once '../includes/functions.php';
    include '../includes/header.php';
    ?>
    <h1>Seu historico de viagens</h1>
    <?php 
    historico_unico($conexao, $_SESSION['id']);
    include '../includes/footer.php'?>
</html>