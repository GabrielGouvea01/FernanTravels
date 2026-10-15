<?php 
require_once '../database/connect.php';
session_start();

// CLIENTE

function nova_cotacao($conexao, $nome, $telefone, $email, $origem, $destino, $ida, $volta, $qnt_adultos, $qnt_criancas, $qnt_bagagens, $hotel, $carro, $id_cliente){
    
    $sql = "INSERT INTO cotacao  (nome, telefone, email, origem, destino, ida, volta, qnt_adultos, qnt_criancas, qnt_bagagens, hotel, carro, id_cliente) VALUES (:nome, :telefone, :email, :origem, :destino, :ida, :volta, :qnt_adultos, :qnt_criancas, :qnt_bagagens, :hotel, :carro, :id_cliente)";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":nome", $nome); // bindValue - usa quando voce passa um valor direto
    $stmt->bindParam(":telefone", $telefone); // bindParams - usa quando voce passa um valor por uma variavel
    $stmt->bindParam(":email", $email); 
    $stmt->bindParam(":origem", $origem);
    $stmt->bindParam(":destino", $destino); 
    $stmt->bindParam(":ida", $ida);
    $stmt->bindParam(":volta", $volta); 
    $stmt->bindParam(":qnt_adultos", $qnt_adultos);
    $stmt->bindParam(":qnt_criancas", $qnt_criancas); 
    $stmt->bindParam(":qnt_bagagens", $qnt_bagagens);
    $stmt->bindParam(":hotel", $hotel); 
    $stmt->bindParam(":carro", $carro);
    $stmt->bindParam(":id_cliente", $id_cliente);

    $stmt->execute();
    echo "Cotação feita com sucesso!";
} //

function atualizar_cotacao($conexao, $nome, $telefone, $email, $origem, $destino, $ida, $volta, $qnt_adultos, $qnt_criancas, $qnt_bagagens, $hotel, $carro, $id_cliente, $id){
    $sql = "UPDATE  cotaco (nome, telefone, email, origem, destino, ida, volta, qnt_adultos, qnt_criancas, qnt_bagagens, hotel, carro, id_cliente) SET nome = :nome , telefone = :telefone, email = :email, origem = :origem, destino = :destino, ida = :ida, volta = :volta, qnt_adultos = :qnt_adultos, qnt_criancas = :qnt_criancas, qnt_bagagens = :qnt_bagagens, hotel = :hotel, carro = :carro, id_cliente = :id_cliente WHERE id = :id";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":nome", $nome); // bindValue - usa quando voce passa um valor direto
    $stmt->bindParam(":telefone", $telefone); // bindParams - usa quando voce passa um valor por uma variavel
    $stmt->bindParam(":email", $email); 
    $stmt->bindParam(":origem", $origem);
    $stmt->bindParam(":destino", $destino); 
    $stmt->bindParam(":ida", $ida);
    $stmt->bindParam(":volta", $volta); 
    $stmt->bindParam(":qnt_adultos", $qnt_adultos);
    $stmt->bindParam(":qnt_criancas", $qnt_criancas); 
    $stmt->bindParam(":qnt_bagagens", $qnt_bagagens);
    $stmt->bindParam(":hotel", $hotel); 
    $stmt->bindParam(":carro", $carro);
    $stmt->bindParam(":id_cliente", $id_cliente);

    $stmt->execute();
    echo "Cotação atualizada com sucesso!";
} //

function consultar($conexao, $id){
    // Coloca a instrução em sql
    $sql = "SELECT nome FROM cotacao WHERE id = ";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id); // bindParam() usa quando tiver pegando valor de uma variavel
    $stmt->execute();

    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "Aluno: {$aluno['nome']}<br>Turma: {$aluno['turma']}<br>Nascimento: {$aluno['nasc']}<br>Ativo: {$aluno['ativo']}";
}

function historico_unico($conexao, $id_cliente){
    // Coloca a instrução em sql
    $sql = "SELECT * FROM cotacao WHERE id_cliente = :id_cliente";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id_cliente", $id_cliente);
    $stmt->execute();

    $cotacoes = $stmt->fetch(PDO::FETCH_ASSOC);

     foreach($cotacoes as $cotacao){
        echo "<hr>";
        echo "Nome: {$cotacao['nome']}<br>";
        echo "Telefone: {$cotacao['telefone']}<br>";
        echo "Email: {$cotacao['email']}<br>";
        echo "Origem: {$cotacao['origem']}<br>";
        echo "Destino: {$cotacao['destino']}<br>";
        echo "Ida: {$cotacao['ida']}<br>";
        echo "Volta: {$cotacao['volta']}<br>";
        echo "Quantidae de Adultos: {$cotacao['qnt_adultos']}<br>";
        echo "Quantidade de Crianças: {$cotacao['qnt_criancas']}<br>";
        echo "Quantidade de Bagagens: {$cotacao['qnt_bagagens']}<br>";
        echo "Hotel: {$cotacao['hotel']}<br>";
        echo "Carro: {$cotacao['Carro']}<br>";
     }
} //?

// ADM

function historico_geral($conexao){
    // Coloca a intrução em sql
    $sql = "SELECT * FROM cotacao";

    // Prepara o codigo para evitar sql injection
    $stmt = $conexao->prepare($sql);
    // Executa a instrução
    $stmt ->execute();

    //Guarda a resposta da instrução em uma variavel(fetchAll - seleciona tudo), transforma em uma array
    $cotacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Percorre toda a lista que esta em alunos e mostra cada aluno por vez
    foreach($cotacoes as $cotacao){
        echo "<hr>";
        echo "ID: {$cotacao['id']}<br>";
        echo "Nome: {$cotacao['nome']}<br>";
        echo "Telefone: {$cotacao['telefone']}<br>";
        echo "Email: {$cotacao['email']}<br>";
        echo "Origem: {$cotacao['origem']}<br>";
        echo "Destino: {$cotacao['destino']}<br>";
        echo "Ida: {$cotacao['ida']}<br>";
        echo "Volta: {$cotacao['volta']}<br>";
        echo "Quantidae de Adultos: {$cotacao['qnt_adultos']}<br>";
        echo "Quantidade de Crianças: {$cotacao['qnt_criancas']}<br>";
        echo "Quantidade de Bagagens: {$cotacao['qnt_bagagens']}<br>";
        echo "Hotel: {$cotacao['hotel']}<br>";
        echo "Carro: {$cotacao['Carro']}<br>";
    }
} //

function deletar_cotacao($conexao, $id){
        // Adiciona a instrução no sql
        $sql = "DELETE FROM cotacao WHERE id = :id";

        // Prepara o codigo em sql
        $stmt = $conexao->prepare($sql);
        //Coloca o valor que sera troca pelo :id
        $stmt->bindParam(":id", $id); // bindParam() usa quando tiver pegando valor de uma variavel
        $stmt->execute();

        echo "Cotação $id deletada com sucesso";
} //

// Ver os dados de um cliente especifico baseado na sua conta e cotação
function unico_usuario($conexao,$id) {
    // 1. Busca os dados dos usuários
    $sql = "SELECT id, nome, email FROM usuarios WHERE id = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    // fetchAll traz TODOS os usuários cadastrados
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Percorre cada usuário retornado
    if($usuario) {
        echo "<hr>";
        echo "Nome: {$usuario['nome']} <br>";
        echo "Email: {$usuario['email']}<br>";

        // Chama a função auxiliar para contar as cotações deste usuário específico
        $total_cotacoes = quantidade_cotacoes($conexao, $usuario['id']);
        echo "Total de Cotações: " . $total_cotacoes . "<br>";
    } else {
        echo "<hr>Usuário não encontrado.";
    }
} //

// LOGIN

function cadastrar_user($conexao, $nome, $email, $senha){
    
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":email", $email); // bindValue - usa quando voce passa um valor direto
    $stmt->bindParam(":senha", password_hash($senha, PASSWORD_DEFAULT)); // gera o hash aqui
    $stmt->execute();
    echo "Usuario cadastrado com sucesso!";
}//

function consulta_user($conexao, $email){
    // Coloca a instrução em sql
    $sql = "SELECT id,email,senha FROM usuarios WHERE email = :email";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    return $usuario;
}


//// listar todos os clientes, baseados na sua conta, e listar quantas cotaçoes ja aforam feitas por eles
function mostrar_usuarios($conexao) {
    // 1. Busca os dados dos usuários
    $sql = "SELECT id, nome, email FROM usuarios";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    // fetchAll traz TODOS os usuários cadastrados
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Percorre cada usuário retornado
    foreach ($usuarios as $usuario) {
        echo "<hr>";
        echo "Nome: {$usuario['nome']} <br>";
        echo "Email: {$usuario['email']}<br>";

        // Chama a função auxiliar para contar as cotações deste usuário específico
        $total_cotacoes = quantidade_cotacoes($conexao, $usuario['id']);
        echo "Total de Cotações: " . $total_cotacoes . "<br>";
    }
} //

// Função auxiliar que conta quantas cotações um cliente específico possui
function quantidade_cotacoes($conexao, $id_cliente) {
    $sql = "SELECT COUNT(*) AS qnt_cotacao FROM cotacao WHERE id_cliente = :id_cliente";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id_cliente", $id_cliente);
    $stmt->execute();

    // fetch traz apenas uma linha com o resultado da contagem
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retorna apenas o número contado
    return $resultado['qnt_cotacao'];
} //


// - pegar id da conta do cliente no banco de dados
// - atribuir esse id a uma sessao
// - quando o cliente fazer uma cotaçao atribuir o id que esta na sessao a ela
// - quando ele for ver a cotaçao usar um SELECT COM WHERE com base no id

function atribuir_id($conexao, $email){
    // Coloca a instrução em sql
    $sql = "SELECT id FROM usuarios WHERE email = :email";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":email", $email); // bindParam() usa quando tiver pegando valor de uma variavel
    $stmt->execute();

    $id = $stmt->fetch(PDO::FETCH_ASSOC);

    return $id;
}


?>