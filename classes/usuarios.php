<?php

// link para conexão com phpMyAdim <http://localhost/phpmyadmin/index.php?route=/sql&pos=0&db=projeto_login&table=usuarios> 

/*Esse código PHP define uma classe chamada Usuario que encapsula operações relacionadas a
usuários em um sistema de login. */

Class Usuario
{   
    private $pdo;
    public $msgError="";
   
    /* Este método é responsável por estabelecer uma conexão com o banco de dados MySQL
    usando a extensão PDO (PHP Data Objects). Os parâmetros $nome, $host, $email, e $senha 
    representam respectivamente o nome do banco de dados, o host do banco de dados, o nome 
    de usuário e a senha.*/
    public function conectar($nome, $host, $email, $senha) 
    /*Dentro do método conectar, $msgErro é definida, mas 
    a variável global correta seria $this->msgError.*/
    {
        global $pdo;
        try 
        {   
            // Estabelece uma conexão PDO com o banco de dados
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$email, $senha); //ou $pdo = new PDO("mysql:dbname=projeto_login;host=localhost","root","");
        } 
        catch (PDOException $e) {
            $this->msgError = "Erro de conexão com o banco de dados: " . $e->getMessage(); //ou $msgError = $e->getMessage(); //echo "Erro com o banco de dados: ".$e->getMessage();
        }
        catch(Exception $e) {
            $this->msgError = "Erro genérico: " . $e->getMessage(); //ou echo "Erro generico: ".$e->getMessage();
        }
            
    }

    /*Este método verifica se um usuário com o mesmo e-mail já está cadastrado no banco de dados. 
    Se não estiver, ele realiza o cadastro do novo usuário. A senha é convertida para o formato MD5 
    antes de ser armazenada no banco de dados, o que não é considerado uma prática segura nos dias 
    de hoje.*/
    public function cadastrar($nome, $telefone, $email, $senha)
    {
        global $pdo;        

        //verificar se já existe o email cadastrado
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
        $sql -> bindValue(":e",$email);
        $sql -> execute();
        if($sql->rowCount() > 0)
        {
            return false; // ja esta cadastrado
        }
        else
        {
            //caso não, cadastrar.
            $sql = $pdo->prepare("INSERT INTO usuarios (nome,telefone,email,senha) VALUES(:n, :t, :e, :s)");
            $sql -> bindValue(":n",$nome);
            $sql -> bindValue(":t",$telefone);
            $sql -> bindValue(":e",$email);
            $sql -> bindValue(":s",md5($senha));
            $sql->execute();
            return true; //tudo ok
        }

    }

    /*Este método verifica se as credenciais (e-mail e senha) fornecidas correspondem a um usuário 
    no banco de dados. Se sim, inicia uma sessão e armazena o ID do usuário na variável de sessão 
    $_SESSION['id_usuario']*/
    public function logar($email, $senha)
    {
        global $pdo;

        //verificar se o email e a senha estão cadastrados,se sim
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
        $sql->bindValue(":e", $email);
        $sql->bindValue(":s", md5($senha));
        $sql->execute();
        if($sql->rowCount() > 0) 
        {
            // Em caso de sucesso, inicia a sessão e armazena o ID do usuário
            $dado = $sql->fetch();
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true; //logado com sucesso
        }
        else
        {
            
            return false; //não foi possivel logar
        }
        
    }

    /*Obtém as informações do usuário pelo ID.*/
    public function obterInformacoesUsuario($id_usuario)
    {
        global $pdo;

        try {
            // Consulta SQL para obter informações do usuário pelo ID
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = :id");
            $sql->bindValue(":id", $id_usuario);
            $sql->execute();

            // Retorna as informações do usuário como um array associativo
            return $sql->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Lida com erros de consulta SQL, você pode ajustar conforme necessário
            die("Erro ao obter informações do usuário: " . $e->getMessage());
        }
    }

}

?>
