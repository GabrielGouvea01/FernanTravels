<?php
require_once __DIR__ . '/../includes/functions.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $usuario = consulta_user($conexao, $email);

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Login</title>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Login</h1>
        <?php if ($erro !== ''): ?>
            <p role="alert"><?= escapar_html($erro) ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Digite seu email" required><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" placeholder="Digite a sua senha" required><br>

            <input type="submit" value="Entrar">
        </form>
        <p>Caso não tenha uma conta, <a href="/login/cadastrar_usuario.php">cadastre-se</a>.</p>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
