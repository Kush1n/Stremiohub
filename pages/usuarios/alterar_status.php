<?php
require_once "../../includes/db.php";

if (!isset($_GET["id"])) {
    die("ID não informado.");
}

$id = $_GET["id"];

// Pegar status atual
$stmt = $pdo->prepare("SELECT ativo FROM usuario WHERE id_usuario = ?");
$stmt->execute([$id]);
$u = $stmt->fetch();

if (!$u) {
    die("Usuário não encontrado.");
}

// Alternar status
$novoStatus = $u["ativo"] ? 0 : 1;

$update = $pdo->prepare("UPDATE usuario SET ativo=? WHERE id_usuario=?");
$update->execute([$novoStatus, $id]);

header("Location: listar.php");
exit;
