<?php

$senha = "123456";
$hash = password_hash($senha, PASSWORD_DEFAULT);

echo "Hash da senha: " . $hash . "\n";


// verificacao

$senhaInformada = "123456";
if (password_verify($senhaInformada, $hash)) {
    echo "Senha correta!";
} else {
    echo "Senha incorreta.";
}