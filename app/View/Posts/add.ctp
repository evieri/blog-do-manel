<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>Adicionar Post</h1>

    </div>

    <div>
        <?php
        $button = [
            'type' => 'submit',
            'class' => 'btn btn-primary btn-lg mt-3'
        ];

        echo $this->Form->create('Post', ['class' => 'd-grid mx-auto col-10 col-lg-6']);

        echo $this->Form->input('title', [
            'required' => false,
            'class' => 'form-control',
            'div' => [
                'class' => 'mb-3'
            ],
            'label' => [
                'class' => 'form-label',
                'text' => 'Título do post'
            ]
        ]);

        echo $this->Form->input('category_id', [
            'required' => false,
            'class' => 'form-select',
            'div' => [
                'class' => 'mb-3'
            ],
            'label' => [
                'class' => 'form-label',
                'text' => 'Categoria'
            ]
        ]);

        echo $this->Form->input('body', [
            'required' => false,
            'class' => 'form-control',
            'div' => [
                'class' => 'mb-3'
            ],
            'label' => [
                'class' => 'form-label',
                'text' => 'Conteúdo do post'
            ]
        ]);

        echo $this->Form->input('id');
        echo $this->Form->button('Postar', $button);
        ?>
    </div>
</div>
