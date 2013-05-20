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

try
{
	$result = BlogComment::CreateFromQuery("SELECT * FROM blog_comments WHERE `PostId` = :PostId AND `Visible` = 1 ORDER BY `Posted` ASC", array(":PostId" => $sBlogPost->sId));
}
catch (NotFoundException $e)
{
	$result = array();
}

$sComments = array();

foreach($result as $sComment)
{
	if($sComment->sIsGuestPost)
	{
		$sAuthorName = $sComment->sName;
		$sEmailAddress = $sComment->sEmailAddress;
	}
	else
	{
		$sAuthorName = $sComment->sAuthor->sUsername;
		$sEmailAddress = $sComment->sAuthor->sEmailAddress;
	}
	
	$sComments[] = array(
		"author"	=> $sAuthorName,
		"relative-date"	=> time_ago($sComment->sPostedDate, $locale),
		"body"		=> Markdown($sComment->sBody),
		"gravatar"	=> "https://secure.gravatar.com/avatar/" . md5(strtolower(trim($sEmailAddress))) . ".jpg?d=retro&s=40",
		"id"		=> $sComment->sId
	);
}

$sPageTitle = $sBlogPost->sTitle;
$sPageContents = NewTemplater::Render("blog/post", $locale->strings, array(
	"title"		=> $sBlogPost->sTitle,
	"body"		=> Markdown($sBlogPost->sBody),
	"author"	=> $sBlogPost->sAuthor->sUsername,
	"relative-date"	=> time_ago($sBlogPost->sPostedDate, $locale),
	"thumbnail"	=> $sBlogPost->sThumbnail,
	"tags"		=> "test1, test2, test3",
	"comments"	=> $sComments,
	"slug"		=> $sBlogPost->sSlug
));
