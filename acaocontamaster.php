<?php
	header('Content-Type: text/html; charset=UTF-8');
	include 'connect/connect.php';
	include 'conf/Conexao.php';
	
	$acao = '';
	if (isset($_GET["acao"]))
		  $acao = $_GET["acao"];

	if ($acao == "excluirUsuario"){
		$conta = $_GET['conta'];
		$usuario = $_GET['usuario'];
		excluirUsuario($conta,$usuario);
	}else if($acao == "excluirDespesa"){
		$codigo = $_GET["despesa"];
		excluirDespesa($codigo);
	}else if($acao == "excluirReceita"){
		$codigo = $_GET["receita"];
		excluirReceita($codigo);
	}
	else if ($acao == "excluir"){
		$codigo = 0;
		if (isset($_GET["conta_id"])){
		  	$codigo = $_GET["conta_id"];
			excluir($codigo);
		}
	}else if (isset($_POST["acao"])){
			$acao = $_POST["acao"];
			if ($acao == "salvar"){
				$codigo = 0;
				if (isset($_POST["conta_id"])){
					$codigo = $_POST["conta_id"];
					if ($codigo == 0)
					inserir();
					else
					alterar($codigo);
				}
			}
			else if($acao == "addUsuario"){
				$usuario = $_POST['usuario'];
				$codigo = $_POST['conta_id'];
				adicionarUsuario($codigo,$usuario);
			}
	}
//--------------
	
	function excluirUsuario($conta,$usuario){
		$sql = "
			DELETE 
			  FROM {$GLOBALS['tb_conta_has_usuario']}
	         WHERE usuario_usuario_id = :usuario
		       AND conta_conta_id = :conta;
		";

		$pdo = Conexao::getInstance();
		$stmt = $pdo->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
		$stmt->bindParam(':conta', $conta, PDO::PARAM_INT);
		$stmt->execute();

		header('location:cadcontamaster.php?acao=editar&conta_id='.$conta);
	}


	function excluirDespesa($codigo){
		//var_dump($codigo);
	$sql = "
		DELETE FROM despesa WHERE id = :id;";

	$pdo = Conexao::getInstance();
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $codigo, PDO::PARAM_INT);
	$stmt->execute();

	header('location:cadcontamaster.php?acao=editar&conta_id='.$_GET['conta_id']);

	}
	
	function excluirReceita($codigo){
		//var_dump($codigo);
	$sql = "
		DELETE FROM receita WHERE id = :id;";

	$pdo = Conexao::getInstance();
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $codigo, PDO::PARAM_INT);
	$stmt->execute();

	header('location:cadcontamaster.php?acao=editar&conta_id='.$_GET['conta_id']);

	}

	function adicionarUsuario($codigo,$usuario){
		$sql = 'INSERT INTO '.$GLOBALS['tb_conta_has_usuario'].
		       ' (conta_conta_id, usuario_usuario_id)'. 
		       ' VALUES ('.$codigo.','.$usuario.')';
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		if ($result == 1)
			header('location:cadcontamaster.php?msg="si"&acao=editar&conta_id='.$codigo);
		else
			header('location:cadcontamaster.php?msg="er"&acao=editar&conta_id='.$codigo);
            echo $sql;
	}

	function adicionarReceita($codigo,$receita){
		$sql = 'INSERT INTO '.$GLOBALS['receita'].
		       ' (conta_conta_id, id)'. 
		       ' VALUES ('.$codigo.','.$receita.')';
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		if ($result == 1)
			header('location:cadcontamaster.php?msg="si"&acao=editar&conta_id='.$codigo);
		else
			header('location:cadcontamaster.php?msg="er"&acao=editar&conta_id='.$codigo);
            echo $sql;
	}
	
	function excluir($codigo){
		$sql = 'DELETE FROM '.$GLOBALS['tb_conta_has_usuario'].
		       ' WHERE conta_conta_id =  '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$sql = 'DELETE FROM '.$GLOBALS['tb_conta'].
		       ' WHERE conta_id =  '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		if ($result == 1)
			header('location:alistarcontamaster.php');
		else
			header('location:alistarcontamaster.php');
	}

	function alterar($codigo){
		$vet = carregarTelaParaVetor();
		$sql = 'UPDATE '.$GLOBALS['tb_conta'].
		       ' SET saldo = "'.$vet['saldo'].
		       '" WHERE conta_id = '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		if ($result == 1)
			header('location:cadcontamaster.php?msg="sa"&acao=editar&conta_id='.$codigo);
		else
			header('location:cadcontamaster.php?msg="er"&acao=editar&conta_id='.$codigo);
	}
	
	function inserir(){	
		$vet = carregarTelaParaVetor();		
		$sql = 'INSERT INTO '.$GLOBALS['tb_conta'].
		       ' (saldo)'. 
		       ' VALUES ('.$vet['saldo'].')';
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$codigo = mysqli_insert_id($GLOBALS['conexao']);
		if ($result == 1)
			header('location:cadcontamaster.php?msg="si"&acao=editar&conta_id='.$codigo);
		else
			header('location:cadcontamaster.php?msg="er"&acao=editar&conta_id='.$codigo);
	}
	
	function carregarTelaParaVetor(){
		include 'util/util.php';
		$vet = array();
		$vet['conta_id'] = $_POST["conta_id"];
		$vet['saldo'] = $_POST["saldo"];
		return $vet;		
	}	
		
	function carregaBDParaVetor($codigo){
		$sql = 'SELECT * FROM '.$GLOBALS['tb_conta'].
		       ' WHERE conta_id = '.$codigo;
			   //var_dump($sql);
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$dados = array();
		while ($row = mysqli_fetch_array($result)){
			$dados['conta_id'] = $row['conta_id'];
			$dados['saldo'] = $row['saldo'];

		}   
		return $dados;    		
	}
?>	