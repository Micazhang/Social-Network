{strip}
<!-- Modals -->
<div id="modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="loader pt10 pb10"></div>
            </div>
        </div>
    </div>
</div>

<script id="modal-login" type="text/template">
    <div class="modal-header">
        <h5 class="modal-title">{__("Not Logged In")}</h5>
    </div>
    <div class="modal-body">
        <p>{__("Please log in to continue")}</p>
    </div>
    <div class="modal-footer">
        <a class="btn btn-primary" href="{$system['system_url']}/signin">{__("Login")}</a>
    </div>
</script>

<script id="modal-message" type="text/template">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h5 class="modal-title">{literal}{{title}}{/literal}</h5>
    </div>
    <div class="modal-body">
        <p>{literal}{{message}}{/literal}</p>
    </div>
</script>

<script id="modal-success" type="text/template">
    <div class="modal-body text-center">
        <div class="big-icon success">
            <i class="fa fa-thumbs-o-up fa-3x"></i>
        </div>
        <h4>{literal}{{title}}{/literal}</h4>
        <p class="mt20">{literal}{{message}}{/literal}</p>
    </div>
</script>

<script id="modal-error" type="text/template">
    <div class="modal-body text-center">
        <div class="big-icon error">
            <i class="fa fa-times fa-3x"></i>
        </div>
        <h4>{literal}{{title}}{/literal}</h4>
        <p class="mt20">{literal}{{message}}{/literal}</p>
    </div>
</script>

<script id="modal-confirm" type="text/template">
    <div class="modal-header">
        <h5 class="modal-title">{literal}{{title}}{/literal}</h5>
    </div>
    <div class="modal-body">
        <p>{literal}{{message}}{/literal}</p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{__("Cancel")}</button>
        <button type="button" class="btn btn-primary" id="modal-confirm-ok">{__("Confirm")}</button>
    </div>
</script>
<!-- Modals -->


<!-- Search -->
<script id="search-for" type="text/template">
    <div class="ptb10 plr10">
        <a href="{$system['system_url']}/search/{literal}{{#hashtag}}hashtag/{{/hashtag}}{/literal}{literal}{{query}}{/literal}">
            <i class="fa fa-search pr5"></i> {__("Search for")} {literal}{{#hashtag}}#{{/hashtag}}{/literal}{literal}{{query}}{/literal}
        </a>
    </div>
</script>
<!-- Search -->


<!-- Lightbox -->
<script id="lightbox" type="text/template">
    <div class="lightbox">
        <div class="container lightbox-container">
            <div class="lightbox-preview">
                <div class="lightbox-next js_lightbox-slider">
                    <i class="fa fa-chevron-right fa-3x"></i>
                </div>
                <div class="lightbox-prev js_lightbox-slider">
                    <i class="fa fa-chevron-left fa-3x"></i>
                </div>
                <img alt="" class="img-responsive" src="{literal}{{image}}{/literal}">
            </div>
            <div class="lightbox-data">
                <div class="clearfix">
                    <div class="pt5 pr5 pull-right flip">
                        <button data-toggle="tooltip" data-placement="bottom" title='{__("Press Esc to close")}' type="button" class="close lightbox-close js_lightbox-close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="lightbox-post">
                    <div class="js_scroller js_scroller-lightbox" data-slimScroll-height="100%">
                        <div class="loader mtb10"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>

<script id="lightbox-nodata" type="text/template">
    <div class="lightbox">
        <div class="container lightbox-container">
            <div class="lightbox-preview nodata">
                <img alt="" class="img-responsive" src="{literal}{{image}}{/literal}">
            </div>
        </div>
    </div>
</script>
<!-- Lightbox -->


{if !$user->_logged_in}

    <!-- Forget Password -->
    <script id="forget-password-confirm" type="text/template">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h5 class="modal-title">{__("Check Your Email")}</h5>
        </div>
        <form class="js_ajax-forms" data-url="core/forget_password_confirm.php">
            <div class="modal-body">
                <div class="mb20">
                    {__("Check your email")} - {__("We sent you an email with a six-digit confirmation code. Enter it below to continue to reset your password")}.
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input name="reset_key" type="text" class="form-control" placeholder="######" required autofocus>
                        </div>

                        <!-- error -->
                        <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                        <!-- error -->
                    </div>
                    <div class="col-md-6">
                        <label class="mb0">{__("We sent your code to")}</label> {literal}{{email}}{/literal}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input name="email" type="hidden" value="{literal}{{email}}{/literal}">
                <button type="submit" class="btn btn-primary">{__("Continue")}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{__("Cancel")}</button>
            </div>
        </form>
    </script>

    <script id="forget-password-reset" type="text/template">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 class="modal-title">{__("Change Your Password!")}</h5>
        </div>
        <form class="js_ajax-forms" data-url="core/forget_password_reset.php">
            <div class="modal-body">
                <div class="form-group">
                    <label for="password">{__("New Password")}</label>
                    <input name="password" id="password" type="password" class="form-control" required autofocus>
                </div>
                <div class="form-group">
                    <label for="confirm">{__("Confirm Password")}</label>
                    <input name="confirm" id="confirm" type="password" class="form-control" required>
                </div>
                <!-- error -->
                <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                <!-- error -->
            </div>
            <div class="modal-footer">
                <input name="email" type="hidden" value="{literal}{{email}}{/literal}">
                <input name="reset_key" type="hidden" value="{literal}{{reset_key}}{/literal}">
                <button type="submit" class="btn btn-primary">{__("Continue")}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{__("Cancel")}</button>
            </div>
        </form>
    </script>
    <!-- Forget Password -->

{else}

    <!-- Email Activation -->
    <script id="activation-email-reset" type="text/template">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 class="modal-title">{__("Change Email Address")}</h5>
        </div>
        <form class="js_ajax-forms" data-url="core/activation_email_reset.php">
            <div class="modal-body">
                <div class="form-group">
                    <label>{__("Current Email")}</label>
                    <p class="form-control-static">{$user->_data['user_email']}</p>

                </div>
                <div class="form-group">
                    <label for="email">{__("New Email")}</label>
                    <input name="email" id="email" type="email" class="form-control" required autofocus>
                </div>
                <!-- error -->
                <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                <!-- error -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{__("Continue")}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{__("Cancel")}</button>
            </div>
        </form>
    </script>
    <!-- Email Activation -->


    <!-- Phone Activation -->
    <script id="activation-phone" type="text/template">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 class="modal-title">{__("Enter the code from the SMS message")}</h5>
        </div>
        <form class="js_ajax-forms" data-url="core/activation_phone_confirm.php">
            <div class="modal-body">
                <div class="mb20">
                    {__("Let us know if this mobile number belongs to you. Enter the code in the SMS")}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input name="token" type="text" class="form-control" placeholder="######" required autofocus>
                            {if $user->_data['user_phone']}
                                <span class="help-block">
                                    <span class="text-link" data-toggle="modal" data-url="core/activation_phone_resend.php">{__("Resend SMS")}</span>
                                </span>
                            {/if}
                        </div>

                        <!-- error -->
                        <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                        <!-- error -->
                    </div>
                    <div class="col-md-6">
                        {if $user->_data['user_phone']}
                            <label class="mb0">{__("We sent your code to")}</label> {$user->_data['user_phone']}
                        {/if}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{__("Continue")}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{__("Cancel")}</button>
            </div>
        </form>
    </script>

    <script id="activation-phone-reset" type="text/template">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 class="modal-title">{__("Change Phone Number")}</h5>
        </div>
        <form class="js_ajax-forms" data-url="core/activation_phone_reset.php">
            <div class="modal-body">
                {if $user->_data['user_phone']}
                    <div class="form-group">
                        <label>{__("Current Phone")}</label>
                        <p class="form-control-static">{$user->_data['user_phone']}</p>

                    </div>
                {/if}
                <div class="form-group">
                    <label for="phone">{__("New Phone")}</label>
                    <input name="phone" id="phone" type="text" class="form-control" required autofocus>
                    <span class="help-block">
                        {__("For example")}: +12344567890
                    </span>
                </div>
                <!-- error -->
                <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                <!-- error -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{__("Continue")}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{__("Cancel")}</button>
            </div>
        </form>
    </script>
    <!-- Phone Activation -->


    <!-- x-uploader -->
    {/strip}
    <script id="x-uploader" type="text/template">
        <form class="x-uploader" action="{literal}{{url}}{/literal}" method="post" enctype="multipart/form-data">
            {literal}{{#multiple}}{/literal}
            <input name="file[]" type="file" multiple="multiple">
            {literal}{{/multiple}}{/literal}
            {literal}{{^multiple}}{/literal}
            <input name="file" type="file">
            {literal}{{/multiple}}{/literal}
            <input type="hidden" name="secret" value="{literal}{{secret}}{/literal}">
        </form>
    </script>
    {strip}
    <!-- x-uploader -->


    <!-- Publisher -->
    <script id="publisher-attachments-item" type="text/template">
        <li class="item deletable" data-src="{literal}{{src}}{/literal}">
            <img alt="" src="{literal}{{image_path}}{/literal}">
            <button type="button" class="close js_publisher-attachment-remover" title='{__("Remove")}'><span>&times;</span></button>
        </li>
    </script>

    <script id="comment-attachments-item" type="text/template">
        <li class="item deletable" data-src="{literal}{{src}}{/literal}">
            <img alt="" src="{literal}{{image_path}}{/literal}">
            <button type="button" class="close js_comment-attachment-remover" title='{__("Remove")}'><span>&times;</span></button>
        </li>
    </script>

    <script id="chat-attachments-item" type="text/template">
        <li class="item deletable" data-src="{literal}{{src}}{/literal}">
            <img alt="" src="{literal}{{image_path}}{/literal}">
            <button type="button" class="close js_chat-attachment-remover" title='{__("Remove")}'><span>&times;</span></button>
        </li>
    </script>

    <script id="scraper-media" type="text/template">
        <div class="publisher-scraper-remover js_publisher-scraper-remover">
            <button type="button" class="close"><span>&times;</span></button>
        </div>
        <div class="post-media">
            <div class="embed-responsive embed-responsive-16by9">
                {literal}{{{html}}}{/literal}
            </div>
            <div class="post-media-meta">
                <a class="title mb5" href="{literal}{{url}}{/literal}" target="_blank">{literal}{{title}}{/literal}</a>
                <div class="text mb5">{literal}{{text}}{/literal}</div>
                <div class="source">{literal}{{provider}}{/literal}</div>
            </div>
        </div>
    </script>

    <script id="scraper-photo" type="text/template">
        <div class="publisher-scraper-remover js_publisher-scraper-remover">
            <button type="button" class="close"><span>&times;</span></button>
        </div>
        <div class="post-media">
            <div class="post-media-image">
                <div style="background-image:url('{literal}{{url}}{/literal}');"></div>
            </div>
            <div class="post-media-meta">
                <div class="source">{literal}{{provider}}{/literal}</div>
            </div>
        </div>
    </script>

    <script id="scraper-link" type="text/template">
        <div class="publisher-scraper-remover js_publisher-scraper-remover">
            <button type="button" class="close"><span>&times;</span></button>
        </div>
        <div class="post-media">
            {literal}{{#thumbnail}}{/literal}
            <div class="post-media-image">
                <div style="background-image:url('{literal}{{thumbnail}}{/literal}');"></div>
            </div>
            {literal}{{/thumbnail}}{/literal}
            <div class="post-media-meta">
                <a class="title mb5" href="{literal}{{url}}{/literal}" target="_blank">{literal}{{title}}{/literal}</a>
                <div class="text mb5">{literal}{{text}}{/literal}</div>
                <div class="source">{literal}{{host}}{/literal}</div>
            </div>
        </div>
    </script>

    <!-- Publisher -->


    <!-- Edit (Posts|Comments) -->
    <script id="edit-post" type="text/template">
        <div class="post-edit">
            <div class="x-form comment-form">
                <textarea rows="2" class="js_autosize js_mention js_update-post">{literal}{{text}}{/literal}</textarea>
                <div class="x-form-tools">
                    <div class="x-form-tools-emoji js_emoji-menu-toggle">
                        <i class="fa fa-smile-o fa-lg"></i>
                    </div>
                    {include file='_emoji-menu.tpl'}
                </div>
            </div>
            <small class="text-link js_unedit-post">{__("Cancel")}</small>
        </div>
    </script>

    <script id="edit-comment" type="text/template">
        <div class="comment-edit">
            <div class="x-form comment-form">
                <textarea rows="1" class="js_autosize js_mention js_update-comment">{literal}{{text}}{/literal}</textarea>
                <div class="x-form-tools">
                    <div class="x-form-tools-attach">
                        <i class="fa fa-camera js_x-uploader" data-handle="comment"></i>
                    </div>
                    <div class="x-form-tools-emoji js_emoji-menu-toggle">
                        <i class="fa fa-smile-o fa-lg"></i>
                    </div>
                    {include file='_emoji-menu.tpl'}
                </div>
            </div>
            <div class="comment-attachments attachments clearfix x-hidden">
                <ul>
                    <li class="loading">
                        <div class="loader loader_small"></div>
                    </li>
                </ul>
            </div>
            <small class="text-link js_unedit-comment">{__("Cancel")}</small>
        </div>
    </script>
    <!-- Edit (Posts|Comments) -->


    <!-- Hidden (Posts|Authors) -->
    <script id="hidden-post" type="text/template">
        <div class="post flagged" data-id="{literal}{{id}}{/literal}">
            <div class="text-semibold mb5">{__("Post Hidden")}</div>
            {__("This post will no longer appear to you")} <span class="text-link js_unhide-post">{__("Undo")}</span>
        </div>
    </script>

    <script id="hidden-author" type="text/template">
        <div class="post flagged" data-id="{literal}{{id}}{/literal}">
            {__("You won't see posts from")} {literal}{{name}}{/literal} {__("in News Feed anymore")}. <span class="text-link js_unhide-author" data-author-id="{literal}{{uid}}{/literal}" data-author-name="{literal}{{name}}{/literal}">{__("Undo")}</span>
        </div>
    </script>
    <!-- Hidden (Posts|Authors) -->


    <!-- DayTime Messages -->
    <script id="message-morning" type="text/template">
        <div class="panel daytime_message">
            <button type="button" class="close pull-right flip js_daytime-remover"><span>&times;</span></button>
            <img src="{$system['system_url']}/content/themes/{$system['theme']}/images/good_morning.png">
            <strong>{__("Good Morning")}, {$user->_data['user_firstname']}</strong>
        </div>
    </script>
    <script id="message-afternoon" type="text/template">
        <div class="panel daytime_message">
            <button type="button" class="close pull-right flip js_daytime-remover"><span>&times;</span></button>
            <img src="{$system['system_url']}/content/themes/{$system['theme']}/images/good_afternoon.png">
            <strong>{__("Good Afternoon")}, {$user->_data['user_firstname']}</strong>
        </div>
    </script>
    <script id="message-evening" type="text/template">
        <div class="panel daytime_message">
            <button type="button" class="close pull-right flip js_daytime-remover"><span>&times;</span></button>
            <img src="{$system['system_url']}/content/themes/{$system['theme']}/images/good_night.png">
            <strong>{__("Good Evening")}, {$user->_data['user_firstname']}</strong>
        </div>
    </script>
    <!-- DayTime Messages -->


    <!-- Noty Notification -->
    <script id="noty-notification" type="text/template">
        <div class="data-container small">
            <img class="data-avatar" src="{literal}{{image}}{/literal}">
            <div class="data-content">{literal}{{message}}{/literal}</div>
        </div>
    </script>
    <!-- Noty Notification -->

{/if}
{/strip}
