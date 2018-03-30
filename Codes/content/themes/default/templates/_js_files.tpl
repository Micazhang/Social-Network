{strip}

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]><script src="{$system['system_url']}/includes/assets/js/plugins/html5shiv/html5shiv.min.js"></script><![endif]-->

<!-- Initialize -->
<script type="text/javascript">
    /* initialize vars */
    var site_title = "{$system['system_title']}";
    var site_path = "{$system['system_url']}";
    var ajax_path = site_path+"/includes/ajax/";
    var uploads_path = "{$system['system_uploads']}";
    var secret = "{$secret}";
    var min_data_heartbeat = "{$system['data_heartbeat']*1000}";
    var geolocation_enabled = {if $system['geolocation_enabled']}true{else}false{/if};
    var daytime_msg_enabled = {if $daytime_msg_enabled}true{else}false{/if};
    var notifications_sound = {if $user->_data['notifications_sound']}true{else}false{/if};
</script>
<script type="text/javascript">
    /* i18n for JS */
    var __ = [];
    __["Describe your item (optional)"] = "{__('Describe your item (optional)')}";
    __["Ask something"] = "{__('Ask something')}";
    __["Add Friend"] = "{__('Add Friend')}";
    __["Friends"] = "{__('Friends')}";
    __["Friend Request Sent"] = "{__('Friend Request Sent')}";
    __["Following"] = "{__('Following')}";
    __["Follow"] = "{__('Follow')}";
    __["Pending"] = "{__('Pending')}";
    __["Remove"] = "{__('Remove')}";
    __["Error"] = "{__('Error')}";
    __["Success"] = "{__('Success')}";
    __["Loading"] = "{__('Loading')}";
    __["Like"] = "{__('Like')}";
    __["Unlike"] = "{__('Unlike')}";
    __["Joined"] = "{__('Joined')}";
    __["Join"] = "{__('Join')}";
    __["Going"] = "{__('Going')}";
    __["Interested"] = "{__('Interested')}";
    __["Delete"] = "{__('Delete')}";
    __["Delete Cover"] = "{__('Delete Cover')}";
    __["Delete Picture"] = "{__('Delete Picture')}";
    __["Delete Post"] = "{__('Delete Post')}";
    __["Delete Comment"] = "{__('Delete Comment')}";
    __["Share Post"] = "{__('Share Post')}";
    __["Mark as Available"] = "{__('Mark as Available')}";
    __["Mark as Sold"] = "{__('Mark as Sold')}";
    __["Save Post"] = "{__('Save Post')}";
    __["Unsave Post"] = "{__('Unsave Post')}";
    __["Pin Post"] = "{__('Pin Post')}";
    __["Unpin Post"] = "{__('Unpin Post')}";
    __["Decline"] = "{__('Decline')}";
    __["Mark as Paid"] = "{__('Mark as Paid')}";
    __["Read more"] = "{__('Read more')}";
    __["Read less"] = "{__('Read less')}";
    __["Monthly Average"] = "{__('Monthly Average')}";
    __["Jan"] = "{__('Jan')}";
    __["Feb"] = "{__('Feb')}";
    __["Mar"] = "{__('Mar')}";
    __["Apr"] = "{__('Apr')}";
    __["May"] = "{__('May')}";
    __["Jun"] = "{__('Jun')}";
    __["Jul"] = "{__('Jul')}";
    __["Aug"] = "{__('Aug')}";
    __["Sep"] = "{__('Sep')}";
    __["Oct"] = "{__('Oct')}";
    __["Nov"] = "{__('Nov')}";
    __["Dec"] = "{__('Dec')}";
    __["Users"] = "{__('Users')}";
    __["Posts"] = "{__('Posts')}";
    __["Are you sure you want to delete this?"] = "{__('Are you sure you want to delete this?')}";
    __["Are you sure you want to remove your cover photo?"] = "{__('Are you sure you want to remove your cover photo?')}";
    __["Are you sure you want to remove your profile picture?"] = "{__('Are you sure you want to remove your profile picture?')}";
    __["Are you sure you want to delete this post?"] = "{__('Are you sure you want to delete this post?')}";
    __["Are you sure you want to share this post?"] = "{__('Are you sure you want to share this post?')}";
    __["Are you sure you want to delete this comment?"] = "{__('Are you sure you want to delete this comment?')}";
    __["Are you sure you want to delete your account?"] = "{__('Are you sure you want to delete your account?')}";
    __["Are you sure you want to decline this request?"] = "{__('Are you sure you want to decline this request?')}";
    __["Are you sure you want to approve this request?"] = "{__('Are you sure you want to approve this request?')}";
    __["There is something that went wrong!"] = "{__('There is something that went wrong!')}";
    __["There is no more data to show"] = "{__('There is no more data to show')}";
    __["This has been shared to your Timeline"] = "{__('This has been shared to your Timeline')}";
</script>
<!-- Initialize -->

<!-- Dependencies Libs [jQuery|Bootstrap|Mustache] -->
<script src="{$system['system_url']}/includes/assets/js/jquery/jquery-3.2.1.min.js" {if !$user->_logged_in}defer{/if}></script>
<script src="{$system['system_url']}/includes/assets/js/bootstrap/bootstrap.min.js" {if !$user->_logged_in}defer{/if}></script>
<script src="{$system['system_url']}/includes/assets/js/mustache/mustache.min.js" {if !$user->_logged_in}defer{/if}></script>
<!-- Dependencies Libs [jQuery|Bootstrap|Mustache] -->

<!-- Dependencies Plugins -->
<script src="{$system['system_url']}/includes/assets/js/plugins/fastclick/fastclick.min.js" {if !$user->_logged_in}defer{/if}></script>

<script src="{$system['system_url']}/includes/assets/js/plugins/jquery.form/jquery.form.min.js" {if !$user->_logged_in}defer{/if}></script>
<script src="{$system['system_url']}/includes/assets/js/plugins/jquery.inview/jquery.inview.min.js" {if !$user->_logged_in}defer{/if}></script>
<script src="{$system['system_url']}/includes/assets/js/plugins/jquery.slimscroll/jquery.slimscroll.min.js" {if !$user->_logged_in}defer{/if}></script>

<script src="{$system['system_url']}/includes/assets/js/plugins/autosize/autosize.min.js" {if !$user->_logged_in}defer{/if}></script>
<script src="{$system['system_url']}/includes/assets/js/plugins/readmore/readmore.min.js" {if !$user->_logged_in}defer{/if}></script>
<script src="{$system['system_url']}/includes/assets/js/plugins/moment/moment-with-locales.min.js" {if !$user->_logged_in}defer{/if}></script>

<script src="{$system['system_url']}/includes/assets/js/plugins/mediaelementplayer/mediaelement-and-player.min.js" {if !$user->_logged_in}defer{/if}></script>
<link rel="stylesheet" type='text/css' href="{$system['system_url']}/includes/assets/js/plugins/mediaelementplayer/mediaelementplayer.min.css">

{if $user->_logged_in}
    {if $system['geolocation_enabled']}
        <script src="{$system['system_url']}/includes/assets/js/plugins/jquery.geocomplete/jquery.geocomplete.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={$system['geolocation_key']}"></script>
    {/if}

    <script src="{$system['system_url']}/includes/assets/js/plugins/bootstrap.select/bootstrap-select.min.js"></script>
    <link rel="stylesheet" type='text/css' href="{$system['system_url']}/includes/assets/js/plugins/bootstrap.select/bootstrap-select.min.css">

    <script src="{$system['system_url']}/includes/assets/js/plugins/bootstrap.datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" type='text/css' href="{$system['system_url']}/includes/assets/js/plugins/bootstrap.datetimepicker/bootstrap-datetimepicker.min.css">

    <script src="{$system['system_url']}/includes/assets/js/plugins/noty/noty.min.js"></script>
    <link rel="stylesheet" type='text/css' href="{$system['system_url']}/includes/assets/js/plugins/noty/noty.css">

    <script src="{$system['system_url']}/includes/assets/js/plugins/magnific-popup/magnific-popup.min.js"></script>
    <link rel="stylesheet" type='text/css' href="{$system['system_url']}/includes/assets/js/plugins/magnific-popup/magnific-popup.css">

    <script src="{$system['system_url']}/includes/assets/js/plugins/tinymce/tinymce.min.js"></script>

{/if}

{if $system['reCAPTCHA_enabled']}
<script src='https://www.google.com/recaptcha/api.js' {if !$user->_logged_in}defer{/if}></script>
{/if}
<!-- Dependencies Plugins -->

<!-- M&M [JS] -->
<script src="{$system['system_url']}/includes/assets/js/M&M/core.js" {if !$user->_logged_in}defer{/if}></script>
{if $user->_logged_in}
    <script src="{$system['system_url']}/includes/assets/js/M&M/user.js"></script>
    <script src="{$system['system_url']}/includes/assets/js/M&M/post.js"></script>
{/if}
<!-- M&M [JS] -->

<!-- DayTime Messages -->
{if $page == "index" && $user->_logged_in && $view == ""}
    <script>
        $(function() {
            if(daytime_msg_enabled) {
                var now = new Date();
                var hours = now.getHours();
                if ( hours >= 5 && hours <= 11 ) {
                    $(render_template('#message-morning')).insertAfter('.publisher').fadeIn();
                } else if ( hours >= 12 && hours <= 18 ) {
                    $(render_template('#message-afternoon')).insertAfter('.publisher').fadeIn();
                } else if ( hours >= 19 || hours <= 4 ) {
                    $(render_template('#message-evening')).insertAfter('.publisher').fadeIn();
                }
            }
        });
    </script>
{/if}
<!-- DayTime Messages -->

{/strip}
