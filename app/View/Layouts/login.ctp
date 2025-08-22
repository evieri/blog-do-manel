<!doctype html>
<html lang="pt-br" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!--=============== BOOTSTRAP ===============-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">

    <!--=============== JQUERY UI ===============-->
    <?= $this->Html->script('jquery-3.7.1.min.js') ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

    <?php echo $this->Html->css('style.css'); ?>
    <?php echo $this->fetch('css'); ?>

    <title>Login</title>

    <script>

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
<body>

<?= $this->Flash->render(); ?>

<?php
$this->Js->buffer('$(".message error").addClass("alert alert-danger");');
?>

<div class="users form visually-hidden">
    <?php echo $this->Flash->render('auth'); ?>
    <?php echo $this->Form->create('User'); ?>
</div>

<div class="vh-100 d-flex align-items-center justify-content-center">

    <div class="col-8 col-lg-3 text-center">

        <div class="users-form">
            <form method="POST" action="/users/add">

                <fieldset>

                    <legend class="fw-bold fs-3 pb-4">Login</legend>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" name="data[User][username]" id="UserUsername" required="required" placeholder="" >
                        <label for="UserUsername">Usuário</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" name="data[User][password]" id="UserPassword" required="required" placeholder="">
                        <label for="floatingPassword">Senha</label>
                    </div>

                    <small class="text-body-secondary">Não tem uma conta? <a href="/users/add">Inscreva-se.</a></small>

                    <button class="w-100 mb-4 mt-3 btn btn-lg rounded-3 btn-primary" type="submit">Entrar</button>

                </fieldset>

            </form>
        </div>

    </div>

</div>

<?php
$this->Js->buffer('$(".error").addClass("alert alert-danger alert-dismissible fade show container mt-4 position-absolute start-50 translate-middle-x").attr("role", "alert").prepend(\'<i class="ri-alert-fill"> </i>\').append(\'<button type="button" class="btn-close" data-bs-dismiss="alert"></button>\');');
echo $this->Js->writeBuffer();
?>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
