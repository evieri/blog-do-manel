<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public $layout = 'bootstrap';

    public $paginate = [
        'fields' => ['User.id', 'User.name', 'User.surname', 'User.created', 'User.role', 'User.username'],
        'limit' => 10,
        'order' => ['User.id' => 'desc'],
    ];

    public function beforeFilter() {
        $this->Auth->allow('add', 'logout');

        if ($this->Auth->user() && $this->Auth->user()['role'] === 'author') {
            $this->Auth->allow('edit');
        }
    }

    public function index() {

        // Pesquisa
        if ($this->request->is('post') && !empty($this->request->data['User']['name'])) {
            $searchTerm = trim($this->request->data['User']['name']);

            // Converte tanto o nome salvo quanto o termo para letras minúsculas para comparação
            $this->paginate['conditions']['LOWER(User.name) LIKE'] = '%' . strtolower($searchTerm) . '%';
        }

        // Filtro de data
        if (!empty($this->request->data['User']['start_date']) && !empty($this->request->data['User']['end_date'])) {
            $startDate = DateTime::createFromFormat('d/m/Y', $this->request->data['User']['start_date']);
            $endDate = DateTime::createFromFormat('d/m/Y', $this->request->data['User']['end_date']);

            if ($startDate && $endDate) {
                $this->paginate['conditions']['User.created >='] = $startDate->format('Y-m-d') . ' 00:00:00';
                $this->paginate['conditions']['User.created <='] = $endDate->format('Y-m-d') . ' 23:59:59';
            }
        }

        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
        $this->set('roles', [
            'author' => 'Autor',
            'admin' => 'Administrador'
        ]);
    }



    public function view($id = null) {

        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException(__('Usuário inválido'));
        }
        $this->set('user', $this->User->findById($id));

    }

    public function add() {

        $this->layout = 'add_user';

        //Se existe informação no formulário
        if (!empty($this->request->data)) {

            //Prepara o Model para receber os dados
            $this->User->create();

            //Manda para o modelo
            if ($this->User->save($this->request->data)) {

                //Mensagem para o usuário
                $this->Flash->success('Usuário criado com sucesso!');
                //Redireciona para os users
                $this->redirect('/users');

            } else {
                $this->Flash->alert('O usuário não pode ser salvo, tente novamente.');
            }
        }

        //        //Apenas edita o título e corpo do post
//        $fields = ['User.id', 'User.name', 'User.body', 'User.username'];
//        //Define o id para validação
//        $conditions = ['User.id' => $id];
//        //Joga os campos selecionados para a requisição
//        $this->request->data = $this->User->find('first', compact('fields','conditions'));
    }

    public function edit($id = null) {

        if (!$this->User->exists($id)) {
            $this->Flash->alert('Usuário inválido.');
            return $this->redirect('/users');
        }

        // Edita apenas o próprio perfil
        $userAtual = $this->Auth->user();
        if ($userAtual['role'] === 'author' && $userAtual['id'] != $id) {
            $this->Flash->danger('Você não tem permissão para editar este perfil.');
            return $this->redirect('/');
        }

        // Admin não edita Admin
        $userEditado = $this->User->findById($id);
        if ($userAtual['role'] === 'admin' && $userEditado['User']['role'] === 'admin' && $userAtual['id'] !== $userEditado['User']['id']) {
            $this->Flash->danger('Você não tem permissão para editar outro administrador.');
            return $this->redirect('/users');
        }

        if ($this->request->is(['post', 'put'])) {
            if ($this->User->save($this->request->data)) {
                $this->Flash->success('Usuário alterado com sucesso!');
                return $this->redirect('/users');
            } else {
                $this->Flash->alert('O usuário não pode ser alterado, tente novamente.');
            }
        } else {
            $this->request->data = $this->User->findById($id);
            unset($this->request->data['User']['password']);
        }
    }


    public function delete($id) {
        $this->request->allowMethod('post');

        $this->User->id = $id;

        if (!$this->User->exists()) {
            $this->Flash->alert('Usuário inválido.');
            return $this->redirect('/users');
        }

        // Verifica se o administrador está tentando deletar a si mesmo
        if ($this->Auth->user('id') == $id) {
            $this->Flash->danger('Você não pode apagar seu próprio perfil.');
            return $this->redirect('/users');
        }

        if ($this->User->delete()) {
            $this->Flash->success('Usuário removido com sucesso!');
        } else {
            $this->Flash->alert('Erro ao remover o usuário.');
        }

        return $this->redirect('/users');
    }


    public function login(){

        $this->layout = 'login';

        if ($this->request->is('post')) {

            if ($this->Auth->login()) {

                $redirectUrl = $this->Auth->redirectUrl();

                if (strpos($redirectUrl, '/users') !== false) {
                    $redirectUrl = $this->Auth->loginRedirect;
                }

                return $this->redirect($redirectUrl);

            } else {

                $this->Flash->danger('Usuário ou senha inválidos, por favor, tente novamente');

            }
        }
    }

    public function logout(){

        $this->Session->destroy();
        $this->Flash->alert('Você saiu da sua conta!');
        return $this->redirect($this->Auth->logout());

    }

}