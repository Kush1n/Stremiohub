<?php
include "../../includes/db.php";
include "../../includes/header.php";

$conteudos = $pdo->query("SELECT * FROM conteudo ORDER BY tipo, titulo")->fetchAll();
?>

<h2>Conteúdos (Filmes & Séries)</h2>
<a href="cadastrar.php">+ Novo Conteúdo</a>

<table border="1" cellpadding="8">
    <tr>
        <th>Título</th>
        <th>Tipo</th>
        <th>Categoria</th>
        <th>Ano</th>
        <th>Classificação</th>
        <th>Duração</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($conteudos as $c): ?>
    <tr>
        <td><?= $c['titulo'] ?></td>
        <td><?= strtoupper($c['tipo']) ?></td>
        <td><?= $c['categoria'] ?></td>
        <td><?= $c['ano_lancamento'] ?></td>
        <td><?= $c['classificacao_indicativa'] ?>+</td>
        <td>
            <?= $c['tipo'] == 'filme' ? $c['duracao'] . ' min' : '-' ?>
        </td>

        <td>
            <a href="editar.php?id=<?= $c['id_conteudo'] ?>">Editar</a> |
            <a href="excluir.php?id=<?= $c['id_conteudo'] ?>"
               onclick="return confirm('Excluir conteúdo?')">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include "../../includes/footer.php"; ?>
