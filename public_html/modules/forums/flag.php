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
	$sForumPost = new ForumPost($router->uParameters[1]);
}
catch (NotFoundException $e)
{
	die("No such post exists.");
}

$done = false;

if(strtolower($_SERVER['REQUEST_METHOD']) == "post")
{
	$sForumPost->Flag($sCurrentUser->sId, $_POST['reason']);
	$done = true;
}

echo(NewTemplater::Render("forum/flag", $locale->strings, array(
	"snippet"	=> purify_html(Markdown(cut_text($sForumPost->uBody, 500))),
	"done"		=> $done
)));
