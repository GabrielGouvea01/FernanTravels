<header>
    <!-- Logo e link para voltar à página inicial. -->
    <a class="header-brand" href="/index.php" aria-label="fernantravels - página inicial">
        <img src="/fernantravels/image/logo_oficial.jpg" alt="Logo FernanTravels">
        <h1>FernanTravels</h1>
    </a>
    <!-- Mantém os links da conta no canto superior direito. -->
    <nav class="header-account" aria-label="Conta">
        <a href="/fernantravels/login/login.php">Conta</a>
        <a href="/fernantravels/login/logout.php">Sair</a>
    </nav>
    <!-- Links principais disponíveis no site. -->
    <nav aria-label="Navegação principal">
        <a href="/fernantravels/index.php">Inicial</a>
        <a href="/fernantravels/app/nova_cotacao.php">Fazer cotação</a>
        <a href="/fernantravels/app/historico.php">Histórico</a>
        <a href="/fernantravels/app/atualizar_cota.php">Atualizar cotação</a>
    </nav>
    <!-- Links administrativos aparecem somente para a sessão de administrador. -->
    <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'admin'): ?>
        <nav aria-label="Navegação administrativa">
            <a href="/fernantravels/admin/ver_cotacoes.php">Ver cotações</a>
            <a href="/fernantravels/admin/ver_clientes.php">Ver clientes</a>
            <a href="/fernantravels/admin/cliente.php">Cliente</a>
            <a href="/fernantravels/admin/historico_cliente.php">Histórico de cliente</a>
            <a href="/fernantravels/admin/deletar_cotacao.php">Deletar cotação</a>
        </nav>
    <?php endif; ?>
    <!-- Separador visual abaixo da navegação. -->
    <hr>
</header>