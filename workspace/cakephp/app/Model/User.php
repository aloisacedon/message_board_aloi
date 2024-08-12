<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class User extends AppModel {
	// public $hasOne = 'profile';
	public $primaryKey = 'id';
	public $hasOne = array(
        'Profile' => array(
            'className' => 'Profile',
			'foreignKey' => 'id'
            // 'conditions' => array('Profile.published' => '1'),
            // 'dependent' => true
        )
    );
	public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Username is required'
            ),
           'minLength' => array(
                'rule' => array('minLength', '5'),
                'message' => 'Name must be at least 5 characters long!'
		   ),
		   'maxLength' => array(
				'rule' => ['maxLength','20'],
				'message' => 'Name should be only up to 20 characters long!'
			)
        ),
        'email' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Email is required'
            ),
            'validEmail' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address'
            ),
            'unique' => array(
                'rule' => 'uniqueEmail',
                'message' => 'This email is already registered'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Password is required'
            ),
            'minLength' => array(
                'rule' => array('minLength', '6'),
                'message' => 'Password must be at least 6 characters long'
            )
        ),
        'confirm_password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'Confirm Password is required'
            ),
            'match' => array(
                'rule' => array('validatePasswordConfirm'),
                'message' => 'Passwords do not match'
            )
        )
    );

    public function validatePasswordConfirm($check) {
        // The confirm_password field value
        $confirm_password = array_values($check)[0];

        // The password field value
        $password = $this->data[$this->alias]['password'];

        return $confirm_password === $password;
    }

    // Hash the password before saving
    public function beforeSave($options = array()) {
        if (!empty($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }


	public function uniqueEmail($check){
		$email = array_values($check)[0];
		$emailExists = $this->find('first',array(
			'conditions' => array('User.email' => $email, 'User.id !=' => $this->data['User']['id'])
		));

		if($emailExists) return false;
		return true;
	}



}
