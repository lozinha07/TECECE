<?php
// index.php
include('conexao.php');
session_start();

echo '<pre>';
var_dump($_SESSION);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COLD</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <style>
        header.hidden {
            transform: translateY(-100%); /* Move o cabeçalho para fora da tela */
            transition: transform 0.3s ease; /* Transição suave */
        }
    </style>
</head>
<body>
    <header>
        <img src="Imagens/logoCOLD.jpg" id="logoCOLD" alt="Logo COLD">
        <div class="main-text">
            <h5>ROUPAS PRA QUEM DITA COM ESTILO</h5>
            <h1>Conheça as roupas que falam a língua da rua!</h1>
            <ul class="ul_navmenu" id="nav-menu" style="display: flex;">
                <li class="navmenu"><a href="index.php" id="home">Home</a></li>
                <li class="navmenu"><a href="produtos.php" id="products">Produtos</a></li>
                <li class="navmenu"><a href="#" id="contact">Contato</a></li>
                <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin") : ?>
                    <li class="navmenu"><a href="listandoclientes.php" id="config">Listagem</a></li>
                <?php endif; ?>
                <li class="navmenu"><a href="logout.php" id="login">Sair</a></li>
            </ul>
        </div>
        <nav>
            <div class="nav-icon">
                <a href="#" id="menu-icon"><i class='bx bx-search'></i></a>
                <a href="#"><i class='bx bx-cart'></i></a>
                <a href="#"><i class='bx bx-user'></i></a>
            </div>
        </nav>
    </header>

    <section class="main-home">
        <!-- Conteúdo da seção principal -->
    </section>

    <div id="background">
        <video class="main_video" loop autoplay muted>
            <source src="streetwear.mp4" type="video/mp4">
        </video>
    </div>

    <section class="trending-products">
        <div class="center-text">
            <!-- Texto central ou título da seção -->
        </div>
        <div class="products">
            <div class="destaques">
                <img src="Imagens/(destaques)layout.png" alt="Destaques Layout">
            </div>
            <div class="destaques row">
                <img src="Imagens/Hocks bold doce(rosa).jpg" alt="Hocks Bold Doce Rosa">
                <img src="Imagens/freedayhero(preto).jpg" alt="Freeday Hero Preto">
                <img src="Imagens/vans.jpg" alt="Vans">
            </div>
        </div>
    </section>

    <script src="java.js"></script>
    <script>
        let lastScrollTop = 0;
        const header = document.querySelector('header');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Rolando para baixo
                header.classList.add('hidden');
            } else {
                // Rolando para cima
                header.classList.remove ('hidden');
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // Para evitar valores negativos
        });

    </script>
</body>
</html>
