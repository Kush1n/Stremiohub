<?php
require_once '../../includes/conexao.php';

// Verifica se todos os campos necessários estão presentes
if (!isset($_POST['id'], $_POST['nome'], $_POST['email'], $_POST['data_nascimento'], $_POST['id_plano'], $_POST['ativo'])) {
    header("Location: listar.php?erro=Dados incompletos");
    exit;
}

$id = intval($_POST['id']);
$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$data_nascimento = $_POST['data_nascimento'];
$id_plano = intval($_POST['id_plano']);
$ativo = intval($_POST['ativo']);
$senha_nova = $_POST['senha'];

// ----------------------
// 1️⃣ Validar idade mínima
// ----------------------
$hoje = new DateTime();
$nasc = new DateTime($data_nascimento);
$idade = $nasc->diff($hoje)->y;

if ($idade < 18) {
    header("Location: editar.php?id=$id&erro=Usuário deve ter pelo menos 18 anos.");
    exit;
}

// ----------------------
// 2️⃣ Validar se o plano existe
// ----------------------
$sqlPlano = $pdo->prepare("SELECT * FROM plano WHERE id_plano = :id");
$sqlPlano->execute([':id' => $id_plano]);

if ($sqlPlano->rowCount() === 0) {
    header("Location: editar.php?id=$id&erro=Plano inválido.");
    exit;
}

// ----------------------
// 3️⃣ Atualizar dados (sem senha primeiro)
// ----------------------
$sql = $pdo->prepare("
    UPDATE usuario SET 
        nome = :nome,
        email = :email,
        data_nascimento = :data_nascimento,
        id_plano = :id_plano,
        ativo = :ativo
    WHERE id_usuario = :id
");

$ok = $sql->execute([
    ':nome' => $nome,
    ':email' => $email,
    ':data_nascimento' => $data_nascimento,
    ':id_plano' => $id_plano,
    ':ativo' => $ativo,
    ':id' => $id
]);

// ----------------------
// 4️⃣ Atualizar senha apenas se enviada
// ----------------------
if (!empty($senha_nova)) {
    $senha_hash = password_hash($senha_nova, PASSWORD_DEFAULT);

    $sqlSenha = $pdo->prepare("
        UPDATE usuario SET senha = :senha WHERE id_usuario = :id
    ");
    $sqlSenha->execute([
        ':senha' => $senha_hash,
        ':id' => $id
    ]);
}

// ----------------------
// 5️⃣ Finalização
// ----------------------
if ($ok) {
    header("Location: listar.php?mensagem=Usuário atualizado com sucesso");
    exit;
} else {
    header("Location: editar.php?id=$id&erro=Falha ao atualizar usuário");
    exit;
}
