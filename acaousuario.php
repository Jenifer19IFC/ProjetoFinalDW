<?php

    include_once "conf/default.inc.php";
    require_once "conf/Conexao.php";

    // Se foi enviado via GET para acaousuario entra aqui
    $acaousuario = isset($_GET['acaousuario']) ? $_GET['acaousuario'] : "";
    if ($acaousuario == "excluir"){
        $codigo = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : 0;
        excluir($codigo);
    }

    // Se foi enviado via POST para acaousuario entra aqui
    $acaousuario = isset($_POST['acaousuario']) ? $_POST['acaousuario'] : "";
    if ($acaousuario == "salvar"){
        $codigo = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : "";
        if ($codigo == 0)
            inserir($codigo);
        else
            editar($codigo);
    }

    // Métodos para cada operação
    function inserir($codigo){
        $dados = dadosForm();
        $nome = $dados['nome'];
        $cpf = $dados['cpf'];
        $bairro = $dados['bairro'];
        $cidade = $dados['cidade'];

        //var_dump($dados);
        
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('INSERT INTO usuario (nome, cpf) VALUES(:nome, :cpf)');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->execute();
        $codigo =$pdo->lastInsertId();
        $stmt = $pdo->prepare('INSERT INTO endereco (bairro, cidade, usuario_id) VALUES(:bairro, :cidade, :usuario_id)');
        $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        header("location:cadusuario.php");
        
    }

    function editar($codigo){
        $dados = dadosForm();
        var_dump($dados);
        $nome = $dados['nome'];
        $cpf = $dados['cpf'];
        $bairro = $dados['bairro'];
        $cidade = $dados['cidade'];
        $codigo = $dados['usuario_id'];
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('UPDATE usuario SET nome = :nome, cpf = :cpf WHERE usuario_id = :usuario_id');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = $pdo->prepare('UPDATE endereco SET bairro = :bairro, cidade = :cidade WHERE usuario_id = :usuario_id');
        $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        header("location:alistarusuario.php");
    }

    function excluir($codigo){
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('DELETE from endereco WHERE usuario_id = :usuario_id');
        $stmt->bindParam(':usuario_id', $codigo, PDO::PARAM_INT);
        $codigo = $codigo;
        $stmt->execute();
        $stmt = $pdo->prepare('DELETE from usuario WHERE usuario_id = :usuario_id');
        $stmt->bindParam(':usuario_id', $codigo, PDO::PARAM_INT);
        $codigo = $codigo;
        $stmt->execute();
        header("location:alistarusuario.php");
        
        //echo "Excluir".$codigo;

    }


    // Busca um item pelo código no BD
    function buscarDados($codigo){
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query("SELECT usuario.usuario_id, usuario.nome, usuario.cpf, endereco.bairro, endereco.cidade FROM usuario LEFT JOIN endereco ON endereco.usuario_id = usuario.usuario_id WHERE usuario.usuario_id = $codigo");
        $dados = array();
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $dados['usuario_id'] = $linha['usuario_id'];
            $dados['nome'] = $linha['nome'];
            $dados['cpf'] = $linha['cpf'];
            $dados['bairro'] = $linha['bairro'];
            $dados['cidade'] = $linha['cidade'];

        }
        //var_dump($dados);
        return $dados;
    }

    // Busca as informações digitadas no form
    function dadosForm(){
        $dados = array();
        $dados['usuario_id'] = $_POST['usuario_id'];
        $dados['nome'] = $_POST['nome'];
        $dados['cpf'] = $_POST['cpf'];
        $dados['bairro'] = $_POST['bairro'];
        $dados['cidade'] = $_POST['cidade'];
        return $dados;
    }

?>