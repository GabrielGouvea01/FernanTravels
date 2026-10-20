<?php 
// Garante que os dados da sessão possam ser consultados.
if(session_status() == PHP_SESSION_NONE){
    session_start();

}
// Abre a tela de login quando a sessão não tem usuário autenticado.
if(!isset($_SESSION['id'])){
    header("Location: ../login/login.php");
    exit();
}
?>