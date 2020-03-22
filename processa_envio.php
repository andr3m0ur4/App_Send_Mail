<?php 

	//print_r($_POST);

	require_once 'Mensagem.php';

	$mensagem = new Mensagem();

	foreach ($_POST as $chave => $valor) {
		$mensagem -> __set($chave, $valor);
	}

	//echo '<pre>';
	//print_r($mensagem);

	if ($mensagem -> mensagemValida()) {
		echo 'Mensagem é válida';
	} else {
		echo 'A mensagem não é válida';
	}
