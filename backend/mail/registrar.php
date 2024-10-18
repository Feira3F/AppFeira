<?php

require_once 'mail.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $codigoAutenticacao = rand(100000, 999999);

    session_start();
    $_SESSION['codigo'] = $codigoAutenticacao;
    $_SESSION['email'] = $email;

    $mail = configurarEmail();
    if ($mail) {
        try {
            $mail->setFrom('appfeira3f24@gmail.com', 'Feira MCM');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $template = file_get_contents('emailregistro.html');
            $mail->Body    = str_replace('<?php echo $codigoAutenticacao; ?>', $codigoAutenticacao, $template);
$mail->AltBody = "Seu código de autenticação é: $codigoAutenticacao";

$mail->send();
echo json_encode(['status' => 'sucesso', 'mensagem' => 'Codigo enviado para ' . $email]);
} catch (Exception $e) {
echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao enviar o email: ' . $mail->ErrorInfo]);
}
}
} else {
echo json_encode(['status' => 'erro', 'mensagem' => 'Metodo de requisicao invalido.']);
}