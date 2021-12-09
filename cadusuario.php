<!DOCTYPE html>
<?php
include_once "acaousuario.php";
$acaousuario = isset($_GET['acaousuario']) ? $_GET['acaousuario'] : "";
$dados;
if ($acaousuario == 'editar'){
    $codigo = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : "";
    if ($codigo > 0)
        $dados = buscarDados($codigo);
}
?>
<html lang="pt-br">
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<br>
<a href="alistarusuario.php"><button>Listar</button></a>
<a href="cadusuario.php"><button>Novo</button></a>
<br><br>
<form action="acaousuario.php" method="post">
<input readonly  type="text" name="usuario_id" id="usuario_id" value="<?php if ($acaousuario == "editar") echo $dados['usuario_id']; else echo 0; ?>"><br><br>
    Nome do Usuário: 
    <input required=true   type="text" name="nome" id="nome" value="<?php if ($acaousuario == "editar") echo $dados['nome']; ?>"><br><br>
    CPF: 
    <input required=true   type="text" name="cpf" id="cpf" value="<?php if ($acaousuario == "editar") echo $dados['cpf']; ?>"><br><br>
    Bairro: 
    <input required=true   type="text" name="bairro" id="bairro" value="<?php if ($acaousuario == "editar") echo $dados['bairro']; ?>"><br><br>
    Cidade: 
    <input required=true   type="text" name="cidade" id="cidade" value="<?php if ($acaousuario == "editar") echo $dados['cidade']; ?>"><br><br>
    <br><button type="submit" name="acaousuario" id="acaousuario" value="salvar">Salvar Usuário</button>
</form>
</body>
</html>