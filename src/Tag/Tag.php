<?php
namespace Anax\Tag;
/**
 * Model for Tags.
 *
 */
class Tag extends \Anax\MVC\CDatabaseModel
{
	
	/**
	 * Find and return all tags
	 *
	 * @return all tags
	 */
	public function findTags()
	{
		$sql = "SELECT DISTINCT tag FROM tag;";
		$this->db->execute($sql);
		return $this->db->fetchAll();
	}
	
	
	/**
	 * find and return the most popular tags
	 *
	 * @return top 10 tags
	 */
	public function findPopTags()
	{
		$sql = "SELECT tag, count(*) as num from tag group by tag order by num desc limit 10;";
		$this->db->execute($sql);
		$this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}
	
	
	/**
	 * Insert a tag
	 *
	 * @param $tag
	 * @param $id
	 *
	 * @return void
	 */
	public function insertTags($tag, $id)
	{
		$sql = "insert into tag (tag, question_id) values ('{$tag}', {$id});";
		
		//$sql = "insert into tag (question_id) values ({$id});";
		$this->db->execute($sql);
	}
	
	
	/**
	 * Delete tag by question id
	 *
	 * @param $id Question id
	 *
	 * @return void
	 */
	public function deleteTagIdQuestion($id)
	{
		$sql = "DELETE FROM tag WHERE question_id = $id;";
        $this->db->execute($sql);
	}
	
}