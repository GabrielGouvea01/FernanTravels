<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Configura a página para exclusão de cotações. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Deletar Cotacão</title>
</head>
<body>
    <!-- Exige login, carrega as funções e inclui a navegação. -->
    <?php 
    require_once __DIR__ . '/../login/verifica_user.php';
    require_once __DIR__ . '/../includes/functions.php';
    include __DIR__ . '/../includes/header.php';
    ?>
    <!-- Formulário para receber o ID da cotação que será apagada. -->
    <div>
        <h1>Deletar Cotação</h1>
        <form action="" method="post">
            <label for="id">Insira o ID da cotação que deseja deletar:</label>
            <input type="number" name="id" id="id" min="1" placeholder="Digite o ID da cotação" required>

            <input type="submit" value="Exluir cotação">
        </form>
    </div>
    <!-- Confere o ID enviado e chama a função que remove a cotação. -->
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