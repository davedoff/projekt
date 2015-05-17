<?php

namespace Anax\Answer;
 
/**
 * Model for Answers.
 *
 */
class Answer extends \Anax\MVC\CDatabaseModel
{
	/**
	 * Find and return a specific answer by id
	 *
	 * @return this
	 */
	public function findAnswer($idAnswer)
	{
		$this->db->select()
				 ->from($this->getSource())
				 ->where("idAnswer = ?");
				 
		$this->db->execute([$idAnswer]);
		return $this->db->fetchInto($this);
	}
	
}