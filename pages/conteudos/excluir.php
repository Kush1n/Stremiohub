<?php
include "../../includes/db.php";

$id = $_GET["id"];

// Verificar se tem episódios
$check = $pdo->prepare("SELECT COUNT(*) FROM episodio WHERE id_conteudo = ?");
$check->execute([$id]);
$temEpisodios = $check->fetchColumn();

if ($temEpisodios > 0) {
    echo "<script>alert('Não é possível excluir: a série possui episódios.');history.back();</script>";
    exit;
}

$delete = $pdo->prepare("DELETE FROM conteudo WHERE id_conteudo = ?");
$delete->execute([$id]);

echo "<script>alert('Conteúdo excluído!');location.href='listar.php';</script>";
?>
