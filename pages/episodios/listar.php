<?php
include "../../includes/db.php";
include "../../includes/header.php";

$episodios = $pdo->query("
    SELECT e.*, c.titulo AS serie
    FROM episodio e
    JOIN conteudo c ON e.id_conteudo = c.id_conteudo
    ORDER BY c.titulo, e.numero_temporada, e.numero_episodio
")->fetchAll();
?>

<h2>Episódios</h2>
<a href="cadastrar.php">+ Novo Episódio</a>

<table border="1" cellpadding="8">
    <tr>
        <th>Série</th>
        <th>Temporada</th>
        <th>Episódio</th>
        <th>Título</th>
        <th>Duração</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($episodios as $e): ?>
    <tr>
        <td><?= $e['serie'] ?></td>
        <td><?= $e['numero_temporada'] ?></td>
        <td><?= $e['numero_episodio'] ?></td>
        <td><?= $e['titulo'] ?></td>
        <td><?= $e['duracao'] ?> min</td>

        <td>
            <a href="editar.php?id=<?= $e['id_episodio'] ?>">Editar</a> |
            <a href="excluir.php?id=<?= $e['id_episodio'] ?>" onclick="return confirm('Excluir episódio?')">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include "../../includes/footer.php"; ?>
