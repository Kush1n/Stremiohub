<?php
require_once '../../includes/conexao.php';

// Se não enviaram o ID, volta para a lista
if (!isset($_GET['id'])) {
    header("Location: listar.php?erro=ID não informado");
    exit;
}

$id = intval($_GET['id']);

// Regra do sistema:
// Histórico não pode ser excluído -> apenas marcar como 100%
$sql = $pdo->prepare("UPDATE historico SET progresso = 100 WHERE id_historico = :id");
$ok = $sql->execute([':id' => $id]);

if ($ok) {
    header("Location: listar.php?mensagem=Histórico marcado como concluído (100%)");
    exit;
} else {
    header("Location: listar.php?erro=Falha ao marcar como concluído");
    exit;
}
