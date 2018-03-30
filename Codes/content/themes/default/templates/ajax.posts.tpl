{if $_get}
	{if $posts}
		<ul>
			{foreach $posts as $post}
			{include file='__feeds_post.tpl'}
			{/foreach}
		</ul>

	{else}
		<div class="text-center x-muted">
			<i class="fa fa-newspaper-o fa-4x"></i>
			<p class="mb10"><strong>{__("No posts to show")}</strong></p>
		</div>
	{/if}
{else}
	{foreach $posts as $post}
	{include file='__feeds_post.tpl'}
	{/foreach}
{/if}
