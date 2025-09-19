<?php
// Configurações do banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$db   = "upload_db";

// Verifica se o ID do arquivo foi informado via GET
if (!isset($_GET['id'])) {
    die("ID não especificado."); // Termina o script se não houver ID
}

$id = (int)$_GET['id']; // Converte o ID para inteiro por segurança

try {
    // Conecta ao banco usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepara e executa a exclusão do arquivo pelo ID
    $stmt = $pdo->prepare("DELETE FROM arquivos WHERE id = ?");
    $stmt->execute([$id]);

    // Redireciona de volta para a lista de arquivos
    header("Location: list.php");
    exit; // Interrompe o script
} catch (PDOException $e) {
    // Mostra erro caso haja problema de conexão ou na exclusão
    die("Erro: ".$e->getMessage());
}
?>
