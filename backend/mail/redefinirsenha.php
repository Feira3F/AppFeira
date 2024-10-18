<?php
session_start();

require_once '../classes/db.class.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['token']) && isset($_POST['senha'])) {
    $token = $_POST['token'];
    $novaSenha = $_POST['senha'];

    if (isset($_SESSION['token_recuperacao']) && $token === $_SESSION['token_recuperacao']) {
        try {
            $pdo = DB::connect();

            $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

            $sql = "UPDATE alunos SET senha = :senha WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':senha', $senhaHash);
            $stmt->bindParam(':email', $_SESSION['email_recuperacao']);
            $stmt->execute();

            unset($_SESSION['token_recuperacao']);
            unset($_SESSION['email_recuperacao']);

            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Senha redefinida com sucesso!']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao redefinir a senha: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Token inválido ou expirado.']);
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método de requisição inválido.']);
}