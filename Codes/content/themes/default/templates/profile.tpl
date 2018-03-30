{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page content -->
<div class="container {if $user->_logged_in}offcanvas{/if}">
    <div class="row">

        <!-- side panel -->
        {if $user->_logged_in}
            <div class="col-xs-12 visible-xs-block offcanvas-sidebar mt20">
                {include file='_sidebar.tpl'}
            </div>
        {/if}
        <!-- side panel -->

        <div class="col-xs-12 {if $user->_logged_in}offcanvas-mainbar{/if}">
            <!-- profile-header -->
            <div class="profile-header">
                <!-- profile-cover -->
                <div {if $profile['user_cover_id']} class="profile-cover-wrapper js_lightbox" data-id="{$profile['user_cover_id']}" data-image="{$system['system_uploads']}/{$profile['user_cover']}" data-context="album" {else} class="profile-cover-wrapper" {/if}  {if $profile['user_cover']} style="background-image:url('{$system['system_uploads']}/{$profile['user_cover']}');" {/if}>
                    {if $profile['user_id'] == $user->_data['user_id']}
                        <div class="profile-cover-change">
                            <i class="fa fa-camera js_x-uploader" data-handle="cover-user"></i>
                        </div>
                        <div class="profile-cover-delete {if !$profile['user_cover']}x-hidden{/if}">
                            <i class="fa fa-trash js_delete-cover" data-handle="cover-user" title='{__("Delete Cover")}'></i>
                        </div>
                        <div class="profile-cover-change-loader">
                            <div class="loader loader_large"></div>
                        </div>
                    {/if}
                </div>
                <!-- profile-cover -->

                <!-- profile-avatar -->
                <div class="profile-avatar-wrapper">
                    <img {if $profile['user_picture_id']} class="js_lightbox" data-id="{$profile['user_picture_id']}" data-image="{$profile['user_picture']}" data-context="album" {/if} src="{$profile['user_picture']}" alt="{$profile['user_firstname']} {$profile['user_lastname']}">
                    {if $profile['user_id'] == $user->_data['user_id']}
                        <div class="profile-avatar-change">
                            <i class="fa fa-camera js_x-uploader" data-handle="picture-user"></i>
                        </div>
                        <div class="profile-avatar-delete {if $profile['user_picture_default']}x-hidden{/if}">
                            <i class="fa fa-trash js_delete-picture" data-handle="picture-user" title='{__("Delete Picture")}'></i>
                        </div>
                        <div class="profile-avatar-change-loader">
                            <div class="loader loader_medium"></div>
                        </div>
                    {/if}
                </div>
                <!-- profile-avatar -->

                <!-- profile-name -->
                <div class="profile-name-wrapper">
                    <a href="{$system['system_url']}/{$profile['user_name']}">{$profile['user_firstname']} {$profile['user_lastname']}</a>
                    {if $profile['user_verified']}
                        <i data-toggle="tooltip" data-placement="top" title='{__("Verified User")}' class="fa fa-check-circle fa-fw verified-badge"></i>
                    {/if}
                    {if $profile['user_subscribed']}
                        <i data-toggle="tooltip" data-placement="top" title='{__("Pro User")}' class="fa fa-bolt fa-fw pro-badge"></i>
                    {/if}
                </div>
                <!-- profile-name -->

                <!-- profile-buttons -->
                <div class="profile-buttons-wrapper">
                    {if $user->_logged_in}
                        {if $user->_data['user_id'] != $profile['user_id']}
                            {if $profile['we_friends']}
                                <div class="btn btn-default btn-delete js_friend-remove" data-uid="{$profile['user_id']}">
                                    <i class="fa fa-check fa-fw"></i> {__("Friends")}
                                </div>
                            {elseif $profile['he_request']}
                                <div class="btn btn-primary js_friend-accept" data-uid="{$profile['user_id']}">{__("Confirm")}</div>
                                <div class="btn btn-default js_friend-decline" data-uid="{$profile['user_id']}">{__("Delete Request")}</div>
                            {elseif $profile['i_request']}
                                <div class="btn btn-default btn-sm js_friend-cancel" data-uid="{$profile['user_id']}">
                                    <i class="fa fa-user-plus"></i> {__("Friend Request Sent")}
                                </div>
                            {else}
                                <button type="button" class="btn btn-success js_friend-add" data-uid="{$profile['user_id']}">
                                    <i class="fa fa-user-plus"></i> {__("Add Friend")}
                                </button>
                            {/if}

                            <div class="btn-group">
                                {if $profile['i_follow']}
                                    <button type="button" class="btn btn-default js_unfollow" data-uid="{$profile['user_id']}">
                                        <i class="fa fa-check"></i>
                                        {__("Following")}
                                    </button>
                                {else}
                                    <button type="button" class="btn btn-default js_follow" data-uid="{$profile['user_id']}">
                                        <i class="fa fa-rss"></i>
                                        {__("Follow")}
                                    </button>
                                {/if}
                            </div>
                        {else}
                            <a href="{$system['system_url']}/settings/profile" class="btn btn-default">
                                <i class="fa fa-pencil"></i> {__("Update Info")}
                            </a>
                        {/if}
                    {/if}
                </div>
                <!-- profile-buttons -->

                <!-- profile-tabs -->
                <div class="profile-tabs-wrapper">
                    <ul class="nav">
                        <li>
                            <a href="{$system['system_url']}/{$profile['user_name']}">
                                {__("Timeline")}
                            </a>
                        </li>
                        <li class="middle-tabs">
                            <a href="{$system['system_url']}/{$profile['user_name']}/friends">
                                {__("Friends")}
                                {if $profile['mutual_friends_count'] && $profile['mutual_friends_count'] > 0}
                                    <small class="text-muted">
                                        (<span class="text-underline" data-toggle="modal" data-url="users/mutual_friends.php?uid={$profile['user_id']}">{$profile['mutual_friends_count']} {__("Mutual")}</span>)
                                    </small>
                                {/if}
                            </a>
                        </li>
                        <li class="middle-tabs">
                            <a href="{$system['system_url']}/{$profile['user_name']}/photos">
                                {__("Photos")}
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- profile-tabs -->
            </div>
            <!-- profile-header -->

            <!-- profile-content -->
            <div class="row">
                <!-- mutual-friends panel -->
                {if $user->_logged_in && $user->_data['user_id'] != $profile['user_id'] && !$profile['we_friends']}
                    <div class="col-sm-12">
                        <div class="panel panel-default panel-mutual-friends">
                            <div class="panel-heading">
                                {__("Do you know")} {$profile['user_firstname']}
                            </div>
                            <div class="panel-body">
                                <div>
                                    {__("To see what")} {$profile['user_firstname']} {__("shares with friends")},
                                    <span class="text-link">
                                        {__("send a friend request")}
                                    </span>
                                    <div class="pull-right flip">
                                        {if $profile['he_request']}
                                            <div class="btn btn-primary js_friend-accept" data-uid="{$profile['user_id']}">{__("Confirm")}</div>
                                            <div class="btn btn-default js_friend-decline" data-uid="{$profile['user_id']}">{__("Delete Request")}</div>
                                        {elseif $profile['i_request']}
                                            <div class="btn btn-default btn-sm js_friend-cancel" data-uid="{$profile['user_id']}">
                                                <i class="fa fa-user-plus"></i> {__("Friend Request Sent")}
                                            </div>
                                        {else}
                                            <button type="button" class="btn btn-success js_friend-add" data-uid="{$profile['user_id']}">
                                                <i class="fa fa-user-plus"></i> {__("Add Friend")}
                                            </button>
                                        {/if}
                                    </div>
                                </div>
                                {if $profile['mutual_friends_count'] && $profile['mutual_friends_count'] > 0}
                                    <div class="mt10 clearfix">
                                        <ul class="pull-left flip">
                                            {foreach $profile['mutual_friends'] as $mutual_friend}
                                                <li>
                                                    <a data-toggle="tooltip" data-placement="top" title="{$mutual_friend['user_firstname']} {$mutual_friend['user_lastname']}" class="post-avatar-picture" href="{$system['system_url']}/{$mutual_friend['user_name']}" style="background-image:url({$mutual_friend['user_picture']});">
                                                    </a>
                                                </li>
                                                {if $mutual_friend@index > 3}{break}{/if}
                                            {/foreach}
                                        </ul>
                                        <div class="pull-left flip mt10">
                                            <span class="text-underline" data-toggle="modal" data-url="users/mutual_friends.php?uid={$profile['user_id']}">{$profile['mutual_friends_count']} {__("Mutual Friends")}</span>
                                        </div>
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                {/if}
                <!-- mutual-friends panel -->

                <!-- profile-buttons alt -->
                {if $user->_logged_in && $user->_data['user_id'] != $profile['user_id']}
                    <div class="col-sm-12">
                        <div class="panel panel-default profile-buttons-wrapper-alt">
                            <div class="panel-body">
                                {if $user->_logged_in && $user->_data['user_id'] != $profile['user_id']}
                                    {if $profile['we_friends']}
                                        <div class="btn btn-default btn-delete js_friend-remove" data-uid="{$profile['user_id']}">
                                            <i class="fa fa-check fa-fw"></i> {__("Friends")}
                                        </div>
                                    {elseif $profile['he_request']}
                                        <div class="btn btn-primary js_friend-accept" data-uid="{$profile['user_id']}">{__("Confirm")}</div>
                                        <div class="btn btn-default js_friend-decline" data-uid="{$profile['user_id']}">{__("Delete Request")}</div>
                                    {elseif $profile['i_request']}
                                        <div class="btn btn-default btn-sm js_friend-cancel" data-uid="{$profile['user_id']}">
                                            <i class="fa fa-user-plus"></i> {__("Friend Request Sent")}
                                        </div>
                                    {else}
                                        <button type="button" class="btn btn-success js_friend-add" data-uid="{$profile['user_id']}">
                                            <i class="fa fa-user-plus"></i> {__("Add Friend")}
                                        </button>
                                    {/if}

                                    <div class="btn-group pull-right flip">
                                        {if $profile['i_follow']}
                                        <button type="button" class="btn btn-default js_unfollow" data-uid="{$profile['user_id']}">
                                            <i class="fa fa-check"></i>
                                            {__("Following")}
                                        </button>
                                        {else}
                                        <button type="button" class="btn btn-default js_follow" data-uid="{$profile['user_id']}">
                                            <i class="fa fa-rss"></i>
                                            {__("Follow")}
                                        </button>
                                        {/if}
                                    </div>
                                {else}
                                    <a href="{$system['system_url']}/settings/profile" class="btn btn-default">
                                        <i class="fa fa-pencil"></i> {__("Update Info")}
                                    </a>
                                {/if}
                            </div>
                        </div>
                    </div>
                {/if}
                <!-- profile-buttons alt -->

                <!-- view content -->
                {if $view == ""}
                    <div class="col-sm-4">
                        <!-- about -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                {if !is_empty($profile['user_biography'])}
                                    <div class="about-bio">
                                        {$profile['user_biography']}
                                    </div>
                                {/if}
                                <ul class="about-list">
                                    {if $profile['user_subscribed']}
                                        <li class="package" {if $profile['package_color']} style="background: {$profile['package_color']}" {/if}>
                                            <i class="fa fa-bolt fa-fw"></i> {$profile['package_name']} {__("Member")}
                                        </li>
                                    {/if}

                                    {if $profile['user_work_title']}
                                        {if $profile['user_id'] == $user->_data['user_id'] || $profile['user_privacy_work'] == "public" || ($profile['user_privacy_work'] == "friends" && $profile['we_friends'])}
                                            <li>
                                                <div class="about-list-item">
                                                    <i class="fa fa-briefcase fa-fw fa-lg"></i>
                                                    {$profile['user_work_title']} {__("at")} <span class="text-link">{$profile['user_work_place']}</span>
                                                </div>
                                            </li>
                                        {/if}
                                    {/if}

                                    {if $profile['user_edu_major']}
                                        {if $profile['user_id'] == $user->_data['user_id'] || $profile['user_privacy_education'] == "public" || ($profile['user_privacy_education'] == "friends" && $profile['we_friends'])}
                                            <li>
                                                <div class="about-list-item">
                                                    <i class="fa fa-graduation-cap fa-fw fa-lg"></i>
                                                    {__("Studied")} {$profile['user_edu_major']}
                                                    {__("at")}  <span class="text-link">{$profile['user_edu_school']}</span>
                                                    <div class="details">
                                                        Class of {$profile['user_edu_class']}
                                                    </div>
                                                </div>
                                            </li>
                                        {/if}
                                    {/if}

                                    {if $profile['user_current_city']}
                                        {if $profile['user_id'] == $user->_data['user_id'] || $profile['user_privacy_location'] == "public" || ($profile['user_privacy_location'] == "friends" && $profile['we_friends'])}
                                            <li>
                                                <div class="about-list-item">
                                                    <i class="fa fa-home fa-fw fa-lg"></i>
                                                    {__("Lives in")} <span class="text-link">{$profile['user_current_city']}</span>
                                                </div>
                                            </li>
                                        {/if}
                                    {/if}

                                    {if $profile['user_hometown']}
                                        {if $profile['user_id'] == $user->_data['user_id'] || $profile['user_privacy_location'] == "public" || ($profile['user_privacy_location'] == "friends" && $profile['we_friends'])}
                                            <li>
                                                <div class="about-list-item">
                                                    <i class="fa fa-map-marker fa-fw fa-lg"></i>
                                                    {__("From")} <span class="text-link">{$profile['user_hometown']}</span>
                                                </div>
                                            </li>
                                        {/if}
                                    {/if}

                                    <li>
                                        <div class="about-list-item">
                                            {if $profile['user_gender'] == "male"}
                                                <i class="fa fa-male fa-fw fa-lg"></i>
                                                {__("Male")}
                                            {else}
                                                <i class="fa fa-female fa-fw fa-lg"></i>
                                                {__("Female")}
                                            {/if}
                                        </div>
                                    </li>

                                    {if $profile['user_relationship']}
                                        {if $profile['user_id'] == $user->_data['user_id'] || $profile['user_privacy_relationship'] == "public" || ($profile['user_privacy_relationship'] == "friends" && $profile['we_friends'])}
                                            <li>
                                                <div class="about-list-item">
                                                    <i class="fa fa-heart fa-fw fa-lg"></i>
                                                    {if $profile['user_relationship'] == "relationship"}
                                                        {__("In a relationship")}
                                                    {elseif $profile['user_relationship'] == "complicated"}
                                                        {__("It's complicated")}
                                                    {else}
                                                        {__($profile['user_relationship']|ucfirst)}
                                                    {/if}
                                                </div>
                                            </li>
                                        {/if}
                                    {/if}

                                    {if $profile['user_birthdate'] != null}
                                        {if $profile['user_id'] == $user->_data['user_id'] || $profile['user_privacy_birthdate'] == "public" || ($profile['user_privacy_birthdate'] == "friends" && $profile['we_friends'])}
                                            <li>
                                                <div class="about-list-item">
                                                    <i class="fa fa-calendar fa-fw fa-lg"></i>
                                                    {$profile['user_birthdate']|date_format:"%d/%m/%Y"}
                                                </div>
                                            </li>
                                        {/if}
                                    {/if}

                                    {if $profile['user_website']}
                                        <li>
                                            <div class="about-list-item">
                                                <i class="fa fa-globe fa-fw fa-lg"></i>
                                                <a target="_blank" href="{$profile['user_website']}">{$profile['user_website']}</a>
                                            </div>
                                        </li>
                                    {/if}

                                    <li>
                                        <div class="about-list-item">
                                            <i class="fa fa-rss fa-fw fa-lg"></i>
                                            {__("Followed by")}
                                            <a href="{$system['system_url']}/{$profile['user_name']}/followers">{$profile['followers_count']} {__("people")}</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- about -->

                        <!-- friends -->
                        {if $profile['friends_count'] > 0}
                            <div class="panel panel-default panel-friends">
                                <div class="panel-heading">
                                    <i class="fa fa-users fa-fw text-info"></i> <a href="{$system['system_url']}/{$profile['user_name']}/friends">{__("Friends")}</a> ·
                                    <small>{$profile['friends_count']}</small>
                                    {if $profile['mutual_friends_count'] && $profile['mutual_friends_count'] > 0}
                                        <small>
                                            (<span class="text-underline" data-toggle="modal" data-url="users/mutual_friends.php?uid={$profile['user_id']}">{$profile['mutual_friends_count']} {__("mutual friends")}</span>)
                                        </small>
                                    {/if}
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        {foreach $profile['friends'] as $_friend}
                                            <div class="col-xs-3 col-sm-4">
                                                <a class="friend-picture" href="{$system['system_url']}/{$_friend['user_name']}" style="background-image:url({$_friend['user_picture']});" >
                                                    <span class="friend-name">{$_friend['user_firstname']} {$_friend['user_lastname']}</span>
                                                </a>
                                            </div>
                                        {/foreach}
                                    </div>
                                </div>
                            </div>
                        {/if}
                        <!-- friends -->

                        <!-- photos -->
                        {if count($profile['photos']) > 0}
                            <div class="panel panel-default panel-photos">
                                <div class="panel-heading">
                                    <i class="fa fa-picture-o fa-fw text-info"></i> <a href="{$system['system_url']}/{$profile['user_name']}/photos">{__("Photos")}</a>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        {foreach $profile['photos'] as $photo}
                                            {include file='__feeds_photo.tpl' _context="photos" _small=true}
                                        {/foreach}
                                    </div>
                                </div>
                            </div>
                        {/if}
                        <!-- photos -->


                    </div>
                    <div class="col-sm-8">
                        <!-- publisher -->
                        {if $user->_logged_in}
                            {if $user->_data['user_id'] == $profile['user_id']}
                                {include file='_publisher.tpl' _handle="me" _privacy=true}
                            {elseif $system['wall_posts_enabled'] && ( $profile['user_privacy_wall'] == 'friends' && $profile['we_friends'] || $profile['user_privacy_wall'] == 'public' )}
                                {include file='_publisher.tpl' _handle="user" _id=$profile['user_id'] _privacy=true}
                            {/if}

                        {/if}
                        <!-- publisher -->

                        <!-- pinned post -->
                        {if $pinned_post}
                            {include file='_pinned_post.tpl' post=$pinned_post}
                        {/if}
                        <!-- pinned post -->

                        <!-- posts -->
                        {include file='_posts.tpl' _get="posts_profile" _id=$profile['user_id']}
                        <!-- posts -->
                    </div>
                {elseif $view == "friends"}
                    <!-- friends -->
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading with-icon with-nav">
                                <!-- friend requests -->
                                {if $user->_logged_in && $user->_data['user_id'] == $profile['user_id']}
                                    <div class="pull-right flip">
                                        <a href="{$system['system_url']}/people/friend_requests" class="btn btn-default btn-sm">
                                            {__("Friend Requests")}
                                        </a>
                                    </div>
                                {/if}
                                <!-- friend requests -->

                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-users pr5 panel-icon"></i>
                                    <strong>{__("Friends")}</strong>
                                </div>
                                <!-- panel title -->

                                <!-- panel nav -->
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="{$system['system_url']}/{$profile['user_name']}/friends">
                                            <strong class="pr5">{__("Friends")}</strong>
                                            <span class="label label-info ml5">{$profile['friends_count']}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$system['system_url']}/{$profile['user_name']}/followers">{__("Followers")}</a>
                                    </li>
                                    <li>
                                        <a href="{$system['system_url']}/{$profile['user_name']}/followings">{__("Followings")}</a>
                                    </li>
                                </ul>
                                <!-- panel nav -->
                            </div>
                            <div class="panel-body">
                                {if $profile['friends_count'] > 0}
                                    <ul class="row">
                                        {foreach $profile['friends'] as $_user}
                                        {include file='__feeds_user.tpl' _connection=$_user["connection"] _parent="profile"}
                                        {/foreach}
                                    </ul>
                                    {if count($profile['friends']) >= $system['min_results_even']}
                                        <!-- see-more -->
                                        <div class="alert alert-info see-more js_see-more" data-get="friends" data-uid="{$profile['user_id']}">
                                            <span>{__("See More")}</span>
                                            <div class="loader loader_small x-hidden"></div>
                                        </div>
                                        <!-- see-more -->
                                    {/if}
                                {else}
                                    <p class="text-center text-muted mt10">
                                        {$profile['user_firstname']} {__("doesn't have friends")}
                                    </p>
                                {/if}
                            </div>
                        </div>
                    </div>
                    <!-- friends -->
                {elseif $view == "photos"}
                    <!-- photos -->
                    <div class="col-xs-12">
                        <div class="panel panel-default panel-photos">
                            <div class="panel-heading with-icon with-nav">
                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-picture-o pr5 panel-icon"></i>
                                    <strong>{__("Photos")}</strong>
                                </div>
                                <!-- panel title -->

                                <!-- panel nav -->
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="{$system['system_url']}/{$profile['user_name']}/photos">
                                            <strong class="pr5">{__("Photos")}</strong>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$system['system_url']}/{$profile['user_name']}/albums">{__("Albums")}</a>
                                    </li>
                                </ul>
                                <!-- panel nav -->
                            </div>
                            <div class="panel-body">
                                {if count($profile['photos']) > 0}
                                    <ul class="row">
                                        {foreach $profile['photos'] as $photo}
                                            {include file='__feeds_photo.tpl' _context="photos"}
                                        {/foreach}
                                    </ul>
                                    {if count($profile['photos']) >= $system['min_results_even']}
                                        <!-- see-more -->
                                        <div class="alert alert-info see-more js_see-more" data-get="photos" data-id="{$profile['user_id']}" data-type='user'>
                                            <span>{__("See More")}</span>
                                            <div class="loader loader_small x-hidden"></div>
                                        </div>
                                        <!-- see-more -->
                                    {/if}
                                {else}
                                    <p class="text-center text-muted mt10">
                                        {$profile['user_firstname']} {__("doesn't have photos")}
                                    </p>
                                {/if}
                            </div>
                        </div>
                    </div>
                    <!-- photos -->
                {elseif $view == "albums"}
                    <!-- albums -->
                    <div class="col-xs-12">
                        <div class="panel panel-default panel-albums">
                            <div class="panel-heading with-icon with-nav">
                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-picture-o pr5 panel-icon"></i>
                                    <strong>{__("Photos")}</strong>
                                </div>
                                <!-- panel title -->

                                <!-- panel nav -->
                                <ul class="nav nav-tabs">
                                    <li>
                                        <a href="{$system['system_url']}/{$profile['user_name']}/photos">{__("Photos")}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{$system['system_url']}/{$profile['user_name']}/albums">
                                            <strong class="pr5">{__("Albums")}</strong>
                                        </a>
                                    </li>
                                </ul>
                                <!-- panel nav -->
                            </div>
                            <div class="panel-body">
                                {if count($profile['albums']) > 0}
                                    <ul class="row">
                                        {foreach $profile['albums'] as $album}
                                        {include file='__feeds_album.tpl'}
                                        {/foreach}
                                    </ul>
                                    {if count($profile['albums']) >= $system['max_results_even']}
                                        <!-- see-more -->
                                        <div class="alert alert-info see-more js_see-more" data-get="albums" data-id="{$profile['user_id']}" data-type='user'>
                                            <span>{__("See More")}</span>
                                            <div class="loader loader_small x-hidden"></div>
                                        </div>
                                        <!-- see-more -->
                                    {/if}
                                {else}
                                    <p class="text-center text-muted mt10">
                                        {$profile['user_firstname']} {__("doesn't have albums")}
                                    </p>
                                {/if}
                            </div>
                        </div>
                    </div>
                    <!-- albums -->
                {elseif $view == "album"}
                    <!-- albums -->
                    <div class="col-xs-12">
                        <div class="panel panel-default panel-albums">
                            <div class="panel-heading with-icon with-nav">
                                <!-- back to albums -->
                                <div class="pull-right flip">
                                    <a href="{$system['system_url']}/{$profile['user_name']}/albums" class="btn btn-default btn-sm">
                                        <i class="fa fa-arrow-circle-left"></i> {__("Back to Albums")}
                                    </a>
                                </div>
                                <!-- back to albums -->

                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-picture-o pr5 panel-icon"></i>
                                    <strong>{__("Photos")}</strong>
                                </div>
                                <!-- panel title -->

                                <!-- panel nav -->
                                <ul class="nav nav-tabs">
                                    <li>
                                        <a href="{$system['system_url']}/{$profile['user_name']}/photos">{__("Photos")}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{$system['system_url']}/{$profile['user_name']}/albums">
                                            <strong class="pr5">{__("Albums")}</strong>
                                        </a>
                                    </li>
                                </ul>
                                <!-- panel nav -->
                            </div>
                            <div class="panel-body">
                            {include file='_album.tpl'}
                            </div>
                        </div>
                    </div>
                    <!-- albums -->
                {elseif $view == "followers"}
                    <!-- followers -->
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading with-icon with-nav">
                                {if $user->_logged_in && $user->_data['user_id'] == $profile['user_id']}
                                <!-- friend requests -->
                                <div class="pull-right flip">
                                    <a href="{$system['system_url']}/people/friend_requests" class="btn btn-default btn-sm">
                                        {__("Friend Requests")}
                                    </a>
                                </div>
                                <!-- friend requests -->
                                {/if}

                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-users pr5 panel-icon"></i>
                                    <strong>{__("Friends")}</strong>
                                </div>
                                <!-- panel title -->

                                <!-- panel nav -->
                                <ul class="nav nav-tabs">
                                    <li>
                                        <a href="{$system['system_url']}/{$profile['user_name']}/friends">{__("Friends")}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{$system['system_url']}/{$profile['user_name']}/followers">
                                            <strong class="pr5">{__("Followers")}</strong>
                                            <span class="label label-info ml5">{$profile['followers_count']}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$system['system_url']}/{$profile['user_name']}/followings">{__("Followings")}</a>
                                    </li>
                                </ul>
                                <!-- panel nav -->
                            </div>
                            <div class="panel-body">
                                {if $profile['followers_count'] > 0}
                                    <ul class="row">
                                        {foreach $profile['followers'] as $_user}
                                            {include file='__feeds_user.tpl' _connection=$_user["connection"] _parent="profile"}
                                        {/foreach}
                                    </ul>

                                    {if count($profile['followers']) >= $system['min_results_even']}
                                    <!-- see-more -->
                                    <div class="alert alert-info see-more js_see-more" data-get="followers" data-uid="{$profile['user_id']}">
                                        <span>{__("See More")}</span>
                                        <div class="loader loader_small x-hidden"></div>
                                    </div>
                                    <!-- see-more -->
                                    {/if}
                                {else}
                                    <p class="text-center text-muted mt10">
                                        {$profile['user_firstname']} {__("doesn't have followers")}
                                    </p>
                                {/if}
                            </div>
                        </div>
                    </div>
                    <!-- followers -->
                {elseif $view == "followings"}
                    <!-- followings -->
                    <div class="col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading with-icon with-nav">
                                {if $user->_logged_in && $user->_data['user_id'] == $profile['user_id']}
                                <!-- friend requests -->
                                <div class="pull-right flip">
                                    <a href="{$system['system_url']}/people/friend_requests" class="btn btn-default btn-sm">
                                        {__("Friend Requests")}
                                    </a>
                                </div>
                                <!-- friend requests -->
                                {/if}

                                <!-- panel title -->
                                <div class="mb20">
                                    <i class="fa fa-users pr5 panel-icon"></i>
                                    <strong>{__("Friends")}</strong>
                                </div>
                                <!-- panel title -->

                                <!-- panel nav -->
                                <ul class="nav nav-tabs">
                                    <li>
                                        <a href="{$system['system_url']}/{$profile['user_name']}/friends">{__("Friends")}</a>
                                    </li>
                                    <li>
                                        <a href="{$system['system_url']}/{$profile['user_name']}/followers">{__("Followers")}</a>
                                    </li>
                                    <li class="active">
                                        <a href="{$system['system_url']}/{$profile['user_name']}/followings">
                                            <strong class="pr5">{__("Followings")}</strong>
                                            <span class="label label-info ml5">{$profile['followings_count']}</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- panel nav -->
                            </div>
                            <div class="panel-body">
                                {if $profile['followings_count'] > 0}
                                    <ul class="row">
                                        {foreach $profile['followings'] as $_user}
                                            {include file='__feeds_user.tpl' _connection=$_user["connection"] _parent="profile"}
                                        {/foreach}
                                    </ul>

                                    {if count($profile['followings']) >= $system['min_results_even']}
                                    <!-- see-more -->
                                    <div class="alert alert-info see-more js_see-more" data-get="followings" data-uid="{$profile['user_id']}">
                                        <span>{__("See More")}</span>
                                        <div class="loader loader_small x-hidden"></div>
                                    </div>
                                    <!-- see-more -->
                                    {/if}
                                {else}
                                    <p class="text-center text-muted mt10">
                                        {$profile['user_firstname']} {__("doesn't have followings")}
                                    </p>
                                {/if}
                            </div>
                        </div>
                    </div>
                    <!-- followings -->

                {/if}
                <!-- view content -->
            </div>
            <!-- profile-content -->
        </div>

    </div>
</div>
<!-- page content -->

{include file='_footer.tpl'}
