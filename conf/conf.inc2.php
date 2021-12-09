<?php
	header('Content-Type: text/html; charset=UTF-8');
	date_default_timezone_set('America/Sao_Paulo');
	
	// Banco de Dados para configuração
	$url = "127.0.0.1";     // IP do host
	$dbname="orcamento";          // Nome do database
	$usuario="root";        // Usuário do database
	$password="";           // Senha do database
	
	// Tabelas do Banco de Dados
	$tb_endereco = "endereco";
	$tb_usuario = "usuario";
	$tb_conta = "conta";
    $tb_receita = "receita";
    $tb_despesa = "despesa";
	$tb_treceita = "treceita";
    $tb_tdespesa = "tdespesa";
	$tb_conta_has_usuario = "conta_has_usuario";
?>
