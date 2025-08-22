<?php

$this->Paginator->options(['update' => '#content']);

$first = $this->Paginator->first('«', ['class' => 'page-link']);
$last = $this->Paginator->last('»', ['class' => 'page-link']);
$counter = $this->Paginator->numbers(['class' => 'page-link', 'separator' => '<li class="page-item">', 'currentClass' => 'active']);
$prev = $this->Paginator->prev('«', ['class' => 'page-link'], '«', ['tag' => 'a', 'class' => 'page-link disabled']);
$next = $this->Paginator->next('»', ['class' => 'page-link'], '»', ['tag' => 'a', 'class' => 'page-link disabled']);

?>

<div class="container pt-4">

    <div class="d-flex align-items-center p-3 my-3 rounded bg-body-secondary text-dark" style="background: url('https://images.unsplash.com/photo-1618397746666-63405ce5d015?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center">
        <i class="ri-group-line fs-3 mx-3"></i>
        <div class="lh-1">
            <h1 class="h6 mb-0 lh-1 fs-4">Usuários</h1>
        </div>
    </div>

    <div class="d-md-flex gap-4 justify-content-between mt-4">

        <div>

            <?= $this->Form->create('User'); ?>

            <div class="d-md-flex gap-4" style="max-width: 722px;">

                <div class="input-group">
                    <input type="text"
                           class="form-control form-control-lg rounded-start-pill border-secondary border-end-0"
                           id="PostTitle"
                           name="data[User][name]"
                           placeholder="Pesquisar..."
                           value="<?= isset($this->request->data['User']['name']) ? h($this->request->data['User']['name']) : ''; ?>">

                    <button type="button" class="btn btn-lg btn-outline-secondary dropdown-toggle dropdown-toggle-split rounded-0 border-end-0" data-bs-toggle="collapse" data-bs-target="#collapse"></button>
                    <button type="submit" class="btn btn-lg btn-outline-secondary rounded-end-pill"><i class="ri-search-line"></i></button>
                </div>

                <div class="collapse" id="collapse">
                    <div class="input-group mt-4 mt-md-0">
                        <input name="data[User][start_date]"
                               class="date-picker form-control form-control-lg rounded-start-pill"
                               placeholder="Data Inicial"
                               type="text"
                               id="dataInicial"
                               style="z-index: 11"
                               value="<?= isset($this->request->data['User']['start_date']) ? h($this->request->data['User']['start_date']) : ''; ?>">

                        <input name="data[User][end_date]"
                               class="date-picker form-control form-control-lg"
                               placeholder="Data Final"
                               type="text"
                               id="dataFinal"
                               style="z-index: 11"
                               value="<?= isset($this->request->data['User']['end_date']) ? h($this->request->data['User']['end_date']) : ''; ?>">

                        <span class="input-group-text rounded-end-pill"><i class="ri-calendar-line"></i></span>
                    </div>
                </div>
            </div>

            <?= $this->Form->end(); ?>

        </div>

        <a style="max-height: 50px" href="/users/add" class="btn btn-large btn-info d-flex align-items-center mt-4 mt-md-0 justify-content-center rounded-pill flex-shrink-0"> <span class="ms-2">Novo </span><i class="ri-user-add-line mx-2"></i></a>

    </div>

    <div class="row my-4">
        <div class="col-md">

            <!--==================== USUÁRIOS ====================-->

            <div class="p-3 bg-body rounded border overflow-auto">
                <table class="table table-hover">

                    <thead>
                    <tr class="border-dark-subtle">
                        <th scope="col">Nome</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Data de criação</th>
                        <th scope="col">Ações</th>
<!--                        <th scope="col">Ativo</th>-->
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="align-middle border-dark-subtle">

                            <td>
                                <div class="list-group-item list-group-item-action d-flex gap-3 py-3">
                                    <img src="https://cdn-icons-png.flaticon.com/512/6997/6997674.png" width="36" height="36" class="rounded-circle flex-shrink-0">
                                    <div>
                                        <h6 class="mb-0"><?= $user['User']['name'] . ' ' . $user['User']['surname']?></h6>
                                        <p class="mb-0 opacity-75"><?= $user['User']['username'] ?></p>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center h-100"><?= $roles[$user['User']['role']] ?></div>
                            </td>

                            <td>
                                <?= $this->Time->format('d/m/Y', $user['User']['created']) ?>
                            </td>

                            <td>
                                <?php if (!($user['User']['role'] === 'admin')): ?>
                                    <a href="/users/edit/<?= $user['User']['id'] ?>" class="btn" data-bs-toggle="tooltip" data-bs-title="Editar"><i class="ri-edit-line fs-5"></i></a>

                                    <?= $this->Form->postLink(
                                        '<i class="ri-user-unfollow-line fs-5"></i>',
                                        ['controller' => 'Users', 'action' => 'delete', $user['User']['id']],
                                        ['confirm' => 'Você tem certeza que deseja apagar este usuário?', 'escape' => false, 'class' => 'btn', 'data-bs-toggle' => 'tooltip', 'data-bs-title' => 'Apagar']
                                    ) ?>
                                <?php endif; ?>
                            </td>

<!--                            <td>-->
<!--                                <div class="form-switch"><input class="form-check-input" type="checkbox" value="" checked disabled></div>-->
<!--                            </td>-->



                        </tr>
                    <?php endforeach; ?>
                    <?php unset($user); ?>
                    </tbody>
                </table>
            </div>

            <hr>

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

<?php
$this->Js->buffer('$(".success").addClass("alert alert-success alert-dismissible fade show container mt-4 ").attr("role", "alert").prepend(\'<i class="ri-checkbox-circle-fill"> </i>\').append(\'<button type="button" class="btn-close" data-bs-dismiss="alert"></button>\');');

$this->Js->buffer("
		$('span.page-link').not('.active').each(function(){
			var link = $(this).find('a');
			var href = link.attr('href');
			var id = link.attr('id');
			var text = link.text();

			var newLink = $('<a></a>', {
				'class': 'page-link',
				'href': href,
				'id': id,
				'text': text
			});

			$(this).replaceWith(newLink);
		});
	");

$this->Js->buffer('
		$("div.submit").each(function() {
			var $div = $(this);
			var $input = $div.find("input[type=\'submit\']");

			if ($input.length) {
				$input.insertBefore($div);
				$div.remove();
			}
		});
	');
?>
