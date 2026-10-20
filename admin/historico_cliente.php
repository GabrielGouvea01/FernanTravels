<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Historico de Clientes</title>
</head>
<body>
    <?php 
    require_once __DIR__ . '/../login/verifica_user.php';
    require_once __DIR__ . '/../includes/functions.php';
    include __DIR__ . '/../includes/header.php';
    ?>
    <h4>Ver o historico de cotações de um cliente especifico</h4>
    <div>
        <form action="" method="post">
            <label for="id">Escreva o ID do Cliente que você deseja ver as cotações:</label>
            <input type="number" name="id" id="id" min="1" required>

            <input type="submit" value="Encontrar cotação">
        </form>
    </div>
    <?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false) {
            echo '<p role="alert">Informe um ID de cliente válido.</p>';
        } else {
            historico_unico($conexao, $id);
        }
    }
    ?>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    
</body>
</html>