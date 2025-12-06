<?php
require_once '../../includes/conexao.php';

// Verifica se todos os campos necessários foram enviados
if (!isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['data_nascimento'], $_POST['id_plano'], $_POST['ativo'])) {
    header("Location: listar.php?erro=Dados incompletos");
    exit;
}

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = $_POST['senha'];
$data_nascimento = $_POST['data_nascimento'];
$id_plano = intval($_POST['id_plano']);
$ativo = intval($_POST['ativo']);


// ----------------------
// 1️⃣ Validar idade (regra de maior de 18 para conteúdos +18)
// ----------------------
$hoje = new DateTime();
$nasc = new DateTime($data_nascimento);
$idade = $nasc->diff($hoje)->y;

if ($idade < 18) {
    header("Location: cadastrar.php?erro=Usuário deve ter pelo menos 18 anos.");
    exit;
}


// ----------------------
// 2️⃣ Validar se o plano existe
// ----------------------
$sqlPlano = $pdo->prepare("SELECT * FROM plano WHERE id_plano = :id");
$sqlPlano->execute([':id' => $id_plano]);

if ($sqlPlano->rowCount() === 0) {
    header("Location: cadastrar.php?erro=Plano inválido.");
    exit;
}


// ----------------------
// 3️⃣ Criar hash seguro da senha
// ----------------------
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);


// ----------------------
// 4️⃣ Inserir no banco
// ----------------------
$sql = $pdo->prepare("
    INSERT INTO usuario 
    (nome, email, senha, data_nascimento, id_plano, data_assinatura, ativo)
    VALUES
    (:nome, :email, :senha, :data_nascimento, :id_plano, NOW(), :ativo)
");

$ok = $sql->execute([
    ':nome'            => $nome,
    ':email'           => $email,
    ':senha'           => $senha_hash,
    ':data_nascimento' => $data_nascimento,
    ':id_plano'        => $id_plano,
    ':ativo'           => $ativo
]);

if ($ok) {
    header("Location: listar.php?mensagem=Usuário cadastrado com sucesso");
    exit;
} else {
    header("Location: cadastrar.php?erro=Falha ao cadastrar usuário");
    exit;
}
