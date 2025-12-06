<?php
require_once "../../includes/db.php";
include "../../includes/header.php";

if (!isset($_GET["id"])) {
    die("ID não informado.");
}

$id = $_GET["id"];

// Buscar dados do plano
$stmt = $pdo->prepare("SELECT * FROM plano WHERE id_plano = ?");
stmt->execute([$id]);
$plano = $stmt->fetch();

if (!$plano) {
    die("Plano não encontrado.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $telas = $_POST["limite_telas"];
    $qualidade = $_POST["qualidade_video"];

    $update = $pdo->prepare("UPDATE plano
                             SET nome_plano=?, preco=?, limite_telas=?, qualidade_video=?
                             WHERE id_plano=?");
    $update->execute([$nome, $preco, $telas, $qualidade, $id]);

    header("Location: listar.php");
    exit;
}
?>

<h2>Editar Plano</h2>

<form method="POST">
    Nome: <input type="text" name="nome" value="<?= $plano['nome_plano'] ?>" required><br><br>

    Preço: <input type="number" step="0.01" name="preco" value="<?= $plano['preco'] ?>" required><br><br>

    Telas simultâneas: <input type="number" name="limite_telas" min="1" value="<?= $plano['limite_telas'] ?>" required><br><br>

    Qualidade:
    <select name="qualidade_video">
        <option <?= $plano["qualidade_video"]=="SD"?"selected":"" ?>>SD</option>
        <option <?= $plano["qualidade_video"]=="HD"?"selected":"" ?>>HD</option>
        <option <?= $plano["qualidade_video"]=="FullHD"?"selected":"" ?>>FullHD</option>
        <option <?= $plano["qualidade_video"]=="4K"?"selected":"" ?>>4K</option>
    </select><br><br>

    <button type="submit">Salvar</button>
</form>

<?php include "../../includes/footer.php"; ?>
