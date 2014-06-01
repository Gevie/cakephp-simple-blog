<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) 2014 Stephen Speakman
 * @link          http://www.stephenspeakman.co.uk
 * @since         SimpleBlog 0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppModel', 'Model');

/**
 * Class SimpleBlogAppModel
 * 
 * @since SimpleBlog 0.1
 */
class SimpleBlogAppModel extends AppModel {

	/**
	 * tablePrefix
	 * 
	 * @var string 
	 */
	public $tablePrefix = 'sb_';

	/**
	 * Finds the model by passed conditions
	 * 
	 * @param array $conditions The conditions to check against
	 * @return bool True if a record was found, else false
	 */
	public function countByConditions($conditions = array()) {
		$count = $this->find('count', array(
			'conditions' => $conditions
		));
		
		return ($count > 0) ? true : false;
	}
}