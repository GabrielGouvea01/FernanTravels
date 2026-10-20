<?php
require_once __DIR__ . '/../database/connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function escapar_html($valor)
{
    return htmlspecialchars((string) ($valor ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function exibir_cotacoes($cotacoes, $exibir_id = false)
{
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

    if (!$cotacoes) {
        echo '<p>Nenhuma cotação encontrada.</p>';
        return;
    }

    foreach ($cotacoes as $cotacao) {
        echo '<article><hr>';
        if ($exibir_id) {
            echo '<strong>ID:</strong> ' . escapar_html($cotacao['id']) . '<br>';
        }
        foreach ($campos as $campo => $rotulo) {
            echo '<strong>' . escapar_html($rotulo) . ':</strong> '
                . escapar_html($cotacao[$campo] ?? '') . '<br>';
        }
        echo '</article>';
    }
}

function nova_cotacao($conexao, $nome, $telefone, $email, $origem, $destino, $ida, $volta, $qnt_adultos, $qnt_criancas, $qnt_bagagens, $hotel, $carro, $id_cliente)
{
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

function atualizar_cotacao($conexao, $nome, $telefone, $email, $origem, $destino, $ida, $volta, $qnt_adultos, $qnt_criancas, $qnt_bagagens, $hotel, $carro, $id_cliente, $id)
{
    $sql = 'UPDATE cotacao SET nome = :nome, telefone = :telefone, email = :email, origem = :origem,
            destino = :destino, ida = :ida, volta = :volta, qnt_adultos = :qnt_adultos,
            qnt_criancas = :qnt_criancas, qnt_bagagens = :qnt_bagagens, hotel = :hotel,
            carro = :carro WHERE id = :id AND id_cliente = :id_cliente';
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

    echo $stmt->rowCount() > 0
        ? 'Cotação atualizada com sucesso!'
        : 'Cotação não encontrada para este usuário.';
}

function consultar($conexao, $id)
{
    $stmt = $conexao->prepare('SELECT * FROM cotacao WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $cotacao = $stmt->fetch(PDO::FETCH_ASSOC);

    exibir_cotacoes($cotacao ? [$cotacao] : [], true);
}

function historico_unico($conexao, $id_cliente)
{
    $stmt = $conexao->prepare('SELECT * FROM cotacao WHERE id_cliente = :id_cliente ORDER BY id DESC');
    $stmt->execute([':id_cliente' => $id_cliente]);
    exibir_cotacoes($stmt->fetchAll(PDO::FETCH_ASSOC), true);
}

function historico_geral($conexao)
{
    $stmt = $conexao->query('SELECT * FROM cotacao ORDER BY id DESC');
    exibir_cotacoes($stmt->fetchAll(PDO::FETCH_ASSOC), true);
}

function deletar_cotacao($conexao, $id)
{
    $stmt = $conexao->prepare('DELETE FROM cotacao WHERE id = :id');
    $stmt->execute([':id' => $id]);

    echo $stmt->rowCount() > 0
        ? 'Cotação ' . escapar_html($id) . ' deletada com sucesso.'
        : 'Cotação não encontrada.';
}

function unico_usuario($conexao, $id)
{
    $stmt = $conexao->prepare('SELECT id, nome, email FROM usuarios WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo '<hr>Usuário não encontrado.';
        return;
    }

    echo '<hr><strong>Nome:</strong> ' . escapar_html($usuario['nome']) . '<br>';
    echo '<strong>Email:</strong> ' . escapar_html($usuario['email']) . '<br>';
    echo '<strong>Total de cotações:</strong> '
        . escapar_html(quantidade_cotacoes($conexao, $usuario['id'])) . '<br>';
}

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

function consulta_user($conexao, $email)
{
    $stmt = $conexao->prepare('SELECT id, email, senha, perfil FROM usuarios WHERE email = :email');
    $stmt->execute([':email' => $email]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function mostrar_usuarios($conexao)
{
    $stmt = $conexao->query('SELECT id, nome, email FROM usuarios ORDER BY id');
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

function quantidade_cotacoes($conexao, $id_cliente)
{
    $stmt = $conexao->prepare('SELECT COUNT(*) FROM cotacao WHERE id_cliente = :id_cliente');
    $stmt->execute([':id_cliente' => $id_cliente]);

    return (int) $stmt->fetchColumn();
}

function atribuir_id($conexao, $email)
{
    $stmt = $conexao->prepare('SELECT id FROM usuarios WHERE email = :email');
    $stmt->execute([':email' => $email]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}