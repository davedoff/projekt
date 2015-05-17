<?php

namespace Anax\Question;
 
/**
 * Model for Comments.
 *
 */
class Question extends \Anax\MVC\CDatabaseModel
{
	/**
     * Gets the 5 latest questions order by the time of creation.
     *
     * @return void
     */
	public function findLatestQuestions()
	{
		$sql = "SELECT * FROM question ORDER BY created DESC LIMIT 5;";
		$this->db->execute($sql);
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}
	
}