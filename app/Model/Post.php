<?php

App::uses('AppModel', 'Model');

class Post extends AppModel {

    public $belongsTo = array(
        'Category',
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id'
        ]
        );

    public $validate = array(
        'title' => array(
            'rule' => 'notBlank',
            'message' => 'Título obligatorio'
        ),
        'body' => array(
            'rule' => 'notBlank',
            'message' => 'Conteúdo obrigatório'
        )
    );

    public function isOwnedBy($post, $user) {

        return $this->field('id', ['id' => $post, 'user_id' => $user]) !== false;

    }

}
