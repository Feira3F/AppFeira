<?php
session_start();
require_once 'classes/db.class.php';

if (!isset($_SESSION['aluno_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso não autorizado.']);
    exit;
}

$aluno_id = $_SESSION['aluno_id'];

function getStudentGrades($pdo, $aluno_id)
{
    $sql = "SELECT p.nome_proj, 
                   AVG(n.oralidade) as oralidade, 
                   AVG(n.postura) as postura, 
                   AVG(n.organizacao) as organizacao, 
                   AVG(n.criatividade) as criatividade, 
                   AVG(n.capricho) as capricho, 
                   AVG(n.dominio) as dominio, 
                   AVG(n.abordagem) as abordagem
            FROM alunos_projetos ap
            JOIN projetos p ON ap.id_estande = p.id_estande
            JOIN notas n ON p.id_estande = n.id_estande
            WHERE ap.id_aluno = :aluno_id
            GROUP BY p.id_estande";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['aluno_id' => $aluno_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

try {
    $pdo = DB::connect();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $grades = getStudentGrades($pdo, $aluno_id);
        if ($grades) {
            echo json_encode(['status' => 'sucesso', 'notas' => $grades]);
        } else {
            echo json_encode(['status' => 'info', 'mensagem' => 'Nenhuma nota encontrada para este aluno.']);
        }
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Método não suportado.']);
    }
} catch (PDOException $e) {
    error_log("Erro ao recuperar notas do aluno: " . $e->getMessage());
    echo json_encode(['status' => 'erro', 'mensagem' => 'Ocorreu um erro ao recuperar suas notas.']);
} finally {
    $pdo = null;
}