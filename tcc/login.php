<?php
// Inclui o arquivo de conexão com o banco de dados
include('conexao.php'); // Ajuste o nome e o caminho conforme necessário

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe o email e senha do formulário
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepara e executa a consulta
    $stmt = $conn->prepare("SELECT senha, tipo FROM tb_clientes WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $user_type);
        $stmt->fetch();

        // Verifica a senha
        if (password_verify($password, $hashed_password)) {
            $_SESSION['email'] = $email; // Armazena o email na sessão
            $_SESSION['tipo'] = $user_type; // Armazena o tipo de usuário na sessão
            header("Location: index.php");
            exit();
        } else {
            $login_error = "Senha incorreta!";
        }
    } else {
        $login_error = "Usuário não encontrado!";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
</head>
<body>
    <header>
        <div id="background">
            <img src="Imagens/imglogin.jpg" alt="Login Background">
        </div>
    </header>
    <div class="form-container">
        <p class="title">Login</p>
        <form class="form" method="post" action="login.php">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Digite seu email" required>
            </div>
            <div class="input-group">
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" placeholder="Digite sua senha" required>
                <div class="forgot">
                    <a href="#" rel="noopener noreferrer">Esqueceu a senha?</a>
                </div>
            </div>
            <button class="sign" type="submit">Entrar</button>
            <?php if (isset($login_error)): ?>
                <p class="error"><?php echo htmlspecialchars($login_error); ?></p>
            <?php endif; ?>
        </form>
        <div class="social-message">
            <div class="line"></div>
            <p class="message">Faça login com sua conta social</p>
            <div class="line"></div>
        </div>
        <div class="social-icons">
            <button class="icon">
                <i class="fab fa-google"></i>
            </button>
        </div>
        <p class="signup">Você não tem uma conta? <a href="cadastro.php" class="">Crie já</a></p>
    </div>
</body>
</html>
