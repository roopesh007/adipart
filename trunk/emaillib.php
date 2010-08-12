<?php
function enviarEmail($nombreRemitente, $emailRemitente, $emailDestinatario, $asunto, $mensaje, $tipoEmail="text/plain" ) {

        return(smtp($emailRemitente, $nombreRemitente, $emailDestinatario, $emailDestinatario, $asunto, $mensaje,$tipoEmail));
}

function smtp($from, $namefrom, $to, $nameto, $subject, $message,$tipoEmail="text/plain") {
	$username = "-removed-";
	$password = "-removed-";
	$newLine = "\r\n";

	$smtpConnect = fsockopen("127.0.0.1", 25, $errno, $errstr, 15);
	$smtpResponse = fgets($smtpConnect, 515);

	if($smtpConnect) {
		$logArray['connect'] = $smtpResponse;
	}

	fputs($smtpConnect, "HELO localhost" . $newLine);
	$smtpResponse = fgets($smtpConnect, 515);
	$logArray['helo'] = $smtpResponse;

	fputs($smtpConnect,"AUTH LOGIN" . $newLine);
	$smtpResponse = fgets($smtpConnect, 515);
	$logArray['auth'] = $smtpResponse;

	fputs($smtpConnect, base64_encode($username) . $newLine);
	$smtpResponse = fgets($smtpConnect, 515);
	$logArray['user'] = $smtpResponse;

	fputs($smtpConnect, base64_encode($password) . $newLine);
	$smtpResponse = fgets($smtpConnect, 515);
	$logArray['pass'] = $smtpResponse;

	fputs($smtpConnect, "MAIL FROM: <$from>" . $newLine);
	$smtpResponse = fgets($smtpConnect, 515);
	$logArray['from'] = $smtpResponse;

	fputs($smtpConnect, "RCPT TO: <$to>" . $newLine);
	$smtpResponse = fgets($smtpConnect, 515);
	$logArray['to'] = $smtpResponse;

	fputs($smtpConnect, "DATA" . $newLine);
	$smtpResponse = fgets($smtpConnect, 515);
	$logArray['data'] = $smtpResponse;

	$headers  = "MIME-Version: 1.0" . $newLine;
	$headers .= "Content-type: ".$tipoEmail."; charset=iso-8859-1" . $newLine;

	fputs($smtpConnect, "To: $nameto <$to>\r\nFrom: $namefrom <$from>\r\nSubject: $subject\r\n$headers\r\n\r\n$message\r\n.\r\n");
	$smtpResponse = fgets($smtpConnect, 515);
	$logArray['message'] = $smtpResponse;

	fputs($smtpConnect, "QUIT" . $newLine);
	$smtpResponse = fgets($smtpConnect, 515);
	$logArray['quit'] = $smtpResponse;
        
        if ($errno == 0 )
          return 1;
        else
	  return 0;

}

?>
