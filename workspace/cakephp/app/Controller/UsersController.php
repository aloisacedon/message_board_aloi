<?php
class UsersController extends AppController {
    public $uses = ['User','Profile'];

	public $helpers = array('Session','Form');

	public function beforeFilter() {
        parent::beforeFilter();

        // always restrict your whitelists to a per-controller basis
        // $this->Auth->allow("ajaxLogin");
        $this->Auth->allow("register");
        $this->Auth->allow("register_successful");
    }

    public function login() {
        if ($this->request->is('post')) {

            $sha1 = Security::hash($this->request->data['User']['password'], 'sha1', true);
			$user = $this->User->find('first', array(
				'conditions' => array(
					'email' => $this->request->data['User']['email'],
					'password' => $sha1
				)
			));

			if(!$user) return $this->Flash->error(__('Invalid username or password, try again'));



            $didLogin = $this->Auth->login($user['User']);
			// exit(var_dump($user['User']['user_id']));
            if ($didLogin) {
				$currentDatetime = date('Y-m-d H:i:s');
				$this->User->id = $user['User']['id'];
				$data = [
					'modified_ip' => $this->request->clientIp(),
					'last_login_time' => $currentDatetime
				];
				$this->User->save($data);
				// exit(var_dump($this->request->data));
                return $this->redirect($this->Auth->redirectUrl());
            }

            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

	public function register() {
        if ($this->request->is('post')) {
			// exit(var_dump($this->request->data));
            $this->User->create();
            if ($this->User->save($this->request->data)) {
				$userId = $this->User->id;
				$data = [
					'id' => $userId,
					'name' => $this->request->data['User']['name']
				];
				$this->Profile->save($data);
                $this->Flash->success(__('The user has been registered.'));
				$this->Flash->render('registered');
                return $this->redirect(array('action' => '/register_successful'));
            } else {
                $this->Flash->error(__('The user could not be registered. Please, try again.'));
            }
        }
    }


	public function change_password() {
		if ($this->request->is('post')) {
			$logged_user = $this->Auth->user();
            // $this->User->create();
			$data = [
				'id' => $logged_user['id'],
				'password' => $this->request->data['User']['password']
			];
			// exit(var_dump($data));
            if ($this->User->save($data)) {
                $this->Flash->success(__('You have successfully change your password.'));
				// $this->Flash->render('change_password');
                return $this->redirect(array('controller' => 'Profile','action' => 'index'));
            } else {
                $this->Flash->error(__('Password did not match!'));
            }
        }
	}

	public function register_successful() {}

	private function last_login_time($id){
		$currentDatetime = date('Y-m-d H:i:s');
		$this->User->user_id = $id;
		$data = [
				// 'user_id' => $id,
				'last_login_time' => $currentDatetime
			];
		$this->User->saveField($data);
		// $this->User->save($data);
		return true;
	}


    // public function ajaxLogin () {
	// 	$sha1 = Security::hash($this->request->data['password'], 'sha1', true);
    //     $user = $this->User->find('first', array(
    //         'conditions' => array(
    //             'email' => $this->request->data['email'],
    //             'password' => $sha1
    //         )
    //     ));
    //     $didLogin = $this->Auth->login($user['User']);

	// 	$response = [
	// 		'status' => 'failed',
	// 		'msg' => 'Password is incorrect!'
	// 	];
	// 	if($didLogin){
	// 		$response['status'] = 'success';
	// 		$response['user'] = $this->Auth->user();
	// 	}
    //     echo json_encode($response);
    //     die();
    // }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($id));
    }




}
