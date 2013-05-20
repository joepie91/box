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
	$sBlogPost = BlogPost::CreateFromQuery("SELECT * FROM blog_posts WHERE `Slug` = :Slug", array(":Slug" => $router->uParameters[1]), 60, true);
}
catch (NotFoundException $e)
{
	throw new RouterException("No such blog post exists.");
}

$sErrors = array();

if(empty($sCurrentUser) && (empty($_POST['name']) && empty($_POST['email'])))
{
	$sErrors[] = "You did not enter a valid name and/or e-mail address.";
}

if(empty($sCurrentUser) && !User::CheckIfEmailValid($_POST['email']))
{
	$sErrors[] = "The e-mail address you entered is invalid.";
}

if(empty($_POST['body']))
{
	$sErrors[] = "You can't post an empty comment!";
}

if(empty($sErrors))
{
	$sBlogComment = new BlogComment(0);

	$sBlogComment->uPostId = $sBlogPost->sId;
	$sBlogComment->uBody = $_POST['body'];
	$sBlogComment->uPostedDate = time();
	$sBlogComment->uVisible = true;

	if(!empty($sCurrentUser))
	{
		$sBlogComment->uIsGuestPost = false;
		$sBlogComment->uName = "";
		$sBlogComment->uEmailAddress = "";
		$sBlogComment->uAuthorId = $sCurrentUser->sId;
	}
	else
	{
		$sBlogComment->uIsGuestPost = true;
		$sBlogComment->uName = $_POST['name'];
		$sBlogComment->uEmailAddress = $_POST['email'];
		$sBlogComment->uAuthorId = 0;
	}
	
	$sBlogComment->InsertIntoDatabase();
	
	redirect("/blog/{$sBlogPost->sSlug}/#comment_{$sBlogComment->sId}");
}
else
{
	foreach($sErrors as $sError)
	{
		flash_error($sError);
	}
	
	redirect("/blog/{$sBlogPost->sSlug}/");
}
