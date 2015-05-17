<?php

namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
	
	
	/**
	 * Initialize the controller. Initialize is called automatically.
	 *
	 * @return void
	 */
	public function initialize()
	{
		$this->users = new \Anax\Users\User();
		$this->users->setDI($this->di);
	}
	
	
	/**
	 * List all users.
	 *
	 * @return void
	 */
	public function listAction()
	{
		$all = $this->users->findAll();
	 
		$this->theme->setTitle("Alla användare");
		$this->views->add('users/list-all', [
			'users' => $all,
			'title' => "Alla användare",
		]);
	}
	
	
	/**
	 * List all users.
	 *
	 * @return void
	 */
	public function listAdminAction()
	{
		$all = $this->users->findAll();
	 
		$this->theme->setTitle("Alla användare");
		$this->views->add('users/list-all-admin', [
			'users' => $all,
			'title' => "Alla användare",
		]);
	}
	
	
	/**
	 * Get user by id
	 *
	 * @param $id
	 *
	 * @return $user 
	 */
	public function getUserAction($id)
	{
		if (!isset($id)) {
            die("Missing id");
        }
		$user = $this->users->find($id);
			
		return $user;
	}
	
	/**
	 * Get user by acronym
	 *
	 * @param $acronym
	 *
	 * @return $user
	 */
	public function getUserAcronymAction($acronym = null)
	{
		if (!isset($acronym)) {
            die("Missing acronym");
        }
		$user = $this->users->findUser($acronym);
			
		return $user;
	}
	
	
	/**
	 * List user with id.
	 *
	 * @param int $id of user to display
	 *
	 * @return void
	 */
	public function idAction($id = null)
	{
		//user
		$user = $this->users->find($id);
		$acronym = $user->acronym;
		
		//questions related to a specific user.
		$questions = $this->users->query()
            ->join('question', 'question.user_id = user.id')
            ->where('acronym = ?')
            ->execute([$acronym]);
			
		//answers related to a specific user.	
		$answers = $this->users->query()
            ->join('answer', 'answer.user_id = user.id')
            ->where('acronym = ?')
            ->execute([$acronym]);
		
		//comments related to a specific user.
		$comments = $this->users->query()
            ->join('comment', 'comment.user_id = user.id')
            ->where('acronym = ?')
            ->execute([$acronym]);

		$this->theme->setTitle($acronym);
		
		$this->views->add('users/profile', [ 
            'user' => $user, 
            'questions' => $questions, 
            'answers' => $answers, 
			'comments' => $comments,
        ]);
	}
	
	
	/**
	 * Reset and setup database with default users.
	 *
	 * @return void
	 */
	public function setupAction()
	{
		$this->theme->setTitle("Setup default usertable");
		$table = [
				'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
				'acronym' => ['varchar(20)', 'unique', 'not null'],
				'email' => ['varchar(80)'],
				'name' => ['varchar(80)'],
				'password' => ['varchar(255)'],
				'created' => ['datetime'],
				'updated' => ['datetime'],
				'deleted' => ['datetime'],
				'active' => ['datetime'],
				'timesLoggedOn' => ['integer'],
		];
		
		// Create table
		$this->users->setupTable($table);
		
		$now = gmdate('Y-m-d H:i:s'); 
		
		// Add some users
		$this->users->create([ 
			'acronym' => 'admin', 
			'email' => 'admin@dbwebb.se', 
			'name' => 'Administrator', 
			'password' => password_hash('admin', PASSWORD_DEFAULT), 
			'created' => $now, 
			'active' => $now, 
			'timesLoggedOn' => 1,
		]); 

		$this->users->create([ 
			'acronym' => 'doe', 
			'email' => 'doe@dbwebb.se', 
			'name' => 'John/Jane Doe', 
			'password' => password_hash('doe', PASSWORD_DEFAULT), 
			'created' => $now, 
			'active' => $now, 
			'timesLoggedOn' => 1,
		]); 

		$url = $this->url->create('users/list'); 
		$this->response->redirect($url); 
	}
	
	

	/**
	 * Add new user
	 *
	 * @return void
	 */
	public function addAction()
	{
		$form = $this->form->create([], [
			'name' => [
				'type'        => 'text',
				'label'       => 'Namn:',
				'required'    => true,
				'validation'  => ['not_empty'],
			],
			'acronym' => [
					'type'        => 'text',
					'label'       => 'Användarnamn:',
					'required'    => true,
					'validation'  => ['not_empty'],
			],
			'password' => [ 
					'type'        => 'password', 
					'label'       => 'Lösenord', 
					'required'    => true, 
					'validation'  => ['not_empty'], 
			],
			'email' => [
				'type'        => 'text',
				'label'       => 'e-mail:',
				'required'    => true,
				'validation'  => ['not_empty', 'email_adress'],
			],
			'submit' => [
				'type'      => 'submit',
				'value'     => 'klar',
				'callback'  => function ($form) {
					
					$now = gmdate('Y-m-d H:i:s');
			 
					$this->users->save([
						'acronym' 	=> $form->Value('acronym'),
						'email' 	=> $form->Value('email'),
						'name' 		=> $form->Value('name'),
						'password' 	=> password_hash($form->Value('password'), PASSWORD_DEFAULT),
						'created' 	=> $now,
						'active' 	=> $now,
						'timesLoggedOn' => 1,
					]);
					
					return true;
				}
			],
		]);	
		
		// Check the status of the form
		$status = $form->check();
		 
		if ($status === true) {
		 
			// What to do if the form was submitted?
			$url = $this->url->create('users/id/' . $this->users->id); 
			$this->response->redirect($url);
		 
		} else if ($status === false) {
		 
			// What to do when form could not be processed?
			$form->AddOutput("Could not create user");
			$url = $this->url->create('users/add'); 
			$this->response->redirect($url);  
		}
		
		$this->theme->setTitle("Ny användare");
		$this->views->add('users/form', [
			'title' => "Registrera",
			'content' => $form->getHTML()
		]);
	}
	
	
	/**
	 * Edit user
	 *
	 * @return void
	 */
	public function editAction($id = null)
	{
		if(!isset($id)) {
			die("missing id");
		}
	
		$user = $this->users->find($id);
	
		$form = $this->form->create([], [
			'name' => [
				'type'        => 'text',
				'label'       => 'Namn:',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => $user->name,
			],
			'acronym' => [
				'type'        => 'text',
				'label'       => 'Användarnamn:',
				'required'    => true,
				'validation'  => ['not_empty'],
				'value'		  => $user->acronym,
			],
			'email' => [
				'type'        => 'text',
				'label'		  => 'e-mail',
				'required'    => true,
				'validation'  => ['not_empty', 'email_adress'],
				'value'		  => $user->email,
			],
			'submit' => [
				'type'      => 'submit',
				'value'     => 'Klar',
				'callback'  => function ($form) {
					
					$now = gmdate('Y-m-d H:i:s');
			 
					$this->users->save([
						'acronym' 	=> $form->Value('acronym'),
						'email' 	=> $form->Value('email'),
						'name' 		=> $form->Value('name'),
						'updated' 	=> $now,
					]);
					
					return true;
				}
			],
		]);	
		
		// Check the status of the form
		$status = $form->check();
		 
		if ($status === true) {
		 
			// What to do if the form was submitted?
			$url = $this->url->create('users/id/' . $user->id); 
			$this->response->redirect($url);
		 
		} else if ($status === false) {
		 
			// What to do when form could not be processed?
			$form->AddOutput("Det gick inte att spara");
			$url = $this->url->create('users/update/' . $user->id); 
			$this->response->redirect($url);  
		}
		
		$this->theme->setTitle("Redigera profil");
		$this->views->add('users/form', [
			'title' => "Redigera profil",
			'content' => $form->getHTML()
		]);
	}
	
	
	
	/**
	 * Delete user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function deleteAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
	 
		$res = $this->users->delete($id);
	 
		$url = $this->url->create('users/list');
		$this->response->redirect($url);
	}
	
	
	/**
	 * Delete (soft) user.
	 *
	 * @param integer $id of user to delete.
	 *
	 * @return void
	 */
	public function softDeleteAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
	 
		$now = gmdate('Y-m-d H:i:s');
	 
		$user = $this->users->find($id);
	 
		$user->deleted = $now;
		$user->save();
	 
		$url = $this->url->create('users/id/' . $id);
		$this->response->redirect($url);
	}
	
	
	/**
	 * Undo delete (soft) user.
	 *
	 * @param integer $id of user to undo delete on.
	 *
	 * @return void
	 */
	public function undoSoftDeleteAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
	 
		//$now = gmdate('Y-m-d H:i:s');
	 
		$user = $this->users->find($id);
	 
		$user->deleted = null; //take away timestamp
		$user->save();
	 
		$url = $this->url->create('users/id/' . $id);
		$this->response->redirect($url);
	}
	
	
	/**
	 * List all active and not deleted users.
	 *
	 * @return void
	 */
	public function activeAction()
	{
		$all = $this->users->query()
			->where('active IS NOT NULL')
			->andWhere('deleted is NULL')
			->execute();
	 
		$this->theme->setTitle("Users that are active");
		$this->views->add('users/list-all', [
			'users' => $all,
			'title' => "Users that are active",
		]);
	}
	
	
	/**
	 * List all inactive and not deleted users.
	 *
	 * @return void
	 */
	public function inactiveAction()
	{
		$all = $this->users->query()
			->where('active IS NULL')
			->andWhere('deleted is NULL')
			->execute();
	 
		$this->theme->setTitle("Users that are inactive");
		$this->views->add('users/list-all', [
			'users' => $all,
			'title' => "Users that are inactive",
		]);
	}
	
	
	/**
	 * Inactivate user.
	 *
	 * @param integer $id of user to inactivate.
	 *
	 * @return void
	 */
	public function setInactiveAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
	 
		//$now = gmdate('Y-m-d H:i:s');
	 
		$user = $this->users->find($id);
	 
		$user->active = null;
		$user->save();
	 
		$url = $this->url->create('users/id/' . $id);
		$this->response->redirect($url);
	}
	
	
	/**
	 * Activate user.
	 *
	 * @param integer $id of user to activate.
	 *
	 * @return void
	 */
	public function setActiveAction($id = null)
	{
		if (!isset($id)) {
			die("Missing id");
		}
	 
		$now = gmdate('Y-m-d H:i:s');
	 
		$user = $this->users->find($id);
	 
		$user->active = $now;
		$user->save();
	 
		$url = $this->url->create('users/id/' . $id);
		$this->response->redirect($url);
	}
	
	
	/**
	 * List all inactive and not deleted users.
	 *
	 * @return void
	 */
	public function trashAction()
	{
		$all = $this->users->query()
			->where('deleted IS NOT NULL')
			->execute();
	 
		$this->theme->setTitle("Trashcan");
		$this->views->add('users/list-all', [
			'users' => $all,
			'title' => "Trashcan",
		]);
	}
	
	
	/**
	 * Login
	 *
	 */
	public function loginAction()
	{
		$form = $this->form->create([], [
			'acronym' => [
					'type'        => 'text',
					'label'       => 'Användarnamn',
					'required'    => true,
					'validation'  => ['not_empty'],
			],
			'password' => [ 
					'type'        => 'password', 
					'label'       => 'Lösenord', 
					'required'    => true, 
					'validation'  => ['not_empty'], 
			],
			'submit' => [
				'type'      => 'submit',
				'value'		=> 'Logga in',
				'callback'  => function ($form) {
					
					$acronym = $form->Value('acronym'); //set now
					$user = $this->users->findUser($acronym); //from database
					if(isset($user->acronym)) {
						if(password_verify($form->Value('password'), $user->password)) {
							$this->session->set('user', $user->acronym);
							$this->users->incLoggedOn($acronym);
							$url = $this->url->create('');
							$this->response->redirect($url);
						} else {
							$messages = "Fel lösenord.";
							$this->views->addString($messages);
						}
					} else {
						$messages = "Användarnamnet existerar inte.";
						$this->views->addString($messages);
					}
					
					return true;
				}
			],
		]);	
		
		// Check the status of the form
		$status = $form->check();
		 
		/*if ($status === true) {
		 
			// What to do if the form was submitted?
			$url = $this->url->create('users/id/' . $this->users->id); 
			$this->response->redirect($url);
		 
		} else if ($status === false) {
		 
			// What to do when form could not be processed?
			$form->AddOutput("Could not create user");
			$url = $this->url->create('users/add'); 
			$this->response->redirect($url);  
		}*/
		
		$this->theme->setTitle("Logga in");
		$this->views->add('users/login', [
			'title' => "Logga in",
			'content' => $form->getHTML()
		]);
	
	}
	
	/**
	 * Get session user
	 *
	 * @return user in session
	 */
	public function getSessionAction()
	{
		return $this->session->get('user');
	}
	
	
	/**
	 * Logout user
	 */
	public function logoutAction()
	{
		$this->session->set('user', null);
		
		$url = $this->url->create('');
        $this->response->redirect($url);
	}
	
	/**
	 * List most active users
	 */
	public function viewFirstAction()
	{
		$all = $this->users->findMostLoggedOn();
		$this->views->add('project/home-users', [
			'users' => $all,
		]);
	}
	
 
}