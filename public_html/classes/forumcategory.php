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

class ForumCategory extends CPHPDatabaseRecordClass
{
	public $table_name = "forum_categories";
	public $fill_query = "SELECT * FROM forum_categories WHERE `Id` = :Id";
	public $verify_query = "SELECT * FROM forum_categories WHERE `Id` = :Id";
	
	public $prototype = array(
		'string' => array(
			'Name'			=> "Name"
		),
		'boolean' => array(
			'Visible'		=> "Visible"
		)
	);
	
	public function GetThreads($start = 0, $limit = 30)
	{
		return ForumPost::CreateFromQuery("SELECT * FROM forum_threads WHERE `CategoryId` = :CategoryId AND `Visible` = 1
		                                   ORDER BY `LastReplyDate` DESC LIMIT {$start},{$limit}",
			                           array(":CategoryId" => $this->sId));
	}
}
