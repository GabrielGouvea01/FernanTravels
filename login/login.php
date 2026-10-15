<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Login</title>
</head>
<body>
    <?php 
    include '../includes/header.php';
    require_once '../includes/functions.php';
    ?>
    <div>
        <h3>Login</h3>
        <form action="" method="post">
            <label for="email">Email: </label>
            <input type="email" name="email" id="email" placeholder="Digite seu email"><br>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" placeholder="Digite a sua senha"><br>

            <input type="submit" value="Criar conta">
        </form>
    </div>
    <br><br>
    Caso não tenha uma conta entre em <b><a href="/login/cadastrar_usuario.php">Cadastrar</a></b>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        // Busca o usuário pelo e-mail
        $usuario = consulta_user($conexao, $_POST['email']);

        // 2 Compara a senha digitada com o hash salvo Tente pegar a senha do banco ($usuario['senha']). Se o usuário não existir e essa senha for nula, não quebre o site! Use uma texto vazio '' no lugar.
        if (password_verify($_POST['senha'], $usuario['senha'] ?? '')) {
            // senha correta: cria a sessão
            $_SESSION['id'] = $usuario['id'];
        } else {
            echo "E-mail ou senha inválidos.";
        }
    }
    include '../includes/footer.php'?>
</body>
</html>