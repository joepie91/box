<div class="sidebar">
	<a href="/forums/create" class="button large" id="button_newthread">Create new thread</a>
	<div class="clear"></div>
</div>

<div class="contents">
	{%foreach thread in threads}
		<div class="thread">
			<img class="avatar" src="{%?thread[gravatar]}">
			<div class="title">
				<a href="/forums/discussion/{%?thread[id]}/{%?thread[slug]}">{%?thread[title]}</a>
			</div>
			<div class="metadata">
				<div class="replycount">{%?thread[replies]} replies</div>
				
				{%if thread[pinned] == true}
					<div class="pinned">Announcement</div>
				{%/if}
				
				{%if thread[locked] == true}
					<div class="locked">Locked</div>
				{%/if}
				
				{%if isempty|thread[latest] == false}
					<div class="author">Latest post by <a href="#" class="user">{%?thread[latest]}</a></div>
				{%/if}
				
				<div class="clear"></div>
			</div>
		</div>
	{%/foreach}
	
	<div class="pagination">
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
</div>

<div class="clear"></div>
