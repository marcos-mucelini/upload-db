<?php
// Configurações do banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$db   = "upload_db";

try {
    // Conecta ao banco usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o formulário foi enviado e se existe arquivo
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['arquivo'])) {
        // Verifica se não houve erro no upload
        if ($_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
            $nome = $_FILES['arquivo']['name']; // Nome original do arquivo
            $tipo = $_FILES['arquivo']['type']; // Tipo MIME do arquivo
            $tamanho = $_FILES['arquivo']['size']; // Tamanho em bytes
            $conteudo = file_get_contents($_FILES['arquivo']['tmp_name']); // Conteúdo do arquivo

            // Prepara comando SQL para inserir arquivo no banco
            $stmt = $pdo->prepare("INSERT INTO arquivos (nome, tipo, tamanho, conteudo) VALUES (?, ?, ?, ?)");
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(2, $tipo);
            $stmt->bindParam(3, $tamanho);
            $stmt->bindParam(4, $conteudo, PDO::PARAM_LOB); // LOB = Large Object

            // Executa e define mensagem de sucesso ou erro
            if ($stmt->execute()) {
                $msg = "Arquivo '$nome' enviado com sucesso!";
            } else {
                $msg = "Erro ao salvar no banco.";
            }
        } else {
            $msg = "Erro no upload."; // Mensagem caso o upload falhe
        }
    }
} catch (PDOException $e) {
    // Mostra mensagem de erro no estilo terminal se conexão falhar
    die("<body style='background:black;color:#00ff00;font-family:Courier New,monospace'>Erro: ".$e->getMessage()."</body>");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Upload MSDOS</title>
    <style>
        body {
            background-color: black; /* Fundo preto estilo terminal */
            color: #00ff00;          /* Texto verde */
            font-family: "Courier New", monospace;
            font-size: 18px;
        }
        .console {
            width: 800px;
            margin: 30px auto;  /* Centraliza a caixa */
            padding: 20px;
            border: 2px solid #00ff00;
        }
        input[type="file"], input[type="submit"] {
            background-color: black;
            color: #00ff00;
            border: 1px solid #00ff00;
            padding: 5px;
            font-family: "Courier New", monospace;
        }
        input[type="submit"]:hover {
            background-color: #003300; /* Efeito hover */
        }
    </style>
</head>
<body>
<div class="console">
    <h1>Upload de Arquivo</h1>

    <?php if (!empty($msg)) echo "<p>$msg</p>"; ?> <!-- Mostra mensagem de sucesso ou erro -->

    <form method="post" enctype="multipart/form-data"> 
        <!-- Formulário de upload; enctype obrigatório para arquivos -->
        <input type="file" name="arquivo" required> <!-- Campo de arquivo -->
        <input type="submit" value="Enviar"> <!-- Botão de envio -->
    </form>

    <p><a href="index.php" style="color:#00ff00">[Voltar]</a></p> <!-- Link para voltar ao terminal -->
</div>
</body>
</html>
