<?php
require_once '../../includes/conexao.php';
include '../../includes/header.php';

// Buscar planos disponíveis para exibir no select
$planos = $pdo->query("SELECT * FROM plano")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Cadastrar Usuário</h1>

<form action="cadastrar_action.php" method="POST">

    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Senha:</label><br>
    <input type="password" name="senha" required><br><br>

    <label>Data de Nascimento:</label><br>
    <input type="date" name="data_nascimento" required><br><br>

    <label>Plano:</label><br>
    <select name="id_plano" required>
        <option value="">Selecione um plano</option>
        <?php foreach ($planos as $p): ?>
            <option value="<?= $p['id_plano'] ?>">
                <?= $p['nome_plano'] ?> - R$<?= number_format($p['preco'], 2, ',', '.') ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Assinatura ativa?</label><br>
    <select name="ativo" required>
        <option value="1">Ativo</option>
        <option value="0">Cancelado</option>
    </select>
    <br><br>

    <button type="submit">Salvar Usuário</button>
</form>

<?php include '../../includes/footer.php'; ?>
            