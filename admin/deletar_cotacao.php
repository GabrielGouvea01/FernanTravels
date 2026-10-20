<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Deletar Cotacão</title>
</head>
<body>
    <?php 
    require_once __DIR__ . '/../login/verifica_user.php';
    require_once __DIR__ . '/../includes/functions.php';
    include __DIR__ . '/../includes/header.php';
    ?>
    <div>
        <form action="" method="post">
            <label for="id">Insira o ID da cotação que deseja deletar:</label>
            <input type="number" name="id" id="id" min="1" required>

            <input type="submit" value="Exluir cotação">
        </form>
    </div>
    <?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false) {
            echo '<p role="alert">Informe um ID de cotação válido.</p>';
        } else {
            deletar_cotacao($conexao, $id);
        }
    }

    include __DIR__ . '/../includes/footer.php'; ?>
    
</body>
</html>