<?php

namespace Anax\Answer;

/**
 * To attach answers-flow to a page or some content.
 *
 */
class AnswerController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


	/**
	 * Initialize the controller. Initialize is called automatically.
	 *
	 * @return void
	 */
	public function initialize()
	{   
		$this->answer = new \Anax\Answer\Answer();
        $this->answer->setDI($this->di);
	}
	
	/**
	 * initalize table.
	 *
	 * @return void
	 */
	public function initAction()
	{
		$this->theme->setTitle("Setup default answertable");
		$table = [
				'idAnswer'    => ['integer', 'primary key', 'not null', 'auto_increment'],
				'answer' 	  => ['varchar(500)'],
				'created'	  => ['datetime'],
				'user_id' 	  => ['integer'],
				'question_id' => ['integer'],
		];
		
		// Create table
		$this->answer->setupTable($table);
		
		$url = $this->url->create('questions'); 
		$this->response->redirect($url); 

	}
	
	/**
	 * Get answer by id
	 *
	 * @param $id
	 *
	 * @return $answer 
	 */
	public function getAnswerAction($id)
	{
		if (!isset($id)) {
            die("Missing id");
        }
		$answer = $this->answer->find($id);
			
		return $answer;
	}
	
}
