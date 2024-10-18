<?php
session_start();
require_once '../classes/db.class.php';

if (!isset($_SESSION['id_aluno'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Aluno não está logado.']);
    exit;
}

$id_aluno = $_SESSION['id_aluno'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_estande = $_POST['id_estande'] ?? '';
    $horario_inicio = $_POST['horario_inicio'] ?? '';
    $horario_fim = $_POST['horario_fim'] ?? '';

    if (empty($id_estande) || empty($horario_inicio) || empty($horario_fim)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Todos os campos são obrigatórios.']);
        exit;
    }

    if (
        !preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]$/", $horario_inicio) ||
        !preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]$/", $horario_fim)
    ) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Formato de horário inválido. Use HH:MM.']);
        exit;
    }

    try {
        $pdo = DB::connect();

        $stmt = $pdo->prepare("SELECT 1 FROM alunos_projetos WHERE id_aluno = :id_aluno AND id_estande = :id_estande");
        $stmt->execute(['id_aluno' => $id_aluno, 'id_estande' => $id_estande]);
        if (!$stmt->fetch()) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Aluno não está associado a este estande.']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO horarios_estande (id_estande, id_aluno, horario_inicio, horario_fim) VALUES (:id_estande, :id_aluno, :horario_inicio, :horario_fim)");
        $stmt->execute([
            'id_estande' => $id_estande,
            'id_aluno' => $id_aluno,
            'horario_inicio' => $horario_inicio,
            'horario_fim' => $horario_fim
        ]);

        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Horário registrado com sucesso.']);
    } catch (PDOException $e) {
        error_log("Erro ao registrar horário: " . $e->getMessage());
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao registrar horário. Por favor, tente novamente.']);
    } finally {
        $pdo = null;
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método de requisição inválido.']);
}
