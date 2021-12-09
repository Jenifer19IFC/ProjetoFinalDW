<?php

    include_once "conf/default.inc.php";
    require_once "conf/Conexao.php";

    // Se foi enviado via GET para acaotipoDespesa entra aqui
    $acaotipoDespesa = isset($_GET['acaotipoDespesa']) ? $_GET['acaotipoDespesa'] : "";
    if ($acaotipoDespesa == "excluir"){
        $codigo = isset($_GET['id']) ? $_GET['id'] : 0;
        excluir($codigo);
    }

    // Se foi enviado via POST para acaotipoDespesa entra aqui
    $acaotipoDespesa = isset($_POST['acaotipoDespesa']) ? $_POST['acaotipoDespesa'] : "";
    if ($acaotipoDespesa == "salvar"){
        $codigo = isset($_POST['id']) ? $_POST['id'] : "";
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
        $stmt = $pdo->prepare('INSERT INTO tdespesa (categoria) VALUES(:categoria)');
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $categoria = $dados['categoria'];
        $stmt->execute();
        header("location:cadtipoDespesa.php");
        
    }

    function editar($codigo){
        $dados = dadosForm();
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('UPDATE tdespesa SET categoria = :categoria WHERE id = :id');
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmt->bindParam(':id', $codigo, PDO::PARAM_INT);
        $categoria = $dados['categoria'];
        $codigo = $dados['id'];
        $stmt->execute();
        header("location:alistartipoDespesa.php");
    }

    function excluir($codigo){
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('DELETE from tdespesa WHERE id = :id');
        $stmt->bindParam(':id', $codigoD, PDO::PARAM_INT);
        $codigoD = $codigo;
        $stmt->execute();
        header("location:alistartipoDespesa.php");
        
        //echo "Excluir".$codigo;

    }


    // Busca um item pelo código no BD
    function buscarDados($codigo){
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query("SELECT * FROM tdespesa WHERE id = $codigo");
        $dados = array();
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $dados['id'] = $linha['id'];
            $dados['categoria'] = $linha['categoria'];
        }
        //var_dump($dados);
        return $dados;
    }

    // Busca as informações digitadas no form
    function dadosForm(){
        $dados = array();
        $dados['id'] = $_POST['id'];
        $dados['categoria'] = $_POST['categoria'];
        return $dados;
    }

?>