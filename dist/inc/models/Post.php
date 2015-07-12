<?php

class Post
{
	public $id             = 0;
	public $slug           = "";
	public $body           = "";
	public $title          = "";
	public $subtitle       = "";
	public $date_published = null;
	public $timestamp      = null;

	public $categories = array();

	public function __construct($data = null, $db = null)
	{
		if($data != null)
		{
			$this->id             = $data->post_id;
			$this->slug           = $data->post_slug;
			$this->title          = $data->title;
			$this->subtitle       = $data->subtitle;
			$this->timestamp      = date_format(date_create($data->date_published), 'jS F Y');

			$this->date_published = (isset($data->date_published)) ? date_format(date_create($data->date_published), 'jS F Y') : null;

			$this->body     = (isset($data->body)) ? $data->body : null;

			$this->populateCategories($db);
		}
	}

	public function hasSubtitle()
	{
		return strlen($this->subtitle) > 0;
	}

	public function isPublished()
	{
		return $this->date_published != null;
	}

	public function populateCategories($db)
	{
		$catStmt = $db->prepare("SELECT categories.category_slug, categories.category_name FROM posts_categories JOIN categories ON posts_categories.category_id = categories.category_id WHERE posts_categories.post_id = ?");
		$catStmt->bind_param("s", $this->id);

		if($catStmt->execute())
		{
			$categories       = $catStmt->get_result();

			while($category = $categories->fetch_assoc())
			{
				$this->categories[] = $category;
			}
		}
	}
}