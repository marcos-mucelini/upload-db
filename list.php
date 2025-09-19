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

    // Consulta todos os arquivos, do mais recente para o mais antigo
    $res = $pdo->query("SELECT id, nome, tipo, tamanho, criado_em FROM arquivos ORDER BY id DESC");
} catch (PDOException $e) {
    // Exibe mensagem de erro no estilo terminal se a conexão falhar
    die("<body style='background:black;color:#00ff00;font-family:Courier New,monospace'>Erro: ".$e->getMessage()."</body>");
}

// Função para transformar bytes em uma unidade mais amigável (KB, MB, etc)
function tamanhoFormatado($bytes, $decimais = 2) {
    $unidades = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($unidades) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, $decimais) . ' ' . $unidades[$i];
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Arquivos</title>
    <style>
        body {
            background-color: black; /* Fundo preto estilo terminal */
            color: #00ff00;          /* Texto verde */
            font-family: "Courier New", monospace; /* Fonte monoespaçada */
            font-size: 18px;
        }
        .console {
            width: 900px;
            margin: 30px auto;  /* Centraliza a caixa */
            padding: 20px;
            border: 2px solid #00ff00; /* Borda verde */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #00ff00;
            padding: 5px;
        }
        a.button {
            display: inline-block;
            padding: 3px 8px;
            background-color: black;
            color: #00ff00;
            border: 1px solid #00ff00;
            text-decoration: none;
            font-family: "Courier New", monospace;
        }
        a.button:hover {
            background-color: #003300; /* Efeito hover nos botões */
        }
    </style>
</head>
<body>
<div class="console">
    <h1>Lista de Arquivos</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Tamanho</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($res as $row): ?> <!-- Percorre todos os arquivos da consulta -->
            <tr>
                <td><?= $row['id'] ?></td> <!-- ID do arquivo -->
                <td><?= htmlspecialchars($row['nome']) ?></td> <!-- Nome do arquivo (com segurança) -->
                <td><?= $row['tipo'] ?></td> <!-- Tipo MIME do arquivo -->
                <td><?= tamanhoFormatado($row['tamanho']) ?></td> <!-- Tamanho formatado para KB/MB/GB -->
                <td><?= $row['criado_em'] ?></td> <!-- Data de criação -->
                <td>
                    <!-- Botão para baixar o arquivo -->
                    <a class="button" href="download.php?id=<?= $row['id'] ?>">Download</a>
                    <!-- Botão para remover arquivo com confirmação -->
                    <a class="button" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Tem certeza que deseja remover este arquivo?')">Remover</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="index.php" style="color:#00ff00">[Voltar]</a></p> <!-- Link para voltar ao terminal -->
</div>
</body>
</html>
