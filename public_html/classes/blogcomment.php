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

class BlogComment extends CPHPDatabaseRecordClass
{
	public $table_name = "blog_comments";
	public $fill_query = "SELECT * FROM blog_comments WHERE `Id` = :Id";
	public $verify_query = "SELECT * FROM blog_comments WHERE `Id` = :Id";
	
	public $prototype = array(
		'string' => array(
			'Body'			=> "Body",
			'Name'			=> "Name",
			'EmailAddress'		=> "EmailAddress"
		),
		'numeric' => array(
			"AuthorId"		=> "UserId",
			"PostId"		=> "PostId",
			"ParentId"		=> "ParentId"
		),
		'timestamp' => array(
			"PostedDate"		=> "Posted"
		),
		'boolean' => array(
			"Visible"		=> "Visible",
			"IsGuestPost"		=> "GuestPost"
		),
		'user' => array(
			"Author"		=> "UserId"
		),
		'blogpost' => array(
			"Post"			=> "PostId"
		),
		'blogcomment' => array(
			"Parent"		=> "ParentId"
		)
	);
}
