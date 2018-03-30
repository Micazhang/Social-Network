{include file='_head.tpl'}
{include file='_header.tpl'}

{if !$user->_logged_in}
    <!-- page content -->
    <div class="index-wrapper" {if !$system['system_wallpaper_default'] && $system['system_wallpaper']} style="background-image: url('{$system['system_uploads']}/{$system['system_wallpaper']}')" {/if}>
        <div class="container">
            <div class="index-intro">
                <h1>
                    {__("Welcome to")} {$system['system_title']}
                </h1>
                <p>
                    {__("Share your memories, connect with others, make new friends")}
                </p>
            </div>

            <div class="row relative">
                <!-- sign in/up form -->
                {include file='_sign_form.tpl'}
                <!-- sign in/up form -->
            </div>
        </div>
    </div>

    <!-- page content -->
{else}
    <!-- page content -->
    <div class="container mt20 offcanvas">
        <div class="row">

            <!-- left panel -->
            <div class="col-sm-4 col-md-2 offcanvas-sidebar">
                {include file='_sidebar.tpl'}
            </div>
            <!-- left panel -->

            <div class="col-sm-8 col-md-10 offcanvas-mainbar">
                <div class="row">
                    <!-- center panel -->
                    <div class="col-sm-12 col-md-8">

                        {if $view == ""}

                            <!-- publisher -->
                            {include file='_publisher.tpl' _handle="me" _privacy=true}
                            <!-- publisher -->

                            <!-- posts stream -->
                            {include file='_posts.tpl' _get="newsfeed"}
                            <!-- posts stream -->

                        {elseif $view == "saved"}
                            <!-- saved posts stream -->
                            {include file='_posts.tpl' _get="saved" _title=__("Saved Posts")}
                            <!-- saved posts stream -->

                        {elseif $view == "articles"}
                            <!-- saved posts stream -->
                            {include file='_posts.tpl' _get="posts_profile" _id=$user->_data['user_id'] _filter="article" _title=__("My Articles")}
                            <!-- saved posts stream -->

                        {/if}
                    </div>
                    <!-- center panel -->

                    <!-- right panel -->
                    <div class="col-sm-12 col-md-4">
                        <!-- pro members -->
                        {if count($pro_members) > 0}
                            <div class="panel panel-default panel-friends">
                                <div class="panel-heading">
                                    <strong class="text-primary"><i class="fa fa-bolt"></i> {__("Pro Users")}</strong>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        {foreach $pro_members as $_member}
                                            <div class="col-xs-4">
                                                <a class="friend-picture" href="{$system['system_url']}/{$_member['user_name']}" style="background-image:url({$_member['user_picture']});" >
                                                    <span class="friend-name">{$_member['user_firstname']} {$_member['user_lastname']}</span>
                                                </a>
                                            </div>
                                        {/foreach}
                                    </div>
                                </div>
                            </div>
                        {/if}
                        <!-- pro members -->

                        <!-- people you may know -->
                        {if count($user->_data['new_people']) > 0}
                            <div class="panel panel-default panel-widget">
                                <div class="panel-heading">
                                    <div class="pull-right flip">
                                        <small><a href="{$system['system_url']}/people">{__("See All")}</a></small>
                                    </div>
                                    <strong>{__("People you may know")}</strong>
                                </div>
                                <div class="panel-body">
                                    <ul>
                                        {foreach $user->_data['new_people'] as $_user}
                                        {include file='__feeds_user.tpl' _connection="add" _small=true}
                                        {/foreach}
                                    </ul>
                                </div>
                            </div>
                        {/if}
                         <!-- people you may know -->

                    </div>
                    <!-- right panel -->
                </div>
            </div>

        </div>
    </div>
    <!-- page content -->
{/if}

{include file='_footer.tpl'}
