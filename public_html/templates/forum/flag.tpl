<!doctype html>
	<head>
		<title>Flag post</title>
		<link rel="stylesheet" href="/static/css/flag.css?2">
	</head>
	<body>
		<h1>Flag abusive post</h1>
		
		{%if done == false}
			<blockquote>
				{%?snippet}
			</blockquote>
			
			<p>
				If you believe this post violates the community
				rules or should otherwise be removed, please fill
				in a reason or explanation below and hit the Flag
				button.
			</p>
			
			<p>
				We ask that you only flag posts that genuinely
				break the community rules or are problematic
				otherwise; we will not solve your personal conflicts,
				and false reports will be ignored.
			</p>
			
			<form method="post">
				<div class="field">
					<label>Reason:</label>
					<input name="reason">
					<button type="submit">Flag</button>
				</div>
			</form>
		{%else}
			<p>
				Thanks for your report! A moderator will review it soon.
			</p>
		{%/if}
	</body>
</html>
