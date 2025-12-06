<?php
include "../../includes/db.php";
include "../../includes/header.php";

$series = $pdo->query("SELECT * FROM conteudo WHERE tipo = 'serie'")->fetchAll();

if ($_POST) {
    $id_conteudo = $_POST["id_conteudo"];
    $titulo = $_POST["titulo"];
    $temporada = $_POST["numero_temporada"];
    $episodio = $_POST["numero_episodio"];
    $duracao = $_POST["duracao"];
    $video = $_POST["video_url"];

    // Inserção
    $sql = $pdo->prepare("
        INSERT INTO episodio (id_conteudo, titulo, numero_temporada, numero_episodio, duracao, video_url)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $sql->execute([$id_conteudo, $titulo, $temporada, $episodio, $duracao, $video]);

    echo "<script>alert('Episódio cadastrado!');location.href='listar.php';</script>";
}
?>

<h2>Cadastrar Episódio</h2>

<form method="POST">
    Série:
    <select name="id_conteudo" required>
        <option value="">Selecione</option>
        <?php foreach ($series as $s): ?>
            <option value="<?= $s['id_conteudo'] ?>"><?= $s['titulo'] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    Título: <input type="text" name="titulo" required><br><br>
    Temporada: <input type="number" name="numero_temporada" required><br><br>
    Episódio: <input type="number" name="numero_episodio" required><br><br>
    Duração (min): <input type="number" name="duracao" required><br><br>
    URL do Vídeo: <input type="text" name="video_url" required><br><br>

    <button type="submit">Salvar</button>
</form>

<?php include "../../includes/footer.php"; ?>
