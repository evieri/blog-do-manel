<?php

$first = $this->Paginator->first('«', ['class' => 'page-link']);
$last = $this->Paginator->last('»', ['class' => 'page-link']);
$counter = $this->Paginator->numbers(['class' => 'page-link', 'separator' => '<li class="page-item">', 'currentClass' => 'active']);
$prev = $this->Paginator->prev('«', ['class' => 'page-link'], '«', ['tag' => 'a', 'class' => 'page-link disabled']);
$next = $this->Paginator->next('»', ['class' => 'page-link'], '»', ['tag' => 'a', 'class' => 'page-link disabled']);

?>

<header style="background: url('https://images.unsplash.com/photo-1618397746666-63405ce5d015?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center; background-size: cover" class="py-5 border-bottom mb-4 bg-body-secondary">
    <div class="container">
        <div class="text-center my-5 text-dark">
            <h1 class="fw-bolder">Bem vindo ao Blog do Manel</h1>
            <p class="lead mb-0">O melhor lugar para aprender Machine Learning de forma totalmente gratuita</p>
        </div>
    </div>
</header>

<div class="row mt-4 container mx-auto flex-column-reverse flex-lg-row" id="main">
    <div class="col-xl-8 col-lg-8">

        <!--==================== POSTS ====================-->

        <div class="row row-cols-1 row-cols-xl-2 row-cols-lg-2 g-4">

            <?php foreach ($posts as $post):?>

                <?php
                $isInactive = ($post['Post']['status'] == 0);
                ?>

                <div class="col mb-1" >

                    <div class="card-posts  <?= $isInactive ? 'inactive-post' : ''; ?>">

                        <div class="card border-0 h-100">

                            <img style="max-height: 250px" src="https://images.unsplash.com/photo-1621839673705-6617adf9e890?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top object-fit-cover" alt="...">

                            <div class="card-body">

                                <h5 class="card-title"><?= strip_tags($post['Post']['title']); ?></h5>

                                <div class="card-subtitle my-2 text-body-secondary d-flex justify-content-between">

                                    <h6>Por: <?= $post['User']['name']; ?></h6>

                                    <h6><i class="ri-time-line"></i> <?= $this->Time->format('d/m/Y', $post['Post']['created']) ?></h6>

                                </div>

                                <p class="card-text">

                                    <?= substr(strip_tags($post['Post']['body']), 0, 80) . '...'; ?>

                                </p>

                                <a class="stretched-link icon-link icon-link-hover text-decoration-none" href="/posts/view/<?= $post['Post']['id'] ?>">
                                    Ler mais
                                    <svg class="bi" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"></path></svg>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <hr class="w-100">

        <!--==================== PAGINATOR ====================-->

        <?php if ($this->Paginator->numbers(array('first' => false, 'last' => false))): ?>
            <nav class="mx-auto d-flex justify-content-center my-3">
                <ul class="pagination">
                    <li class="page-item"><?= $prev ?></li>
                    <li class="page-item"><?= $counter ?></li>
                    <li class="page-item"><?= $next ?></li>
                </ul>
            </nav>
        <?php endif; ?>


    </div>

    <div class="col mb-4">

        <!--==================== PESQUISA ====================-->
        <div class="mb-4 bg-body-tertiary" style="position: sticky; top: 5rem; z-index: 10">

            <?= $this->Form->create('Post'); ?>

            <div class="input-group">
                <input type="text"
                       class="form-control form-control-lg rounded-start-pill border-secondary border-end-0"
                       id="PostTitle"
                       name="data[Post][title]"
                       placeholder="Pesquisar..."
                       value="<?= isset($this->request->data['Post']['title']) ? h($this->request->data['Post']['title']) : ''; ?>">

                <button type="button" class="btn btn-lg btn-outline-secondary dropdown-toggle rounded-end-pill" data-bs-toggle="collapse" data-bs-target="#collapse"></button>
            </div>

            <!--=== Filtro de data ===-->
            <div class="collapse show" id="collapse" >
                <div class="input-group mt-3">
                    <input name="data[Post][start_date]"
                           class="date-picker form-control rounded-start-pill"
                           placeholder="Data Inicial"
                           type="text"
                           id="dataInicial"
                           style="z-index: 11"
                           value="<?= isset($this->request->data['Post']['start_date']) ? h($this->request->data['Post']['start_date']) : ''; ?>">

                    <input name="data[Post][end_date]"
                           class="date-picker form-control"
                           placeholder="Data Final"
                           type="text"
                           id="dataFinal"
                           style="z-index: 11"
                           value="<?= isset($this->request->data['Post']['end_date']) ? h($this->request->data['Post']['end_date']) : ''; ?>">

                    <span class="input-group-text rounded-end-pill"><i class="ri-calendar-line"></i></span>
                </div>

                <!--=== Ativo/Inativo ===-->
                <div class="input-group mt-3">
                    <select name="data[Post][status]" class="form-select rounded-start-pill">
                        <option value="">Status...</option>
                        <option value="1" <?= (isset($this->request->data['Post']['status']) && $this->request->data['Post']['status'] === '1') ? 'selected' : ''; ?>>Ativo</option>
                        <option value="0" <?= (isset($this->request->data['Post']['status']) && $this->request->data['Post']['status'] === '0') ? 'selected' : ''; ?>>Inativo</option>
                    </select>
                    <span class="input-group-text rounded-end-pill"><i class="ri-checkbox-line"></i></span>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-info btn-lg rounded-pill"><i class="ri-search-line"></i> Buscar</button>
                <?= $this->Form->end(); ?>
            </div>
        </div>
        <hr>

        <!--==================== CATEGORIAS ====================-->
        <div class="mx-4">

            <div class="d-grid gap-2">
<!--                <a class="btn btn-lg btn-outline-secondary text-body-secondary border-0 text-start rounded-pill d-flex align-items-center" data-bs-toggle="collapse" href="#categorias">-->
<!--                    <i class="ri-list-check fs-4 me-2"></i><span class="fs-5"> Categorias <i class="ri-arrow-drop-down-line"></i></span>-->
<!--                </a>-->
<!---->
<!--                <div class="collapse ms-4 fs-6" id="categorias">-->
<!--                    <div class="row">-->
<!--                        <div class="col-sm-6">-->
<!--                            <ul>-->
<!--                                --><?php //foreach ($categories as $category): ?>
<!--                                    <li>--><?php //= $this->Html->link($category['Category']['name'], ['controller' => 'posts', 'action' => 'category', $category['Category']['id']], ['class' => 'text-decoration-none text-body']) ?><!--</li>-->
<!--                                --><?php //endforeach; ?>
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

                <?php if ($this->Session->read('Auth.User.role') === 'admin'): ?>
                <a href="/users" class="btn btn-lg btn-outline-secondary text-body-secondary border-0 text-start rounded-pill">
                    <i class="ri-group-line fs-4 me-2"></i>Usuários
                </a>
                <?php endif; ?>

                <!--==================== ADICIONAR POST ====================-->
                <a href="/posts/add" class="btn btn-lg btn-outline-secondary text-body-secondary border-0 text-start rounded-pill">
                    <i class="ri-edit-box-line fs-4 me-2"></i>Postar
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    $(function() {
        $.datepicker.setDefaults($.datepicker.regional[ "pt-BR" ]);
        $("#dataInicial, #dataFinal").datepicker({
            dateFormat: "dd/mm/yy"
        });
    });
</script>
