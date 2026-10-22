<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Define idioma, codificação, estilo e título da página. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/fernantravels/Style/style.css">
    <title>Mudar Cotação</title>
</head>
<body>
    <!-- Exige login e carrega as funções e o menu compartilhado. -->
    <?php
    require_once __DIR__ . '/../login/verifica_user.php';
    require_once __DIR__ . '/../includes/functions.php';
    include __DIR__ . '/../includes/header.php';

    // Guarda os dados da cotação depois que ela for pesquisada.
    $cota = [];

    // Procura a cotação quando o formulário de busca envia um ID.
    if (isset($_GET['id_cotacao']) && $_GET['id_cotacao'] != '') {
        $id = $_GET['id_cotacao'];

        // Busca os dados da cotação informada no banco de dados.
        $sql = "SELECT * FROM cotacao WHERE id = $id";
        $resultado = $conexao->query($sql);

        // Guarda os dados encontrados para preencher o formulário.
        if ($resultado) {
            $cota = $resultado->fetch(PDO::FETCH_ASSOC);
        }
    }


    // Atualiza os dados quando o formulário de edição for enviado.

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Identifica a cotação que será atualizada.
        $id = $_POST['id_cotacao'];

        // Envia os dados novos para a função de atualização.
        atualizar_cotacao( $conexao, $_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['origem'], $_POST['destino'], $_POST['ida'], $_POST['volta'], $_POST['adultos'], $_POST['criancas'], $_POST['bagagens'], $_POST['escolhaH'], $_POST['escolhaC'], $_SESSION['id'], $id
        );


    }
    ?>

    <!-- Primeiro formulário: procura uma cotação pelo ID. -->
    <div>
        <h1>Mude a sua cotação</h1>

        <!-- Pesquisa o ID da cotação para carregar seus dados. -->
        <form action="" method="get">
            <label for="id_cotacao">ID da cotação:</label>
            <input type="number" name="id_cotacao" value="<?= $cota['id'] ?? '' ?>" placeholder="Digite o ID da cotação" required>
            <button type="submit">Buscar</button>
        </form>

        <hr>

        <!-- Segundo formulário: altera os dados encontrados. -->
        <form action="" method="post">

            <!-- Mantém o ID da cotação que será atualizada. -->
            <input type="hidden" name="id_cotacao" value="<?= $cota['id'] ?? '' ?>">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?= $cota['nome'] ?? '' ?>" placeholder="Digite o nome completo do cliente" required><br>

            <label for="telefone">Telefone:</label>
            <input type="tel" name="telefone" value="<?= $cota['telefone'] ?? '' ?>" placeholder="Digite o telefone com DDD" required><br>

            <label for="email">Email para contato:</label>
            <input type="email" name="email" value="<?= $cota['email'] ?? '' ?>" placeholder="Digite o e-mail para contato" required><br><hr>

            <label for="origem">Origem:</label>
            <input type="text" name="origem" value="<?= $cota['origem'] ?? '' ?>" placeholder="Digite a cidade ou aeroporto de origem" required><br>

            <label for="destino">Destino:</label>
            <input type="text" name="destino" value="<?= $cota['destino'] ?? '' ?>" placeholder="Digite a cidade ou aeroporto de destino" required><br><br>

            <label for="ida">Data de ida:</label>
            <input type="date" name="ida" min="<?= date('Y-m-d') ?>" value="<?= $cota['ida'] ?? '' ?>" title="Selecione a data de ida" required><br>

            <label for="volta">Data de volta:</label>
            <input type="date" name="volta" min="<?= date('Y-m-d') ?>" value="<?= $cota['volta'] ?? '' ?>" title="Selecione a data de volta" required><br><br>

            <label for="adultos">Quantos adultos:</label>
            <input type="number" name="adultos" min="1" value="<?= $cota['adultos'] ?? '1' ?>" placeholder="Informe a quantidade de adultos" required><br>

            <label for="criancas">Quantas crianças (menores de 12 anos):</label>
            <input type="number" name="criancas" min="0" value="<?= $cota['criancas'] ?? '0' ?>" placeholder="Informe a quantidade de crianças menores que 12 anos" required><br>

            <label for="bagagens">Quantas bagagens:</label>
            <input type="number" name="bagagens" min="0" value="<?= $cota['bagagens'] ?? '0' ?>" placeholder="Informe a quantidade de bagagens" required><br><hr>

            <!-- Escolhe se a cotação inclui hotel. -->
            <label>Vai alugar hotel?</label><br>
            <label>Sim</label>
            <input type="radio" name="escolhaH" value="sim" <?= (($cota['escolha_h'] ?? '') == 'sim') ? 'checked' : '' ?> required>
            <label>Não</label>
            <input type="radio" name="escolhaH" value="nao" <?= (($cota['escolha_h'] ?? '') == 'nao') ? 'checked' : '' ?>><br><br>

            <!-- Escolhe se a cotação inclui carro. -->
            <label>Vai alugar carro?</label><br>
            <label>Sim</label>
            <input type="radio" name="escolhaC" value="sim" <?= (($cota['escolha_c'] ?? '') == 'sim') ? 'checked' : '' ?> required>
            <label>Não</label>
            <input type="radio" name="escolhaC" value="nao" <?= (($cota['escolha_c'] ?? '') == 'nao') ? 'checked' : '' ?>><br><br>

            <input type="submit" value="Atualizar cotação">
        </form>
    </div>

    <!-- Inclui o rodapé e encerra a página. -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>