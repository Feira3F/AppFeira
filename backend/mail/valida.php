<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo']) && isset($_SESSION['codigo'])) {
    $codigoInformado = $_POST['codigo'];

    if ($codigoInformado == $_SESSION['codigo']) {
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Código válido.']);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Código inválido.']);
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método de requisição inválido ou código não fornecido.']);
}