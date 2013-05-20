<div class="entry">
	<h1>{%?title}</h1>
	<img src="{%?thumbnail}">
	<div class="metadata">
		<span class="date">{%?relative-date}</span>, by
		<span class="author">{%?author}</span>
		<span class="tags">Tags: {%?tags}</span>
	</div>
	{%?body}
</div>

<div class="comments">
	<h2>Comments</h2>
	{%if isempty|comments == true}
		No comments have been posted yet.
	{%else}
		{%foreach comment in comments}
			<div class="comment">
				<a name="comment_{%?comment[id]}"></a>
				<img src="{%?comment[gravatar]}" class="gravatar">
				<div class="metadata">
					<span class="author">{%?comment[author]}</span>
					<span class="date">{%?comment[relative-date]}</span>
				</div>
				{%?comment[body]}
			</div>
		{%/foreach}
	{%/if}
	
	<h2>Post a new comment</h2>
	<div class="commentform">
		<form method="post" action="/blog/{%?slug}/comment">
			{%if logged-in == false}
				<label>Name</label>
				<input type="text" name="name">
				
				<label>E-mail address</label>
				<input type="text" name="email">
				
				<div class="clear"></div>
			{%/if}
			
			<div class="field">
				<textarea class="body" name="body"></textarea>
			</div>
			
			<div class="subtext">
				You can use <a href="http://static.squarespace.com/static/50060af484ae2a1f638413cb/5025cecce4b0922760c3c438/5025cecce4b0922760c3c43a/1304275182573/">Markdown</a>.
			</div>
			
			<button class="submit" type="submit" name="submit">Post comment</button>
			<button class="submit preview" type="submit" name="submit">Preview</button>
			<div class="clear"></div>
		</form>
	</div>
</div>
