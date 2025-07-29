<?php
include('../php/conexao.php');

$id = $_POST['id'] ?? null;

header('Content-Type: application/json');

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}
$sql = "DELETE FROM pokemon WHERE pokemon_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
if($stmt->execute()){
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao excluir']);
}
$stmt->close();
$conexao->close();
?>
