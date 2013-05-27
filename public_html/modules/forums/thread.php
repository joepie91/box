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

$sPageNumber = empty($router->uParameters[3]) ? 1 : $router->uParameters[3];

try
{
	$sForumThread = new ForumThread($router->uParameters[1]);
}
catch (NotFoundException $e)
{
	throw new RouterException("No such thread.");
}


$per_page = 30;
$start = ($sPageNumber - 1) * $per_page;

$total_posts = $sForumThread->GetPostCount();
$total_pages = ceil($total_posts / $per_page);

try
{
	$result = $sForumThread->GetPosts($start, $per_page);
}
catch (NotFoundException $e)
{
	throw new RouterException("Specified page does not exist.");
}

$sForumPosts = array();

foreach($result as $sForumPost)
{
	$sForumPosts[] = array(
		"id"		=> $sForumPost->sId,
		"author"	=> $sForumPost->sAuthor->sUsername,
		"author-status"	=> $sForumPost->sAuthor->sIsBanned ? "Banned" : "Member",
		"body"		=> purify_html(Markdown($sForumPost->uBody)),
		"date"		=> time_ago($sForumPost->sPostedDate, $locale),
		"date-full"	=> local_from_unix($sForumPost->sPostedDate, $locale->datetime_long),
		"self"		=> (!empty($sCurrentUser) && $sForumPost->sAuthorId == $sCurrentUser->sId),
		"gravatar"	=> "https://secure.gravatar.com/avatar/" . md5(strtolower(trim($sForumPost->sAuthor->sEmailAddress))) . ".jpg?d=retro&s=40",
		"signature"	=> purify_html(Markdown($sForumPost->sAuthor->uSignature)),
		"permalink"	=> $sForumPost->GetPermalink()
	);
}

foreach(generate_pagination(1, $total_pages, $sPageNumber, 2, 3, 3) as $page)
{
	if($page === null)
	{
		$sPages[] = array('value' => false);
	}
	else
	{
		$sPages[] = array(
			'value' 	=> $page,
			'current' 	=> ($page == $sPageNumber)
		);
	}
}

$sPageTitle = $sForumThread->sTopic;
$sPageContents = NewTemplater::Render("forum/thread", $locale->strings, array(
	"id"			=> $sForumThread->sId,
	"slug"			=> $sForumThread->sSlug,
	"title"			=> $sForumThread->sTopic,
	"posts"			=> $sForumPosts,
	"pagination-first" 	=> ($sPageNumber == 1),
	"pagination-last"	=> ($sPageNumber == $total_pages),
	"previous-page"		=> ($sPageNumber - 1),
	"next-page"		=> ($sPageNumber + 1),
	"pages"			=> $sPages,
	"can-post"		=> ($sForumThread->sIsLocked == false)
));
