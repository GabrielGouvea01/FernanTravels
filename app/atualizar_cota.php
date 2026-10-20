<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css"> <!--[cite: 2]-->
    <title>Mudar Cotação</title> <!--[cite: 2]-->
</head>
<body>
    <?php 
    // 1. Inclui os ficheiros do sistema (login, funções e cabeçalho)
    require_once __DIR__ . '/../login/verifica_user.php'; //[cite: 2]
    require_once __DIR__ . '/../includes/functions.php'; //[cite: 2]
    include __DIR__ . '/../includes/header.php'; //[cite: 2]

    // Criamos uma variável vazia para guardar a cotação que vamos buscar
    $cota = [];

    // -------------------------------------------------------------
    // PASSO A: SE O UTILIZADOR DIGITOU O ID E CLICOU EM "BUSCAR"
    // -------------------------------------------------------------
    if (isset($_GET['id_cotacao']) && $_GET['id_cotacao'] != '') {
        $id = $_GET['id_cotacao'];

        // Consulta simples para procurar a cotação pelo ID no banco de dados
        $sql = "SELECT * FROM cotacao WHERE id = $id";
        $resultado = $conexao->query($sql);

        // Se encontrar a cotação, guarda os dados na variável $cota
        if ($resultado) {
            $cota = $resultado->fetch(PDO::FETCH_ASSOC);
        }
    }

    // -------------------------------------------------------------
    // PASSO B: SE O UTILIZADOR ALTEROU OS DADOS E CLICOU EM "ENVIAR"
    // -------------------------------------------------------------
    if ($_SERVER["REQUEST_METHOD"] === "POST") { //[cite: 2]
        // Pegamos o ID e enviamos todos os dados para a função do seu sistema
        $id = $_POST['id_cotacao'];

        atualizar_cotacao( //[cite: 2]
            $conexao, 
            $_POST['nome'], 
            $_POST['telefone'], 
            $_POST['email'], 
            $_POST['origem'], 
            $_POST['destino'], 
            $_POST['ida'], 
            $_POST['volta'], 
            $_POST['adultos'], 
            $_POST['criancas'], 
            $_POST['bagagens'], 
            $_POST['escolhaH'], 
            $_POST['escolhaC'], 
            $_SESSION['id'], 
            $id
        ); //[cite: 2]

        echo "<p style='color: green;'>Cotação $id atualizada com sucesso!</p>";
    }
    ?>

    <div>
        <h1>Mude a sua cotação</h1> <!--[cite: 2]-->

        <!-- FORMULÁRIO 1: Apenas para pesquisar o ID (método GET) -->
        <form action="" method="get">
            <label for="id_cotacao">ID da cotação:</label> <!--[cite: 2]-->
            <input type="number" name="id_cotacao" value="<?= $cota['id'] ?? '' ?>" required>
            <button type="submit">Buscar</button>
        </form>

        <hr>

        <!-- FORMULÁRIO 2: Para exibir os dados e salvar as alterações (método POST) -->
        <form action="" method="post">

            <!-- Guardamos o ID num campo invisível (hidden) para saber qual cotação atualizar -->
            <input type="hidden" name="id_cotacao" value="<?= $cota['id'] ?? '' ?>">

            <label for="nome">Nome:</label> <!--[cite: 2]-->
            <input type="text" name="nome" value="<?= $cota['nome'] ?? '' ?>" required><br> <!--[cite: 2]-->

            <label for="telefone">Telefone:</label> <!--[cite: 2]-->
            <input type="tel" name="telefone" value="<?= $cota['telefone'] ?? '' ?>" required><br> <!--[cite: 2]-->

            <label for="email">Email para contato:</label> <!--[cite: 2]-->
            <input type="email" name="email" value="<?= $cota['email'] ?? '' ?>" required><br><hr> <!--[cite: 2]-->

            <label for="origem">Origem:</label> <!--[cite: 2]-->
            <input type="text" name="origem" value="<?= $cota['origem'] ?? '' ?>" required><br> <!--[cite: 2]-->

            <label for="destino">Destino:</label> <!--[cite: 2]-->
            <input type="text" name="destino" value="<?= $cota['destino'] ?? '' ?>" required><br><br> <!--[cite: 2]-->

            <label for="ida">Data de ida:</label> <!--[cite: 2]-->
            <input type="date" name="ida" min="<?= date('Y-m-d') ?>" value="<?= $cota['ida'] ?? '' ?>" required><br> <!--[cite: 2]-->

            <label for="volta">Data de volta:</label> <!--[cite: 2]-->
            <input type="date" name="volta" min="<?= date('Y-m-d') ?>" value="<?= $cota['volta'] ?? '' ?>" required><br><br> <!--[cite: 2]-->

            <label for="adultos">Quantos adultos:</label> <!--[cite: 2]-->
            <input type="number" name="adultos" min="1" value="<?= $cota['adultos'] ?? '1' ?>" required><br> <!--[cite: 2]-->

            <label for="criancas">Quantas crianças (menores de 12 anos):</label> <!--[cite: 2]-->
            <input type="number" name="criancas" min="0" value="<?= $cota['criancas'] ?? '0' ?>" required><br> <!--[cite: 2]-->

            <label for="bagagens">Quantas bagagens:</label> <!--[cite: 2]-->
            <input type="number" name="bagagens" min="0" value="<?= $cota['bagagens'] ?? '0' ?>" required><br><hr> <!--[cite: 2]-->
            
            <!-- Opção de Hotel -->
            <label>Vai alugar hotel?</label><br> <!--[cite: 2]-->
            <label>Sim</label> <!--[cite: 2]-->
            <input type="radio" name="escolhaH" value="sim" <?= (($cota['escolha_h'] ?? '') == 'sim') ? 'checked' : '' ?> required> <!--[cite: 2]-->
            <label>Não</label> <!--[cite: 2]-->
            <input type="radio" name="escolhaH" value="nao" <?= (($cota['escolha_h'] ?? '') == 'nao') ? 'checked' : '' ?>><br><br> <!--[cite: 2]-->

            <!-- Opção de Carro -->
            <label>Vai alugar carro?</label><br> <!--[cite: 2]-->
            <label>Sim</label> <!--[cite: 2]-->
            <input type="radio" name="escolhaC" value="sim" <?= (($cota['escolha_c'] ?? '') == 'sim') ? 'checked' : '' ?> required> <!--[cite: 2]-->
            <label>Não</label> <!--[cite: 2]-->
            <input type="radio" name="escolhaC" value="nao" <?= (($cota['escolha_c'] ?? '') == 'nao') ? 'checked' : '' ?>><br><br> <!--[cite: 2]-->

            <input type="submit" value="Atualizar cotação"> <!--[cite: 2]-->
        </form>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?> <!--[cite: 2]-->
</body>
</html>