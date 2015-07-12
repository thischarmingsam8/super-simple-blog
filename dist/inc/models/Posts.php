<?php

class Posts
{
	public $posts;
	public $totalPosts;
	public $postsPerPage;
	public $currentPageNum;
	public $pageAmount;

	protected $db;

	public function __construct($db, $postsPerPage, $currentPageNum)
	{
		$this->db             = $db;
		$this->postsPerPage   = $postsPerPage;
		$this->currentPageNum = $currentPageNum;
		$this->pageAmount     = 0;
	}

	public function addPosts($postsData)
	{
		$this->posts = array();

		while($postData = $postsData->fetch_object())
		{
			$this->posts[] = new Post($postData, $this->db);
		}
	}

	public function getTotalPosts($includeUnpublished = false)
	{
		$stmtText = "SELECT COUNT(*) as total FROM posts p";

		if($includeUnpublished == false)
		{
			$stmtText .= " WHERE p.date_published IS NOT NULL";
		}

		$stmt = $this->db->prepare($stmtText);

		if ($stmt->execute())
		{
			$result = $stmt->get_result();
			$result_obj = $result->fetch_object();

			$this->totalPosts = $result_obj->total;

			if($this->postsPerPage > 0 && $this->totalPosts > 0)
			{
				$this->pageAmount = ceil($this->totalPosts / $this->postsPerPage);
			}

		}
		else
		{
			die('There was an error running the query [' . $this->db->error . ']');
		}
	}
}