<?php
/*
 * Box is more free software. It is licensed under the WTFPL, which
 * allows you to do pretty much anything with it, without having to
 * ask permission. Commercial use is allowed, and no attribution is
 * required. We do politely request that you share your modifications
 * to benefit other developers, but you are under no enforced
 * obligation to do so :)
 * 
 * Please read the accompanying LICENSE document for the full WTFPL
 * licensing text.
 */
 
if(!isset($_APP)) { die("Unauthorized."); }

class BlogPost extends CPHPDatabaseRecordClass
{
	public $table_name = "blog_posts";
	public $fill_query = "SELECT * FROM blog_posts WHERE `Id` = :Id";
	public $verify_query = "SELECT * FROM blog_posts WHERE `Id` = :Id";
	
	public $prototype = array(
		'string' => array(
			'Title'			=> "Title",
			'Body'			=> "Body",
			'Slug'			=> "Slug"
		),
		'numeric' => array(
			'Views'			=> "Views",
			'AuthorId'		=> "UserId"
		),
		'timestamp' => array(
			"PostedDate"		=> "Posted",
			"LastEditedDate"	=> "LastEdited"
		),
		'boolean' => array(
			"Visible"		=> "Visible"
		),
		'user' => array(
			"Author"		=> "UserId"
		)
	);
	
	public function GenerateSlug()
	{
		return strtolower(
			preg_replace("/[^a-zA-Z0-9-]/", "", 
				preg_replace("/[ =_+]/", "-", 
					$this->uTitle
		)));
	}
}
