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

/**
 * Posts Settings
 */
Configure::write('SB.PaginationLimit', 10);

/**
 * Author Configuration
 */
Configure::write('SB.EnableAuthor', true);
Configure::write('SB.AuthorSettings', array(
	'alias' => 'User',
	'name' => 'User.username',
	'action' => array(
		'controller' => 'users', 
		'action' => 'view'
	)
));