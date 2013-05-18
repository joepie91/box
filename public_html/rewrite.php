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

$_APP = true;
require("include/base.php");

$sPageTitle = "";
$sPageContents = "";

$router = new CPHPRouter();

$router->allow_slash = true;
$router->ignore_query = true;

$router->routes = array(
	0 => array(
		"^/$"							=> array(
			"target"	=> "modules/home.php",
			"_section"	=> "Home"
		),
		"^/blog$"						=> array(
			"target"	=> "modules/blog/home.php",
			"_section"	=> "Blog"
		),
		"^/blog/p([0-9]+)$"					=> array(
			"target"	=> "modules/blog/home.php",
			"_section"	=> "Blog"
		),
		"^/login$"						=> array(
			"target"	=> "modules/account/login.php",
			"_section"	=> "Account"
		),
		"^/logout/([a-zA-Z0-9]+)$"				=> array(
			"target"	=> "modules/account/logout.php",
			"_section"	=> "Account"
		),
		"^/account/confirm/(.+)/([a-zA-Z0-9]+)$"		=> array(
			"target"	=> "modules/account/confirm.php",
			"_section"	=> "Account"
		),
		"^/sign-up$"						=> array(
			"target"	=> "modules/account/signup.php",
			"_section"	=> "Account"
		),
		"^/forums$"						=> array(
			"target"	=> "modules/forums/home.php",
			"_section"	=> "Forums"
		),
		"^/forums/p([0-9]+)$"					=> array(
			"target"	=> "modules/forums/home.php",
			"_section"	=> "Forums"
		),
		"^/forums/post/([0-9]+)/[a-z0-9-]+$"			=> array(
			"methods"	=> "get",
			"target"	=> "modules/forums/permalink.php",
			"_section"	=> "Forums"
		),
		"^/forums/discussion/([0-9]+)/[a-z0-9-]+(/p([0-9]))?$"	=> array(
			"methods"	=> "get",
			"target"	=> "modules/forums/thread.php",
			"_section"	=> "Forums"
		),
		"^/forums/discussion/([0-9]+)/[a-z0-9-]+/reply$"	=> array(
			"methods"	=> "post",
			"target"	=> "modules/forums/reply.php",
			"authenticator"	=> "authenticators/user.php",
			"auth_error"	=> "modules/account/login.php",
			"_section"	=> "Forums"
		),
		"^/forums/create(/([0-9]+))?$"				=> array(
			"target"	=> "modules/forums/create.php",
			"authenticator"	=> "authenticators/user.php",
			"auth_error"	=> "modules/account/login.php",
			"_section"	=> "Forums"
		),
		"^/forums/inbox$"					=> array(
			"target"	=> "modules/forums/pm/home.php",
			"authenticator"	=> "authenticators/user.php",
			"auth_error"	=> "modules/account/login.php",
			"_section"	=> "Forums"
		),
		"^/forums/inbox/([0-9]+)$"				=> array(
			"methods"	=> "get",
			"target"	=> "modules/forums/pm/read.php",
			"authenticator"	=> "authenticators/user.php",
			"auth_error"	=> "modules/account/login.php",
			"_section"	=> "Forums"
		),
		"^/forums/inbox/([0-9]+)/reply$"			=> array(
			"methods"	=> "post",
			"target"	=> "modules/forums/pm/reply.php",
			"authenticator"	=> "authenticators/user.php",
			"auth_error"	=> "modules/account/login.php",
			"_section"	=> "Forums"
		),
		"^/forums/notifications$"				=> array(
			"target"	=> "modules/forums/notifications.php",
			"authenticator"	=> "authenticators/user.php",
			"auth_error"	=> "modules/account/login.php",
			"_section"	=> "Forums"
		)
	)
);

$router->RouteRequest();

echo(NewTemplater::Render("layout", $locale->strings, array(
	"title"		=> $sPageTitle,
	"section"	=> $router->uVariables["section"],
	"contents"	=> $sPageContents,
	"logout-key"	=> "test"
)));

