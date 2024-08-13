<?php
class MessagesController extends AppController {
    public $uses = ['User','Profile','Messages','Conversations'];
	public $helpers = array('Session','Form');
	public $components = array('Paginator');

	public function beforeFilter() {
        parent::beforeFilter();
    }

	public function index() {
		$logged_userid = $this->Auth->user('id');
		$page = $this->request->query('page') ? $this->request->query('page') : 1;

		$limit = 10;
		$offset = ($page - 1) * $limit;

		$results = $this->Messages->query(
			$this->paginateConversationsList("m1.*,users_profile.name,users_profile.image_path",$logged_userid,$limit, $offset)
		);

		$total = $this->Messages->query(
			$this->paginateConversationsList("COUNT(*) as count",$logged_userid)
		);
		$total = $total[0][0]['count'];

		$this->Paginator->settings = array(
			'limit' => $limit,
			'paramType' => 'querystring',
			'total' => $total,
		);

		try {
			$this->set('results', $results);
			$this->set('paginate', $this->Paginator->paginate());
		} catch (NotFoundException $e) {
			//Do something here like redirecting to first or last page.
			// exit(var_dump($this->request->params['paging']));
			return $this->redirect(array('action' => 'index'));
			//$this->request->params['paging'] will give you required info.
		}


		$this->set('logged_user', $this->Auth->user());
	}

	public function delete_conversation() {
		if($this->request->is('post')){
			$token = $this->request->data('token');
			$this->Messages->deleteAll(['Messages.token' => $token]);
			echo json_encode(true);
			die();
		}
	}

	public function delete_text() {
		$logged_userid = $this->Auth->user('id');

		if($this->request->is('post')){
			$id = $this->request->data('id');
			$myText = $this->Messages->find('first',[
				'conditions' => ['Messages.id' => $id, 'sender_id' => $logged_userid]
			]);
			// exit(var_dump($myText));
			$this->Messages->delete(['Messages.id' => $myText['Messages']['id']]);
			echo json_encode(true);
			die();
		}
	}

	public function details($token = null) {
		$logged_userid = $this->Auth->user('id');
		$myToken = $this->Messages->find('first',[
			'conditions' => ['Messages.token' => $token, 'OR' => ['Messages.sender_id' => $logged_userid, 'Messages.receiver_id' => $logged_userid]]
		]);

		if(empty($myToken)) return $this->redirect(array('action' => 'index'));

		$page = $this->request->query('page') ? $this->request->query('page') : 1;

		$limit = 5;
		$offset = ($page - 1) * $limit;

		$results = $this->Messages->query(
			$this->paginateMessagesDetails("m1.*,up1.*,up2.*",$token,$limit, $offset)
		);

		$total = $this->Messages->query(
			$this->paginateMessagesDetails("COUNT(*) as count",$token)
		);
		// exit($this->Messages->getLastQuery());
		$total = $total[0][0]['count'];

		$this->Paginator->settings = array(
			'limit' => $limit,
			'paramType' => 'querystring',
			'total' => $total,
		);

		try {
			$this->set('results', $results);
			$this->set('paginate', $this->Paginator->paginate());

		} catch (NotFoundException $e) {

			// exit(var_dump($this->request->params['paging']));
			return $this->redirect(array('action' => 'index'));
			//$this->request->params['paging'] will give you required info.
		}
		$receiver_id = $this->Messages->query(
			"SELECT CASE WHEN messages.sender_id = $logged_userid THEN messages.receiver_id ELSE messages.sender_id END AS receiver_id
				FROM messages WHERE messages.token = '$token' LIMIT 1
			"
		);

		$this->set('receiver_id',$receiver_id[0][0]['receiver_id']);


		$this->set('logged_user', $this->Auth->user());
	}

	private function paginateConversationsList($select,$userId,$limit = null, $offset = null){
		$filter = ($limit == null) ? '' : "LIMIT $limit OFFSET $offset";
		return "SELECT
					$select
				FROM
					messages m1
				JOIN users_profile ON users_profile.id = m1.sender_id
				WHERE
					m1.id =(
					SELECT
						m2.id
					FROM
						messages m2
					WHERE
						m2.token = m1.token
					ORDER BY
						m2.timestamp
					DESC
				LIMIT 1
				)
				AND token IN(SELECT m3.token FROM messages m3 WHERE m3.sender_id = $userId OR m3.receiver_id = $userId) $filter";
	}

	private function paginateMessagesDetails($select,$token,$limit = null, $offset = null){
		$filter = ($limit == null) ? '' : "LIMIT $limit OFFSET $offset";
		return "SELECT
					$select
				FROM
					messages m1
				JOIN users_profile up1 ON up1.id = m1.sender_id
				JOIN users_profile up2 ON up2.id = m1.receiver_id
				 WHERE m1.token = '$token' ORDER BY m1.timestamp DESC $filter";
	}

	public function search_messages() {
		$response = [
			'status' => 'failed',
			'msg' => 'request not valid!',
			'data' => ''
		];
		if($this->request->is('get')){
			$param = $this->request->query;
			$token = $param['token'];
			$term = $param['term'];
			$data = $this->Messages->query(
				"SELECT m1.*,sender.name,sender.id,sender.image_path,receiver.name,receiver.id,receiver.image_path
				FROM
					messages m1
				JOIN users_profile sender ON sender.id = m1.sender_id
				JOIN users_profile receiver ON receiver.id = m1.receiver_id
				 WHERE m1.token = '$token' AND m1.content LIKE '%$term%' ORDER BY m1.timestamp DESC"
			);

			if(count($data) > 0){
				$response = [
					'status' => 'success',
					'msg' => '',
					'data' => $data
				];
			}else{
				$response['msg'] = 'No messages found!';
			}

			exit(json_encode($response));
			// exit($this->Messages->getLastQuery());
			// exit(var_dump($data));

		}

		echo json_encode($response);
		die();
	}

	public function new() {
		$sender_id = $this->Auth->user()['id'];
		$users =$this->User->find('all',[
			'conditions' => ['User.id !=' => $sender_id]
		]);
		$data = [
			'users' => $users,
			'sender_id' => $sender_id
		];
		$this->set($data);

		if($this->request->is('post')){
			$req = $this->request->data['new'];
			$conversation = $this->create_conversation($req['sender_id'],$req['receiver_id']);
			$this->Messages->create();

			$req['token'] = $conversation['token'];

			if($this->Messages->save($req)){
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

	public function reply() {
		if($this->request->is('post')){
			// exit(var_dump($this->request->data));
			$req = $this->request->data;
			if($req['content'] == '')  exit(json_encode(['status' => 'failed','msg' => 'Cannot send empty content!']));
			$conversation = $this->create_conversation($req['sender_id'],$req['receiver_id']);
			$this->Messages->create();

			$req['token'] = $conversation['token'];

			$save = $this->Messages->save($req);
			if($save){
				// return $this->redirect(array('action' => 'index'));
				echo json_encode([
					'status' => 'success',
					'data' => $save
				]);
				die();
			}
		}
	}

	public function create_conversation($sender_id = null,$receiver_id = null){
		$existingConversation = $this->Messages->find('first',array(
			'conditions' => array(
				'OR' => array(
					array('Messages.sender_id' => $sender_id, 'Messages.receiver_id' => $receiver_id),
					array('Messages.sender_id' => $receiver_id, 'Messages.receiver_id' => $sender_id)
				)
			),
			'order' => array('Messages.id' => 'DESC'),
			'limit' => 1
		));

		if(count($existingConversation) !== 0){
			return $existingConversation['Messages'];
		}

		$hashedString = Security::hash(Security::randomBytes(32), 'sha1', true);
		$token = substr($hashedString, 0, 10);
		$this->Conversations->create();
		$data = [
			'token' => $token
		];

		return $this->Conversations->save($data)['Conversations'];
	}



}
