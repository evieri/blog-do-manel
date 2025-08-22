<?= $this->Flash->render(); ?>

<div class="container d-flex align-items-center justify-content-center">

    <div class="col-lg-8 px-5">

        <?= $this->Form->create('User'); ?>

        <fieldset>

            <legend class="fw-bold fs-3 py-3 mt-5">Editar usuário</legend>

            <?php
                $options = [
                    'required' => false,
                    'div' => false,
                    'class' => 'form-control',
                    'label' => false
                ];

                $selectOptions = [
                    'required' => false,
                    'div' => false,
                    'class' => 'form-select',
                    'type' => 'select',
                    'label' => false,
                    'options' => ['author' => 'Autor', 'admin' => 'Administrador']
                ]
            ?>

            <div class="row">
                <div class="col">
                    <label for="UserName" class="fw-semibold">Nome</label>
                    <div class="input-group mb-3 mt-2">
                        <span class="input-group-text bg-body border-end-0">@</span>
                        <?= $this->Form->input('name', $options) ?>
                    </div>
                </div>
                <div class="col">
                    <label for="UserSurname" class="fw-semibold">Sobrenome</label>
                    <div class="input-group mb-3 mt-2">
                        <span class="input-group-text bg-body border-end-0">@</span>
                        <?= $this->Form->input('surname', $options) ?>
                    </div>
                </div>
            </div>

            <label for="UserUsername">E-mail</label>
            <div class="input-group mb-3 mt-2">
                <span class="input-group-text bg-body border-end-0"><i class="ri-mail-line"></i></span>
                <?= $this->Form->input('username', $options) ?>
            </div>

            <!-- Somente o adm poderá alterar o cargo de alguém -->
            <?php if (
                $this->Session->read('Auth.User.role') === 'admin' &&
                $this->Session->read('Auth.User.id') !== $this->request->data['User']['id']
            ): ?>
                <label for="UserRole">Cargo</label>
                <div class="input-group mb-3 mt-2">
                    <span class="input-group-text bg-body border-end-0"><i class="ri-user-settings-line"></i></span>
                    <?= $this->Form->input('User.role', $selectOptions) ?>
                </div>
            <?php endif; ?>

            <label for="UserPassword">Senha</label>
            <div class="input-group mb-4 mt-2">
                <span class="input-group-text bg-body border-end-0"><i class="ri-lock-password-line"></i></span>
                <input type="password" class="form-control" name="data[User][password]" id="UserPassword" placeholder="******">
            </div>

            <hr>

            <?= $this->Form->hidden('id'); ?>

            <div class="d-flex justify-content-between my-4">
                <a href="javascript:history.back()" class="btn btn-outline-secondary" type="submit">Voltar</a>
                <button class="btn btn-info" type="submit">Alterar</button>
            </div>

        </fieldset>

    </div>

</div>
