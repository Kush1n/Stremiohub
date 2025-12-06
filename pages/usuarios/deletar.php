<?php
require_once '../../includes/conexao.php';

// Verifica se recebeu o ID
if (!isset($_GET['id'])) {
    header("Location: listar.php?erro=ID não informado");
    exit;
}

$id = intval($_GET['id']);

// Verifica se o usuário existe
$sql = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id");
$sql->execute([':id' => $id]);

if ($sql->rowCount() === 0) {
    header("Location: listar.php?erro=Usuário não encontrado");
    exit;
}

// Excluir usuário
$delete = $pdo->prepare("DELETE FROM usuario WHERE id_usuario = :id");
$ok = $delete->execute([':id' => $id]);

if ($ok) {
    header("Location: listar.php?mensagem=Usuário excluído com sucesso");
    exit;
} else {
    header("Location: listar.php?erro=Falha ao excluir usuário");
    exit;
}
     