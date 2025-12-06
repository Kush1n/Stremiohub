<?php
require_once "../../includes/db.php";
include "../../includes/header.php";

// Buscar todos os planos
$stmt = $pdo->query("SELECT * FROM plano");
$planos = $stmt->fetchAll();
?>

<h2>Planos</h2>
<a href="criar.php">+ Novo Plano</a>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Preço</th>
        <th>Telas</th>
        <th>Qualidade</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($planos as $p): ?>
        <tr>
            <td><?= $p["id_plano"] ?></td>
            <td><?= htmlspecialchars($p["nome_plano"]) ?></td>
            <td>R$ <?= number_format($p["preco"], 2, ',', '.') ?></td>
            <td><?= $p["limite_telas"] ?></td>
            <td><?= $p["qualidade_video"] ?></td>
            <td>
                <a href="editar.php?id=<?= $p['id_plano'] ?>">Editar</a> |
                <a href="excluir.php?id=<?= $p['id_plano'] ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include "../../includes/footer.php"; ?>
