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

try
{
	$sForumThread = new ForumThread($router->uParameters[1]);
}
catch (NotFoundException $e)
{
	throw new RouterException("No such thread.");
}

if(empty($_POST['body']) || trim($_POST['body']) == "")
{
	flash_error("You can't post an empty reply.");
	redirect("/forums/discussion/{$sForumThread->sId}/{$sForumThread->sSlug}");
}

if($sForumThread->sIsLocked === true)
{
	flash_error("You can't post replies to a locked discussion.");
	redirect("/forums/discussion/{$sForumThread->sId}/{$sForumThread->sSlug}");
}

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

$sForumThread->RecalculatePosts();
$sForumThread->InsertIntoDatabase();

redirect($sForumPost->GetPermalink());
