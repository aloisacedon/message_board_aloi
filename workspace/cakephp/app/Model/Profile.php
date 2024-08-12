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
/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class Profile extends AppModel {
	public $useTable = 'users_profile';
	// public $primaryKey = 'id';
	// public $belongsTo = 'User';
	// public $primaryKey = "id";
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
                'rule' => 'validateEmailFromUsers',
                'message' => 'This email is already registered'
			),
			),
		'image' => array(
            'uploadError' => array(
                'rule' => 'uploadError',
                'message' => 'Something went wrong with the file upload',
                'allowEmpty' => true,
                'required' => false,
            ),
            'mimeType' => array(
                'rule' => array('mimeType', array('image/jpeg', 'image/png', 'image/gif','image/jpg')),
                'message' => 'Please upload only images (jpg, png, gif)',
                'allowEmpty' => true,
                'required' => false,
            ),
            'fileSize' => array(
                'rule' => array('fileSize', '<=', '1MB'),
                'message' => 'Image must be less than 1MB',
                'allowEmpty' => true,
                'required' => false,
            ),
            'extension' => array(
                'rule' => array('extension', array('jpeg', 'jpg', 'png', 'gif')),
                'message' => 'Please upload a file with a valid image extension (jpeg, jpg, png, gif)',
                'allowEmpty' => true,
                'required' => false,
            ),
        ),
    );


    public function beforeSave($options = array()) {

        return true;
    }

	public function validateEmailFromUsers($check){
		$email = array_values($check)[0];
		  // Load the Profile model
		  $Users = ClassRegistry::init('User');

		  // Find the profile based on some condition, e.g., user_id
		  $user = $Users->find('first', [
			  'conditions' => ['User.id' => $this->data['Profile']['id']],
			  'fields' => ['User.email']
		  ]);

		  if ($user && $email === $user['User']['email']) {
			  // If the email matches the profile's some_field, return true
			  return true;
		  }

		  // If validation fails, return false
		  return false;
	}
}
