<?php

App::uses('AppController', 'Controller');

class PostsController extends AppController {

    public $layout = 'bootstrap';

    public $paginate = [
        'fields' => ['Post.id', 'Post.title', 'Post.created', 'Post.body', 'Post.status', 'User.name', 'User.surname'],
        'limit' => 10,
        'order' => ['Post.id' => 'desc'],
        ];

    public function beforeFilter() {
        //Define as páginas que podem ser vistas sem estar logado
        $this->Auth->allow('index', 'view');
    }

    private function _proibidoGet() {
        if (!$this->request->is('post') && !$this->request->is('put')) {
            throw new MethodNotAllowedException('Requisição não permitida.');
        }
    }

    public function isAuthorized($user) {

        // Todas as roles podem adicionar posts
        if ($this->action === 'add' || $this->action === 'activate' || $this->action === 'deactivate') {
            return true;
        }

        // O dono do post pode alterá-lo e editá-lo
        if (in_array($this->action, ['edit', 'delete'])) {

            $postId = (int) $this->request->params['pass'][0];

            if ($this->Post->isOwnedBy($postId, $user['id'])) {

                return true;

            }
        }

        return parent::isAuthorized($user);
    }

    public function index() {
        // Verifica se o usuário é admin
        $isAdmin = $this->Session->read('Auth.User.role') === 'admin';
        $userId = $this->Auth->user('id'); // ID do usuário logado

        // Condições base
        $conditions = [];

        // Se não for admin, adiciona a condição de mostrar apenas posts ativos ou posts do próprio usuário
        if (!$isAdmin) {
            $conditions[] = [
                'OR' => [
                    'Post.status' => true,       // Posts ativos
                    'Post.user_id' => $userId      // Posts do próprio usuário (mesmo que inativos)
                ]
            ];
        }

        // Restaurar dados da pesquisa da sessão
        $searchData = $this->Session->read('Post.search') ?: [];

        // Se o campo de pesquisa for enviado, atualiza a sessão
        if ($this->request->is('post')) {
            $searchTerm = trim($this->request->data['Post']['title'] ?? '');
            if (!empty($searchTerm)) {
                $searchData['title'] = $searchTerm;
            } else {
                unset($searchData['title']);
            }

            // Outras condições como categoria, data, etc.
            $searchData['category_id'] = $this->request->data['Post']['category_id'] ?? null;
            $searchData['start_date'] = $this->request->data['Post']['start_date'] ?? null;
            $searchData['end_date'] = $this->request->data['Post']['end_date'] ?? null;
            $searchData['status'] = $this->request->data['Post']['status'] ?? null;

            $this->Session->write('Post.search', $searchData);
        }

        // Condições de pesquisa
        if (!empty($searchData['title'])) {
            $searchTermLower = strtolower($searchData['title']);
            $conditions[] = [
                'OR' => [
                    'LOWER(Post.title) LIKE' => '%' . $searchTermLower . '%',
                    'LOWER(Post.body) LIKE' => '%' . $searchTermLower . '%'
                ]
            ];
        }

        if (!empty($searchData['category_id'])) {
            $conditions['Post.category_id'] = $searchData['category_id'];
        }

        if (!empty($searchData['start_date'])) {
            $startDate = DateTime::createFromFormat('d/m/Y', $searchData['start_date']);
            if ($startDate) {
                $conditions['Post.created >='] = $startDate->format('Y-m-d') . ' 00:00:00';
            }
        }

        if (!empty($searchData['end_date'])) {
            $endDate = DateTime::createFromFormat('d/m/Y', $searchData['end_date']);
            if ($endDate) {
                $conditions['Post.created <='] = $endDate->format('Y-m-d') . ' 23:59:59';
            }
        }

        if (isset($searchData['status']) && $searchData['status'] !== '') {
            $conditions['Post.status'] = (int)$searchData['status'];
        }

        // Atualiza as condições na configuração de paginação
        $this->paginate['conditions'] = $conditions;

        // Recupera os posts paginados
        $posts = $this->paginate('Post');
        $this->set('posts', $posts);

        // Resgata a tabela categorias
        $this->loadModel('Category');
        $categories = $this->Category->find('list');
        $this->set(compact('categories'));

        // Restaurar os valores da pesquisa na view
        $this->request->data['Post'] = $searchData;
    }



    public function view($id = null) {

        $view = $this->Post->findById($id);

        if (!$view) {
            throw new NotFoundException(__('Post inválido.'));
        }

        // Verifica se o post está desativado e se o usuário tem permissão para vê-lo
        if (!$view['Post']['status']) {
            $isOwner = $this->Auth->user('id') === $view['Post']['user_id'];
            $isAdmin = $this->Auth->user('role') === 'admin';

            if (!$isOwner && !$isAdmin) {
                $this->Flash->danger('Você não tem permissão para ver este post.');
                return $this->redirect('/posts');
            }
        }

        $this->set('view', $view);
        $posts = $this->paginate();
        $this->set('posts', $posts);

    }

    public function add() {

        if ($this->request->is('post')) {

            $this->request->data['Post']['user_id'] = $this->Auth->user('id');

            //Manda para o modelo
            if ($this->Post->save($this->request->data)) {

                $this->Flash->success('Post enviado com sucesso!');

                return $this->redirect('/posts');
            }
        }

        //Define que somente o id e nome serão buscados
        $fields = ['Category.id', 'Category.name'];
        //Pega os dados do banco de dados
        $categories = $this->Post->Category->find('list', compact('fields'));
        //Seta a variável $categories para ser usada na view
        $this->set('categories', $categories);
    }

    public function edit($id = null) {

        $this->_proibidoGet();

        //Se existe informação no formulário
        if (!empty($this->request->data)) {

            //Manda para o modelo
            if ($this->Post->save($this->request->data)) {

                //Mensagem para o usuário
                $this->Flash->success('Post alterado com sucesso!');
                //Redireciona para os posts
                $this->redirect('/posts');

            }
        } else {

            //Apenas edita o título e corpo do post
            $fields = ['Post.id', 'Post.title', 'Post.body', 'Post.category_id'];
            //Define o id para validação
            $conditions = ['Post.id' => $id];
            //Joga os campos selecionados para a requisição
            $this->request->data = $this->Post->find('first', compact('fields','conditions'));

        }

        //Define que somente o id e nome serão buscados
        $fields = ['Category.id', 'Category.name'];
        //Pega os dados do banco de dados
        $categories = $this->Post->Category->find('list', compact('fields'));
        //Seta a variável $categories para ser usada na view
        $this->set('categories', $categories);

    }

    public function delete($id){

        $this->_proibidoGet();

        //Apaga o post
        if ($this->Post->delete($id)) {
            $this->Flash->success('Post removido com sucesso!');
        } else {
            $this->Flash->danger('Erro ao remover o post.');
        }

        //Redireciona para o index
        $this->redirect('/posts');

    }

    public function deactivate($id = null) {

        $this->_proibidoGet();

        // Busca o post pelo ID
        $post = $this->Post->findById($id);

        // Verifica se o post existe
        if (!$post) {
            $this->Flash->alert('Post inválido.');
            return $this->redirect('/posts');
        }

        // Verifica se o usuário logado é o dono do post OU é admin
        if ($this->Auth->user('id') !== $post['Post']['user_id'] && $this->Auth->user('role') !== 'admin') {
            $this->Flash->danger('Você não tem permissão para desativar este post.');
            return $this->redirect('/posts');
        }

        // Tenta desativar o post
        $this->Post->id = $id;
        if ($this->Post->saveField('status', false)) {
            $this->Flash->success('O post foi desativado.');
        } else {
            $this->Flash->danger('Não foi possível desativar o post. Por favor, tente novamente.');
        }

        return $this->redirect('/posts');
    }

    public function activate($id = null) {

        $this->_proibidoGet();

        // Busca o post pelo ID
        $post = $this->Post->findById($id);

        // Verifica se o post existe
        if (!$post) {
            $this->Flash->alert('Post inválido.');
            return $this->redirect('/posts');
        }

        // Verifica se o usuário logado é o dono do post OU é admin
        if ($this->Auth->user('id') !== $post['Post']['user_id'] && $this->Auth->user('role') !== 'admin') {
            $this->Flash->danger('Você não tem permissão para ativar este post.');
            return $this->redirect('/posts');
        }

        // Tenta ativar o post
        $this->Post->id = $id;
        if ($this->Post->saveField('status', true)) {
            $this->Flash->success('O post foi reativado.');
        } else {
            $this->Flash->danger('Não foi possível reativar o post. Por favor, tente novamente.');
        }

        return $this->redirect('/posts');
    }



}