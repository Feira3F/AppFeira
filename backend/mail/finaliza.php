<?php
session_start();

require_once '../classes/db.class.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['codigo'])) {
    $nome = $_POST['nome'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $idEstande = $_POST['id_estande'] ?? '';

    if (empty($nome) || empty($senha) || empty($idEstande)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Nome, senha e ID do estande são obrigatórios.']);
        exit;
    }

    try {
        $pdo = DB::connect();

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $pdo->beginTransaction();

        $sqlAluno = "INSERT INTO alunos (email, nome, senha) VALUES (:email, :nome, :senha)";
        $stmtAluno = $pdo->prepare($sqlAluno);
        $stmtAluno->bindParam(':email', $_SESSION['email']);
        $stmtAluno->bindParam(':nome', $nome);
        $stmtAluno->bindParam(':senha', $senhaHash);
        $stmtAluno->execute();

        $idAluno = $pdo->lastInsertId();

        $sqlRelacao = "INSERT INTO alunos_projetos (id_aluno, id_estande) VALUES (:id_aluno, :id_estande)";
        $stmtRelacao = $pdo->prepare($sqlRelacao);
        $stmtRelacao->bindParam(':id_aluno', $idAluno);
        $stmtRelacao->bindParam(':id_estande', $idEstande);
        $stmtRelacao->execute();

        $pdo->commit();

        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Conta criada com sucesso!']);

        // Limpar as variáveis de sessão após o cadastro bem-sucedido
        unset($_SESSION['codigo']);
        unset($_SESSION['email']);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao criar a conta: ' . $e->getMessage()]);
    } finally {
        $pdo = null;
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método de requisição inválido.']);
}