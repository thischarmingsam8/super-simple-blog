<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/config.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/inc/models/Postman.php';

$pat = new Postman($db);

$categoryNames = array_map(function($category)
{
	return $category->category_name;

},$pat->getAllCategories());

header('Content-Type: application/json');
echo json_encode($categoryNames);

?>