<!doctype html>
<html lang="pt-br" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!--=============== BOOTSTRAP ===============-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


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

<main class="container d-flex flex-column flex-md-row align-items-center justify-content-center vh-100">

    <div class="col-md-4 border-end text-end px-5 vh-100 d-flex justify-content-center flex-column" id="add-user-card">
        <h1 style="font-size: 3.5rem" class="text-info fw-bold">Criar conta</h1>
        <h6 class="fw-light">Estamos muito felizes em recebê-lo!</h6>
    </div>

    <div class="col-md-8 px-5">

        <form method="POST" action="/users/add">

            <fieldset>

                <legend class="fw-bold fs-3 pb-3">Inscrever-se</legend>

                <div class="row">
                    <div class="col">
                        <label for="UserName" class="fw-semibold">Nome</label>
                        <div class="input-group mb-3 mt-2">
                            <span class="input-group-text bg-transparent border-end-0">@</span>
                            <input type="text" class="form-control" name="data[User][name]" id="UserName" placeholder="Digite seu primeiro nome">
                        </div>
                    </div>
                    <div class="col">
                        <label for="UserSurname" class="fw-semibold">Sobrenome</label>
                        <div class="input-group mb-3 mt-2">
                            <span class="input-group-text bg-transparent border-end-0">@</span>
                            <input type="text" class="form-control" name="data[User][surname]" id="UserSurname" placeholder="Digite seu sobrenome">
                        </div>
                    </div>
                </div>

                <label for="UserUsername">E-mail</label>
                <div class="input-group mb-3 mt-2">
                    <span class="input-group-text bg-transparent border-end-0"><i class="ri-mail-line"></i></span>
                    <input type="text" class="form-control" name="data[User][username]" id="UserUsername" placeholder="Digite seu endereço de e-mail">
                </div>

                <?php if ($this->Session->read('Auth.User.role') === 'admin'): ?>
                    <label for="UserRole">Cargo</label>
                    <div class="input-group mb-3 mt-2">
                        <span class="input-group-text bg-transparent border-end-0"><i class="ri-user-settings-line"></i></span>
                        <select class="form-select" name="data[User][role]" id="UserRole">
                            <option value="admin">Administrador</option>
                            <option selected value="author">Usuário</option>
                        </select>
                    </div>
                <?php endif; ?>

                <label for="UserPassword">Senha</label>
                <div class="input-group mb-4 mt-2">
                    <span class="input-group-text bg-transparent border-end-0"><i class="ri-lock-password-line"></i></span>
                    <input type="password" class="form-control" name="data[User][password]" id="UserPassword" placeholder="Escolha sua senha">
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <a href="javascript:history.back()" class="btn btn-secondary" type="submit">Voltar</a>
                    <button class="btn btn-info" type="submit">Criar</button>
                </div>

                <hr>

            </fieldset>

        </form>

    </div>

</main>

</body>

</html>
