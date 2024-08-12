<?php
class ProfileController extends AppController {
    public $uses = ['User','Profile'];

	public $helpers = array('Session','Form');

	public function beforeFilter() {
        parent::beforeFilter();
    }

	public function index() {
		$id = $this->request->query('id');
		$this->set_profile_info($id);
	}

	public function edit() {
		$userId = $this->Auth->user('id');
		$this->set_profile_info();
		if ($this->request->is('post')) {
            $this->Profile->create();
			$this->Profile->id = $userId;
            //Validate and save the image
			$this->User->id = $userId;
			$this->User->saveField('email', $this->request->data['Profile']['email']);
            if ($this->Profile->save($this->request->data,['fieldList' => ['name','birthdate','gender','hubby']])) {
				$file = $this->request->data['Profile']['image'];
                $destination = WWW_ROOT . 'img/uploads/' . $file['name'];
				// exit(var_dump($file));
				if($file['name'] !== ''){
					$this->Profile->saveField('image_path','img/uploads/' . $file['name']);
					move_uploaded_file($file['tmp_name'], $destination);
				}

                return $this->redirect(array('action' => 'index'));
            } else {
            }
        }
	}

	public function set_profile_info($id = null){
		$logged_userId = $this->Auth->user('id');
		$edit = true;
		if(isset($id)){
			$edit = false;
			$logged_userId = $id;

		}
		$profile = $this->Profile->find('first',['conditions' => ['Profile.id' => $logged_userId]]);
		$user = $this->User->find('first',['conditions' => ['User.id' => $logged_userId]])['User'];
		// exit(var_dump($user));
		$user_info = [
			'info' => $profile['Profile'],
			'email' => $user['email'],
			'last_login_time' => $user['last_login_time'],
			'joined' => $user['created'],
			'edit' => $edit
		];
		$this->set('profile',$user_info);
	}

}
