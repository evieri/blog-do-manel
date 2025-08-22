<div class="d-flex align-items-center justify-content-center">

    <div class="w-25 text-center pt-5 pb-5">

        <div class="users-form">
            <form method="POST" action="/users/add">

                <fieldset>

                    <legend class="fw-bold fs-3 pt-5 pb-4">Increva-se</legend>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" name="data[User][username]" id="UserUsername" required="required" placeholder="" >
                        <label for="UserUsername">Usuário</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" name="data[User][name]" id="UserName" required="required" placeholder="" >
                        <label for="UserName">Nome</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" name="data[User][surname]" id="UserSurname" required="required" placeholder="" >
                        <label for="UserSurname">Sobrenome</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" name="data[User][password]" id="UserPassword" required="required" placeholder="">
                        <label for="floatingPassword">Senha</label>
                    </div>

                    <select class="form-select mb-3" name="data[User][role]" id="UserRole">
                        <option selected>Cargo</option>
                        <option value="admin">Administrador</option>
                        <option value="author">Usuário</option>
                    </select>

                    <button class="w-100 mb-4 mt-3 btn btn-lg rounded-3 btn-primary" type="submit">Adicionar</button>

                </fieldset>

            </form>
        </div>

    </div>

</div>
