<!doctype html>
<html>
	<head>
		<title>{%?title} - BoxOnABudget {%?section}</title>
		<link rel="stylesheet" href="/static/css/style.css">
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<div class="logo">BoxOnABudget</div>
				<span class="menu">
					<div id="menu_blog" {%if section == "Blog"}class="active"{%/if}>
						<a class="section" href="/blog">Blog</a>
						<a href="/blog/tags">Tags</a>
						<a href="/blog/submit">Submit</a>
					</div>
					
					<div id="menu_forums" {%if section == "Forums"}class="active"{%/if}>
						<a class="section" href="/forums">Forums</a>
						<a href="/forums/inbox">Inbox</a>
						<a href="/forums/notifications">Notifications</a>
					</div>
					
					<div id="menu_account" {%if section == "Account"}class="active"{%/if}>
						{%if logged-in == true}
							<a class="section" href="/account">Account</a>
							<a href="/logout/{%?logout-key}">Log out</a>
						{%else}
							<a class="section" href="/sign-up">Sign up</a>
							<a href="/login">Log in</a>
						{%/if}
					</div>
				</span>
				<div class="clear"></div>
			</div>
			<div class="main">
				{%if isempty|notices == false}
					{%foreach notice in notices}
						<div class="notice">
							{%?notice}
						</div>
					{%/foreach}
				{%/if}
				{%if isempty|errors == false}
					<div class="errors">
						<span class="intro">One or more errors occurred:</span>
						<ul>
							{%foreach error in errors}
								<li>{%?error}</li>
							{%/foreach}
						</ul>
					</div>
				{%/if}
				{%?contents}
			</div>
			<div class="footer">
				BoxOnABudget is a non-commercial and ad-free site. <a href="/donate">Please donate!</a>
			</div>
		</div>
	</body>
</html>
