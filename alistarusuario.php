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
    <title>Lista de Usuários</title>
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
            border-radius: 5px;
            border-style: hidden;
            /* hide standard table (collapsed) border */
            box-shadow: 0 0 0 1px black;
            /* this draws the table border  */
        }

        tr,
        th,
        td {
            border: 1px solid black;
        }

        th {
            width: 150px;
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
    <a href="cadusuario.php">Novo Usuário</a><br><br>

    <form method="POST">
        <b>Consultar por: </b><br>
        <input type="radio" name="optionSearchUser" id="" value="usuario_id" required>Código<br>
        <input type="radio" name="optionSearchUser" id="" value="nome" required>Nome<br>
        <input type="radio" name="optionSearchUser" id="" value="cpf" required>CPF<br>
        <input type="radio" name="optionSearchUser" id="" value="bairro" required>Bairro<br>
        <input type="radio" name="optionSearchUser" id="" value="cidade" required>Cidade<br><br>
        <b>Ordenar por:</b><br>
        <input type="radio" name="optionOrderUser" id="" value="usuario_id" required>Código<br>
        <input type="radio" name="optionOrderUser" id="" value="nome" required>Nome<br>
        <input type="radio" name="optionOrderUser" id="" value="cpf" required>CPF<br>
        <input type="radio" name="optionOrderUser" id="" value="bairro" required>Bairro<br>
        <input type="radio" name="optionOrderUser" id="" value="cidade" required>Cidade<br>
        <br>
        <a href="alistarusuario.php">Listar todos</a><br>
        <input type="text" name="valorUser">
        <input type="submit" value="Consultar">
    </form>
    <?php

    try {

        $optionSearchUser = isset($_POST["optionSearchUser"]) ? $_POST["optionSearchUser"] : "";
        $optionOrderUser = isset($_POST["optionOrderUser"]) ? $_POST["optionOrderUser"] : "usuario_id";
        $valorUser = isset($_POST["valorUser"]) ? $_POST["valorUser"] : "";

        $sql = ("SELECT usuario.usuario_id, nome, cpf, bairro, cidade FROM usuario, endereco WHERE usuario.usuario_id = endereco.usuario_id;");   

        if ($optionSearchUser != "") {
            if ($optionSearchUser == "usuario_id") {
                $sql = ("SELECT usuario.usuario_id, nome, cpf, bairro, cidade FROM usuario, endereco WHERE usuario.usuario_id = endereco.usuario_id AND usuario.usuario_id = $valorUser ORDER BY $optionOrderUser;"); 
            }elseif ($optionSearchUser == "nome") {
                $sql =("SELECT usuario.usuario_id, nome, cpf, bairro, cidade FROM usuario, endereco WHERE usuario.usuario_id = endereco.usuario_id AND $optionSearchUser LIKE '$valorUser%' ORDER BY $optionOrderUser;");   
            }elseif ($optionSearchUser == "cpf") {
                $sql = ("SELECT usuario.usuario_id, nome, cpf, bairro, cidade FROM usuario, endereco WHERE usuario.usuario_id = endereco.usuario_id AND $optionSearchUser LIKE '$valorUser%' ORDER BY $optionOrderUser;");             
            } elseif ($optionSearchUser == "bairro") {
                $sql = ("SELECT usuario.usuario_id, nome, cpf, bairro, cidade FROM usuario, endereco WHERE usuario.usuario_id = endereco.usuario_id AND $optionSearchUser LIKE '$valorUser%' ORDER BY $optionOrderUser;");           
            } elseif ($optionSearchUser == "cidade") {
                $sql = ("SELECT usuario.usuario_id, nome, cpf, bairro, cidade FROM usuario, endereco WHERE usuario.usuario_id = endereco.usuario_id AND $optionSearchUser LIKE '$valorUser%' ORDER BY $optionOrderUser;");    
            } 
        } 
        if($valorUser == ""){
            $sql =  ("SELECT usuario.usuario_id, nome, cpf, bairro, cidade FROM usuario, endereco WHERE usuario.usuario_id = endereco.usuario_id ORDER BY $optionOrderUser;");
        }

        $pdo = Conexao::getInstance();
        $consulta = $pdo->query($sql);
        echo "<br><table><tr><th>Codigo</th><th>Nome</th><th>CPF</th><th>Bairro</th><th>Cidade</th><th>Alterar</th><th>Excluir</th></tr>";
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
    ?>
            <tr>
                <td><?php echo $linha['usuario_id']; ?></td>
                <td><?php echo $linha['nome']; ?></td>
                <td><?php echo $linha['cpf']; ?></td>
                <td><?php echo $linha['bairro']; ?></td>
                <td><?php echo $linha['cidade']; ?></td>
                <td><a href='cadusuario.php?acaousuario=editar&usuario_id=<?php echo $linha['usuario_id']; ?>'><img class="icon" src="img/edit.png" alt=""></a></td>
                <td><a href="javascript:excluirRegistro('acaousuario.php?acaousuario=excluir&usuario_id=<?php echo $linha['usuario_id']; ?>')"><img class="icon" src="img/delete.png" alt=""></a></td>
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