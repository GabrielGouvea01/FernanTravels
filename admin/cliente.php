<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Cliente</title>
</head>
<body>
    <?php 
    include '../includes/header.php';
    require_once '../includes/functions.php';
    require_once '../login/verifica_user.php';
    ?>
    <h4>Ver os dados de um cliente especifico baseado na sua conta e cotação</h4>
    <div>
        <form action="" method="post">
            <label for="id">Digite o ID que você deseja encontrar:</label>
            <input type="number" name="id" id="id">

            <input type="submit" value="Encotrar cliente">
        </form>
    </div>
    <?php 
    unico_usuario($conexao,$_POST['id'])
    ?>
    <?php include '../includes/footer.php'?>
    
</body>
</html>
