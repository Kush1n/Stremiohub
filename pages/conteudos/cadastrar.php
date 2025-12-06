<?php
include "../../includes/db.php";
include "../../includes/header.php";

if ($_POST) {
    $titulo = $_POST["titulo"];
    $descricao = $_POST["descricao"];
    $categoria = $_POST["categoria"];
    $tipo = $_POST["tipo"];
    $classificacao = $_POST["classificacao_indicativa"];
    $duracao = $_POST["duracao"] ?: null;
    $ano = $_POST["ano_lancamento"];
    $capa = $_POST["capa_url"];

    // Se for série, duração fica NULL
    if ($tipo == "serie") {
        $duracao = null;
    }

    $sql = $pdo->prepare("
        INSERT INTO conteudo 
        (titulo, descricao, categoria, tipo, classificacao_indicativa, duracao, ano_lancamento, capa_url)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $sql->execute([$titulo, $descricao, $categoria, $tipo, $classificacao, $duracao, $ano, $capa]);

    echo "<script>alert('Conteúdo cadastrado!');location.href='listar.php';</script>";
}
?>

<h2>Cadastrar Conteúdo</h2>

<form method="POST">
    Título: <input type="text" name="titulo" required><br><br>

    Descrição:<br>
    <textarea name="descricao" required></textarea><br><br>

    Categoria: <input type="text" name="categoria" required><br><br>

    Tipo:
    <select name="tipo" required>
        <option value="filme">Filme</option>
        <option value="serie">Série</option>
    </select><br><br>

    Classificação Indicativa:
    <input type="number" name="classificacao_indicativa" min="0" max="18" required> anos<br><br>

    Duração (somente filmes):
    <input type="number" name="duracao"><br><br>

    Ano de Lançamento:
    <input type="number" name="ano_lancamento" required><br><br>

    URL da Capa:
    <input type="text" name="capa_url"><br><br>

    <button type="submit">Salvar</button>
</form>

<?php include "../../includes/footer.php"; ?>
