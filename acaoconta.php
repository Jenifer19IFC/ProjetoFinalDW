<?php

    include_once "conf/default.inc.php";
    require_once "conf/Conexao.php";

    // Se foi enviado via GET para acao entra aqui
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    if ($acao == "excluir"){
        $codigo = isset($_GET['conta_id']) ? $_GET['conta_id'] : 0;
        excluir($codigo);
    }

    // Se foi enviado via POST para acao entra aqui
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
    if ($acao == "salvar"){
        $codigo = isset($_POST['conta_id']) ? $_POST['conta_id'] : "";
        if ($codigo == 0)
            inserir($codigo);
        else
            editar($codigo);
    }

    // Métodos para cada operação
    function inserir($codigo){
        $dados = dadosForm();
        //var_dump($dados);
        
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('INSERT INTO conta (saldo) VALUES(:saldo)');
        $stmt->bindParam(':saldo', $saldo, PDO::PARAM_STR);
        $saldo = $dados['saldo'];
        $stmt->execute();
        header("location:cadconta.php");
        
    }

    function editar($codigo){
        $dados = dadosForm();
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('UPDATE conta SET saldo = :saldo WHERE conta_id = :conta_id');
        $stmt->bindParam(':saldo', $saldo, PDO::PARAM_STR);
        $stmt->bindParam(':conta_id', $codigo, PDO::PARAM_INT);
        $saldo = $dados['saldo'];
        $codigo = $dados['conta_id'];
        $stmt->execute();
        header("location:alistarconta.php");
    }

    function excluir($codigo){
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('DELETE from conta WHERE conta_id = :conta_id');
        $stmt->bindParam(':conta_id', $codigoD, PDO::PARAM_INT);
        $codigoD = $codigo;
        $stmt->execute();
        header("location:alistarconta.php");
        
        //echo "Excluir".$codigo;

    }

    // Busca um item pelo código no BD
    function buscarDados($codigo){
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query("SELECT * FROM conta WHERE conta_id = $codigo");
        $dados = array();
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $dados['conta_id'] = $linha['conta_id'];
            $dados['saldo'] = $linha['saldo'];
        }
        //var_dump($dados);
        return $dados;
    }

    // Busca as informações digitadas no form
    function dadosForm(){
        $dados = array();
        $dados['conta_id'] = $_POST['conta_id'];
        $dados['saldo'] = $_POST['saldo'];
        return $dados;
    }

?>