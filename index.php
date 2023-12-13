<?php 

require_once 'classes/usuarios.php';
$u = new Usuario(); 

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div id="corpo-form">
    <h1>Entrar</h1>
    <form method ="POST" >
        <input  type="email" class="input-estilo" placeholder="Usuário" name="email" required>
        <input  type="password" class="input-estilo" placeholder="Senha" name="senha" required> 
        <input  type="submit" class="input-estilo" value="ACESSAR">

        <a href="cadastrar.php">Ainda não é inscrito?<strong>Cadastre-se</strong></a>
    </form>
    </div>

    <?php

    /*--- Configure cabeçalhos HTTP para evitar o cache na página de login, assim os navegadores 
    não armazenarão uma versão em cache da página que pode conter informações do último usuário. 
    Adicione isso no início do seu script de login (antes de qualquer saída)
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0"); ---*/


    if (isset($_POST['email'])) {

        // Obter valores do formulário e aplicar proteção contra SQL injection
       
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);
   
        // Verificar se há campos vazios
        if (!empty($email) && !empty($senha)) {
            $u->conectar("projeto_login", "localhost", "root", "");
            
            // if($u->msgError == "") {
            // ^- Esta linha estava comentada, então você precisa remover o comentário.
            
            if ($u->logar($email, $senha)) {
                header("location: areaPrivada.php");
                exit();
            } else {
                ?>
                <div class="msg-erro">
                    Email e/ou Senha incorretos!
                </div>
                <?php
            }
        } else {
            ?>
            <div class="msg-erro">
                Preencha todos os campos!
            </div>
            <?php
        }
    } else {
        
    }
?>

</body>

</html>