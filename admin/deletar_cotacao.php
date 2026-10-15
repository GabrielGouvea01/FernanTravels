<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Deletar Cotacão</title>
</head>
<body>
    <?php 
    include '../includes/header.php';
    require_once '../includes/functions.php';
    require_once '../login/verifica_user.php';
    ?>
    <div>
        <form action="" method="post">
            <label for="id">Insira o ID da cotação que deseja deletar:</label>
            <input type="number" name="id" id="id">

            <input type="submit" value="Exluir cotação">
        </form>
    </div>
    <h4>Apagar cotações</h4>
    <h1>OK</h1>
    <?php 
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        deletar_cotacao($conexao,$_POST["id"]);
    }

    include '../includes/footer.php'?>
    
</body>
</html>