<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Blog do Manel</title>

    <!--=============== BOOTSTRAP ===============-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">

    <?php echo $this->Html->css('style.css'); ?>
    <?php echo $this->fetch('css'); ?>

    <!--=============== JQUERY UI ===============-->
    <?= $this->Html->script('jquery-3.7.1.min.js') ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

    <script>
        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';

            // Altera o tema da página e armazena no localStorage
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            // Seleciona o ícone pelo id
            const icon = document.getElementById('themeIcon');

            // Verifica a classe atual e altera para a classe oposta
            if (icon.classList.contains('ri-moon-clear-fill')) {
                icon.classList.remove('ri-moon-clear-fill');
                icon.classList.add('ri-sun-fill');
            } else {
                icon.classList.remove('ri-sun-fill');
                icon.classList.add('ri-moon-clear-fill');
            }
        }

        // Função para verificar o tema salvo no localStorage e aplicá-lo ao carregar a página
        function setInitialTheme() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-bs-theme', savedTheme);
            }
        }

        // Chamar a função para definir o tema inicial
        setInitialTheme();
    </script>

</head>
<body class="min-vh-100 d-flex flex-column">
<!--<body style="font-family: Syne, sans-serif;">-->

<!--==================== HEADER ====================-->
<header class="header sticky-top">
    <nav class="navbar navbar-expand-sm bg-dark">

        <!-- Logo -->
        <div class="container fs-5">
            <a href="/" id="logo" class="navbar brand fw-bold text-decoration-none gap-2">Blog <i class="ri-code-s-slash-fill"></i></a>

            <button class="rounded-pill btn btn-dark" onclick="toggleTheme()"><i id="themeIcon" class="ri-moon-clear-fill"></i></button>

            <div class="navbar-nav">
                <!-- Login -->

                <?php if ($this->Session->check('Auth.User.name')): ?>

                    <div class="dropdown">

                        <a class="btn btn-dark border-secondary rounded-pill d-flex flex-row align-items-center gap-2" data-bs-toggle="dropdown">
                            <img src="https://cdn-icons-png.flaticon.com/512/6997/6997674.png" width="24" height="24" class="rounded-circle flex-shrink-0">
                            <?= h($this->Session->read('Auth.User.name')) ?>
                            <i class="ri-arrow-down-s-line"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/users/edit/<?= $this->Session->read('Auth.User.id') ?>">Perfil</a></li>
                            <?php if ($this->Session->read('Auth.User.role') === 'admin'): ?>
                                <li><a class="dropdown-item" href="/users">Usuários</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger fw-bold" href="/users/logout">Sair</a></li>
                        </ul>

                    </div>


                <?php else: ?>

                    <a href="/users/login" class="btn btn-secondary rounded-pill d-flex flex-row align-items-center text-white fw-bold">Login</a>

                <?php endif; ?>
                <!-- Sanduíche -->
                <!--			<div class="nav__toggle" id="nav-toggle">-->
                <!--				<i class="ri-menu-line"></i>-->
                <!--			</div>-->
            </div>
        </div>

    </nav>
</header>

<!--==================== MAIN ====================-->
<main class="bg-body-tertiary flex-fill">
    <?= $this->Flash->render(); ?>
    <?= $this->fetch('content'); ?>
</main>

<footer class="p-5 bg-dark text-light">

    <div class="container">
        <div class="row">
            <!-- Sobre -->
            <div class="col-md-4 mb-3">
                <h5>Sobre o Blog</h5>
                <p>Bem-vindo ao nosso blog, onde você encontrará artigos inspiradores, tutoriais úteis e notícias interessantes sobre uma variedade de tópicos.</p>
            </div>

            <!-- Links Rápidos -->
            <div class="col-md-4 mb-3">
                <h5>Links Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="text-light text-decoration-none">Página Inicial</a></li>
                    <li><a href="/about" class="text-light text-decoration-none">Sobre Nós</a></li>
                    <li><a href="/contact" class="text-light text-decoration-none">Contato</a></li>
                    <li><a href="/posts" class="text-light text-decoration-none">Posts</a></li>
                </ul>
            </div>

            <!-- Redes Sociais -->
            <div class="col-md-4 mb-3">
                <h5>Siga-nos</h5>
                <div>
                    <a href="https://github.com/evieri" class="text-light me-2"><i class="ri-github-fill"></i></a>
                    <a href="#" class="text-light me-2"><i class="ri-instagram-fill"></i></a>
                    <a href="#" class="text-light me-2"><i class="ri-twitter-fill"></i></a>
                    <a href="https://www.linkedin.com/in/emmanuel-vieri-b1878b189/" class="text-light"><i class="ri-linkedin-fill"></i></a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col text-center">
                <p class="small mb-0">&copy; 2024 Blog do Manel. Todos os direitos reservados.</p>
            </div>
        </div>
    </div>

</footer>

<?php
    echo $this->Html->script('main.js');
    echo $this->Html->script('datepicker-pt-BR.js');
    echo $this->fetch('script');
?>

</body>
</html>
