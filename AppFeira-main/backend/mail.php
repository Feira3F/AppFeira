<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $codigoAutenticacao = rand(100000, 999999);
     $_SESSION['codigo'] = $codigoAutenticacao;
  
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                 
        $mail->Username   = '...@gmail.com';               
        $mail->Password   = 'pass';                         
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
        $mail->Port       = 587;

        $mail->setFrom('...@gmail.com', 'Feira Tecnológica mcm');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Código de Autenticação';
        $mail->Body    = 'Seu código de autenticação é: <b>' . $codigoAutenticacao . '</b>';
        $mail->AltBody = 'Seu código de autenticação é: ' . $codigoAutenticacao;

        $mail->send();
        echo 'E-mail enviado com sucesso para ' . $email;
    } catch (Exception $e) {
        echo "O e-mail não pôde ser enviado. Erro: {$mail->ErrorInfo}";
    }
} else {
    echo "Método de requisição inválido.";
}
?>
