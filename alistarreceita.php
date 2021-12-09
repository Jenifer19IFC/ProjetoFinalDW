<!DOCTYPE html>
<?php
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";
?>
<html lang="pt-br">

<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Operações</title>
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>
    <style>
        table {
            text-align: center;
            margin: 0 auto;
            border-collapse: collapse;
            width: 100%;
            border-radius: 5px;
            border-style: hidden;
            box-shadow: 0 0 0 1px black;
        }

        tr,
        th,
        td {
            border: 1px solid black;
        }

        th {
            width: 5%;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
<?php
    include  "menu.php" ;
?>
    <a href="cadreceita.php">Nova Receita</a><br><br>
    <form method="POST">
        <b>Consultar por:</b> <br>
        <input type="radio" name="optionSearchUser" id="" value="id" required>Código<br>
        <input type="radio" name="optionSearchUser" id="" value="valor" required>Valor<br>
        <input type="radio" name="optionSearchUser" id="" value="categoria" required>Categoria<br><br>
        <b>Ordenar por:</b> <br>
        <input type="radio" name="optionOrderUser" id="" value="id" required>Código<br>
        <input type="radio" name="optionOrderUser" id="" value="valor" required>Valor<br>
        <input type="radio" name="optionOrderUser" id="" value="categoria" required>Categoria<br>
        <br>
        <a href="alistarreceita.php">Listar todos</a><br>
        <input type="text" name="valorUser">
        <input type="submit" value="Consultar">
    </form>
    <?php
 try {

        $optionSearchUser = isset($_POST["optionSearchUser"]) ? $_POST["optionSearchUser"] : "";
        $optionOrderUser = isset($_POST["optionOrderUser"]) ? $_POST["optionOrderUser"] : "";
        $valorUser = isset($_POST["valorUser"]) ? $_POST["valorUser"] : "";
 
        $sql = "SELECT receita.id, data, valor, conta.conta_id, tipo_receita_id, categoria FROM receita, conta, treceita WHERE receita.conta_id = conta.conta_id AND receita.tipo_receita_id = treceita.id;";

        if ($optionSearchUser != "") {
            if ($optionSearchUser == "id") {
                $sql = ("SELECT receita.id, data, valor, conta.conta_id, tipo_receita_id, categoria FROM receita LEFT JOIN conta ON  receita.conta_id = conta.conta_id  JOIN treceita ON receita.tipo_receita_id = treceita.id AND receita.id = $valorUser ORDER BY $optionOrderUser;"); 
            }elseif ($optionSearchUser == "valor") {
                $sql = ("SELECT receita.id, data, valor, conta.conta_id, tipo_receita_id, categoria FROM receita LEFT JOIN conta ON  receita.conta_id = conta.conta_id JOIN treceita ON receita.tipo_receita_id = treceita.id AND $optionSearchUser = '$valorUser' ORDER BY $optionOrderUser;");   
            }elseif ($optionSearchUser == "data") {
                $sql =  ("SELECT receita.id, data, valor, conta.conta_id, tipo_receita_id, categoria FROM receita LEFT JOIN conta ON  receita.conta_id = conta.conta_id JOIN treceita ON receita.tipo_receita_id = treceita.id AND $optionSearchUser LIKE '$valorUser%' ORDER BY $optionOrderUser;");             
            } elseif ($optionSearchUser == "categoria") {
                $sql = ("SELECT receita.id, data, valor, conta.conta_id, tipo_receita_id, categoria FROM receita LEFT JOIN conta ON  receita.conta_id = conta.conta_id JOIN treceita ON receita.tipo_receita_id = treceita.id AND $optionSearchUser LIKE '$valorUser%' ORDER BY $optionOrderUser;");           
            } 
        } 
        if($valorUser == ""){
            $sql = "SELECT receita.id, data, valor, conta.conta_id, tipo_receita_id, categoria FROM receita, conta, treceita WHERE receita.conta_id = conta.conta_id AND receita.tipo_receita_id = treceita.id;";
        }

        $pdo = Conexao::getInstance();
        $consulta = $pdo->query($sql);
        //var_dump($sql);
    ?>
        <br>
        <table>
            <tr>
                <th>Código</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Categoria</th>
                <th>Alterar</th>
                <th>Excluir</th>
            </tr>
            <?php
            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <tr>
                    <td><?php echo $linha['id']; ?></td>
                    <td><?php echo $linha['valor']; ?></td>
                    <td><?php echo $linha['data']; ?></td>
                    <td><?php echo $linha['categoria']; ?></td>
                    <td><a href='cadreceita.php?acao=editar&id=<?php echo $linha['id']; ?>'><img class="icon" src="img/edit.png" alt=""></a></td>
                    <td><a href="javascript:excluirRegistro('acaoreceita.php?acao=excluir&id=<?php echo $linha['id']; ?>')"><img class="icon" src="img/delete.png" alt=""></a></td>
                </tr>
            <?php } ?>
        </table>
    <?php
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    ?>

</body>

</html>