<!DOCTYPE html> <!-- Define que o arquivo é HTML5 -->
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define codificação UTF-8 -->
    <title>UploadDB</title> <!-- Título da aba do navegador -->
    <style>
        body {
            background-color: black; /* Fundo preto estilo terminal */
            color: #00ff00;          /* Texto verde */
            font-family: "Courier New", monospace; /* Fonte de terminal */
            font-size: 18px;
        }
        .console { 
            width: 800px;
            margin: 30px auto;  /* Centraliza a caixa */
            padding: 20px;
            border: 2px solid #00ff00; /* Borda verde */
        }
        input[type="text"], input[type="submit"] { 
            background-color: black; 
            color: #00ff00;
            border: 1px solid #00ff00;
            padding: 5px;
            font-family: "Courier New", monospace;
        }
        input[type="submit"]:hover { 
            background-color: #003300; /* Efeito hover no botão */
        }
        .cursor { 
            display: inline-block; 
            width: 10px;
            background-color: #00ff00; 
            animation: blink 1s infinite; /* Cursor piscando */
        }
        @keyframes blink { 
            0% { opacity: 1; } 
            50% { opacity: 0; } 
            100% { opacity: 1; } 
        }
    </style>
</head>
<body>
<div class="console">
    <h1>UploadDB</h1> <!-- Título dentro da tela estilo terminal -->

    <p>Digite um comando (list / create): <span class="cursor"></span></p> 
    <!-- Prompt para o usuário digitar comando -->

    <form method="get"> <!-- Formulário para enviar o comando -->
        <input type="text" name="comando" autofocus> <!-- Campo de texto -->
        <input type="submit" value="Executar"> <!-- Botão de enviar -->
    </form>

    <?php
    if (isset($_GET['comando'])) { 
        $cmd = strtolower(trim($_GET['comando'])); // Normaliza o comando
        if ($cmd === "list") { 
            header("Location: list.php"); // Redireciona para lista de arquivos
            exit;
        } elseif ($cmd === "create") { 
            header("Location: upload.php"); // Redireciona para upload de arquivo
            exit;
        } else { 
            echo "<p>Comando inválido. Use <b>list</b> ou <b>create</b>.</p>"; 
            // Mensagem de erro caso o comando não seja reconhecido
        }
    }
    ?>
</div>
</body>
</html>
