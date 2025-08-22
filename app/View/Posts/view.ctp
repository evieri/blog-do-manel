<!-- Mensagem flash será renderizada aqui -->
<?php echo $this->Session->flash(); ?>

<div class=" container mb-5 overflow-hidden rounded" style="height: 25rem; background: url(https://images.unsplash.com/photo-1621839673705-6617adf9e890?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D) no-repeat center center;"></div>

<div class="container row mx-auto">

    <div class="col-md-8">

        <article class="mx-3">

            <div class="d-flex justify-content-between align-items-center">

                <h2 class="display-5 fw-bold link-body-emphasis mb-1"><?= h($view['Post']['title']); ?></h2>

                <div class="d-flex flex-direction-row ms-3">

                    <a href="javascript:history.back()" class="btn btn-outline-secondary me-3 rounded-pill"><i class="ri-arrow-go-back-line fs-4"></i></a>

                    <?php if ($this->Session->read('Auth.User.role') === 'admin' || $this->Session->read('Auth.User.id') == $view['Post']['user_id']): ?>
                        <div class="dropdown">

                            <button class="btn btn-outline-secondary me-3 rounded-pill dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-settings-4-line fs-4"></i>
                            </button>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <?= $this->Form->postLink(
                                        '<i class="ri-edit-fill"></i> Editar',
                                        '/posts/edit/' . $view['Post']['id'],
                                        ['class' => 'dropdown-item', 'escape' => false]
                                    ); ?>
                                </li>
                                <li>
                                    <?= $this->Form->postLink(
                                        '<i class="ri-delete-bin-line"></i> Apagar',
                                        '/posts/delete/' . $view['Post']['id'],
                                        [
                                            'class' => 'dropdown-item',
                                            'escape' => false, // Permite ícones HTML dentro do link
                                            'confirm' => 'Tem certeza que deseja apagar este post?'
                                        ]
                                    ); ?>
                                </li>

                                <?php if (($this->Session->read('Auth.User.id') == $view['Post']['user_id'] || $this->Session->read('Auth.User.role') === 'admin') && $view['Post']['status']): ?>
                                    <li>
                                        <?= $this->Form->postLink(
                                            '<i class="ri-close-circle-line"></i> Desativar',
                                            '/posts/edit/' . $view['Post']['id'],
                                            ['class' => 'dropdown-item', 'escape' => false]
                                        ); ?>
                                    </li>
                                <?php elseif (($this->Session->read('Auth.User.id') == $view['Post']['user_id'] || $this->Session->read('Auth.User.role') === 'admin') && !$view['Post']['status']): ?>
                                    <li>
                                        <?= $this->Form->postLink(
                                            '<i class="ri-checkbox-line"></i> Reativar',
                                            '/posts/edit/' . $view['Post']['id'],
                                            ['class' => 'dropdown-item', 'escape' => false]
                                        ); ?>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

            <p class="text-secondary mb-4"><?= $this->Time->format('d M Y', $view['Post']['created']) . ', por ' . $view['User']['name'] . ' ' . $view['User']['surname']; ?></p>

            <hr class="my-4">

            <p><?= $view['Post']['body']; ?></p>

        </article>

        <hr class="mx-3">

    </div>

    <div class="col-md-4">

        <h2>Recentes:</h2>

        <hr class="mb-4">

        <?php $c=0; foreach ($posts as $post): $c++;?>

            <div class="col mb-4 mx-3" >

                <div class="card-posts">

                    <div class="card border-0 h-100">

                        <img style="max-height: 250px" src="https://images.unsplash.com/photo-1621839673705-6617adf9e890?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top object-fit-cover" alt="...">

                        <div class="card-body">

                            <h5 class="card-title"><?= h($post['Post']['title']); ?></h5>

                            <div class="card-subtitle my-2 text-body-secondary d-flex justify-content-between">

                                <h6>Por: <?= h($post['User']['name']); ?></h6>

                                <h6><i class="ri-time-line"></i> <?= $this->Time->format('d/m/Y', $post['Post']['created']) ?></h6>

                            </div>

                            <p class="card-text">

                                <?= substr($post['Post']['body'], 0, 80) . '...'; ?>

                            </p>

                            <a class="stretched-link icon-link icon-link-hover" href="/posts/view/<?= $post['Post']['id'] ?>">
                                Ler mais
                                <svg class="bi" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"></path></svg>
                            </a>

                        </div>
                    </div>
                </div>
            </div>

            <?php
            if ($c >= 4) {
                break;
            }
            ?>

        <?php endforeach; ?>

    </div>

</div>