<?php
// Inclui o arquivo de conexão com o banco de dados
include('conexao.php'); // Ajuste o nome e o caminho conforme necessário

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $tipo = 'cliente'; // Define o tipo como 'cliente' por padrão

    // Verifica se as senhas coincidem
    if ($password !== $password_confirm) {
        $signup_error = "As senhas não coincidem!";
    } else {
        // Verifica se o email já está cadastrado
        $stmt = $conn->prepare("SELECT id_cliente FROM tb_clientes WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $signup_error = "Email já cadastrado!";
        } else {
            // Criptografa a senha
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepara e executa a inserção no banco de dados
            $stmt = $conn->prepare("INSERT INTO tb_clientes (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nome, $email, $hashed_password, $tipo);

            if ($stmt->execute()) {
                $_SESSION['email'] = $email; // Armazena o email na sessão
                header("Location: index.php");
                exit();
            } else {
                $signup_error = "Erro ao criar conta. Tente novamente.";
            }
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="CSS/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
</head>
<body>
    <header>
        <div id="background">
            <img src="Imagens/imglogin.jpg" alt="Cadastro Background">
        </div>
    </header>
    <div class="form-container">
        <p class="title">Cadastro</p>
        <form class="form" method="post" action="cadastro.php">
            <div class="input-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite seu nome" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Digite seu email" required>
            </div>
            <div class="input-group">
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" placeholder="Digite sua senha" required>
            </div>
            <div class="input-group">
                <label for="password_confirm">Confirmar Senha</label>
                <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirme sua senha" required>
            </div>
            <br><br>
            <button class="sign" type="submit">Cadastrar</button>
            <?php if (isset($signup_error)): ?>
                <p class="error"><?php echo htmlspecialchars($signup_error); ?></p>
            <?php endif; ?>
        </form>
        <div class="social-message">
            <div class="line"></div>
            <p class="message">Já tem uma conta? <a href="login.php">Faça login</a></p>
            <div class="line"></div>
        </div>
        <div class="social-icons">
            <button class="icon">
                <i class="fab fa-google"></i>
            </button>
        </div>
    </div>
</body>
</html>
