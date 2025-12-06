<?php
include "../../includes/db.php";

$id = $_GET["id"];

$sql = $pdo->prepare("UPDATE historico SET progresso = 100 WHERE id_historico = ?");
$sql->execute([$id]);

echo "<script>alert('Conteúdo marcado como concluído!');location.href='listar.php';</script>";
?>
