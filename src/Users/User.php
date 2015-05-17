<?php

namespace Anax\Users;
 
/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{
	
	/**
	 * Find and return a specific user by acronym
	 *
	 * @return this
	 */
	public function findUser($acronym)
	{
		$this->db->select()
				 ->from($this->getSource())
				 ->where("acronym = ?");
				 
		$this->db->execute([$acronym]);
		return $this->db->fetchInto($this);
	}
	
	
	/**
	 * Find and return the user that has been logged in most times
	 */
	public function findMostLoggedOn()
	{
		$sql = "SELECT * FROM user ORDER BY timesLoggedOn DESC LIMIT 3;";
		$this->db->execute($sql);
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}
	
	
	/**
	 * Check if logged in
	 */
	public function checkLogin()
	{
		if(isset($_SESSION['user'])) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	 * Increment times logged in.
	 */
	public function incLoggedOn($acronym)
	{
		$sql = "UPDATE user SET timesLoggedOn = timesLoggedOn + 1 WHERE acronym = '{$acronym}';";
		//$sql = "UPDATE user SET timesLoggedOn = timesLoggedOn + 1 WHERE acronym = ?;"; 
		$this->db->execute($sql);
	}
	
}