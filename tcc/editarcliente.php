<?php
// editarcliente.php
include('conexao.php');
session_start();

// Verifica se o ID do cliente foi passado
if (!isset($_GET['id_cliente'])) {
    die("ID do cliente não fornecido.");
}

$id_cliente = $_GET['id_cliente'];

// Selecionar os dados do cliente
$sql = "SELECT * FROM tb_clientes WHERE id_cliente='$id_cliente'";
$result = $conn->query($sql);
$cliente = $result->fetch_assoc();

if (!$cliente) {
    die("Cliente não encontrado.");
}

// Atualizar dados do cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : $cliente['senha']; // Criptografa a senha se fornecida
    $tipo = $_POST['tipo'];
    $dt_nascimento = $_POST['dt_nascimento'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $telefone = $_POST['telefone'];

    $sql = "UPDATE tb_clientes SET 
                nome='$nome', 
                email='$email', 
                senha='$senha', 
                tipo='$tipo', 
                dt_nascimento='$dt_nascimento', 
                ativo='$ativo', 
                telefone='$telefone' 
            WHERE id_cliente='$id_cliente'";

    if ($conn->query($sql) === TRUE) {
        header("Location: listandoclientes.php"); // Redireciona para a página de listagem de clientes
        exit();
    } else {
        echo "Erro ao atualizar cliente: " . $conn->error;
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
    <title>Editar Cliente</title>
    <style>
        /* Seu CSS fornecido aqui */
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
    </style>
</head>
<body>

<div class="form-container">
    <h2 class="title">Editar Cliente</h2>
    <form method="POST">
        <div class="input-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($cliente['nome']); ?>" required>
        </div>

        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($cliente['email']); ?>" required>
        </div>

        <div class="input-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha">
        </div>

        <div class="input-group">
            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                <option value="admin" <?php echo $cliente['tipo'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="cliente" <?php echo $cliente['tipo'] == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
            </select>
        </div>

        <div class="input-group">
            <label for="dt_nascimento">Data de Nascimento:</label>
            <input type="date" id="dt_nascimento" name="dt_nascimento" value="<?php echo htmlspecialchars($cliente['dt_nascimento']); ?>">
        </div>

        <div class="input-group">
            <label for="ativo">Ativo:</label>
            <input type="checkbox" id="ativo" name="ativo" <?php echo $cliente['ativo'] ? 'checked' : ''; ?>>
        </div>

        <div class="input-group">
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($cliente['telefone']); ?>">
        </div>

        <button type="submit" class="button">Salvar</button>
    </form>
</div>

</body>
</html>
