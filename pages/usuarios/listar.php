<?php
require_once '../../includes/conexao.php';
include '../../includes/header.php';

// Busca todos os usuários + nome do plano
$sql = $pdo->query("
    SELECT u.*, p.nome_plano 
    FROM usuario u
    LEFT JOIN plano p ON u.id_plano = p.id_plano
");
$usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Usuários</h1>
<a href="cadastrar.php">+ Cadastrar Usuário</a>

<table border="1" width="100%" cellspacing="0" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Plano</th>
        <th>Assinatura ativa?</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($usuarios as $u): ?>
    <tr>
        <td><?= $u['id_usuario'] ?></td>
        <td><?= $u['nome'] ?></td>
        <td><?= $u['email'] ?></td>
        <td><?= $u['nome_plano'] ?></td>
        <td><?= ($u['ativo'] == 1 ? "Ativo" : "Cancelado") ?></td>
        <td>
            <a href="editar.php?id=<?= $u['id_usuario'] ?>">Editar</a> |
            <a href="deletar.php?id=<?= $u['id_usuario'] ?>"
               onclick="return confirm('Tem certeza que deseja excluir este usuário?');">
               Excluir
            </a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

<?php include '../../includes/footer.php'; ?>
