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
App::uses('AppController', 'Controller');

/**
 * Class PostsController
 * 
 * @since SimpleBlog 0.1
 */
class PostsController extends SimpleBlogAppController {

	/**
	 * Lists all of the blog posts by default unless a filter is passed
	 * 
	 * @return void
	 */
	public function index() {
		// do nothing yet
	}
	
	public function view($slug = null) {
		$this->set('post', $this->Post->findBySlug($slug, true));
	}
	
}