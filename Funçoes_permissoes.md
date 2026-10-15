Para organizar seu código PHP de forma limpa e profissional, o recomendado é colocar todas as funções de autenticação em um arquivo separado (por exemplo, **`auth.php`** ou **`funcoes_autenticacao.php`**).

Aqui estão os nomes de funções padronizados (em camelCase e no imperativo/infinitivo), o que cada uma faz e como estruturar esse arquivo:

---

### Nomes das Funções e Suas Responsabilidades

#### 1. Gestão da Sessão e Usuário Logado

* **`iniciarSessao()`**: Abre a sessão com `session_start()`, garantindo que ela só seja iniciada uma única vez para evitar avisos (*warnings*) do PHP.
* **`estaLogado()`**: Retorna `true` se existir um usuário na sessão e `false` se não houver.
* **`obterUsuarioLogado()`**: Retorna um array com os dados do usuário logado (ID, nome, e-mail, perfil).

#### 2. Ações de Login e Logout

* **`fazerLogin($usuario)`**: Armazena os dados do usuário na `$_SESSION` e renova o ID da sessão por segurança (`session_regenerate_id`).
* **`fazerLogout()`**: Limpa a variável `$_SESSION`, destrói a sessão no servidor e redireciona para a tela de login.

#### 3. Proteção e Controle de Acesso (Guardiões)

* **`exigirLogin()`**: Verifica se o usuário está logado. Se não estiver, redireciona automaticamente para `login.php` e para a execução.
* **`exigirPerfil($perfilExigido)`**: Verifica se o usuário logado tem o perfil necessário (ex: `'ADMIN'` ou `'GERENTE'`). Se não tiver, exibe mensagem de acesso negado ou redireciona.
* **`temPermissao($permissao)`**: Retorna `true` ou `false` para checar se um gerente tem autorização para realizar uma ação específica.

---

### Exemplo Prático de Código (`auth.php`)

Crie o arquivo `auth.php` e cole o código abaixo:

```php
<?php

// 1. Inicializa a sessão com segurança
function iniciarSessao() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// 2. Verifica se o usuário está autenticado
function estaLogado() {
    iniciarSessao();
    return isset($_SESSION['usuario_id']);
}

// 3. Registra o login do usuário
function fazerLogin($usuario) {
    iniciarSessao();
    session_regenerate_id(true); // Segurança contra fixação de sessão

    $_SESSION['usuario_id']     = $usuario['id'];
    $_SESSION['usuario_nome']   = $usuario['nome'];
    $_SESSION['usuario_email']  = $usuario['email'];
    $_SESSION['usuario_perfil'] = $usuario['perfil']; // 'CLIENTE', 'GERENTE', 'ADMIN'
}

// 4. Retorna os dados do usuário atual
function obterUsuarioLogado() {
    iniciarSessao();
    if (!estaLogado()) {
        return null;
    }

    return [
        'id'     => $_SESSION['usuario_id'],
        'nome'   => $_SESSION['usuario_nome'],
        'email'  => $_SESSION['usuario_email'],
        'perfil' => $_SESSION['usuario_perfil']
    ];
}

// 5. Bloqueia o acesso a páginas que exigem login
function exigirLogin() {
    if (!estaLogado()) {
        header('Location: login.php');
        exit;
    }
}

// 6. Bloqueia o acesso por perfil (ex: Admin ou Gerente)
function exigirPerfil($perfilExigido) {
    exigirLogin();
    
    $usuario = obterUsuarioLogado();
    if ($usuario['perfil'] !== $perfilExigido) {
        http_response_code(403);
        die("Acesso negado: Você não tem permissão para acessar esta página.");
    }
}

// 7. Encerra a sessão
function fazerLogout() {
    iniciarSessao();
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
    header('Location: login.php');
    exit;
}

```

---

### Como Usar essas Funções no Seu Site

Agora, nas suas páginas do site, você só precisa importar esse arquivo usando `require_once 'auth.php'`:

#### Na página de checkout/cotação (`minhas-cotacoes.php`):

```php
<?php
require_once 'auth.php';

// Bloqueia automaticamente quem não estiver logado
exigirLogin();

$usuario = obterUsuarioLogado();
?>

<h1>Olá, <?php echo htmlspecialchars($usuario['nome']); ?>!</h1>
<p>Aqui estão suas cotações de viagem.</p>

```

#### Na página do painel administrativo (`admin.php`):

```php
<?php
require_once 'auth.php';

// Garante que só usuários com perfil ADMIN consigam entrar
exigirPerfil('ADMIN');
?>

<h1>Painel do Administrador</h1>

```

#### No arquivo de logout (`logout.php`):

```php
<?php
require_once 'auth.php';

fazerLogout();

```


---
---
---
---
---

O PHP possui um sistema de sessões nativo muito simples e poderoso. Ele cria um cookie temporário chamado `PHPSESSID` no navegador do usuário e guarda os dados reais no próprio servidor dentro da variável superglobal `$_SESSION`.

Abaixo está a estrutura mínima em PHP puro para implementar essa autenticação de forma segura.

---

### 1. Processo de Login (`login.php`)

Neste arquivo, você recebe o e-mail e a senha do formulário, valida no banco de dados e salva o usuário na sessão.

```php
<?php
// O session_start() DEVE ser a primeira linha do código (antes de qualquer HTML)
session_start();

// Exemplo simples simulando o recebimento dos dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // 1. Busca o usuário no banco de dados (exemplo ilustrativo)
    // $usuario = buscarNoBanco($email);

    // Exemplo estático apenas para ilustrar o teste:
    if ($email === 'cliente@email.com' && $senha === '123456') {
        
        // Boa prática de segurança: gera um novo ID de sessão após o login
        session_regenerate_id(true);

        // 2. Guarda os dados do usuário na variável global $_SESSION
        $_SESSION['usuario_id'] = 1;
        $_SESSION['usuario_nome'] = 'Maria Silva';
        $_SESSION['usuario_perfil'] = 'CLIENTE'; // ou 'GERENTE', 'ADMIN'

        // Redireciona para o painel
        header('Location: minhas-cotacoes.php');
        exit;
    } else {
        $erro = "E-mail ou senha incorretos!";
    }
}
?>

<!-- Formulário HTML simples -->
<form method="POST" action="login.php">
    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
    <input type="email" name="email" placeholder="Seu e-mail" required>
    <input type="password" name="senha" placeholder="Sua senha" required>
    <button type="submit">Entrar</button>
</form>

```

---

### 2. Proteger Páginas Exclusivas (`minhas-cotacoes.php`)

Para proteger qualquer página que exija login, verifique se a chave de sessão existe no topo do arquivo.

```php
<?php
session_start();

// Se a variável 'usuario_id' não existir na sessão, bloqueia o acesso
if (!isset($_SESSION['usuario_id'])) {
    // Redireciona para a página de login
    header('Location: login.php');
    exit; // O exit evita que o restante da página seja executado
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Minhas Cotações</title>
</head>
<body>
    <h1>Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
    <p>Perfil: <?php echo $_SESSION['usuario_perfil']; ?></p>
    
    <a href="logout.php">Sair do Sistema</a>
</body>
</html>

```

---

### 3. Restringir por Perfil de Acesso (Gerente / Admin)

Você pode criar verificações adicionais com a mesma sessão para controlar permissões:

```php
<?php
session_start();

// Verifica se está logado E se tem o perfil necessário
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_perfil'] !== 'ADMIN') {
    http_response_code(403);
    die("Acesso negado: Apenas administradores podem ver esta página.");
}

// Conteúdo restrito do administrador abaixo...

```

---

### 4. Encerrar a Sessão / Logout (`logout.php`)

Para deslogar o usuário, limpe as variáveis e destrua a sessão.

```php
<?php
session_start();

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Destrói a sessão no servidor
session_destroy();

// Redireciona o usuário para a página de login
header('Location: login.php');
exit;

```

---

### 3 Regras de Ouro para Trabalhar com Sessões no PHP

1. **`session_start()` sempre em primeiro lugar:** Chame essa função antes de exibir qualquer texto, espaço em branco ou tag HTML no arquivo. Caso contrário, o PHP retornará o erro *"Headers already sent"*.
2. **Sempre use `exit;` após `header('Location: ...')`:** O comando `header()` solicita o redirecionamento ao navegador, mas o script PHP continua rodando no servidor se você não colocar o `exit;`.
3. **Sempre limpe os dados com `htmlspecialchars()`:** Ao exibir no HTML dados vindos da sessão ou do banco (como o nome do usuário), use `htmlspecialchars($string)` para se proteger contra ataques do tipo XSS.