<?php 

	//print_r($_POST);

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

	//echo '<pre>';
	//print_r($mensagem);

	if (!$mensagem -> mensagemValida()) {
		echo 'A mensagem não é válida';
		die();
	}

	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = 'mouraandre2500@gmail.com';                 // SMTP username
	    $mail->Password = 'secret';                           // SMTP password
	    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 587;                                    // TCP port to connect to
	    $mail->CharSet = 'utf-8';

	    //Recipients
	    $mail->setFrom('mouraandre2500@hotmail.com', 'App Send Mail');
	    $mail->addAddress($mensagem -> __get('para'));     // Add a recipient
	    //$mail->addAddress('ellen@example.com');               // Name is optional
	    //$mail->addReplyTo('info@example.com', 'Information');
	    //$mail->addCC('cc@example.com');
	    //$mail->addBCC('bcc@example.com');

	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $mensagem -> __get('assunto');
	    $mail->Body    = $mensagem -> __get('mensagem');
	    $mail->AltBody = 'É necessário utilizar um client que suporte HTML para ter acesso total ao conteúdo dessa mensagem.';

	    $mail->send();
	    echo 'E-mail enviado com sucesso';

	} catch (Exception $e) {
	    echo 'Não foi possível enviar este e-mail! Por favor tente novamente mais tarde. ';
	    echo 'Detalhes do erro: ' . $mail->ErrorInfo;
	}
