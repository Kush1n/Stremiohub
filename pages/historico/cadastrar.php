<?php
include "../../includes/db.php";
include "../../includes/header.php";

// Listar usuários
$usuarios = $pdo->query("SELECT * FROM usuario ORDER BY nome")->fetchAll();

// Listar conteúdos
$conteudos = $pdo->query("SELECT * FROM conteudo ORDER BY titulo")->fetchAll();

if ($_POST) {

    $id_usuario = $_POST["id_usuario"];
    $id_conteudo = $_POST["id_conteudo"];
    $id_episodio = $_POST["id_episodio"] ?: null;
    $progresso = $_POST["progresso"];

    $sql = $pdo->prepare("
        INSERT INTO historico (id_usuario, id_conteudo, id_episodio, data_visualizacao, progresso)
        VALUES (?, ?, ?, NOW(), ?)
    ");
    
    $sql->execute([$id_usuario, $id_conteudo, $id_episodio, $progresso]);

    echo "<script>alert('Histórico registrado!');location.href='listar.php';</script>";
}
?>

<h2>Cadastrar Histórico</h2>

<form method="POST">

    Usuário:
    <select name="id_usuario" required>
        <option value="">Selecione</option>
        <?php foreach ($usuarios as $u): ?>
            <option value="<?= $u['id_usuario'] ?>"><?= $u["nome"] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    Conteúdo:
    <select name="id_conteudo" required>
        <option value="">Selecione</option>
        <?php foreach ($conteudos as $c): ?>
            <option value="<?= $c['id_conteudo'] ?>"><?= $c["titulo"] ?> (<?= $c["tipo"] ?>)</option>
        <?php endforeach; ?>
    </select><br><br>

    Episódio (somente séries):
    <select name="id_episodio">
        <option value="">Nenhum (Filmes)</option>
        <?php
        $episodios = $pdo->query("SELECT * FROM episodio ORDER BY numero_temporada, numero_episodio")->fetchAll();
        foreach ($episodios as $e):
        ?>
            <option value="<?= $e['id_episodio'] ?>">
                T<?= $e['numero_temporada'] ?>E<?= $e['numero_episodio'] ?> - <?= $e['titulo'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    Progresso (%):
    <input type="number" name="progresso" min="0" max="100" required><br><br>

    <button type="submit">Salvar</button>

</form>

<?php include "../../includes/footer.php"; ?>
