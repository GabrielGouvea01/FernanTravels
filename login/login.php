<?php
// Carrega a conexão, as funções do sistema e inicia a sessão.
require_once __DIR__ . '/../includes/functions.php';

// Guarda uma mensagem para mostrar quando os dados de acesso estiverem incorretos.
$erro = '';

// Confere os dados enviados pelo formulário de login.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    // Busca a conta pelo e-mail digitado.
    $usuario = consulta_user($conexao, $email);

    // Se a senha estiver correta, salva o usuário na sessão e abre a página inicial.
    if ($usuario && password_verify($senha, $usuario['senha'] ?? '')) {
        session_regenerate_id(true);
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['perfil'] = $usuario['perfil'];
        header('Location: ../index.php');
        exit();
    }

    $erro = 'E-mail ou senha inválidos.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Define o idioma, a codificação, o estilo e o título da página. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Login</title>
</head>
<body>
    <!-- Mostra a navegação compartilhada do site. -->
    <?php include __DIR__ . '/../includes/header.php'; ?>
        <div>
            <h1>Login</h1>
            <!-- Exibe uma mensagem quando o e-mail ou a senha não conferem. -->
            <?php if ($erro !== ''): ?>
                <p role="alert"><?= escapar_html($erro) ?></p>
            <?php endif; ?>
            <!-- Formulário usado para enviar e-mail e senha ao próprio arquivo. -->
            <form action="" method="post">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Digite seu email" required><br>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Digite a sua senha" required><br>
                <input type="submit" value="Entrar">
            </form>
            <!-- Link para quem ainda não possui uma conta. -->
            <p>Caso não tenha uma conta: <a href="/fernantravels/login/cadastrar_usuario.php">CADASTRAR</a>.</p>
        </div>
    <!-- Inclui o rodapé compartilhado. -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
