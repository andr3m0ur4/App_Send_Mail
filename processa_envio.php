<?php 

	require './Mensagem.php';
	require './bibliotecas/PHPMailer/Exception.php';
	require './bibliotecas/PHPMailer/OAuth.php';
	require './bibliotecas/PHPMailer/PHPMailer.php';
	require './bibliotecas/PHPMailer/POP3.php';
	require './bibliotecas/PHPMailer/SMTP.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	$mensagem = new Mensagem();

	foreach ($_POST as $chave => $valor) {
		$mensagem -> __set($chave, $valor);
	}

	if (!$mensagem -> mensagemValida()) {
		echo 'A mensagem não é válida';
		header('Location: index.php');
	}

	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail -> SMTPDebug = false;                                 // Enable verbose debug output
	    $mail -> isSMTP();                                      // Set mailer to use SMTP
	    $mail -> Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	    $mail -> SMTPAuth = true;                               // Enable SMTP authentication
	    $mail -> Username = 'mouraandre2500@gmail.com';                 // SMTP username
	    $mail -> Password = '$andr3_m0ur4';                           // SMTP password
	    $mail -> SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	    $mail -> Port = 587;                                    // TCP port to connect to
	    $mail -> CharSet = 'UTF-8';
	    $mail -> Encoding = 'base64';

	    //Recipients
	    $mail -> From = 'andre.benedicto@etec.sp.gov.br';
	    $mail -> FromName = 'App Send Mail';
	    $mail -> addAddress($mensagem -> __get('para'));     // Add a recipient
	    //$mail -> addAddress('ellen@example.com');               // Name is optional
	    //$mail -> addReplyTo('info@example.com', 'Information');
	    //$mail -> addCC('cc@example.com');
	    //$mail -> addBCC('bcc@example.com');

	    //Attachments
	    //$mail -> addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    //$mail -> addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    //Content
	    $mail -> isHTML(true);                                  // Set email format to HTML
	    $mail -> Subject = $mensagem -> __get('assunto');
	    $mail -> Body    = $mensagem -> __get('mensagem');
	    $mail -> AltBody = 'É necessário utilizar um client que suporte HTML para ter acesso total ao conteúdo dessa mensagem.';

	    $mail -> send();

	    $mensagem -> status['codigo_status'] = 1;
	    $mensagem -> status['descricao_status'] = 'E-mail enviado com sucesso';

	} catch (Exception $e) {
		$mensagem -> status['codigo_status'] = 2;
	    $mensagem -> status['descricao_status'] = 'Não foi possível enviar este e-mail! ' .
	    	'Por favor tente novamente mais tarde. Detalhes do erro: ' . $mail -> ErrorInfo;
	}

	require 'template.php';
