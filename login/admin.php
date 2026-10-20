<?php
// Inicia a sessão somente se ela ainda não estiver ativa.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Envia visitantes sem login para a tela de entrada.
if (!isset($_SESSION['id'])) {
    header("Location: /login/login.php");
    exit();
}

// Impede que usuários sem perfil administrativo continuem nesta página.
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'admin') {
    header("Location: /index.php");
    exit();
}
