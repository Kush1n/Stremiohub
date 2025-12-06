<?php
require_once '../../includes/conexao.php';

// Verifica se o ID foi passado
if (!isset($_GET['id'])) {
    header("Location: listar.php?erro=ID não informado");
    exit;
}

$id = intval($_GET['id']);

// Consulta os dados atuais do registro
$sql = $pdo->prepare("SELECT * FROM historico WHERE id = :id LIMIT 1");
$sql->execute([':id' => $id]);
$historico = $sql->fetch(PDO::FETCH_ASSOC);

if (!$historico) {
    header("Location: listar.php?erro=Registro não encontrado");
    exit;
}

require_once '../../includes/header.php';
?>

<div class="container mt-4">
    <h2 class="mb-4">Editar Registro do Histórico</h2>

    <form action="editar_action.php" method="POST">

        <input type="hidden" name="id" value="<?= $historico['id']; ?>">

        <div class="mb-3">
            <label class="form-label">ID do Conteúdo</label>
            <input type="number" class="form-control" name="conteudo_id"
                   value="<?= $historico['conteudo_id']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">ID do Episódio</label>
            <input type="number" class="form-control" name="episodio_id"
                   value="<?= $historico['episodio_id']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ação</label>
            <select class="form-select" name="acao" required>
                <option value="visualizado" <?= $historico['acao'] == 'visualizado' ? 'selected' : ''; ?>>
                    Visualizado
                </option>
                <option value="assistido" <?= $historico['acao'] == 'assistido' ? 'selected' : ''; ?>>
                    Assistido
                </option>
                <option value="pausado" <?= $historico['acao'] == 'pausado' ? 'selected' : ''; ?>>
                    Pausado
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Data</label>
            <input type="datetime-local" class="form-control" name="data"
                   value="<?= date('Y-m-d\TH:i', strtotime($historico['data'])); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="listar.php" class="btn btn-secondary">Cancelar</a>

    </form>
</div>

<?php require_once '../../includes/footer.php'; ?>
