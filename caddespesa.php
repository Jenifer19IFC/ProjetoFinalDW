<!DOCTYPE html>
<?php 
    $title = "Cadastro de Receitas";
    include 'connect/connect.php';
    include 'acaodespesa.php';
    $acao = '';
    $id = '';
    $dados;
    if (isset($_GET["acao"]))
        $acao = $_GET["acao"];
    if ($acao == "editar"){
        if (isset($_GET["id"])){
            $codigo = $_GET["id"];
            $dados = carregaBDParaVetor($codigo);
            //var_dump($dados);
        }
    }
?>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>        
</head>
<body>
    <a href="alistardespesa.php"><button>Listar</button></a><br><br>
    <form action="acaodespesa.php" id="form" method="post">
    <input readonly  type="text" name="id" id="id" value="<?php if ($acao == "editar") echo $dados['id']; else echo 0; ?>"><br><br>
        <label for="">Tipo da despesa</label>
        <select name="tdespesa" id="tdespesa">
            <?php
            $sql = "SELECT * FROM tdespesa;";
            #$pdo = Conexao::getInstance();
            #$consulta = $pdo->query($sql);
            $result = mysqli_query($conexao, $sql);
            #while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            while ($row = mysqli_fetch_array($result)) {
                echo '<option value="' . $row['id'] . '"';
                if ($acao == "editar" && $dados['tdespesa'] == $row['id'])
                    echo ' selected';
                echo '>' . $row['categoria'] . '</option>';
            }
            ?>
        </select>
        <br><br>
        <label for="">ID conta</label>
        <input readonly name="conta" value= " <?php echo $_GET['conta_id'] ?>">
            <?php
            /*$sql = "SELECT * FROM conta;";
            $result = mysqli_query($conexao, $sql);
            while ($row = mysqli_fetch_array($result)) {
                echo '<option value="' . $row['conta_id'] . '"';
                if ($acao == "editar" && $dados['conta'] == $row['conta_id'])
                    echo ' selected';
                echo '>' . $row['conta_id'] . '</option>';
            }*/
            ?>
        </select>
        <br><br>
        <label for="">Valor da despesa</label>
        <input required=true placeholder="valor" type="text" name="valor" id="valor" value="<?php if ($acao == "editar") echo $dados['valor']; ?>"><br>
        <br>
        <label for="">Data</label>
        <input required=true placeholder="data" type="date" name="data" id="data" value="<?php if ($acao == "editar") echo $dados['data']; ?>"><br>
        <br>
        <button name="acao" value="salvar" id="acao" type="submit">Salvar</button>
    </form>
</body>
</html>