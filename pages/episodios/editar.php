<?php
include "../../includes/db.php";
include "../../includes/header.php";

$id = $_GET["id"];

$episodio = $pdo->prepare("SELECT * FROM episodio WHERE id_episodio = ?");
$episodio->execute([$id]);
$episodio = $episodio->fetch();

$series = $pdo->query("SELECT * FROM conteudo WHERE tipo = 'serie'")->fetchAll();

if ($_POST) {
    $sql = $pdo->prepare("
        UPDATE episodio SET 
            id_conteudo=?, titulo=?, numero_temporada=?, numero_episodio=?, duracao=?, video_url=?
        WHERE id_episodio=?
    ");
    $sql->execute([
        $_POST["id_conteudo"],
        $_POST["titulo"],
        $_POST["numero_temporada"],
        $_POST["numero_episodio"],
        $_POST["duracao"],
        $_POST["video_url"],
        $id
    ]);

    echo "<script>alert('Episódio atualizado!');location.href='listar.php';</script>";
}
?>

<h2>Editar Episódio</h2>

<form method="POST">

    Série:
    <select name="id_conteudo">
        <?php foreach ($series as $s): ?>
            <option value="<?= $s['id_conteudo'] ?>" 
                <?= $s['id_conteudo'] == $episodio["id_conteudo"] ? "selected" : "" ?>>
                <?= $s['titulo'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    Título: <input type="text" name="titulo" value="<?= $episodio['titulo'] ?>"><br><br>
    Temporada: <input type="number" name="numero_temporada" value="<?= $episodio['numero_temporada'] ?>"><br><br>
    Episódio: <input type="number" name="numero_episodio" value="<?= $episodio['numero_episodio'] ?>"><br><br>
    Duração: <input type="number" name="duracao" value="<?= $episodio['duracao'] ?>"><br><br>
    URL vídeo: <input type="text" name="video_url" value="<?= $episodio['video_url'] ?>"><br><br>

    <button type="submit">Salvar Alterações</button>
</form>

<?php include "../../includes/footer.php"; ?>
