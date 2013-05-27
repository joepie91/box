<h1>Create new thread</h1>
<form method="post" action="">
	<div class="field">
		<label for="inp_topic">Thread title</label>
		{%input name="topic" id="inp_topic"}
		<div class="clear"></div>
	</div>
	
	<div class="field">
		<label for="inp_category">Category</label>
		{%select name="category" id="inp_category"}
			{%foreach category in categories}
				{%option text="(?category[name])" value="(?category[id])"}
			{%/foreach}
		{%/select}
		<div class="clear"></div>
	</div>
	
	<div class="field">
		<textarea name="body" id="input_body"></textarea>
	</div>
	
	<div class="field">
		<div class="subtext">You can use <a href="http://static.squarespace.com/static/50060af484ae2a1f638413cb/5025cecce4b0922760c3c438/5025cecce4b0922760c3c43a/1304275182573/">Markdown</a> and <a href="http://michelf.ca/projects/php-markdown/extra/">Markdown Extra</a>.</div>
		<button type="submit" class="post">Create thread</button>
		<button type="button" class="submit preview markdown-preview" data-preview-source="input_body">Preview</button>
		<div class="clear"></div>
	</div>
</form>
