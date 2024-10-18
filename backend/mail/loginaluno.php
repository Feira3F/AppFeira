<?php
session_start();

require_once '../classes/db.class.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        $pdo = DB::connect();

        $sql = "SELECT * FROM alunos WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {

            $_SESSION['usuario_id'] = $usuario['id_aluno'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Login bem-sucedido!']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Email ou senha incorretos.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao realizar o login: ' . $e->getMessage()]);
    } finally {
        $pdo = null;
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método de requisição inválido.']);
}