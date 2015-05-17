<?php

namespace Anax\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


	/**
	 * Initialize the controller. Initialize is called automatically.
	 *
	 * @return void
	 */
	public function initialize()
	{
		$this->comment = new \Anax\Comment\Comment();
		$this->comment->setDI($this->di);
		
		$this->answer = new \Anax\Answer\Answer();
        $this->answer->setDI($this->di);
		
		$this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
	}
	
	/**
	 * List all comments.
	 *
	 * @return void
	 */
	public function viewAction($key = null)
	{	
		//$this->theme->setTitle("comments");
		$all = $this->comment->findAll();
		$this->views->add('comment/list-all', [
            'comments' => $all,
        ]);
	}
	
	
	/**
	 * Add new comment
	 *
	 * @param $type Comment an answer or a question?
	 * @param $id Id of answer or question
	 *
	 * @return void
	 */
	public function addAction($type, $id)
	{
		$user = $this->session->get('user');
		if(!isset($user)) {
			//die("You must be logged in");
			$url = $this->url->create('users/login');
            $this->response->redirect($url);
		}
	
		$form = $this->form->create([], [
			'comment' => [
				'type'        => 'textarea',
				'label'       => 'Kommentar:',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'submit' => [
				'type'      => 'submit',
				'value'		=> 'Kommentera',
				'callback'  => function ($form) {
					
					$form->saveInSession = true;
					return true;
				}
			],
		]);	
		
		// Check the status of the form
		$status = $form->check();
		 
		if ($status === true) {
			// What to do if the form was submitted?
			$form_data = $this->session->get('form-save');
			$now = gmdate('Y-m-d H:i:s');
			$user = $this->users->findUser($user);
			$userId = $user->id;
			//$user = $this->session->get('user');
			$comment = $this->textFilter->doFilter($form_data['comment']['value'], 'shortcode, markdown');
			$questionId = null;
			// Question or answer?
			if($type == 'question') {
				$this->comment->save([
					'comment' 	  => $comment,
					'user_id' 	  => $userId,
					'question_id' => $id,
					'created' 	  => $now,
				]);
				$questionId = $id;
				
			} else if($type == 'answer') {
				$this->comment->save([
					'comment' 	  => $comment,
					'user_id' 	  => $userId,
					'answer_id'   => $id,
					'created' 	  => $now,
				]);
				$ans = $this->answer->findAnswer($id);
				$questionId = $ans->question_id;
			}
			
			unset($_SESSION['form-save']);
			
			$url = $this->url->create('question/id/' . $questionId);
			$this->response->redirect($url);
		
		} else if ($status === false) {
			$form->AddOutput("Something went wrong");
		}
		
		$questionId = null;
		if($type == 'question') {
			$questionId = $id;
		} else if($type == 'answer') {
			$ans = $this->answer->findAnswer($id);
			$questionId = $ans->question_id;
		}
		
		$this->theme->setTitle("Kommentera");
		$this->views->add('comment/comment-form', [
			'form' => $form->getHTML(),
			'id'   => $questionId,
		]);

	}
	
	
	/**
	 * List comments by id that are related to questions
	 *
	 * @param $id Id of the question
	 *
	 * @return comments
	 */
	public function listCommentQuestionAction($id)
	{
		 $all = $this->comment->query()
            ->where("question_id = ?")
            ->execute([$id]);
        
		return $all;
	}
	
	
	/**
	 * List comments by id that are related to answers
	 *
	 * @param $id Id of the question
	 *
	 * @return comments
	 */
	public function listCommentAnswerAction($id)
	{
		 $all = $this->comment->query()
            ->where("answer_id = ?")
            ->execute([$id]);
        
		return $all;
	}
	
	
	/**
	 * initalize table.
	 *
	 * @return void
	 */
	public function initAction()
	{
		$this->theme->setTitle("Setup default commenttable");
		$table = [
				'idComment'   => ['integer', 'primary key', 'not null', 'auto_increment'],
				'comment' 	  => ['varchar(500)'],
				'created'	  => ['datetime'],
				'user_id' 	  => ['integer'],
				'question_id' => ['integer'],
				'answer_id'   => ['integer'],
		];
		
		// Create table
		$this->comment->setupTable($table);
		
		$url = $this->url->create('questions'); 
		$this->response->redirect($url); 

	}

}
