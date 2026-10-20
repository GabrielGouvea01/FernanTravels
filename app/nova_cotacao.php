<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Fazer Cotação</title>
</head>
<body>
    <?php 
    require_once __DIR__ . '/../login/verifica_user.php';
    require_once __DIR__ . '/../includes/functions.php';
    include __DIR__ . '/../includes/header.php';
    ?>
    <div>
        <h1>Cotação</h1>
        <form action="" method="post">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required><br>

            <label for="telefone">Telefone:</label>
            <input type="tel" name="telefone" id="telefone" required><br>

            <label for="email">Email para contato:</label>
            <input type="email" name="email" id="email" required><br><hr>

            <label for="origem">Origem: </label>
            <input type="text" name="origem" id="origem" required>
            <br>
            <label for="destino">Destino: </label>
            <input type="text" name="destino" id="destino" required>
            <br>
            <br>
            <label for="ida">Data de ida:</label>
            <input type="date" name="ida" id="ida" min="<?= date('Y-m-d') ?>" required>
            <br>
            <label for="volta">Data de volta</label>
            <input type="date" name="volta" id="volta" min="<?= date('Y-m-d') ?>" required> <br> <br>

            <label for="adultos">Quantos adultos:</label>
            <input type="number" name="adultos" id="adultos" min="1" required><br>

            <label for="criancas">Quantas crianças (menores de 12 anos):</label>
            <input type="number" name="criancas" id="criancas" min="0" required><br>

            <label for="bagagens">Quantas bagagens:</label>
            <input type="number" name="bagagens" id="bagagens" min="0" required><br><hr>
            
            <label for="escolhaH_sim">Vai alugar hotel?</label>
            <br>
            <label for="escolhaH_sim">Sim</label>
            <input type="radio" name="escolhaH" id="escolhaH_sim" value="sim" required>
            <label for="escolhaH_nao">Não</label>
            <input type="radio" name="escolhaH" id="escolhaH_nao" value="nao"> <br><br>

            <label for="escolhaC_sim">Vai alugar carro?</label>
            <br>
            <label for="escolhaC_sim">Sim</label>
            <input type="radio" name="escolhaC" id="escolhaC_sim" value="sim" required>
            <label for="escolhaC_nao">Não</label>
            <input type="radio" name="escolhaC" id="escolhaC_nao" value="nao">
            <br><br>

            <input type="submit" value="Enviar cotação">
        </form>
    </div>
    <?php 
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        nova_cotacao($conexao, $_POST['nome'] ?? '', $_POST['telefone'] ?? '', $_POST['email'] ?? '', $_POST['origem'] ?? '', $_POST['destino'] ?? '', $_POST['ida'] ?? '', $_POST['volta'] ?? '', $_POST['adultos'] ?? 0, $_POST['criancas'] ?? 0, $_POST['bagagens'] ?? 0, $_POST['escolhaH'] ?? '', $_POST['escolhaC'] ?? '', $_SESSION['id']);
    }
    include __DIR__ . '/../includes/footer.php';
    ?>
</body>
</html>