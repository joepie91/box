<?php
/*
 * projectname is more free software. It is licensed under the WTFPL, which
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

class ForumFlag extends CPHPDatabaseRecordClass
{
	public $table_name = "forum_flags";
	public $fill_query = "SELECT * FROM forum_flags WHERE `Id` = :Id";
	public $verify_query = "SELECT * FROM forum_flags WHERE `Id` = :Id";
	
	public $prototype = array(
		'string' => array(
			'Reason'		=> "Reason"
		),
		'numeric' => array(
			"UserId"		=> "UserId",
			"PostId"		=> "PostId",
			"ModeratorId"		=> "ModeratorId"
		),
		'boolean' => array(
			"IsReviewed"		=> "Reviewed",
			"IsValid"		=> "Valid"
		),
		'timestamp' => array(
			"FlagDate"		=> "FlagDate",
			"ReviewDate"		=> "ReviewDate"
		),
		'user' => array(
			"User"			=> "UserId",
			"Moderator"		=> "ModeratorId"
		),
		'forumpost' => array(
			"Post"			=> "PostId"
		)
	);
}
