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
    include '../includes/header.php';
    require_once '../includes/functions.php';
    require_once '../login/verifica_user.php';
    ?>
    <div>
        <h1>Cotação</h1>
        <form action="" method="post">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome"><br>

            <label for="telefone">Telefone:</label>
            <input type="tel" name="telefone" id="telefone"><br>

            <label for="email">Email para contato:</label>
            <input type="email" name="email" id="email"><br><hr>

            <label for="origem">Origem: </label>
            <input type="text" name="origem" id="origem">
            <br>
            <label for="destino">Destino: </label>
            <input type="text" name="destino" id="destino">
            <br>
            <br>
            <label for="ida">Data de ida:</label>
            <input type="date" name="ida" id="ida" min="2026-10-05">
            <br>
            <label for="volta">Data de volta</label>
            <input type="date" name="volta" id="volta" min="2026-10-05"> <br> <br>

            <label for="bagagens">Quantas adultos:</label>
            <input type="number" name="adultos" id="adultos"><br>

            <label for="bagagens">Quantas crianças(menores de 12 anos):</label>
            <input type="number" name="criancas" id="criancas"><br>

            <label for="bagagens">Quantas bagagens:</label>
            <input type="number" name="bagagens" id="bagagens"><br><hr>
            
            <label for="hotel">Vai alugar hotel?</label>
            <br>
            <label for="escolhaH">Sim</label>
            <input type="radio" name="escolhaH" id="escolhaH" value="sim">
            <label for="escolhaH">Não</label>
            <input type="radio" name="escolhaH" id="escolhaH" value="nao"> <br><br>

            <label for="hotel">Vai alugar carro?</label>
            <br>
            <label for="escolhaC">Sim</label>
            <input type="radio" name="escolhaC" id="escolhaC" value="sim">
            <label for="escolhaC">Não</label>
            <input type="radio" name="escolhaC" id="escolhaC" value="nao">
            <br><br>

            <input type="submit" value="Enviar cotação">
        </form>
    </div>
    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        nova_cotacao($conexao,  $_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['origem'], $_POST['destino'], $_POST['ida'], $_POST['volta'], $_POST['adultos'], $_POST['criancas'], $_POST['bagagens'], $_POST['escolhaH'], $_POST['escolhaC'], $_SESSION['id']);   
    }
    include '../includes/footer.php'
    ?>
</body>
</html>