<?php
// editarproduto.php
include('conexao.php');
session_start();

// Verifica se o ID do produto foi passado
if (!isset($_GET['id_produto'])) {
    die("ID do produto não fornecido.");
}

$id_produto = $_GET['id_produto'];

// Selecionar os dados do produto
$sql = "SELECT * FROM tb_produtos WHERE id_produto='$id_produto'";
$result = $conn->query($sql);
$produto = $result->fetch_assoc();

if (!$produto) {
    die("Produto não encontrado.");
}

// Atualizar dados do produto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $categoria = $_POST['categoria'];
    $preco = $_POST['preco'];
    $imagem = $_FILES['imagem']['name'];
    
    if ($imagem) {
        $imagemTemp = $_FILES['imagem']['tmp_name'];
        $imagemDestino = 'Imagens/' . $imagem;
        move_uploaded_file($imagemTemp, $imagemDestino);
        
        $sql = "UPDATE tb_produtos SET 
                    nome='$nome', 
                    categoria='$categoria', 
                    preco='$preco', 
                    imagem='$imagem' 
                WHERE id_produto='$id_produto'";
    } else {
        $sql = "UPDATE tb_produtos SET 
                    nome='$nome', 
                    categoria='$categoria', 
                    preco='$preco' 
                WHERE id_produto='$id_produto'";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: listandoprodutos.php"); // Redireciona para a página de listagem de produtos
        exit();
    } else {
        echo "Erro ao atualizar produto: " . $conn->error;
    }
}

// Fechar conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Editar Produto</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #000000; /* Fundo preto */
            color: rgba(243, 244, 246, 1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            width: 320px;
            border-radius: 0.75rem;
            background-color: #1e2028;
            padding: 2rem;
        }

        .title {
            text-align: center;
            font-size: 1.5rem;
            line-height: 2rem;
            font-weight: 700;
        }

        .input-group {
            margin-top: 0.25rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .input-group label {
            display: block;
            color: rgba(156, 163, 175, 1);
            margin-bottom: 4px;
        }

        .input-group input, .input-group select {
            width: 90%;
            border-radius: 0.375rem;
            border: 1px solid rgba(55, 65, 81, 1);
            outline: 0;
            background-color: #1e2028;
            padding: 0.75rem 1rem;
            color: rgba(243, 244, 246, 1);
            font-size: 0.875rem;
        }

        .input-group input:focus, .input-group select:focus {
            border-color: rgba(229, 231, 235, 1);
        }

        .button {
            margin-top: 1.5rem;
            width: 100%;
            background-color: #0d6efd;
            color: rgba(243, 244, 246, 1);
            border: none;
            padding: 0.75rem 1.25rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0a58ca;
        }

        .input-group img {
            max-width: 100%;
            height: auto;
            margin: 10px 0;
            border-radius: 30px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2 class="title">Editar Produto</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="input-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
        </div>

        <div class="input-group">
            <label for="categoria">Categoria:</label>
            <input type="text" id="categoria" name="categoria" value="<?php echo htmlspecialchars($produto['categoria']); ?>" required>
        </div>

        <div class="input-group">
            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" value="<?php echo htmlspecialchars($produto['preco']); ?>" step="0.01" required>
        </div>

        <div class="input-group">
            <label for="imagem">Imagem:</label>
            <?php if ($produto['imagem']): ?>
                <img src="Imagens/<?php echo htmlspecialchars($produto['imagem']); ?>" alt="Imagem do Produto">
            <?php endif; ?>
            <input type="file" id="imagem" name="imagem">
        </div>

        <button type="submit" class="button">Salvar</button>
    </form>
</div>

</body>
</html>
