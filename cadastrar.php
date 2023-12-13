<?php
    /*Esta linha inclui o arquivo usuarios.php, que deve conter a definição da classe Usuario. 
    O require_once é usado para garantir que o arquivo seja incluído apenas uma vez, evitando 
    inclusões duplicadas.*/
    require_once 'classes/usuarios.php';

    /*Esta linha cria uma nova instância da classe Usuario e atribui essa instância à variável 
    $u. O operador new é usado para instanciar um objeto a partir de uma classe. */
    $u = new Usuario(); 

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="css/style.css">

<body>
    <div id="corpo-form-cad">
    <h1>Cadastrar</h1>
    <form method ="POST"  >
        <input  type="nome"     name="nome"      class="input-estilo" placeholder="Nome Completo" maxlength="30">
        <input  type="telefone" name="telefone"  class="input-estilo" placeholder="Telefone" maxlength="30">
        <input  type="email"    name="email"     class="input-estilo" placeholder="Usuário" maxlength="40">
        <input  type="password" name="senha"     class="input-estilo" placeholder="Senha" maxlength="15">
        <input  type="password" name="confSenha" class="input-estilo" placeholder="Confirmar Senha" maxlength="15"> 
        <input  type="submit"                    class="input-estilo" value="CADASTRAR">
    </form>
    </div>

    <?php
// Verificar se a pessoa clicou no botão de submeter o formulário
if (isset($_POST['nome'])) {

    // Obter valores do formulário e aplicar proteção contra SQL injection
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);
    $confSenha = addslashes($_POST['confSenha']);

    // Verificar se há campos vazios
    if (!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confSenha)) {

        // Instanciar objeto $u da classe Usuario e conectar ao banco de dados
        $u->conectar("projeto_login", "localhost", "root", "");

        // Verificar se não houve erros na conexão
        if ($u->msgError == "") {    // se vazia, tudo ok

            // Verificar se os campos 'senha' e 'confSenha' são iguais.
            if ($senha == $confSenha) {

                // Se a conexão for bem-sucedida, chama o método cadastrar da classe Usuario
                if ($u->cadastrar($nome, $telefone, $email, $senha)) {

                    ?>
                    <div id="msg-sucesso">
                        Cadastrado com sucesso!
                    </div>
                    <?php

                } else {
                    ?>
                    <div class="msg-erro">
                        Email já cadastrado!
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="msg-erro">
                    Os campos 'Senha' e 'Confirmar senha' não correspondem!
                </div>
                <?php
            }
        } else {
            // Se houver erros na conexão, exibe a mensagem de erro
            ?>
            <div class="msg-erro">
                <?php echo "Erro: " . $u->msgError; ?>
            </div>
            <?php
        }
    } else {
        // Se há campos vazios, exibe mensagem para preencher todos os campos
        ?>
        <div class="msg-erro">
            Preencha todos os campos!
        </div>
        <?php
    }
}

?>
<a href="index.php">Sair</a>

</body>

</html>