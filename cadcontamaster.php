<!DOCTYPE html>
<?php 
    $title = "Cadastro de Conta";
    include 'connect/connect.php';
    include 'acaocontamaster.php';
    $acao = '';
    $codigo = '';
    $dados;
    if (isset($_GET["acao"]))
        $acao = $_GET["acao"];
    if ($acao == "editar"){
        if (isset($_GET["conta_id"])){
            $codigo = $_GET["conta_id"];
            $dados = carregaBDParaVetor($codigo); 
        }
    }
?>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>  
    <link rel=stylesheet href='css/jquery-calendario.css'/>
    <link rel=stylesheet href='css/calendario.css'/>
    <link rel=stylesheet href='css/estilo.css'/>  
    <script src="js/jquery.maskedinput.js"></script>
    <script src='js/calendario.js'></script>      
    <script src="js/jquery-2.1.4.min.js"></script>
    <script>
    jQuery(function($){
        $("#dataVencimento").mask("99/99/9999");
        $("#dataPagamento").mask("99/99/9999");
    });

    function excluirRegistro(url) {
        if(confirm("Excluir usuario?"))
        location.href = url;
    }
    </script>
    
</head>
<body>
    <?php include 'menu.php'; ?>
    <?php include 'util/util.php';?>
    <form action="acaocontamaster.php" id="form" method="post">
        <fieldset>
            <legend><?php echo $title; ?></legend>
            Código
            <input type="number" name="conta_id" id="conta_id" size="3" value="<?php if ($acao == "editar") echo $dados['conta_id']; else echo "0";?>" readonly>
            Saldo
            <input type='number' size='11' name='saldo' id='saldo' value="<?php if ($acao == "editar") echo $dados['saldo'];?>"/>
            <br><br>
            <button name="acao" value="salvar" id="acao" 
            type="submit">Salvar</button>
            <a href="alistarcontamaster.php">Consultar</a>    

            <br><br>
            <?php if ($acao == "editar"){ ?>

            <table width="100%"   border="1" align="left" id='painel'>
                <tr><tr>
                    <td width="90" align="center"><b>Nome|CPF</b></td>
                    <td width="120" align="right"><b></b></td>
                </tr>
                <tr>
                    <td width="90" align="center">
                        <select name="usuario" id="usuario">
                            <?php
                            $sql = "SELECT * FROM usuario";
                            echo $sql;
                            $result = mysqli_query($conexao,$sql);
                            while ($row = mysqli_fetch_array($result)) {      
                                ?>
                                <option value="<?php echo $row[0];?>">
                                    <?php echo $row[1]." | ".$row[2];?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td width="120" align="right">
                                <button name="acao" id="acao" value="addUsuario"  type="submit" onclick="return validaAddProd();">
                                    <img src="img/add.png" alt="Adicionar Usuario"> 
                                </button><br><br>
                            </td>
                        </tr>
                    </table>


                    <br><br>

                    <table width="100%"   border="1" align="left" id='painel'>
                        <tr>
                            <td width="90" align="center"><b>Código</b></td>
                            <td width="400" ><b>Nome</b></td>
                            <td width="400" ><b>CPF</b></td>
                            <td width="20" ></td>
                        </tr>


                        
                        <?php 
                        $sql = "SELECT usuario.usuario_id AS codigo_usuario, conta.conta_id, usuario.nome AS unome, usuario.cpf FROM conta, usuario, conta_has_usuario
						WHERE conta.conta_id = $codigo
                        AND conta_has_usuario.conta_conta_id = conta.conta_id AND usuario.usuario_id = conta_has_usuario.usuario_usuario_id;";
                        $result = mysqli_query($conexao,$sql);
                        while ($row = mysqli_fetch_array($result))  {         
                            ?>
                            <tr>
                                <td align="center"><?php echo $row['codigo_usuario'];?></td>
                                <td width="400"><?php echo $row['unome'];?></td>
                                <td><?php echo $row['cpf'];?></td>
                                <td><a href="javascript:excluirRegistro('acaocontamaster.php?acao=excluirUsuario&usuario=<?php echo $row['codigo_usuario'];?>&conta=<?php echo $codigo;?>')"><img border="0" src="img/delete.png" alt="Excluir"></a></td>
                            </tr>
                            <?php } 
                            ?>
                            <?php } ?>
                        </table> 
                </fieldset>
            </form>
                  

<BR></BR>
            <?php if ($acao == "editar"){ ?>
                <h4><b><?php echo "DESPESAS";?></b></h4>
<table width="100%"   border="1" align="left" id='painel'>
    <tr><tr>
        <td width="90" align="center"><b>VALOR|DATA</b></td>
        <td width="120" align="right"><b></b></td>
    </tr>
    <tr>
        <td width="90" align="center">
            <select name="despesa" id="despesa">
                <?php
                $sql = "SELECT * FROM despesa";
                echo $sql;
                $result = mysqli_query($conexao,$sql);
                while ($row = mysqli_fetch_array($result)) {      
                    ?>
                    <option value="<?php echo $row[0];?>">
                        <?php echo $row[1]." | ".$row[2];?></option>
                        <?php } ?>
                    </select>
                </td>
                <td width="120" align="right">
                    <button name="acao" id="acao" value="addDespesa"  type="submit" onclick="return validaAddProd();">
                        <img src="img/add.png" alt="Adicionar Despesa"> 
                    </button><br><br>
                </td>
            </tr>
        </table>
        <br><br>

        <table width="100%"   border="1" align="left" id='painel'>
            <tr>
                <td width="90" align="center"><b>Código</b></td>
                <td width="400" ><b>Valor</b></td>
                <td width="400" ><b>Data</b></td>
                <td width="400" ><b>Categoria</b></td>
                <td width="20" ></td>
            </tr>

            <?php 
            $sql = "SELECT * FROM despesa
            where despesa.conta_conta_id = 9
            ORDER BY despesa.data;";
            $result = mysqli_query($conexao,$sql);
            while ($row = mysqli_fetch_array($result))  {         
                ?>
                <tr>
                    <td align="center"><?php echo $row['id'];?></td>
                    <td width="400"><?php echo $row['valor'];?></td>
                    <td><?php echo dataTracoToPadrao($row['data']);?></td>
                    <td><?php echo $row['tipo_despesa_id'];?></td>

                    <td><a href="javascript:excluirRegistro('acaocontamaster.php?acao=excluir&receita=<?php echo $row['id'];?>&conta=<?php echo $codigo;?>')"><img border="0" src="img/delete.png" alt="Excluir"></a></td>
                </tr>
                <?php } 
                ?>
<?php } 
                ?>
            </table> 
    </fieldset>
</form>

























            <?php if ($acao == "editar"){ ?>

<table width="100%"   border="1" align="left" id='painel'>
    <tr><tr>
        <td width="90" align="center"><b>VALOR|DATA</b></td>
        <td width="120" align="right"><b></b></td>
    </tr>
    <tr>
        <td width="90" align="center">
            <select name="receita" id="receita">
                <?php
                $sql = "SELECT * FROM receita";
                echo $sql;
                $result = mysqli_query($conexao,$sql);
                while ($row = mysqli_fetch_array($result)) {      
                    ?>
                    <option value="<?php echo $row[0];?>">
                        <?php echo $row[1]." | ".$row[2];?></option>
                        <?php } ?>
                    </select>
                </td>
                <td width="120" align="right">
                    <button name="acao" id="acao" value="addReceita"  type="submit" onclick="return validaAddProd();">
                        <img src="img/add.png" alt="Adicionar Receita"> 
                    </button><br><br>
                </td>
            </tr>
        </table>
        <br><br>

        <h4><b><?php echo "RECEITAS";?></b></h4>
        <table width="100%"   border="1" align="left" id='painel'>
            <tr>
                <td width="90" align="center"><b>Código</b></td>
                <td width="400" ><b>Valor</b></td>
                <td width="400" ><b>Data</b></td>
                <td width="400" ><b>Categoria</b></td>
                <td width="20" ></td>
            </tr>

            <?php 
            $sql = "SELECT * FROM receita
            WHERE receita.conta_id = $codigo
            ORDER BY receita.data;";
            $result = mysqli_query($conexao,$sql);
            while ($row = mysqli_fetch_array($result))  {         
                ?>
                <tr>
                    <td align="center"><?php echo $row['id'];?></td>
                    <td width="400"><?php echo $row['valor'];?></td>
                    <td><?php echo dataTracoToPadrao($row['data']);?></td>
                    <td><?php echo $row['tipo_receita_id'];?></td>

                    <td><a href="javascript:excluirRegistro('acaocontamaster.php?acao=excluirReceita&receita=<?php echo $row['id'];?>&conta=<?php echo $codigo;?>')"><img border="0" src="img/delete.png" alt="Excluir"></a></td>
                </tr>
                <?php } 
                ?>
                <?php } ?>
            </table> 
    </fieldset>
</form>







        </body>
        </html>