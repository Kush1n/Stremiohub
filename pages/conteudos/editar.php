<?php
include "../../includes/db.php";
include "../../includes/header.php";

$id = $_GET["id"];

$sql = $pdo->prepare("SELECT * FROM conteudo WHERE id_conteudo = ?");
$sql->execute([$id]);
$c = $sql->fetch();

if ($_POST) {
    $tipo = $_POST["tipo"];
    $duracao = $_POST["duracao"] ?: null;

    if ($tipo == "serie") $duracao = null;

    $update = $pdo->prepare("
        UPDATE conteudo SET 
            titulo=?, descricao=?, categoria=?, tipo=?, classificacao_indicativa=?, 
            duracao=?, ano_lancamento=?, capa_url=?
        WHERE id_conteudo=?
    ");

    $update->execute([
        $_POST["titulo"],
        $_POST["descricao"],
        $_POST["categoria"],
        $tipo,
        $_POST["classificacao_indicativa"],
        $duracao,
        $_POST["ano_lancamento"],
        $_POST["capa_url"],
        $id
    ]);

    echo "<script>alert('Conteúdo atualizado!');location.href='listar.php';</script>";
}
?>

<h2>Editar Conteúdo</h2>

<form method="POST">
    Título: <input type="text" name="titulo" value="<?= $c['titulo'] ?>" required><br><br>

    Descrição:<br>
    <textarea name="descricao" required><?= $c['descricao'] ?></textarea><br><br>

    Categoria: <input type="text" name="categoria" value="<?= $c['categoria'] ?>" required><br><br>

    Tipo:
    <select name="tipo">
        <option value="filme" <?= $c['tipo']=='filme'?'selected':'' ?>>Filme</option>
        <option value="serie" <?= $c['tipo']=='serie'?'selected':'' ?>>Série</option>
    </select><br><br>

    Classificação:
    <input type="number" name="classificacao_indicativa"
           value="<?= $c['classificacao_indicativa'] ?>" min="0" max="18" required><br><br>

    Duração:
    <input type="number" name="duracao" value="<?= $c['duracao'] ?>"><br><br>

    Ano:
    <input type="number" name="ano_lancamento" value="<?= $c['ano_lancamento'] ?>" required><br><br>

    Capa:
    <input type="text" name="capa_url" value="<?= $c['capa_url'] ?>"><br><br>

    <button type="submit">Salvar Alterações</button>
</form>

<?php include "../../includes/footer.php"; ?>
