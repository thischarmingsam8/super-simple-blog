<?php

class Category extends Posts
{
	public $id;
	public $name;
	public $slug;

	public function __construct($db, $postsPerPage, $currentPageNum, $data)
	{
		parent::__construct($db, $postsPerPage, $currentPageNum);

		$this->id   = $data->category_id;
		$this->name = $data->category_name;
		$this->slug = $data->category_slug;
	}

	public function getTotalPostsInCategory()
	{
		$stmtText = "SELECT COUNT(p.post_id) as total FROM posts p JOIN posts_categories pc on pc.post_id = p.post_id WHERE pc.category_id = ? AND p.date_published IS NOT NULL";

		$stmt = $this->db->prepare($stmtText);
		$stmt->bind_param("s", $this->id);

		if ($stmt->execute())
		{
			$result = $stmt->get_result();
			$result_obj = $result->fetch_object();

			$this->totalPosts = $result_obj->total;

			$this->pageAmount = ceil($this->totalPosts / $this->postsPerPage);
		}
		else
		{
			die('There was an error running the query [' . $this->db->error . ']');
		}
	}
}
