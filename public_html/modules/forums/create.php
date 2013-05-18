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

if(strtolower($_SERVER["REQUEST_METHOD"]) == "post")
{
	/* Form submission */
	if(empty($_POST['topic']) || trim($_POST['topic']) == "")
	{
		flash_error("You did not enter a thread title.");
	}
	
	if(empty($_POST['body']) || trim($_POST['body']) == "")
	{
		flash_error("Your post can't be empty.");
	}
	
	if(empty($_POST['category']))
	{
		flash_error("You did not select a category.");
	}
	
	try
	{
		$sCategory = new ForumCategory($_POST['category']);
	}
	catch (NotFoundException $e)
	{
		flash_error("The category you selected does not exist (anymore).");
	}
	
	if(count(get_errors(false)) == 0)
	{
		$sForumThread = new ForumThread(0);
		$sForumThread->uTopic = $_POST['topic'];
		$sForumThread->uSlug = $sForumThread->GenerateSlug();
		$sForumThread->uCategoryId = $_POST['category'];
		$sForumThread->uCreatorId = $sCurrentUser->sId;
		$sForumThread->uPostCount = 0;
		$sForumThread->uCreationDate = time();
		$sForumThread->uLastReplyDate = time();
		$sForumThread->uVisible = true;
		$sForumThread->InsertIntoDatabase();
		
		$sForumPost = new ForumPost(0);
		$sForumPost->uThreadId = $sForumThread->sId;
		$sForumPost->uBody = $_POST['body'];
		$sForumPost->uAuthorId = $sCurrentUser->sId;
		$sForumPost->uRevision = 1;
		$sForumPost->uVisible = true;
		$sForumPost->uLatestRevision = true;
		$sForumPost->uPostedDate = time();
		$sForumPost->uLastEditedDate = time();
		$sForumPost->uEditExpiry = time() + (24 * 60 * 60);
		$sForumPost->InsertIntoDatabase();
		
		$sForumThread->uPostCount = 1;
		$sForumThread->InsertIntoDatabase();
		
		redirect("/forums/discussion/{$sForumThread->sId}/{$sForumThread->sSlug}");
	}
}

$sCategories = array();

try
{
	$result = ForumCategory::CreateFromQuery("SELECT * FROM forum_categories WHERE `Visible` = 1");
}
catch (NotFoundException $e)
{
	$result = array();
}

foreach($result as $sCategory)
{
	$sCategories[] = array(
		"id"	=> $sCategory->sId,
		"name"	=> $sCategory->sName
	);
}

$sPageTitle = "Create new thread";
$sPageContents = NewTemplater::Render("forum/create", $locale->strings, array(
	"categories"	=> $sCategories
));
