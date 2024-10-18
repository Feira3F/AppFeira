<?php
session_start();

require_once '../classes/db.class.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        $pdo = DB::connect();

        $sql = "SELECT * FROM professores WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $professor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($professor) {
            if ($senha === $professor['senha']) {
                $_SESSION['professor_id'] = $professor['id_professor'];
                $_SESSION['professor_nome'] = $professor['nome'];

                echo json_encode(['status' => 'sucesso', 'mensagem' => 'Login bem-sucedido!']);
            } else {
                echo json_encode(['status' => 'erro', 'mensagem' => 'Email ou senha incorretos.']);
            }
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