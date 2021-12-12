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
    $sql = "DELETE FROM receita WHERE id = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    if ($result == 1)
        header('location:alistarreceita.php');
    else
        header('location:alistarreceita.php');
}

function alterar($codigo)
{
    $vet = carregarTelaParaVetor();
    //var_dump($vet);
    $sql = 'UPDATE ' . $GLOBALS['tb_receita'] .
        ' SET tipo_receita_id = "' . $vet['treceita'] . '"' .
        ', conta_id = ' . $vet['conta'] .
        ', valor = "' . $vet['valor'] . '"' .
        ', data = "' . $vet['data'] . '"' .
        ' WHERE id = ' . $codigo;
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    
    header("location:cadcontamaster.php?acao=editar&conta_id=".$vet['conta']);
}

function inserir()
{

    $dados = carregarTelaParaVetor();
    //var_dump($dados);

    $pdo = Conexao::getInstance();
    $stmt = $pdo->prepare('INSERT INTO receita (id, valor, data, tipo_receita_id, conta_id) VALUES (:id, :valor, :data, :tipo_receita_id, :conta_id)');
    $codigo = $dados['id'];
    $valor = $dados['valor'];
    $data = $dados['data'];
    $tipo_receita_id = $dados['treceita'];
    $conta_id = $dados['conta'];
    $stmt->bindParam(':id', $codigo, PDO::PARAM_INT);
    $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
    $stmt->bindParam(':data', $data, PDO::PARAM_STR);
    $stmt->bindParam(':tipo_receita_id', $tipo_receita_id, PDO::PARAM_INT);
    $stmt->bindParam(':conta_id', $conta_id, PDO::PARAM_INT);

    $stmt->execute();

    header("location:cadcontamaster.php?acao=editar&conta_id=$conta_id");

}

function carregarTelaParaVetor()
{
    $vet = array();
    $vet['id'] = $_POST["id"];
    $vet['valor'] = $_POST["valor"];
    $vet['data'] = $_POST["data"];
    $vet['treceita'] = $_POST["treceita"];
    $vet['conta'] = $_POST["conta"];
    return $vet;
}

function carregaBDParaVetor($codigo)
{
    $sql = "SELECT * FROM receita WHERE id = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    $dados = array();
    while ($row = mysqli_fetch_array($result)) {
        $dados['id'] = $row['id'];
        $dados['valor'] = $row['valor'];
        $dados['data'] = $row['data'];
        $dados['treceita'] = $row['tipo_receita_id'];
        $dados['conta'] = $row['conta_id'];
    }
    return $dados;
}
