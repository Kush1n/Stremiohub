<?php
require_once '../../includes/conexao.php';

// Verifica se todos os campos obrigatórios foram enviados
if (!isset($_POST['id'], $_POST['conteudo_id'], $_POST['episodio_id'], $_POST['acao'], $_POST['data'])) {
    header("Location: listar.php?erro=Dados incompletos");
    exit;
}

$id = intval($_POST['id']);
$conteudo_id = intval($_POST['conteudo_id']);
$episodio_id = intval($_POST['episodio_id']);
$acao = trim($_POST['acao']);
$data = $_POST['data'];

// Atualiza no banco de dados
$sql = $pdo->prepare("
    UPDATE historico 
    SET conteudo_id = :conteudo_id,
        episodio_id = :episodio_id,
        acao = :acao,
        data = :data
    WHERE id = :id
");

$ok = $sql->execute([
    ':conteudo_id' => $conteudo_id,
    ':episodio_id' => $episodio_id,
    ':acao'        => $acao,
    ':data'        => $data,
    ':id'          => $id
]);

// Verifica se deu certo
if ($ok) {
    header("Location: listar.php?mensagem=Registro atualizado com sucesso");
    exit;
} else {
    header("Location: listar.php?erro=Falha ao atualizar o registro");
    exit;
}
