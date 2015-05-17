<?php

namespace Anax\Tag;
/**
 * A controller for tags.
 *
 */
class TagController implements \Anax\DI\IInjectionAware
{
	use \Anax\DI\TInjectable;
	
	/**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->tag = new \Anax\Tag\Tag();
        $this->tag->setDI($this->di);
    }
	
	
	/**
	 * List all tags
	 *
	 * @return void
	 */
	public function viewAction()
	{
		$all = $this->tag->findTags();
		$this->views->add('tag/list-all', [
			'tags' => $all,
		]);
	}
	
	/**
	 * Get tags by question id
	 *
	 * @param $id Question id
	 *
	 * @return $tags all tags related to the id
	 */
	public function getTagsIdQuestionAction($id = null)
	{
		if (!isset($id)) {
            die("Missing id");
        }
		
		$tags = $this->tag->query('tag')
            ->where("question_id = ?")
            ->execute([$id]);
        
		return $tags;
	}
	
	
	/**
	 * List the most popular tags
	 *
	 * @return void
	 */
	public function viewFirstAction()
	{
		$all = $this->tag->findPopTags();
		$this->views->add('project/home-tags', [
			'tags' => $all,
		]);
	}
	
	
	/**
	 * Delete a tag
	 *
	 * @param $id The tag you want to delete
	 *
	 * @return void
	 */
	public function deleteAction($id = null)
	{
		if (!isset($id)) {
            die("Missing id");
        }
		
		$url = $this->url->create('');
        $this->response->redirect($url);
	}
	
	
	/**
	 * Translate a tag string from the form and store the tags in a table
	 * 
	 * @param $tagString Tags to insert
	 * @param $id
	 *
	 * @return $tags As an array
	 */
	public function transformTagsAction($tagString, $id)
	{
		//makes the string lowercase
		$tagString = strtolower($tagString);
		
		//remove whitespaces
		$tagString = preg_replace('/\s+/', '', $tagString);
		
		//split the string by commas (,) into multiple tags and store all tags into an array
		$tags = explode(",", $tagString);
		
		//store all tags
		foreach($tags as $tag) {
			$tag = urldecode($tag);
			$this->tag->insertTags($tag, $id);
		}
		
		return $tags;
	}
	
	
	/**
	 * initalize table.
	 *
	 * @return void
	 */
	public function initAction()
	{
		$this->theme->setTitle("");
		$table = [
				'idTag' 		=> ['integer', 'primary key', 'not null', 'auto_increment'],
				'tag'			=> ['varchar(100)'],
				'question_id' 	=> ['integer'],
		];
		
		// Create table
		$this->tag->setupTable($table);
		
		$url = $this->url->create('tags'); 
		$this->response->redirect($url); 

	}
	
	
}