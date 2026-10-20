<header>
    <a class="header-brand" href="/index.php" aria-label="FernanTravels - página inicial">
        <img src="/image/logo_oficial.jpg" alt="Logo FernanTravels">
        <h1>FernanTravels</h1>
    </a>
    <nav aria-label="Navegação principal">
        <a href="/index.php">Inicial</a>
        <a href="/app/nova_cotacao.php">Fazer cotação</a>
        <a href="/app/historico.php">Histórico</a>
        <a href="/app/atualizar_cota.php">Atualizar cotação</a>
        <a href="/login/login.php">Conta</a>
        <a href="/login/logout.php">Sair</a>
    </nav>
    <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'admin'): ?>
        <nav aria-label="Navegação administrativa">
            <a href="/admin/ver_cotacoes.php">Ver cotações</a>
            <a href="/admin/ver_clientes.php">Ver clientes</a>
            <a href="/admin/cliente.php">Cliente</a>
            <a href="/admin/historico_cliente.php">Histórico de cliente</a>
            <a href="/admin/deletar_cotacao.php">Deletar cotação</a>
        </nav>
    <?php endif; ?>
    <hr>
</header>