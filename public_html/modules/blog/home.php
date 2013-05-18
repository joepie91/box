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

$per_page = 5;
$start = ($current_page - 1) * $per_page;

$result = $database->CachedQuery("SELECT COUNT(*) FROM blog_posts WHERE `Visible` = 1");
$total_posts = $result->data[0]["COUNT(*)"];
$total_pages = ceil($total_posts / $per_page);

$sPosts = array();

try
{
	$result = BlogPost::CreateFromQuery("SELECT * FROM blog_posts WHERE `Visible` = 1 ORDER BY `Posted` DESC LIMIT {$start},{$per_page}");
}
catch (NotFoundException $e)
{
	$result = array();
}

foreach($result as $sBlogPost)
{
	$sPosts[] = array(
		"title"		=> $sBlogPost->sTitle,
		"author"	=> $sBlogPost->sAuthor->sUsername,
		"relative-date"	=> time_ago($sBlogPost->sPostedDate, $locale),
		"teaser"	=> Markdown(cut_text($sBlogPost->sBody, 1000)),
		"thumbnail"	=> $sBlogPost->sThumbnail,
		"tags"		=> "test1, test2, test3",
		"url"		=> "/blog/{$sBlogPost->sSlug}"
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

$sPageTitle = "Latest posts";
$sPageContents = NewTemplater::Render("blog/home", $locale->strings, array(
	"entries"		=> $sPosts,
	"pagination-first" 	=> ($current_page == 1),
	"pagination-last"	=> ($current_page == $total_pages),
	"previous-page"		=> ($current_page - 1),
	"next-page"		=> ($current_page + 1),
	"pages"			=> $sPages
));
