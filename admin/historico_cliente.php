<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Configura a página de histórico por cliente. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Historico de Clientes</title>
</head>
<body>
    <!-- Exige login, carrega as funções e mostra o menu. -->
    <?php 
    require_once __DIR__ . '/../login/verifica_user.php';
    require_once __DIR__ . '/../includes/functions.php';
    include __DIR__ . '/../includes/header.php';
    ?>
    <!-- Formulário para selecionar o cliente pelo ID. -->
    <div>
        <h1>historico de um cliente </h1>
        <form action="" method="post">
            <label for="id">Escreva o ID do Cliente que você deseja ver as cotações:</label>
            <input type="number" name="id" id="id" min="1" required>

            <input type="submit" value="Encontrar cotação">
        </form>
    </div>
    <!-- Valida o ID e mostra as cotações relacionadas ao cliente. -->
    <div>
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
    </div>
    <!-- Inclui o rodapé comum do site. -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    
</body>
</html>