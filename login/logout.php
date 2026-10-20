<?php
// Inicia a sessão para que seus dados possam ser removidos.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Apaga os dados de login guardados na sessão.
$_SESSION = [];

// Finaliza a sessão e retorna para a página inicial.
session_destroy();
header('Location: ../index.php');
exit();