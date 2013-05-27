<div class="sidebar">
	<a href="/forums/create" class="button large" id="button_newthread">Create new thread</a>
	<div class="clear"></div>
</div>

<div class="contents">
	<h2>{%?title}</h2>

	{%foreach post in posts}
		<div class="post {%if post[self] == true}self{%/if}">
			<a name="post_{%?post[id]}"></a>
			<div class="main">
				<div class="metadata">
					<img src="{%?post[gravatar]}" class="avatar">
					<div class="primary">
						<span class="author">{%?post[author]}</span>
						<form style="display: none;" id="csrf_form_{%?post[id]}"></form>
						<a class="date" href="{%?post[permalink]}">{%?post[date]}</a>
						<a class="thanks" href="#" target="_blank" data-id="{%?post[id]}">Thanks</a>
						<a class="flag" href="/forums/flag/{%?post[id]}" target="_blank" data-id="{%?post[id]}">Flag</a>
					</div>
					<div class="status">{%?post[author-status]}</div>
				</div>
				<div class="clear"></div>
				<div class="body">
					{%?post[body]}
				</div>
			</div>
			<div class="signature">{%?post[signature]}</div>
		</div>
	{%/foreach}

	<div class="pagination line">
		{%if pagination-first == false}
			<a href="/forums/p{%?previous-page}" class="previous">&lt;</a>
		{%/if}
		
		{%foreach page in pages}
			<a href="/forums/p{%?page[value]}" {%if page[current] == true}class="current"{%/if}>{%?page[value]}</a>
		{%/foreach}
		
		{%if pagination-last == false}
			<a href="/forums/p{%?next-page}" class="next">&gt;</a>
		{%/if}
	</div>
	
	<div class="reply">
		{%if can-post == true}
			<form method="post" action="/forums/discussion/{%?id}/{%?slug}/reply">
				<h3>Reply to this discussion</h3>
				
				<div class="field">
					<textarea name="body" id="input_body"></textarea>
					<div class="clear"></div>
				</div>
				
				<div class="field">
					<div class="subtext">You can use <a href="http://static.squarespace.com/static/50060af484ae2a1f638413cb/5025cecce4b0922760c3c438/5025cecce4b0922760c3c43a/1304275182573/">Markdown</a> and <a href="http://michelf.ca/projects/php-markdown/extra/">Markdown Extra</a>.</div>
					<button type="submit" class="submit">Post reply</button>
					<button type="button" class="submit preview markdown-preview" data-preview-source="input_body">Preview</button>
					<div class="clear"></div>
				</div>
			</form>
		{%else}
			<strong>This discussion is locked.</strong>
		{%/if}
	</div>
</div>
