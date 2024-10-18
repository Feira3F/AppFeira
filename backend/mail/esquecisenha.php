<?php
session_start();
require_once 'mail.php';
require_once '../classes/db.class.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    try {
        $pdo = DB::connect();

        $sql = "SELECT id_aluno FROM alunos WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $token = bin2hex(random_bytes(32));

            $_SESSION['token_recuperacao'] = $token;
            $_SESSION['email_recuperacao'] = $email;

            $caminhoAtual = $_SERVER['PHP_SELF'];
            $nomeArquivoAtual = basename($caminhoAtual);
            $nomeArquivoRedefinicao = 'redefinirsenha.php';
            $linkRedefinicao = str_replace($nomeArquivoAtual, $nomeArquivoRedefinicao, $caminhoAtual) . "?token=$token";

            $mail = configurarEmail();
            if ($mail) {
                try {
                    $mail->setFrom('appfeira3f24@gmail.com', 'Feira Tecnológica');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Redefinir sua senha';

                    $template = file_get_contents('emailesqueci.html');

                    $mail->Body = str_replace('<?php echo $linkRedefinicao; ?>', $linkRedefinicao, $template);

$mail->AltBody = "Acesse o link para redefinir sua senha: $linkRedefinicao";

$mail->send();
echo json_encode(['status' => 'sucesso', 'mensagem' => 'Email de redefinição enviado!']);
} catch (Exception $e) {
echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao enviar o email: ' . $mail->ErrorInfo]);
}
}
} else {
echo json_encode(['status' => 'erro', 'mensagem' => 'Email não encontrado.']);
}
} catch (PDOException $e) {
echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao processar a solicitação: ' . $e->getMessage()]);
}
} else {
echo json_encode(['status' => 'erro', 'mensagem' => 'Método de requisição inválido.']);
}