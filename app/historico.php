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
    require_once __DIR__ . '/../login/verifica_user.php';
    require_once __DIR__ . '/../includes/functions.php';
    include __DIR__ . '/../includes/header.php';
    ?>
    <h1>Seu historico de viagens</h1>
    <?php 
    historico_unico($conexao, $_SESSION['id']);
    include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>