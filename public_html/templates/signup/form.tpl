<form class="narrow" method="post" action="/sign-up">
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
	
	<h1>Sign up</h1>
	
	<div class="field">
		<label for="inp_username">Username</label>
		{%input name="username" id="inp_username"}
		<div class="clear"></div>
	</div>
	
	<div class="field">
		<label for="inp_email">E-mail address</label>
		{%input name="email" id="inp_email"}
		<div class="clear"></div>
	</div>
	
	<div class="field">
		<label for="inp_password">Password</label>
		{%input type="password" name="password" id="inp_password"}
		<div class="clear"></div>
	</div>
	
	<div class="field">
		<label for="inp_password2">Password (again)</label>
		{%input type="password" name="password2" id="inp_password2"}
		<div class="clear"></div>
	</div>
	
	<div class="field">
		<button type="submit" class="submit">Sign up</button>
		<div class="clear"></div>
	</div>
</form>
