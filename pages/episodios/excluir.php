<?php
include "../../includes/db.php";

$id = $_GET["id"];

$sql = $pdo->prepare("DELETE FROM episodio WHERE id_episodio = ?");
$sql->execute([$id]);

echo "<script>alert('Episódio excluído!');location.href='listar.php';</script>";
?>
