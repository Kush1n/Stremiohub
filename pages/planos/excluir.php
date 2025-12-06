<?php
require_once "../../includes/db.php";

if (!isset($_GET["id"])) {
    die("ID não informado.");
}

$id = $_GET["id"];

// Verificar se há usuários usando o plano
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM usuario WHERE id_plano = ?");
$stmt->execute([$id]);
$total = $stmt->fetch()["total"];

if ($total > 0) {
    die("Não é possível excluir este plano porque existem usuários vinculados a ele.");
}

// Excluir plano
$del = $pdo->prepare("DELETE FROM plano WHERE id_plano = ?");
$del->execute([$id]);

header("Location: listar.php");
exit;
