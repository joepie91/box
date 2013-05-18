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
 
if(empty($_APP)) { die("Unauthorized."); }

$uLogoutKey = $router->uParameters[1];

if(!empty($_SESSION['logout_key']) && $_SESSION['logout_key'] == $uLogoutKey)
{
	unset($_SESSION['user_id']);
	unset($_SESSION['logout_key']);
	
	flash_notice("You have been logged out.");
	redirect("/");
}
else
{
	throw new RouterException("No valid logout key specified.");
}
