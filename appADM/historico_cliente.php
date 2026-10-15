<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/style.css">
    <title>Historico de Clientes</title>
</head>
<body>
    <?php 
    require_once './includes/functions.php';
    include '../includes/header.php';
    ?>
    <h4>Ver o historico de cotações de um cliente especifico</h4>
    <div>
        <form action="" method="post">
            <label for="id">Escreva o ID do Cliente que você deseja ver as cotações:</label>
            <input type="number" name="id" id="id">
        </form>
    </div>
    <?php 
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        historico_unico($conexao, $_POST['id']);
    }
    ?>
    <?php include '../includes/footer.php'?>
    
</body>
</html>