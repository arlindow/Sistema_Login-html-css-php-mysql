<?php

    require_once 'classes/usuarios.php';
    
    $u = new Usuario(); 

    // Inicia a sessão para permitir o uso de variáveis de sessão
    session_start();
    // Verifica se a variável de sessão 'id_usuario' não está definida
    if(!isset($_SESSION['id_usuario']))
    {
        // Redireciona o usuário para a página 'index.php'
        header("location: index.php");
        // Encerra a execução do script
        exit;
    }

// Supondo que a classe Usuario tenha um método para obter informações do usuário
    $u->conectar("projeto_login", "localhost", "root", "");
    $usuario = new Usuario();
    $informacoesUsuario = $usuario->obterInformacoesUsuario($_SESSION['id_usuario']);
    $nomeUsuario = $informacoesUsuario['nome'];
?>

<!-- Seção de HTML abaixo -->
SEJA BEM-VINDO, <?php echo $nomeUsuario; ?>!!!!!!
<a href="Sair.php">Sair</a>
