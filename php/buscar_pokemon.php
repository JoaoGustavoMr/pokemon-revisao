<?php
// Mostrar erros na tela (apenas para testes)
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('../php/conexao.php');

header('Content-Type: application/json; charset=utf-8');

// Verifica se recebeu o ID
if (!isset($_GET['id'])) {
    echo json_encode(['erro' => 'ID não informado']);
    exit;
}

$id = (int) $_GET['id'];

// Prepara a consulta
$sql = "SELECT * FROM pokemon WHERE pokemon_id = ?";
$stmt = $conexao->prepare($sql);

if (!$stmt) {
    echo json_encode(['erro' => 'Erro na query: ' . $conexao->error]);
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Se encontrou o Pokémon
if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(['erro' => 'Pokémon não encontrado']);
}

$stmt->close();
$conexao->close();
?>
