<?php
require_once '../../includes/conexao.php';
include '../../includes/header.php';

// Verifica se enviou o ID
if (!isset($_GET['id'])) {
    header("Location: listar.php?erro=ID não informado");
    exit;
}

$id = intval($_GET['id']);

// Buscar dados do usuário
$sql = $pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id");
$sql->execute([':id' => $id]);

if ($sql->rowCount() === 0) {
    header("Location: listar.php?erro=Usuário não encontrado");
    exit;
}

$usuario = $sql->fetch(PDO::FETCH_ASSOC);

// Buscar planos para o select
$planos = $pdo->query("SELECT * FROM plano")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Editar Usuário</h1>

<form action="editar_action.php" method="POST">

    <input type="hidden" name="id" value="<?= $usuario['id_usuario'] ?>">

    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= $usuario['nome'] ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $usuario['email'] ?>" required><br><br>

    <label>Data de nascimento:</label><br>
    <input type="date" name="data_nascimento" value="<?= $usuario['data_nascimento'] ?>" required><br><br>

    <label>Plano:</label><br>
    <select name="id_plano" required>
        <?php foreach ($planos as $p): ?>
            <option value="<?= $p['id_plano'] ?>" 
                <?= ($p['id_plano'] == $usuario['id_plano'] ? "selected" : "") ?>>
                <?= $p['nome_plano'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Assinatura ativa?</label><br>
    <select name="ativo" required>
        <option value="1" <?= ($usuario['ativo'] == 1 ? "selected" : "") ?>>Ativo</option>
        <option value="0" <?= ($usuario['ativo'] == 0 ? "selected" : "") ?>>Cancelado</option>
    </select>
    <br><br>

    <label>Alterar Senha (opcional):</label><br>
    <input type="password" name="senha">
    <br><small>Deixe em branco para não alterar</small>
    <br><br>

    <button type="submit">Salvar Alterações</button>
</form>

<?php include '../../includes/footer.php'; ?>
