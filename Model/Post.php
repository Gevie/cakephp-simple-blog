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
 * Class Post
 * 
 * @since SimpleBlog 0.1
 */
class Post extends SimpleBlogAppModel {

	/**
	 * Executed before any plugin query
	 * 
	 * @param array $query Holds the query data i.e. fields, conditions
	 * @return void
	 */
	public function beforeFind($query = array()) {
		if(Configure::read('SB.EnableAuthor') === true) {
			$this->bindModel(array(
				'belongsTo' => array(
					Configure::read('SB.AuthorSettings.alias') => array(
						'className' => Configure::read('SB.AuthorSettings.alias'),
						'foreignKey' => 'author_id'
					)
				)
			));
		}
	}

	/**
	 * Attach the author contain query
	 * 
	 * @return array The author contain with fields name and id
	 */
	protected function _containAuthor() {
		$alias = Configure::read('SB.AuthorSettings.alias');
		$name = Configure::read('SB.AuthorSettings.name');
		
		$contain = array(
			'fields' => array(
				"{$alias}.id",
				"{$alias}.{$name}"
			)
		);
				
		return $contain;
	}
	
	/**
	 * Checks whether the passed slug exists or not
	 * 
	 * @param string $slug The slug to search for
	 * @param bool $published If true make sure the result is published
	 * @return bool True if found, else false
	 */
	protected function _doesSlugExist($slug = null, $published = true) {
		$conditions = array('Post.slug' => $slug);
		if($published === true) $conditions['Post.published'] = 1;
		
		return $this->countByConditions($conditions);
	}

	/**
	 * Checks if the slug is valid (regex)
	 * 
	 * @param string $slug The slug to check against
	 * @return bool True if valid, else false
	 */
	protected function _isValidSlug($slug) {
		return preg_match("/^[a-z0-9-]+$/", $slug);
	}

	/**
	 * Finds a post by slug, works for both published and draft
	 * 
	 * @param string $slug The slug to search for
	 * @param bool $published If true make sure we only search for published only
	 * @return array The blog with the given slug
	 * @throws InvalidArgumentException If the slug is not valid or cannot be found
	 */
	public function findBySlug($slug = null, $published = true) {
		if(empty($slug) || ! $this->_isValidSlug($slug))
			throw new InvalidArgumentException(__('%s is not a valid slug', $slug));
		
		if(! $this->_doesSlugExist($slug, $published))
			throw new InvalidArgumentException(__('The post %s could not be found', $slug));
		
		// Set up the default query parameters
		$conditions = array('Post.slug' => $slug);
		$contain = array();

		// Are we searching for published only
		if($published === true)
			$conditions['Post.published'] = 1;
		
		// Did we enable the author, if so contain the author
		if(Configure::read('SB.EnableAuthor') === true)
			$contain[Configure::read('SB.AuthorSettings.alias')] = $this->_containAuthor();
		
		$post = $this->find('first', array(
			'conditions' => $conditions,
			'contain' => $contain
		));
		
		return $post;
	}

	/**
	 * Produces pagination settings for the posts index method
	 * 
	 * @param bool $published If set to true, only list published posts
	 * @return array The paginate settings for the controller method
	 */
	public function paginationList($published = true) {
		$conditions = ($published === true) ? array('Post.published' => 1) : array();
		$contain = array();
		
		if(Configure::read('SB.EnableAuthor') === true)
			$contain[Configure::read('SB.AuthorSettings.alias')] = $this->_containAuthor();
		
		$paginate = array(
			'contain' => $contain,
			'conditions' => $conditions,
			'limit' => Configure::read('SB.PaginationLimit'),
			'order' => array(
				'Post.created' => 'ASC'
			)
		);
		
		return $paginate;
	}
}