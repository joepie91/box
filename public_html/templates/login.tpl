<form class="narrow" method="post" action="/login">
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
	
	<h1>Log in</h1>
	
	<div class="field">
		<label for="inp_username">Username</label>
		{%input name="username" id="inp_username"}
		<div class="clear"></div>
	</div>
	
	<div class="field">
		<label for="inp_password">Password</label>
		{%input type="password" name="password" id="inp_password"}
		<div class="clear"></div>
	</div>
	
	<div class="field">
		<button type="submit" class="submit">Log in</button>
		<div class="clear"></div>
	</div>
</form>
