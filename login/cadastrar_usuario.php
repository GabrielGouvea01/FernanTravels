<?php
// Carrega a conexão, as funções e inicia a sessão do site.
require_once __DIR__ . '/../includes/functions.php';

// Mensagens que serão exibidas após validar o formulário.
$erro = '';
$mensagem = '';

// Trata o formulário quando ele é enviado.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    // Confere os campos obrigatórios e o formato do e-mail.
    if ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $senha === '') {
        $erro = 'Preencha o nome, informe um e-mail válido e digite uma senha.';
    } else {
        // Salva o novo usuário e prepara a mensagem de confirmação.
        cadastrar_user($conexao, $nome, $email, $senha);
        $mensagem = 'Usuário cadastrado com sucesso!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Define idioma, codificação, estilo e título da página. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Criar conta</title>
</head>
<body>
    <!-- Inclui o menu compartilhado. -->
    <?php include __DIR__ . '/../includes/header.php'; ?>
        <div>
        <h1>Cadastro</h1>
        <!-- Mostra o resultado da validação ou do cadastro. -->
        <?php if ($erro !== ''): ?>
            <p role="alert"><?= escapar_html($erro) ?></p>
        <?php elseif ($mensagem !== ''): ?>
            <p><?= escapar_html($mensagem) ?></p>
        <?php endif; ?>
        <!-- Formulário para criar uma conta de usuário. -->
        <form action="" method="post">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" placeholder="Digite seu nome" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Digite seu email" required><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" placeholder="Digite a sua senha" required><br>

            <input type="submit" value="Criar conta">
        </form>
        <!-- Link para quem já possui uma conta. -->
        <p>Caso já tenha uma conta: <a href="/fernantravels/login/login.php">LOGIN</a>.</p>
        </div>
    <!-- Inclui o rodapé compartilhado. -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
