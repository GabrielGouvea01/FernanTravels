<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Configura a página que lista todas as cotações. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Mostrar Cotações</title>
</head>
<body>
    <!-- Exige login e carrega os arquivos compartilhados. -->
    <?php 
    require_once __DIR__ . '/../login/verifica_user.php';
    require_once __DIR__ . '/../includes/functions.php';
    include __DIR__ . '/../includes/header.php';
    ?>
    <!-- Busca e exibe todas as cotações cadastradas. -->
    <div>
        <h1>Todas Cotações</h1>
        <?php
        historico_geral($conexao);
     ?>
     </div>

    <!-- Inclui o rodapé comum do site. -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    
</body>
</html>