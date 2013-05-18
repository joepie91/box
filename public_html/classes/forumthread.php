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

class ForumThread extends CPHPDatabaseRecordClass
{
	public $table_name = "forum_threads";
	public $fill_query = "SELECT * FROM forum_threads WHERE `Id` = :Id";
	public $verify_query = "SELECT * FROM forum_threads WHERE `Id` = :Id";
	
	public $prototype = array(
		'string' => array(
			'Topic'			=> "Topic",
			'Slug'			=> "Slug"
		),
		'numeric' => array(
			"CreatorId"		=> "CreatorId",
			"CategoryId"		=> "CategoryId",
			"PostCount"		=> "PostCount"
		),
		'boolean' => array(
			"Visible"		=> "Visible",
			"IsLocked"		=> "Locked",
			"IsPinned"		=> "Pinned"
		),
		'timestamp' => array(
			"CreationDate"		=> "CreationDate",
			"LastReplyDate"		=> "LastReplyDate"
		),
		'user' => array(
			"Creator"		=> "CreatorId"
		),
		'forumcategory' => array(
			"Category"		=> "CategoryId"
		)
	);
	
	public function GetPosts($start = 0, $limit = 15)
	{
		return ForumPost::CreateFromQuery("SELECT * FROM forum_posts WHERE `ThreadId` = :ThreadId AND `Visible` = 1 AND `LatestRevision` = 1
		                                   ORDER BY `PostedDate` ASC LIMIT {$start},{$limit}",
			                           array(":ThreadId" => $this->sId));
	}
	
	public function GetLastReply()
	{
		return ForumPost::CreateFromQuery("SELECT * FROM forum_posts WHERE `ThreadId` = :ThreadId AND `Visible` = 1 AND `LatestRevision` = 1
		                                   ORDER BY `PostedDate` DESC LIMIT 1",
			                           array(":ThreadId" => $this->sId), 30, true);
	}
	
	public function GenerateSlug()
	{
		return strtolower(
			preg_replace("/[^a-zA-Z0-9-]/", "", 
				preg_replace("/[ =_+]/", "-", 
					$this->uTopic
		)));
	}
	
	public function GetPostCount()
	{
		global $database;
		
		$result = $database->CachedQuery("SELECT COUNT(*) FROM forum_posts WHERE `Visible` = 1 AND `ThreadId` = :ThreadId", 
						 array(":ThreadId" => $this->sId), 0);

		return $result->data[0]["COUNT(*)"];
	}
	
	public function RecalculatePosts()
	{
		$sLastReply = $this->GetLastReply();
		$this->uLastReplyDate = $sLastReply->sPostedDate;
		$this->uPostCount = $this->GetPostCount();
	}
}
