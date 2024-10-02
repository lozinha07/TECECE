<?php
// listandoprodutos.php
include('conexao.php');
session_start();

// Selecionar produtos cadastrados
$sql = "SELECT * FROM tb_produtos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Listagem de Produtos</title>
    <style>
        /* Seu CSS fornecido aqui */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            background-color: #000000;
            color: #ffffff;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            z-index: 1000;
        }

        .logo {
            max-width: 100px; /* Ajuste o tamanho da logo */
            height: auto;
            margin-right: auto; /* Move a logo para o canto esquerdo */
        }

        .ul_navmenu {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Centraliza a navegação */
            width: 100%;
        }

        .ul_navmenu li {
            margin: 0 10px;
        }

        .ul_navmenu a {
            color: #ffffff;
            text-decoration: none;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: 400;
            transition: color 0.3s ease;
        }

        .ul_navmenu a:hover {
            color: #7497da;
        }

        h2 {
            margin-top: 100px; /* Espaço para o cabeçalho fixo */
            padding: 0 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            padding: 0 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }


        input[type="text"], input[type="email"], input[type="date"], select {
            width: 100%;
            padding: 5px;
            margin: 0;
            box-sizing: border-box;
        }

        button {
            background-color: #000000;
            color: #ffffff;
            border: none;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #333333;
        }

        h2 {
            text-align: center;
        }
        .product-image {
    width: 150px;
    height: auto; 
    object-fit: cover; 
    border-radius: 8px;
}


.table-product img {
    width: 100px; 
    height: auto; 
}
    </style>
</head>
<body>

<header>
    <img src="Imagens/logoCOLD.jpg" class="logo" alt="Logo">
    <ul class="ul_navmenu">
        <li><a href="index.php" id="home">Home</a></li>
        <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") : ?>
            <li><a href="listandoclientes.php" id="config">Clientes</a></li>
            <li><a href="listandoprodutos.php" id="products">Produtos</a></li>
        <?php endif; ?>
        <li><a href="login.php" id="login">Sair</a></li>
    </ul>
</header>
<br><br><br>
<h2>Produtos Cadastrados</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Preço</th>
        <th>Imagem</th>
        <th>Ações</th>
    </tr>
    <?php
    // Supondo que você já tenha o resultado dos produtos
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id_produto"] . "</td>
                    <td>" . $row["nome"] . "</td>
                    <td>" . $row["categoria"] . "</td>
                    <td>" . $row["preco"] . "</td>
                    <td><img src='Imagens/" . $row["imagem"] . "' class='product-image' alt='" . $row["nome"] . "'></td>
                    <td><a href='editarproduto.php?id_produto=" . $row["id_produto"] . "'><button>Editar</button></a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Nenhum produto encontrado</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
