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

class ForumPost extends CPHPDatabaseRecordClass
{
	public $table_name = "forum_posts";
	public $fill_query = "SELECT * FROM forum_posts WHERE `Id` = :Id";
	public $verify_query = "SELECT * FROM forum_posts WHERE `Id` = :Id";
	
	public $prototype = array(
		'none' => array(
			'Body'			=> "Body"
		),
		'numeric' => array(
			'AuthorId'		=> "AuthorId",
			'ThreadId'		=> "ThreadId",
			'Revision'		=> "Revision"
		),
		'boolean' => array(
			"Visible"		=> "Visible",
			"LatestRevision"	=> "LatestRevision"
		),
		'timestamp' => array(
			"PostedDate"		=> "PostedDate",
			"LastEditedDate"	=> "LastEditedDate",
			"EditExpiry"		=> "EditExpiry"
		),
		'user' => array(
			'Author'		=> "AuthorId"
		),
		'forumthread' => array(
			"Thread"		=> "ThreadId"
		)
	);
	
	public function GetPermalink()
	{
		return "/forums/post/{$this->sId}/{$this->sThread->sSlug}";
	}
	
	public function GetPage()
	{
		global $database;
		
		/* How many posts before this post in the thread? */
		$result = $database->CachedQuery("SELECT COUNT(*) FROM forum_posts WHERE `ThreadId` = :ThreadId AND `Id` < :Id",
		                                 array(":ThreadId" => $this->sThreadId, ":Id" => $this->sId));
		$total_posts = $result->data[0]["COUNT(*)"];
		
		return ($total_posts == 0) ? 1 : ceil(($total_posts + 1) / 30);
	}
}
