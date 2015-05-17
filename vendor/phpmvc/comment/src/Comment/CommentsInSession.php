<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentsInSession implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
	
    /**
     * Add a new comment.
     *
     * @param array $comment with all details.
     * 
     * @return void
     */
    public function add($comment, $pageType = null)
    {
        $comments = $this->session->get('comments', []);
        $comments[$pageType][] = $comment;
        $this->session->set('comments', $comments);
    }



    /**
     * Find and return all comments.
     *
     * @return array with all comments.
     */
    public function findAll($pageType = null)
    {
        $comments = $this->session->get('comments', []);
		if(isset($comments[$pageType])) {
			return $comments[$pageType];
		}
		
    }
	
	
	/**
	 * Find a single comment.
	 *
	 * @param $id The id of the comment
	 * @return $comment Return a single comment.
	 */
	public function findSingle($id, $pageType = null)
	{
		$comments = $this->session->get('comments', []);
		$comment = $comments[$pageType][$id];
		
		return $comment;
	}



    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteAll($pageType = null)
    {
        $comments = $this->session->get('comments', []);
		unset($comments[$pageType]);
		$this->session->set('comments', $comments);
		
		
		/*$this->session->set('comments', []);*/
    }
	
	
	/**
	 * Delete a single comment.
	 *
	 * @param $key
	 * @return void
	 */
	public function delete($key, $pageType = null)
	{
		$comments = $this->session->get('comments', []);
		unset($comments[$pageType][$key]);
		$this->session->set('comments', $comments);
	}
	
	/**
	 * Save a comment
	 *
	 * @param $key
	 * @return void
	 */
	public function save($comment, $key = null, $pageType = null)
	{
		$comments = $this->session->get('comments', []);
        $comments[$pageType][$key] = $comment;
        $this->session->set('comments', $comments);
	}

}
