<?php
require_once "../../includes/db.php";
include "../../includes/header.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titulo = $_POST["titulo"];
    $descricao = $_POST["descricao"];
    $categoria = $_POST["categoria"];
    $tipo = $_POST["tipo"];
    $classificacao = $_POST["classificacao_indicativa"];
    $ano = $_POST["ano_lancamento"];
    $capa = $_POST["capa_url"];

    // Regra: duração só para filmes
    $duracao = $tipo == "filme" ? $_POST["duracao"] : null;

    $stmt = $pdo->prepare("
        INSERT INTO conteudo
        (titulo, descricao, categoria, tipo, classificacao_indicativa, duracao, ano_lancamento, capa_url)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $titulo, $descricao, $categoria, $tipo, $classificacao,
        $duracao, $ano, $capa
    ]);
    
    header("Location: listar.php");
    exit;
}
?>

<h2>Novo Conteúdo</h2>

<form method="POST">

    Título: <br>
    <input type="text" name="titulo" required><br><br>

    Descrição: <br>
    <textarea name="descricao" required></textarea><br><br>

    Categoria: <br>
    <input type="text" name="categoria" required><br><br>

    Tipo: <br>
    <select name="tipo" id="tipo" onchange="atualizarCampos()">
        <option value="filme">Filme</option>
        <option value="serie">Série</option>
    </select><br><br>

    Classificação indicativa: <br>
    <input type="number" name="classificacao_indicativa" min="0" max="18" required> <br><br>

    <div id="campo_duracao">
        Duração (minutos): <br>
        <input type="number" name="duracao" min="1"><br><br>
    </div>

    Ano de lançamento: <br>
    <input type="number" name="ano_lancamento" min="1900" max="2100" required><br><br>

    URL da capa: <br>
    <input type="text" name="capa_url"><br><br>

    <button type="submit">Salvar</button>
</form>

<script>
function atualizarCampos() {
    const tipo = document.getElementById("tipo").value;
    document.getElementById("campo_duracao").style.display =
        tipo === "filme" ? "block" : "none";
}
</script>

<?php include "../../includes/footer.php"; ?>
