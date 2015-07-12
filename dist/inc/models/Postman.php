<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/models/Post.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/models/Posts.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/models/Category.php');

class PostMan
{
	private $db;
	public $postsPerPage;
	public $currentPageNum;

	public function __construct($db)
	{
		$this->db = $db;
		$this->currentPageNum = (isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 1;
		$this->postsPerPage = 5;
	}

	private function queryPosts($includeUnpublished)
	{
		$stmtText = $this->prepareQueryPostStatement("",$includeUnpublished);

		$stmt = $this->db->prepare($stmtText);

		if ($stmt->execute())
		{
			$posts = new Posts($this->db, $this->postsPerPage, $this->currentPageNum);

			$posts->addPosts($stmt->get_result());
			$posts->getTotalPosts($includeUnpublished);

			return $posts;
		}
		else
		{
			die('There was an error running the query [' . $db->error . ']');
		}
	}

	private function queryPost($slug, $includeUnpublished)
	{
		$pSql = "SELECT * FROM posts p where p.";

		if(is_numeric($slug))
		{
			$pSql .= "post_id";
		}
		else
		{
			$slug = strtolower($slug);
			$pSql .= "post_slug";
		}

		$pSql .= " = ?";

		if($includeUnpublished == false)
		{
			$pSql .= " AND p.date_published IS NOT NULL";
		} 

		$pSql .= " limit 1";
		
		$pStmt = $this->db->prepare($pSql);
		$pStmt->bind_param("s", $slug);

		if ($pStmt->execute())
		{
			$result     = $pStmt->get_result();

			if($result->num_rows === 0) return null;

			$result_obj = $result->fetch_object();

			if($result_obj === null) return null;

			return new Post($result_obj, $this->db);
		}
		else
		{
			die('There was an error running the query [' . $db->error . ']');
		}
	}

	private function queryPostsInCategory($slug)
	{
		//convert slug to number
		if(!is_numeric($slug))
		{
			$slug = $this->categorySlugToId($slug);
		}

		if(!$slug) return null;

		$categoryNameResult = $this->getCategoryName($slug);

		if(!$categoryNameResult) return null;

		$pSql = $this->prepareQueryPostStatement("JOIN posts_categories pc on pc.post_id = p.post_id WHERE pc.category_id = ?");

		$pStmt = $this->db->prepare($pSql);
		$pStmt->bind_param("s", $slug);

		if ($pStmt->execute())
		{
			$category = new Category($this->db, $this->postsPerPage, $this->currentPageNum, $categoryNameResult->fetch_object());
			
			$category->postsPerPage = $this->postsPerPage;
			$category->addPosts($pStmt->get_result());
			$category->getTotalPostsInCategory();

			return $category;
		}
		else
		{
			die('There was an error running the query [' . $db->error . ']');
		}

	}

	//utility methods

	//add pagination / limits to posts list queries
	private function prepareQueryPostStatement($stmtText = "", $includeUnpublished = false)
	{
		$stmtText = "SELECT p.post_id, p.title, p.subtitle, p.post_slug, p.timestamp, p.date_published FROM posts p " . $stmtText;

		if($includeUnpublished == false)
		{
			$stmtText .= (strrpos($stmtText, 'WHERE')) ? " AND" : " WHERE";
			$stmtText .= " p.date_published IS NOT NULL";
		}

		$stmtText .= " order by p.date_published desc";

		if($this->postsPerPage > 0)
		{
			$stmtText .= ' limit ' . $this->postsPerPage;

			$stmtText .= ' offset ' . (($this->currentPageNum - 1) * $this->postsPerPage);
		}

		return $stmtText;
	}

	public function getAllCategories()
	{
		$pSql  = "SELECT category_name from categories";

		$pStmt = $this->db->prepare($pSql);

		if($pStmt->execute())
		{
			$result    = $pStmt->get_result();

			while($result_obj = $result->fetch_object())
			{
				$allCategories[] = $result_obj;
			}

			return $allCategories;
		}
		else
		{
			die('There was an error running the query [' . $db->error . ']');
		}
	}

	private function categorySlugToId($slug)
	{
		$slug  = strtolower($slug);
		$pSql  = "SELECT category_id from categories where category_slug = ? limit 1";

		$pStmt = $this->db->prepare($pSql);
		$pStmt->bind_param("s", $slug);

		if($pStmt->execute())
		{
			$result    = $pStmt->get_result();
			$resultObj = $result->fetch_object();

			if($resultObj && $resultObj->category_id) return $resultObj->category_id;

			return null;
		}
		else
		{
			die('There was an error running the query [' . $db->error . ']');
		}
	}

	private function getCategoryName($slug)
	{
		$catNameSql  = "SELECT * FROM categories WHERE category_id = ? LIMIT 1";
		$catNameStmt = $this->db->prepare($catNameSql);
		$catNameStmt->bind_param("s", $slug);

		if($catNameStmt->execute())
		{
			$categoryNameResult = $catNameStmt->get_result();

			if($categoryNameResult->num_rows === 0)
			{
				return null;
			}

			return $categoryNameResult;
		}
		else
		{
			die('There was an error running the query [' . $db->error . ']');
		}
	}

	//getters
	public function getPostsInCategory($category_slug)
	{
		return $this->queryPostsInCategory($category_slug);
	}

	public function getPosts($includeUnpublished = false)
	{
		return $this->queryPosts($includeUnpublished);
	}

	public function getPostBySlug($slug, $includeUnpublished = false)
	{
		return $this->queryPost($slug, $includeUnpublished);
	}
}