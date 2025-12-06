<?php
include "../../includes/db.php";
include "../../includes/header.php";

$sql = $pdo->query("
    SELECT h.id_historico, h.data_visualizacao, h.progresso,
           u.nome AS usuario,
           c.titulo AS conteudo,
           e.titulo AS episodio
    FROM historico h
    JOIN usuario u ON h.id_usuario = u.id_usuario
    JOIN conteudo c ON h.id_conteudo = c.id_conteudo
    LEFT JOIN episodio e ON h.id_episodio = e.id_episodio
    ORDER BY h.data_visualizacao DESC
");
$historicos = $sql->fetchAll();
?>

<h2>Histórico de Visualizações</h2>
<a href="cadastrar.php">+ Novo Registro</a>

<table border="1" cellpadding="8">
    <tr>
        <th>Usuário</th>
        <th>Conteúdo</th>
        <th>Episódio</th>
        <th>Data</th>
        <th>Progresso</th>
        <th>Ações</th>
    </tr>

<?php foreach ($historicos as $h): ?>
    <tr>
        <td><?= $h['usuario'] ?></td>
        <td><?= $h['conteudo'] ?></td>
        <td><?= $h['episodio'] ?: '-' ?></td>
        <td><?= $h['data_visualizacao'] ?></td>
        <td><?= $h['progresso'] ?>%</td>

        <td>
            <a href="editar.php?id=<?= $h['id_historico'] ?>">Editar</a> |
            <a href="concluir.php?id=<?= $h['id_historico'] ?>"
               onclick="return confirm('Marcar como concluído (100%)?')">
               Marcar 100%
            </a>
        </td>
    </tr>
<?php endforeach; ?>
</table>

<?php include "../../includes/footer.php"; ?>
