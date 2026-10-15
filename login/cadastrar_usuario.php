<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Cria conta</title>
</head>
<body>
    <?php 
    require_once '../includes/functions.php';
    include '../includes/header.php'
    ?>
    <div>
        <h1>Cadastro</h1>
        <form action="" method="post">
            <label for="nome">Nome: </label>
            <input type="nome" name="nome" id="nome" placeholder="Digite seu nome"><br>

            <label for="email">Email: </label>
            <input type="email" name="email" id="email" placeholder="Digite seu email"><br>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" placeholder="Digite a sua senha"><br>

            <input type="submit" value="Criar conta">
        </form>
    </div>
    <br><br>
    Caso tenha uma conta entre em <b><a href="/login/login.php">Login</a></b>
    <?php 
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
            cadastrar_user($conexao, $_POST['nome'], $_POST['email'], $_POST['senha']);
        }
    include '../includes/footer.php'?>
</body>
</html>