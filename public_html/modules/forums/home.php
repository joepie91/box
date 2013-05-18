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

$current_page = empty($router->uParameters[1]) ? 1 : (int) $router->uParameters[1];
$current_page = ($current_page < 1) ? 1 : $current_page;

$per_page = 10;
$start = ($current_page - 1) * $per_page;

$result = $database->CachedQuery("SELECT COUNT(*) FROM forum_threads WHERE `Visible` = 1");
$total_threads = $result->data[0]["COUNT(*)"];
$total_pages = ceil($total_threads / $per_page);

$sThreads = array();

try
{
	$result = ForumThread::CreateFromQuery("SELECT * FROM forum_threads WHERE `Visible` = 1 ORDER BY `Pinned` DESC, `LastReplyDate` DESC LIMIT {$start},{$per_page}");
}
catch (NotFoundException $e)
{
	$result = array();
}

foreach($result as $sThread)
{
	try
	{
		$sLastReply = $sThread->GetLastReply();
		$sLatest = $sLastReply->sAuthor->sUsername;
	}
	catch (NotFoundException $e)
	{
		$sLatest = "";
	}
	
	$sThreads[] = array(
		"title"		=> $sThread->sTopic,
		"replies"	=> $sThread->sPostCount - 1,
		"latest"	=> $sLatest,
		"gravatar"	=> "https://secure.gravatar.com/avatar/" . md5(strtolower(trim($sThread->sCreator->sEmailAddress))) . ".jpg?d=retro&s=40",
		"id"		=> $sThread->sId,
		"slug"		=> $sThread->sSlug,
		"pinned"	=> $sThread->sIsPinned,
		"locked"	=> $sThread->sIsLocked
	);
}

$sPages = array();

foreach(generate_pagination(1, $total_pages, $current_page, 2, 3, 3) as $page)
{
	if($page === null)
	{
		$sPages[] = array('value' => false);
	}
	else
	{
		$sPages[] = array(
			'value' 	=> $page,
			'current' 	=> ($page == $current_page)
		);
	}
}

$sPageTitle = "Overview";
$sPageContents = NewTemplater::Render("forum/home", $locale->strings, array(
	"threads"		=> $sThreads,
	"pagination-first" 	=> ($current_page == 1),
	"pagination-last"	=> ($current_page == $total_pages),
	"previous-page"		=> ($current_page - 1),
	"next-page"		=> ($current_page + 1),
	"pages"			=> $sPages
));
