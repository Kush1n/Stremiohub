<?php
require_once "../../includes/db.php";
include "../../includes/header.php";

// Carregar os planos
$planos = $pdo->query("SELECT * FROM plano")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $nascimento = $_POST["data_nascimento"];
    $plano = $_POST["id_plano"];

    // Verificar idade
    $idade = date_diff(date_create($nascimento), date_create('today'))->y;

    if ($idade < 12) {
        die("Usuário não pode ter menos de 12 anos.");
    }

    // Criptografar senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO usuario (nome, email, senha_hash, data_nascimento, id_plano, data_assinatura, ativo)
        VALUES (?, ?, ?, ?, ?, CURRENT_DATE(), 1)
    ");

    $stmt->execute([$nome, $email, $senha_hash, $nascimento, $plano]);

    header("Location: listar.php");
    exit;
}
?>

<h2>Novo Usuário</h2>

<form method="POST">

    Nome:<br>
    <input type="text" name="nome" required><br><br>

    Email:<br>
    <input type="email" name="email" required><br><br>

    Senha:<br>
    <input type="password" name="senha" required><br><br>

    Data de Nascimento:<br>
    <input type="date" name="data_nascimento" required><br><br>

    Plano:<br>
    <select name="id_plano" required>
        <?php foreach ($planos as $p): ?>
            <option value="<?= $p["id_plano"] ?>"><?= $p["nome_plano"] ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Salvar</button>
</form>

<?php include "../../includes/footer.php"; ?>
