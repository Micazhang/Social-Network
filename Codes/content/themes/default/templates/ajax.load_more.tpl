{if $get == 'newsfeed' || $get == 'posts_profile' || $get == 'saved' }

	{foreach $data as $post}
		{include file='__feeds_post.tpl'}
	{/foreach}


{elseif $get == 'articles'}
	{foreach $data as $article}
		{include file='__feeds_article.tpl'}
	{/foreach}


{elseif $get == 'shares'}
	{foreach $data as $post}
		{include file='__feeds_post.tpl' _snippet=true}
	{/foreach}


{elseif $get == 'post_comments' || $get == 'photo_comments'}
	{foreach $data as $comment}
		{include file='__feeds_comment.tpl' _comment=$comment}
	{/foreach}

{elseif $get == 'comment_replies'}
	{foreach $data as $comment}
		{include file='__feeds_comment.tpl' _comment=$comment _is_reply=true}
	{/foreach}


{elseif $get == 'photos'}
	{foreach $data as $photo}
		{include file='__feeds_photo.tpl' _context=$context}
	{/foreach}


{elseif $get == 'albums'}
	{foreach $data as $album}
		{include file='__feeds_album.tpl'}
	{/foreach}


{elseif $get == 'post_likes' || $get == 'photo_likes' || $get == 'comment_likes'}
	{foreach $data as $_user}
		{include file='__feeds_user.tpl' _connection=$_user["connection"]}
	{/foreach}


{elseif $get == 'friend_requests'}
	{foreach $data as $_user}
		{include file='__feeds_user.tpl' _connection="request"}
	{/foreach}


{elseif $get == 'friend_requests_sent'}
	{foreach $data as $_user}
		{include file='__feeds_user.tpl' _connection="cancel"}
	{/foreach}


{elseif $get == 'mutual_friends'}
	{foreach $data as $_user}
		{include file='__feeds_user.tpl' _connection="remove"}
	{/foreach}


{elseif $get == 'new_people'}
	{foreach $data as $_user}
		{include file='__feeds_user.tpl' _connection="add"}
	{/foreach}


{elseif $get == 'friends' || $get == 'followers' || $get == 'followings'}
	{foreach $data as $_user}
		{include file='__feeds_user.tpl' _connection=$_user["connection"] _parent="profile"}
	{/foreach}


{elseif $get == 'notifications'}
	{foreach $data as $notification}
		{include file='__feeds_notification.tpl'}
	{/foreach}


{/if}
