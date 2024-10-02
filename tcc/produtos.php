<?php
// produtos.php
include('conexao.php');
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="CSS/produtos.css">
</head>
<body>
    <div class="container">
        <?php
        // Consulta para obter os produtos da tabela `tb_produtos`
        $query = "SELECT nome, imagem, preco FROM tb_produtos";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="card">
                    <img src="Imagens/<?php echo htmlspecialchars($row['imagem']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>">
                    <h2><?php echo htmlspecialchars($row['nome']); ?></h2>
                    <p>Preço: R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
                </div>
                <?php
            }
        } else {
            echo "<p>Nenhum produto encontrado.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
