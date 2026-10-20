<?php
require_once __DIR__ . '/../includes/functions.php';

$erro = '';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $senha === '') {
        $erro = 'Preencha o nome, informe um e-mail válido e digite uma senha.';
    } else {
        cadastrar_user($conexao, $nome, $email, $senha);
        $mensagem = 'Usuário cadastrado com sucesso!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Criar conta</title>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Cadastro</h1>
        <?php if ($erro !== ''): ?>
            <p role="alert"><?= escapar_html($erro) ?></p>
        <?php elseif ($mensagem !== ''): ?>
            <p><?= escapar_html($mensagem) ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" placeholder="Digite seu nome" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Digite seu email" required><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" placeholder="Digite a sua senha" required><br>

            <input type="submit" value="Criar conta">
        </form>
        <p>Caso já tenha uma conta, <a href="/login/login.php">entre aqui</a>.</p>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
