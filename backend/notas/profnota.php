<?php
session_start();
require_once 'classes/db.class.php';

if (!isset($_SESSION['professor_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Acesso não autorizado.']);
    exit;
}

$professor_id = $_SESSION['professor_id'];

function getProfessorProjects($pdo, $professor_id)
{
    $sql = "SELECT p.id_estande, p.nome_proj 
            FROM profavalia pa
            JOIN projetos p ON pa.id_estande = p.id_estande
            WHERE pa.id_professor = :professor_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['professor_id' => $professor_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function submitGrade($pdo, $professor_id, $data)
{
    $sql = "INSERT INTO notas (id_professor, id_estande, oralidade, postura, organizacao, criatividade, capricho, dominio, abordagem, comentario)
            VALUES (:professor_id, :id_estande, :oralidade, :postura, :organizacao, :criatividade, :capricho, :dominio, :abordagem, :comentario)
            ON DUPLICATE KEY UPDATE
            oralidade = VALUES(oralidade), postura = VALUES(postura), organizacao = VALUES(organizacao),
            criatividade = VALUES(criatividade), capricho = VALUES(capricho), dominio = VALUES(dominio),
            abordagem = VALUES(abordagem), comentario = VALUES(comentario)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'professor_id' => $professor_id,
        'id_estande' => $data['id_estande'],
        'oralidade' => $data['oralidade'],
        'postura' => $data['postura'],
        'organizacao' => $data['organizacao'],
        'criatividade' => $data['criatividade'],
        'capricho' => $data['capricho'],
        'dominio' => $data['dominio'],
        'abordagem' => $data['abordagem'],
        'comentario' => $data['comentario']
    ]);
}

function getGrades($pdo, $professor_id)
{
    $sql = "SELECT n.*, p.nome_proj 
            FROM notas n
            JOIN projetos p ON n.id_estande = p.id_estande
            WHERE n.id_professor = :professor_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['professor_id' => $professor_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

try {
    $pdo = DB::connect();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $projects = getProfessorProjects($pdo, $professor_id);
        echo json_encode(['status' => 'sucesso', 'projetos' => $projects]);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        submitGrade($pdo, $professor_id, $data);
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Nota submetida com sucesso.']);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['view_grades'])) {
        $grades = getGrades($pdo, $professor_id);
        echo json_encode(['status' => 'sucesso', 'notas' => $grades]);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Método não suportado.']);
    }
} catch (PDOException $e) {
    error_log("Erro no sistema de notas: " . $e->getMessage());
    echo json_encode(['status' => 'erro', 'mensagem' => 'Ocorreu um erro ao processar sua solicitação.']);
} finally {
    $pdo = null;
}