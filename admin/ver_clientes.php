<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Configura a página que lista os clientes. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Mostrar Clientes</title>
</head>
<body>
    <!-- Exige login e carrega os arquivos compartilhados do sistema. -->
    <?php 
    require_once __DIR__ . '/../login/verifica_user.php';
    require_once __DIR__ . '/../includes/functions.php';
    include __DIR__ . '/../includes/header.php';
    ?>
    <!-- Mostra cada cliente e a quantidade de cotações associadas. -->
    <div>
        <h1>Todos Clientes</h1>
        <?php
        mostrar_usuarios($conexao);
        ?>
    </div>
    <!-- Inclui o rodapé comum do site. -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    
</body>
</html>