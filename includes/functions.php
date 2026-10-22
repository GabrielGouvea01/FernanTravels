<?php
// Carrega os dados de conexão com o banco de dados.
require_once __DIR__ . '/../database/connect.php';

// Inicia a sessão para guardar as informações do usuário conectado.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Prepara um valor para ser mostrado com segurança em uma página HTML.
function escapar_html($valor)
{
    return htmlspecialchars((string) ($valor ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Mostra os dados de uma ou mais cotações recebidas do banco.
function exibir_cotacoes($cotacoes, $exibir_id = false)
{
    // Relaciona o nome de cada campo com o texto que aparece na página.
    $campos = [
        'nome' => 'Nome',
        'telefone' => 'Telefone',
        'email' => 'Email',
        'origem' => 'Origem',
        'destino' => 'Destino',
        'ida' => 'Ida',
        'volta' => 'Volta',
        'qnt_adultos' => 'Quantidade de adultos',
        'qnt_criancas' => 'Quantidade de crianças',
        'qnt_bagagens' => 'Quantidade de bagagens',
        'hotel' => 'Hotel',
        'carro' => 'Carro',
    ];

    // Informa quando a busca não encontrou cotações.
    if (!$cotacoes) {
        echo '<p>Nenhuma cotação encontrada.</p>';
        return;
    }

    // Mostra os dados de cada cotação.
    foreach ($cotacoes as $cotacao) {
        echo '<article><hr>';
        // Verifica se a flag $exibir_id está ativa antes de mostrar o ID da cotação
        if ($exibir_id) {
            // Exibe o ID contra ataques XSS usando a função escapar_html()
            echo '<strong>ID:</strong> ' . escapar_html($cotacao['id']) . '<br>';
        }
        // Percorre o mapa de campos ($chave_no_array => $texto_do_rotulo)
        foreach ($campos as $campo => $rotulo) {
            // Imprime o rótulo do campo em negrito e o seu respectivo valor
            // O operador '??' evita erros de índice ausente (undefined index) caso o campo seja nulo
            echo '<strong>' . escapar_html($rotulo) . ':</strong> '
                . escapar_html($cotacao[$campo] ?? '') . '<br>';
        }
        echo '</article>';
    }
}

// Salva uma nova cotação e associa ela à conta que está conectada.
function nova_cotacao($conexao, $nome, $telefone, $email, $origem, $destino, $ida, $volta, $qnt_adultos, $qnt_criancas, $qnt_bagagens, $hotel, $carro, $id_cliente)
{
    // Define os campos que serão preenchidos na tabela de cotações.
    $sql = 'INSERT INTO cotacao (nome, telefone, email, origem, destino, ida, volta, qnt_adultos, qnt_criancas, qnt_bagagens, hotel, carro, id_cliente)
            VALUES (:nome, :telefone, :email, :origem, :destino, :ida, :volta, :qnt_adultos, :qnt_criancas, :qnt_bagagens, :hotel, :carro, :id_cliente)';
    $stmt = $conexao->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':telefone' => $telefone,
        ':email' => $email,
        ':origem' => $origem,
        ':destino' => $destino,
        ':ida' => $ida,
        ':volta' => $volta,
        ':qnt_adultos' => $qnt_adultos,
        ':qnt_criancas' => $qnt_criancas,
        ':qnt_bagagens' => $qnt_bagagens,
        ':hotel' => $hotel,
        ':carro' => $carro,
        ':id_cliente' => $id_cliente,
    ]);

    echo 'Cotação feita com sucesso!';
}

// Atualiza os dados da cotação somente se ela pertencer ao usuário informado.
function atualizar_cotacao($conexao, $nome, $telefone, $email, $origem, $destino, $ida, $volta, $qnt_adultos, $qnt_criancas, $qnt_bagagens, $hotel, $carro, $id_cliente, $id)
{
    $sql = 'UPDATE cotacao SET nome = :nome, telefone = :telefone, email = :email, origem = :origem, destino = :destino, ida = :ida, volta = :volta, qnt_adultos = :qnt_adultos, qnt_criancas = :qnt_criancas, qnt_bagagens = :qnt_bagagens, hotel = :hotel, carro = :carro WHERE id = :id AND id_cliente = :id_cliente';
    $stmt = $conexao->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':telefone' => $telefone,
        ':email' => $email,
        ':origem' => $origem,
        ':destino' => $destino,
        ':ida' => $ida,
        ':volta' => $volta,
        ':qnt_adultos' => $qnt_adultos,
        ':qnt_criancas' => $qnt_criancas,
        ':qnt_bagagens' => $qnt_bagagens,
        ':hotel' => $hotel,
        ':carro' => $carro,
        ':id' => $id,
        ':id_cliente' => $id_cliente,
    ]);

    // Mostra se a atualização encontrou uma cotação do usuário.
    echo $stmt->rowCount() > 0
        ? 'Cotação atualizada com sucesso!'
        : 'Cotação não encontrada para este usuário.';
}



// Busca e mostra todas as cotações de um cliente.
function historico_unico($conexao, $id_cliente)
{
    $stmt = $conexao->prepare('SELECT * FROM cotacao WHERE id_cliente = :id_cliente ORDER BY id DESC');
    $stmt->execute([':id_cliente' => $id_cliente]);
    exibir_cotacoes($stmt->fetchAll(PDO::FETCH_ASSOC), true);
}

// Busca e mostra todas as cotações cadastradas.
function historico_geral($conexao)
{
    $stmt = $conexao->query('SELECT * FROM cotacao ORDER BY id DESC');
    exibir_cotacoes($stmt->fetchAll(PDO::FETCH_ASSOC), true);
}

// Exclui uma cotação pelo ID informado.
function deletar_cotacao($conexao, $id)
{
    $stmt = $conexao->prepare('DELETE FROM cotacao WHERE id = :id');
    $stmt->execute([':id' => $id]);

    // Informa se a cotação foi encontrada e removida.
    echo $stmt->rowCount() > 0
        ? 'Cotação ' . escapar_html($id) . ' deletada com sucesso.'
        : 'Cotação não encontrada.';
}

// Procura um usuário pelo ID e mostra também quantas cotações ele tem.
function unico_usuario($conexao, $id)
{
    $stmt = $conexao->prepare('SELECT id, nome, email FROM usuarios WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Encerra a função se não encontrar o usuário.
    if (!$usuario) {
        echo '<hr>Usuário não encontrado.';
        return;
    }

    echo '<hr><strong>Nome:</strong> ' . escapar_html($usuario['nome']) . '<br>';
    echo '<strong>Email:</strong> ' . escapar_html($usuario['email']) . '<br>';
    echo '<strong>Total de cotações:</strong> '
        . escapar_html(quantidade_cotacoes($conexao, $usuario['id'])) . '<br>';
}

// Cria uma conta e guarda a senha em formato protegido.
function cadastrar_user($conexao, $nome, $email, $senha)
{
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)';
    $stmt = $conexao->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':senha' => $senha_hash,
    ]);
}

// Busca os dados da conta usada durante o login.
function consulta_user($conexao, $email)
{
    $stmt = $conexao->prepare('SELECT id, email, senha, perfil FROM usuarios WHERE email = :email');
    $stmt->execute([':email' => $email]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Lista os usuários cadastrados e a quantidade de cotações de cada um.
function mostrar_usuarios($conexao)
{
    $stmt = $conexao->query('SELECT id, nome, email FROM usuarios ORDER BY id');
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Informa quando não existem usuários para listar.
    if (!$usuarios) {
        echo '<p>Nenhum cliente encontrado.</p>';
        return;
    }

    foreach ($usuarios as $usuario) {
        echo '<hr><strong>ID:</strong> ' . escapar_html($usuario['id']) . '<br>';
        echo '<strong>Nome:</strong> ' . escapar_html($usuario['nome']) . '<br>';
        echo '<strong>Email:</strong> ' . escapar_html($usuario['email']) . '<br>';
        echo '<strong>Total de cotações:</strong> '
            . escapar_html(quantidade_cotacoes($conexao, $usuario['id'])) . '<br>';
    }
}

// Conta quantas cotações pertencem a um cliente.
function quantidade_cotacoes($conexao, $id_cliente)
{
    $stmt = $conexao->prepare('SELECT COUNT(*) FROM cotacao WHERE id_cliente = :id_cliente');
    $stmt->execute([':id_cliente' => $id_cliente]);

    return (int) $stmt->fetchColumn();
}



// Procura uma cotação pelo ID e mostra o resultado.
function consultar($conexao, $id)
{
    $stmt = $conexao->prepare('SELECT * FROM cotacao WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $cotacao = $stmt->fetch(PDO::FETCH_ASSOC);

    exibir_cotacoes($cotacao ? [$cotacao] : [], true);
}

// Localiza o ID do usuário associado ao e-mail informado.
function atribuir_id($conexao, $email)
{
    $stmt = $conexao->prepare('SELECT id FROM usuarios WHERE email = :email');
    $stmt->execute([':email' => $email]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}