<?php
// Configurações do banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$db   = "upload_db";

// Verifica se o ID do arquivo foi informado via GET
if (!isset($_GET['id'])) {
    die("ID não especificado.");
}

$id = (int)$_GET['id']; // Converte o ID para inteiro por segurança

try {
    // Conecta ao banco usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Busca o arquivo no banco pelo ID
    $stmt = $pdo->prepare("SELECT nome, tipo, conteudo FROM arquivos WHERE id = ?");
    $stmt->execute([$id]);
    $arquivo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se não encontrar, exibe mensagem de erro
    if (!$arquivo) {
        die("Arquivo não encontrado.");
    }

    // Define headers para forçar download no navegador
    header("Content-Description: File Transfer");
    header("Content-Type: ".$arquivo['tipo']); // Tipo do arquivo
    header("Content-Disposition: attachment; filename=\"".$arquivo['nome']."\""); // Nome do arquivo
    header("Content-Length: ".strlen($arquivo['conteudo'])); // Tamanho do arquivo

    echo $arquivo['conteudo']; // Envia o conteúdo do arquivo para download
    exit; // Interrompe o script
} catch (PDOException $e) {
    // Mostra erro caso haja problema de conexão ou consulta
    die("Erro: ".$e->getMessage());
}
?>
