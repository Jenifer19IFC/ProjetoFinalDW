<?php
header('Content-Type: text/html; charset=UTF-8');
include 'connect/connect.php';
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";

$acao = '';
if (isset($_GET["acao"]))
    $acao = $_GET["acao"];

if ($acao == "excluir") {
    $codigo = 0;
    if (isset($_GET["id"])) {
        $codigo = $_GET["id"];
        excluir($codigo);
    }
} else {
    if (isset($_POST["acao"])) {
        $acao = $_POST["acao"];
        if ($acao == "salvar") {
            $codigo = 0;
            if (isset($_POST["id"])) {
                $codigo = $_POST["id"];
                if ($codigo == 0)
                    inserir();
                else
                    alterar($codigo);
            }
        }
    }
}

function excluir($codigo)
{
    $sql = "DELETE FROM despesa WHERE id = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    if ($result == 1)
        header('location:alistardespesa.php');
    else
        header('location:alistardespesa.php');
}

function alterar($codigo)
{
    $vet = carregarTelaParaVetor();
    $sql = 'UPDATE ' . $GLOBALS['tb_despesa'] .
        ' SET tipo_despesa_id = ' . $vet['tdespesa'] . '' .
        ', conta_conta_id = ' . $vet['conta'] .
        ', valor = ' . $vet['valor'] . '' .
        ', data = "' . $vet['data'] . '"' .
        ' WHERE id = ' . $codigo;
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    if ($result == 1)
        header('location:caddespesa.php?msg="sa"&acao=editar&id=' . $codigo);
    else
        header('location:caddespesa.php?msg="er"&acao=editar&id=' . $codigo);
}

function inserir()
{

    $dados = carregarTelaParaVetor();
    //var_dump($dados);

    $pdo = Conexao::getInstance();
    $stmt = $pdo->prepare('INSERT INTO despesa ( valor, data, tipo_despesa_id, conta_conta_id) VALUES (:valor, :data, :tipo_despesa_id, :conta_conta_id)');
    $valor = $dados['valor'];
    $data = $dados['data'];
    $tipo_despesa_id = $dados['tdespesa'];
    $conta = $dados['conta'];
    $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
    $stmt->bindParam(':data', $data, PDO::PARAM_STR);
    $stmt->bindParam(':tipo_despesa_id', $tipo_despesa_id, PDO::PARAM_INT);
    $stmt->bindParam(':conta_conta_id', $conta, PDO::PARAM_INT);

    $stmt->execute();

    header("location:caddespesa.php");

}

function carregarTelaParaVetor()
{
    $vet = array();
    $vet['id'] = $_POST["id"];
    $vet['valor'] = $_POST["valor"];
    $vet['data'] = $_POST["data"];
    $vet['tdespesa'] = $_POST["tdespesa"];
    $vet['conta'] = $_POST["conta"];
    return $vet;
}

function carregaBDParaVetor($codigo)
{
    $sql = "SELECT * FROM despesa WHERE id = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    $dados = array();
    while ($row = mysqli_fetch_array($result)) {
        $dados['id'] = $row['id'];
        $dados['valor'] = $row['valor'];
        $dados['data'] = $row['data'];
        $dados['tdespesa'] = $row['tipo_despesa_id'];
        $dados['conta'] = $row['conta_conta_id'];

    }
    return $dados;
    //var_dump($dados);
}
