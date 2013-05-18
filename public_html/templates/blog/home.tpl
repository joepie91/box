{%foreach entry in entries}
	<div class="entry">
		<h1><a href="{%?entry[url]}">{%?entry[title]}</a></h1>
		<img src="{%?entry[thumbnail]}">
		<div class="metadata">
			<span class="date">{%?entry[relative-date]}</span>, by
			<span class="author">{%?entry[author]}</span>
			<span class="tags">Tags: {%?entry[tags]}</span>
		</div>
		{%?entry[teaser]}
		<a href="{%?entry[url]}" class="readmore">Read more...</a>
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
