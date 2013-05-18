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
	$sUser = User::CreateFromQuery("SELECT * FROM users WHERE `EmailAddress` = :EmailAddress AND `ActivationKey` = :ActivationKey AND `Activated` = 0", 
		array(":EmailAddress" => $router->uParameters[1], ":ActivationKey" => $router->uParameters[2]), 0, true);
	$sUser->uIsActivated = true;
	$sUser->InsertIntoDatabase();
	
	$sUser->Authenticate();
	
	flash_notice("Your account was successfully activated. Welcome on board!");
	redirect("/");
}
catch (NotFoundException $e)
{
	/* No user or subscription with this e-mail address and verification key exists. Bail out.
	 * We'll throw a RouterException so that we only have to deal with 404s in one place. */
	throw new RouterException("Confirmation key not found.");
}
