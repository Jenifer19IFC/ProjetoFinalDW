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
    <title>Lista de Tipos de Receita</title>
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
    <a href="cadtipoDespesa.php">Nova categoria</a><br><br>

    <form method="POST">
        <b>Consultar por: </b><br>
        <input type="radio" name="optionSearchUser" id="" value="id" required>Código<br>
        <input type="radio" name="optionSearchUser" id="" value="categoria" required>Categoria<br><br>
        <b>Ordenar por: </b><br>
        <input type="radio" name="optionOrderUser" id="" value="id" required>Código
        <input type="radio" name="optionOrderUser" id="" value="categoria" required>Categoria
        <br><br>
        <a href="alistartipoDespesa.php">Listar todos</a><br>
        <input type="text" name="valorUser">
        <input type="submit" value="Consultar">
    </form>
    <?php

    try {

        $optionSearchUser = isset($_POST["optionSearchUser"]) ? $_POST["optionSearchUser"] : "";
        $optionOrderUser = isset($_POST["optionOrderUser"]) ? $_POST["optionOrderUser"] : "";
        $valorUser = isset($_POST["valorUser"]) ? $_POST["valorUser"] : "";

        $sql = "";

        if ($optionSearchUser != "") {
            if ($valorUser == "") {

                $sql = ("SELECT * FROM tdespesa ORDER BY $optionOrderUser;");
            } elseif ($optionSearchUser == "categoria") {
                $sql = ("SELECT * FROM tdespesa WHERE $optionSearchUser LIKE '$valorUser%';");
            } else {
                $sql = ("SELECT * FROM tdespesa WHERE $optionSearchUser = $valorUser ORDER BY $optionOrderUser;");
            }
        } else {
            $sql = ("SELECT * FROM tdespesa;");
        }
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query($sql);
        echo "<br><table><tr><th>Codigo</th><th>Categoria</th><th>Alterar</th><th>Excluir</th></tr>";
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
    ?>
            <tr>
                <td><?php echo $linha['id']; ?></td>
                <td><?php echo $linha['categoria']; ?></td>
                <td><a href='cadtipoDespesa.php?acaotipoDespesa=editar&id=<?php echo $linha['id']; ?>'><img class="icon" src="img/edit.png" alt=""></a></td>
                <td><a href="javascript:excluirRegistro('acaotipoDespesa.php?acaotipoDespesa=excluir&id=<?php echo $linha['id']; ?>')"><img class="icon" src="img/delete.png" alt=""></a></td>
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