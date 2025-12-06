<?php
require_once "../../includes/db.php";
include "../../includes/header.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $telas = $_POST["limite_telas"];
    $qualidade = $_POST["qualidade_video"];

    $stmt = $pdo->prepare("INSERT INTO plano (nome_plano, preco, limite_telas, qualidade_video)
                           VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $preco, $telas, $qualidade]);

    header("Location: listar.php");
    exit;
}
?>

<h2>Novo Plano</h2>

<form method="POST">
    Nome: <input type="text" name="nome" required><br><br>

    Preço: <input type="number" step="0.01" name="preco" required><br><br>

    Telas simultâneas: <input type="number" name="limite_telas" min="1" required><br><br>

    Qualidade:
    <select name="qualidade_video">
        <option value="SD">SD</option>
        <option value="HD">HD</option>
        <option value="FullHD">Full HD</option>
        <option value="4K">4K</option>
    </select><br><br>

    <button type="submit">Salvar</button>
</form>

<?php include "../../includes/footer.php"; ?>
