<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($pageType = null, $key = null)
    {
        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

		if(isset($key)) {
			$comment = $comments->findSingle($key, $pageType);
		} else {
			$comment = $comments->findAll($pageType);
		}
		
        $this->views->add('comment/comments', [
            'comments' => $comment,
			'pageType' => $pageType,
        ]);
    }
	
	
	/**
     * Edit a comment.
     *
     * @return void
     */
	public function editAction() 
	{
		$isPosted = $this->request->getPost('doEdit');
		
		if($isPosted) {
			$key = $this->request->getPost('key');
			$pageType = $this->request->getPost('pageType');
		} else {
			$key = $this->request->getGet('id');
			$pageType = $this->request->getGet('pageType');
		}
		
		
		$comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);
		
		$comment = $comments->findSingle($key, $pageType);
		
		$this->theme->setTitle('Editera');
		$this->views->add('comment/edit', [
			'mail'      => $comment['mail'],
			'web'       => $comment['web'],
			'name'      => $comment['name'],
			'content'   => $comment['content'],
			'id'		=> $key,
			'pageType'	=> $pageType,
		]);
		
	}
	
	/**
	 * Remove all comments or just a single comment
	 *
	 * @return void
	 */
	public function removeAction()
	{
		$isPosted = $this->request->getPost('doRemove');
		
		if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }
		
		$key = $this->request->getPost('key');
		$pageType = $this->request->getPost('pageType');
		
		$comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);
		
		if (isset($key)) {
			$comments->delete($key, $pageType);
		} else {
			$comments->deleteAll($pageType);
		}
	
		$this->response->redirect($this->request->getPost('redirect'));
	
	}
	
	/**
	 * Save a comment
	 *
	 * @return void
	 */
	public function saveAction()
	{
		$isPosted = $this->request->getPost('doSave');
        
        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
        ];	
		$key = $this->request->getPost('key');
		$pageType = $this->request->getPost('pageType');
		
        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);
		if (isset($key)) {
			$comments->save($comment, $key, $pageType);
		} else {
			$comments->add($comment, $pageType);
		}
		
        $this->response->redirect($this->request->getPost('redirect'));
	}
}
