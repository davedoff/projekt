<?php

namespace Anax\Question;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class QuestionController implements \Anax\DI\IInjectionAware
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
		
		$this->question = new \Anax\Question\Question();
        $this->question->setDI($this->di);
        
		$this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
        
		$this->answer = new \Anax\Answer\Answer();
        $this->answer->setDI($this->di);
        
		$this->tag = new \Anax\Tag\Tag();
        $this->tag->setDI($this->di);
	}
	
	/**
	 * List all questions.
	 *
	 * @return void
	 */
	public function viewAction()
	{
		
		$all = $this->question->findQuestions();
        $this->views->add('question/list-all', [
            'questions' => $all,
        ]);
	}
	
	
	/**
	 * Add new question
	 *
	 * @return void
	 */
	public function addAction()
	{
		$user = $this->session->get('user');
		if(!isset($user)) {
			$url = $this->url->create('users/login');
            $this->response->redirect($url);
		}
	
		$form = $this->form->create([], [
			'title' => [
				'type'        => 'text',
				'label'       => 'Rubrik:',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'question' => [
				'type'        => 'textarea',
				'label'       => 'Innehåll:',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'tags' => [
				'type'        => 'text',
				'label'		  => 'Taggar (använd komma för att skriva flera taggar)',
				'required'    => true,
				'multiple'	  => true,
				'validation'  => ['not_empty'],
			],
			'submit' => [
				'type'      => 'submit',
				'value'		=> 'Skapa fråga',
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
			$title = $form_data['title']['value'];
			$question = $this->textFilter->doFilter($form_data['question']['value'], 'shortcode, markdown');
			$tagsString = $form_data['tags']['value'];
			$user = $this->users->findUser($user);
			$userId = $user->id;
			//$user = $this->session->get('user');
			
			$this->question->save([
                'title' => $title,
                'question' => $question,
                'user_id' => $userId,
                'created' => $now,
            ]);
			
			$id = $this->question->getLastInsertID();
			
			$this->di->dispatcher->forward([
                'controller' => 'tag',
                'action' => 'transformTags',
                'params' => [$tagsString, $id]
            ]);
			
			unset($_SESSION['form-save']);
			
			$url = $this->url->create('questions');
			$this->response->redirect($url);
		
		} else if ($status === false) {
			$form->AddOutput("Something went wrong");
		}
			
		$this->theme->setTitle("Ställ en fråga");
		$this->views->add('question/question-form', [
			'form' => $form->getHTML(),
		]);

	}
	
	
	/**
	 * Add a new answer to a question.
	 *
	 * @param $id Question
	 */
	public function addAnswerAction($question_id = null)
	{
		
		if (!isset($question_id)) {
            die("Missing question_id");
        }
		
		$user = $this->session->get('user');
		if(!isset($user)) {
			$url = $this->url->create('users/login');
            $this->response->redirect($url);
		}
	
		$form = $this->form->create([], [
			'answer' => [
				'type'        => 'textarea',
				'label'       => 'Svar:',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'submit' => [
				'type'      => 'submit',
				'value'		=> 'Svara',
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
			$answer = $this->textFilter->doFilter($form_data['answer']['value'], 'shortcode, markdown');
			$user = $this->users->findUser($user);
			$userId = $user->id;
			
			$this->answer->save([
                'answer' 	  => $answer,
                'user_id' 	  => $userId,
				'question_id' => $question_id,
                'created' 	  => $now,
            ]);
			
			unset($_SESSION['form-save']);
			
			$url = $this->url->create('question/id/' . $question_id);
			$this->response->redirect($url);
		
		} else if ($status === false) {
			$form->AddOutput("Something went wrong");
		}
			
		$this->theme->setTitle("Answer a question");
		$this->views->add('question/question-form', [
			'form' => $form->getHTML(),
		]);

	}
	
	
	/**
	 * Delete questions
	 *
	 * @param $id Id of the question you want to delete.
	 *
	 * @return void
	 */
	public function deleteAction($id = null)
	{
		if (!isset($id)) {
            die("Missing id");
        }
	
		$this->tag->deleteTagIdQuestion($id);
		
		$res = $this->question->delete($id);
		
		if($res) {
			$url = $this->session->get('url');
            //$url = $this->url->create($url);
            $this->response->redirect($url);
		}
	}

	
	/**
	 * List a question
	 *
	 * @return void
	 */
	public function idAction($id = null)
	{
		if (!isset($id)) {
            die("Missing id");
        }
	
		$question = $this->question->query()
			->where("id = ?")
			->execute([$id]);
			
		$answers = $this->answer->query()
			->where("question_id = ?")
            ->execute([$id]);
			
		$comments = $this->comment->query()
			->where("question_id = ?")
            ->execute([$id]);
        
		$this->theme->setTitle("Fråga");
		$this->views->add('question/question-view', [
            'question' => $question,
            'comments' => $comments,
            'answers' => $answers,
        ]);
	
	}
	
	/**
	 * Get question by id
	 *
	 * @param $id
	 *
	 * @return $question 
	 */
	public function getQuestionAction($id)
	{
		if (!isset($id)) {
            die("Missing id");
        }
		$question = $this->question->find($id);
			
		return $question;
	}
	
	
	/**
	 * List all questions that are related to a specific tag.
	 *
	 * @return void
	 */
	public function taggedAction($tag = null)
	{
		$tag = urldecode($tag);
		$questions = $this->question->query()
			->join('tag', 'question.id = tag.question_id')
			->where("tag.tag = ?")
			->execute([$tag]);
	
		$this->theme->setTitle("Taggade frågor");
		$this->views->add('question/list-all', [
            'questions' => $questions,
        ]);
	}
	
	
	/**
	 * Get questions created by a specific user
	 *
	 * @param $id Id of user 
	 *
	 * @return All questions in form of an array
	 */
	public function getQuestionsByUserAction($id = null)
	{
		if (!isset($id)) {
            die("Missing id");
        }
		
		$questions = $this->question->query()
			->where('user_id = ?')
			->execute([$id]);
        return $questions;
	}
	
	
	/**
	 * List the latest questions
	 *
	 * @return void
	 */
	public function viewFirstAction()
	{
		$all = $this->question->findLatestQuestions();
		$this->views->add('project/home-questions', [
			'questions' => $all,
		]);
	}

	/**
	 * initalize table.
	 *
	 * @return void
	 */
	public function initAction()
	{
		$this->theme->setTitle("Setup default questiontable");
		$table = [
				'id' 		=> ['integer', 'primary key', 'not null', 'auto_increment'],
				'title'		=> ['varchar(100)'],
				'question' 	=> ['varchar(500)'],
				'created'	=> ['datetime'],
				'user_id' 	=> ['integer'],
		];
		
		// Create table
		$this->question->setupTable($table);
		
		$url = $this->url->create('questions'); 
		$this->response->redirect($url); 

	}
	
	
	
	
	

}
