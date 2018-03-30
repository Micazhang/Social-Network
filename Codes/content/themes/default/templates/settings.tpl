{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page content -->
<div class="container mt20 offcanvas">
    <div class="row">

        <!-- left panel -->
        <div class="col-sm-3 offcanvas-sidebar">
            <div class="panel panel-default">
                <div class="panel-body with-nav">
                    <ul class="side-nav">
                        <li {if $view == ""}class="active"{/if}>
                            <a href="{$system['system_url']}/settings"><i class="fa fa-cog fa-fw fa-lg pr10"></i> {__("Account Settings")}</a>
                        </li>
                        <li {if $view == "profile"}class="active"{/if}>
                            <a href="{$system['system_url']}/settings/profile"><i class="fa fa-user fa-fw fa-lg pr10"></i> {__("Edit Profile")}</a>
                        </li>
                        <li {if $view == "privacy"}class="active"{/if}>
                            <a href="{$system['system_url']}/settings/privacy"><i class="fa fa-lock fa-fw fa-lg pr10"></i> {__("Privacy Settings")}</a>
                        </li>

                        {if $system['email_notifications']}
                            {if $system['email_post_likes'] || $system['email_post_comments'] || $system['email_post_shares'] || $system['email_wall_posts'] || $system['email_mentions'] || $system['email_profile_visits'] || $system['email_friend_requests']}
                                <li {if $view == "notifications"}class="active"{/if}>
                                    <a href="{$system['system_url']}/settings/notifications"><i class="fa fa-envelope-open-o fa-fw fa-lg pr10"></i> {__("Email Notifications")}</a>
                                </li>
                            {/if}
                        {/if}
                        {if $system['delete_accounts_enabled']}
                            <li {if $view == "delete"}class="active"{/if}>
                                <a href="{$system['system_url']}/settings/delete"><i class="fa fa-trash fa-fw fa-lg pr10"></i> {__("Delete Account")}</a>
                            </li>
                        {/if}
                    </ul>
                </div>
            </div>
        </div>
        <!-- left panel -->

        <!-- right panel -->
        <div class="col-sm-9 offcanvas-mainbar">
            <div class="panel panel-default">

                {if $view == ""}
                    <div class="panel-heading with-icon with-nav">
                        <!-- panel title -->
                        <div class="mb20">
                            <i class="fa fa-cog pr5 panel-icon"></i>
                            <strong>{__("Account Settings")}</strong>
                        </div>
                        <!-- panel title -->

                        <!-- panel nav -->
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#username" data-toggle="tab">
                                    <i class="fa fa-cog fa-fw mr5"></i><strong class="pr5">{__("Username")}</strong>
                                </a>
                            </li>
                            <li>
                                <a href="#email" data-toggle="tab">
                                    <i class="fa fa-envelope-o fa-fw mr5"></i><strong class="pr5">{__("Email")}</strong>
                                </a>
                            </li>
                            <li>
                                <a href="#password" data-toggle="tab">
                                    <i class="fa fa-key fa-fw mr5"></i><strong class="pr5">{__("Password")}</strong>
                                </a>
                            </li>
                        </ul>
                        <!-- panel nav -->
                    </div>
                    <div class="panel-body tab-content">
                        <!-- username tab -->
                        <div class="tab-pane active" id="username">
                            <form class="js_ajax-forms form-horizontal" data-url="users/settings.php?edit=username">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Username")}
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">{$system['system_url']}/</span>
                                            <input type="text" class="form-control" name="username" value="{$user->_data['user_name']}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
                                    </div>
                                </div>

                                <!-- success -->
                                <div class="alert alert-success mb0 mt10 x-hidden" role="alert"></div>
                                <!-- success -->

                                <!-- error -->
                                <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                                <!-- error -->
                            </form>
                        </div>
                        <!-- username tab -->

                        <!-- email tab -->
                        <div class="tab-pane" id="email">
                            <form class="js_ajax-forms form-horizontal" data-url="users/settings.php?edit=email">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Email Address")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email" value="{$user->_data['user_email']}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
                                    </div>
                                </div>

                                <!-- success -->
                                <div class="alert alert-success mb0 mt10 x-hidden" role="alert"></div>
                                <!-- success -->

                                <!-- error -->
                                <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                                <!-- error -->
                            </form>
                        </div>
                        <!-- email tab -->

                        <!-- password tab -->
                        <div class="tab-pane" id="password">
                            <form class="js_ajax-forms form-horizontal" data-url="users/settings.php?edit=password">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Current")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="current">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("New")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="new">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Re-type new")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="confirm">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
                                    </div>
                                </div>

                                <!-- success -->
                                <div class="alert alert-success mb0 mt10 x-hidden" role="alert"></div>
                                <!-- success -->

                                <!-- error -->
                                <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                                <!-- error -->
                            </form>
                        </div>
                        <!-- password tab -->
                    </div>
                {elseif $view == "profile"}
                    <div class="panel-heading with-icon with-nav">
                        <!-- panel title -->
                        <div class="mb20">
                            <i class="fa fa-user pr5 panel-icon"></i>
                            <strong>{__("Edit Profile")}</strong>
                        </div>
                        <!-- panel title -->

                        <!-- panel nav -->
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#basic" data-toggle="tab">
                                    <i class="fa fa-user fa-fw mr5"></i><strong class="pr5">{__("Basic")}</strong>
                                </a>
                            </li>
                            <li>
                                <a href="#work" data-toggle="tab">
                                    <i class="fa fa-briefcase fa-fw mr5"></i><strong class="pr5">{__("Work")}</strong>
                                </a>
                            </li>
                            <li>
                                <a href="#location" data-toggle="tab">
                                    <i class="fa fa-map-marker fa-fw mr5"></i><strong class="pr5">{__("Location")}</strong>
                                </a>
                            </li>
                            <li>
                                <a href="#education" data-toggle="tab">
                                    <i class="fa fa-graduation-cap fa-fw mr5"></i><strong class="pr5">{__("Education")}</strong>
                                </a>
                            </li>
                        </ul>
                        <!-- panel nav -->
                    </div>

                    <div class="panel-body tab-content">
                        <!-- basic tab -->
                        <div class="tab-pane active" id="basic">
                            <form class="js_ajax-forms form-horizontal" data-url="users/settings.php?edit=basic">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("First Name")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="firstname" value="{$user->_data['user_firstname']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Last Name")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="lastname" value="{$user->_data['user_lastname']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("I am")}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="gender" class="form-control">
                                            <option value="none">{__("Select Sex")}</option>
                                            <option {if $user->_data['user_gender'] == "male"}selected{/if} value="male">{__("Male")}</option>
                                            <option {if $user->_data['user_gender'] == "female"}selected{/if} value="female">{__("Female")}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Birthdate")}
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <select class="form-control" name="birth_month">
                                                    <option value="none">{__("Select Month")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '1'}selected{/if} value="1">{__("Jan")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '2'}selected{/if} value="2">{__("Feb")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '3'}selected{/if} value="3">{__("Mar")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '4'}selected{/if} value="4">{__("Apr")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '5'}selected{/if} value="5">{__("May")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '6'}selected{/if} value="6">{__("Jun")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '7'}selected{/if} value="7">{__("Jul")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '8'}selected{/if} value="8">{__("Aug")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '9'}selected{/if} value="9">{__("Sep")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '10'}selected{/if} value="10">{__("Oct")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '11'}selected{/if} value="11">{__("Nov")}</option>
                                                    <option {if $user->_data['user_birthdate_parsed']['month'] == '12'}selected{/if} value="12">{__("Dec")}</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-4">
                                                <select class="form-control" name="birth_day">
                                                    <option value="none">{__("Select Day")}</option>
                                                    {for $i=1 to 31}
                                                    <option {if $user->_data['user_birthdate_parsed']['day'] == $i}selected{/if} value="{$i}">{$i}</option>
                                                    {/for}
                                                </select>
                                            </div>
                                            <div class="col-xs-4">
                                                <select class="form-control" name="birth_year">
                                                    <option value="none">{__("Select Year")}</option>
                                                    {for $i=1905 to 2015}
                                                    <option {if $user->_data['user_birthdate_parsed']['year'] == $i}selected{/if} value="{$i}">{$i}</option>
                                                    {/for}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Relationship Status")}
                                    </label>
                                    <div class="col-sm-9">
                                        <select name="relationship" class="form-control">
                                            <option value="none">{__("Select Relationship")}</option>
                                            <option {if $user->_data['user_relationship'] == "single"}selected{/if} value="single">{__("Single")}</option>
                                            <option {if $user->_data['user_relationship'] == "relationship"}selected{/if} value="relationship">{__("In a relationship")}</option>
                                            <option {if $user->_data['user_relationship'] == "married"}selected{/if} value="married">{__("Married")}</option>
                                            <option {if $user->_data['user_relationship'] == "complicated"}selected{/if} value="complicated">{__("It's complicated")}</option>
                                            <option {if $user->_data['user_relationship'] == "separated"}selected{/if} value="separated">{__("Separated")}</option>
                                            <option {if $user->_data['user_relationship'] == "divorced"}selected{/if} value="divorced">{__("Divorced")}</option>
                                            <option {if $user->_data['user_relationship'] == "widowed"}selected{/if} value="widowed">{__("Widowed")}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("About Me")}
                                    </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="biography">{$user->_data['user_biography']}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Website")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="website" value="{$user->_data['user_website']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
                                    </div>
                                </div>

                                <!-- success -->
                                <div class="alert alert-success mb0 mt10 x-hidden" role="alert"></div>
                                <!-- success -->

                                <!-- error -->
                                <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                                <!-- error -->
                            </form>
                        </div>
                        <!-- basic tab -->

                        <!-- work tab -->
                        <div class="tab-pane" id="work">
                            <form class="js_ajax-forms form-horizontal" data-url="users/settings.php?edit=work">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Work Title")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="work_title" value="{$user->_data['user_work_title']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Work Place")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="work_place" value="{$user->_data['user_work_place']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
                                    </div>
                                </div>

                                <!-- success -->
                                <div class="alert alert-success mb0 mt10 x-hidden" role="alert"></div>
                                <!-- success -->

                                <!-- error -->
                                <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                                <!-- error -->
                            </form>
                        </div>
                        <!-- work tab -->

                        <!-- location tab -->
                        <div class="tab-pane" id="location">
                            <form class="js_ajax-forms form-horizontal" data-url="users/settings.php?edit=location">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Current City")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control js_geocomplete" name="city" value="{$user->_data['user_current_city']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Hometown")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control js_geocomplete" name="hometown" value="{$user->_data['user_hometown']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
                                    </div>
                                </div>

                                <!-- success -->
                                <div class="alert alert-success mb0 mt10 x-hidden" role="alert"></div>
                                <!-- success -->

                                <!-- error -->
                                <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                                <!-- error -->
                            </form>
                        </div>
                        <!-- location tab -->

                        <!-- education tab -->
                        <div class="tab-pane" id="education">
                            <form class="js_ajax-forms form-horizontal" data-url="users/settings.php?edit=education">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("School")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="edu_school" value="{$user->_data['user_edu_school']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Major")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="edu_major" value="{$user->_data['user_edu_major']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        {__("Class")}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="edu_class" value="{$user->_data['user_edu_class']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
                                    </div>
                                </div>

                                <!-- success -->
                                <div class="alert alert-success mb0 mt10 x-hidden" role="alert"></div>
                                <!-- success -->

                                <!-- error -->
                                <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                                <!-- error -->
                            </form>
                        </div>
                        <!-- education tab -->


                    </div>
                {elseif $view == "privacy"}
                    <div class="panel-heading with-icon">
                        <!-- panel title -->
                        <i class="fa fa-lock pr5 panel-icon"></i>
                        <strong>{__("Privacy Settings")}</strong>
                        <!-- panel title -->
                    </div>
                    <div class="panel-body">
                        <form class="js_ajax-forms form-horizontal" data-url="users/settings.php?edit=privacy">
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="privacy_wall">
                                    {__("Who can post on your wall")}
                                </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="privacy_wall" id="privacy_wall">
                                        <option {if $user->_data['user_privacy_wall'] == "public"}selected{/if} value="public">
                                            {__("Everyone")}
                                        </option>
                                        <option {if $user->_data['user_privacy_wall'] == "friends"}selected{/if} value="friends">
                                            {__("Friends")}
                                        </option>
                                        <option {if $user->_data['user_privacy_wall'] == "me"}selected{/if} value="me">
                                            {__("Just Me")}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="privacy_birthdate">
                                    {__("Who can see your")} {__("birthdate")}
                                </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="privacy_birthdate" id="privacy_birthdate">
                                        <option {if $user->_data['user_privacy_birthdate'] == "public"}selected{/if} value="public">
                                            {__("Everyone")}
                                        </option>
                                        <option {if $user->_data['user_privacy_birthdate'] == "friends"}selected{/if} value="friends">
                                            {__("Friends")}
                                        </option>
                                        <option {if $user->_data['user_privacy_birthdate'] == "me"}selected{/if} value="me">
                                            {__("Just Me")}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="privacy_relationship">
                                    {__("Who can see your")} {__("relationship")}
                                </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="privacy_relationship" id="privacy_relationship">
                                        <option {if $user->_data['user_privacy_relationship'] == "public"}selected{/if} value="public">
                                            {__("Everyone")}
                                        </option>
                                        <option {if $user->_data['user_privacy_relationship'] == "friends"}selected{/if} value="friends">
                                            {__("Friends")}
                                        </option>
                                        <option {if $user->_data['user_privacy_relationship'] == "me"}selected{/if} value="me">
                                            {__("Just Me")}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="privacy_basic">
                                    {__("Who can see your")} {__("basic info")}
                                </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="privacy_basic" id="privacy_basic">
                                        <option {if $user->_data['user_privacy_basic'] == "public"}selected{/if} value="public">
                                            {__("Everyone")}
                                        </option>
                                        <option {if $user->_data['user_privacy_basic'] == "friends"}selected{/if} value="friends">
                                            {__("Friends")}
                                        </option>
                                        <option {if $user->_data['user_privacy_basic'] == "me"}selected{/if} value="me">
                                            {__("Just Me")}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="privacy_work">
                                    {__("Who can see your")} {__("work info")}
                                </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="privacy_work" id="privacy_work">
                                        <option {if $user->_data['user_privacy_work'] == "public"}selected{/if} value="public">
                                            {__("Everyone")}
                                        </option>
                                        <option {if $user->_data['user_privacy_work'] == "friends"}selected{/if} value="friends">
                                            {__("Friends")}
                                        </option>
                                        <option {if $user->_data['user_privacy_work'] == "me"}selected{/if} value="me">
                                            {__("Just Me")}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="privacy_location">
                                    {__("Who can see your")} {__("location info")}
                                </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="privacy_location" id="privacy_location">
                                        <option {if $user->_data['user_privacy_location'] == "public"}selected{/if} value="public">
                                            {__("Everyone")}
                                        </option>
                                        <option {if $user->_data['user_privacy_location'] == "friends"}selected{/if} value="friends">
                                            {__("Friends")}
                                        </option>
                                        <option {if $user->_data['user_privacy_location'] == "me"}selected{/if} value="me">
                                            {__("Just Me")}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="privacy_education">
                                    {__("Who can see your")} {__("education info")}
                                </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="privacy_education" id="privacy_education">
                                        <option {if $user->_data['user_privacy_education'] == "public"}selected{/if} value="public">
                                            {__("Everyone")}
                                        </option>
                                        <option {if $user->_data['user_privacy_education'] == "friends"}selected{/if} value="friends">
                                            {__("Friends")}
                                        </option>
                                        <option {if $user->_data['user_privacy_education'] == "me"}selected{/if} value="me">
                                            {__("Just Me")}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="privacy_other">
                                    {__("Who can see your")} {__("other info")}
                                </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="privacy_other" id="privacy_other">
                                        <option {if $user->_data['user_privacy_other'] == "public"}selected{/if} value="public">
                                            {__("Everyone")}
                                        </option>
                                        <option {if $user->_data['user_privacy_other'] == "friends"}selected{/if} value="friends">
                                            {__("Friends")}
                                        </option>
                                        <option {if $user->_data['user_privacy_other'] == "me"}selected{/if} value="me">
                                            {__("Just Me")}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="privacy_friends">
                                    {__("Who can see your")} {__("friends")}
                                </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="privacy_friends" id="privacy_friends">
                                        <option {if $user->_data['user_privacy_friends'] == "public"}selected{/if} value="public">
                                            {__("Everyone")}
                                        </option>
                                        <option {if $user->_data['user_privacy_friends'] == "friends"}selected{/if} value="friends">
                                            {__("Friends")}
                                        </option>
                                        <option {if $user->_data['user_privacy_friends'] == "me"}selected{/if} value="me">
                                            {__("Just Me")}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label" for="privacy_photos">
                                    {__("Who can see your")} {__("photos")}
                                </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="privacy_photos" id="privacy_photos">
                                        <option {if $user->_data['user_privacy_photos'] == "public"}selected{/if} value="public">
                                            {__("Everyone")}
                                        </option>
                                        <option {if $user->_data['user_privacy_photos'] == "friends"}selected{/if} value="friends">
                                            {__("Friends")}
                                        </option>
                                        <option {if $user->_data['user_privacy_photos'] == "me"}selected{/if} value="me">
                                            {__("Just Me")}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-7 col-sm-offset-5">
                                    <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
                                </div>
                            </div>

                            <!-- success -->
                            <div class="alert alert-success mb0 mt10 x-hidden" role="alert"></div>
                            <!-- success -->

                            <!-- error -->
                            <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                            <!-- error -->
                        </form>
                    </div>
              
                {elseif $view == "notifications"}
                    <div class="panel-heading with-icon">
                        <!-- panel title -->
                        <i class="fa fa-envelope-open-o pr5 panel-icon"></i>
                        <strong>{__("Email Notifications")}</strong>
                        <!-- panel title -->
                    </div>
                    <div class="panel-body">
                        <form class="js_ajax-forms form-horizontal" data-url="users/settings.php?edit=notifications">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    {__("Email Me When")}
                                </label>
                                <div class="col-sm-9">
                                    {if $system['email_post_likes']}
                                        <div class="checkbox checkbox-primary">
                                            <input type="checkbox" name="email_post_likes" id="email_post_likes" {if $user->_data['email_post_likes']}checked{/if}>
                                            <label for="email_post_likes">{__("Someone liked my post")}</label>
                                        </div>
                                    {/if}
                                    {if $system['email_post_comments']}
                                        <div class="checkbox checkbox-primary">
                                            <input type="checkbox" name="email_post_comments" id="email_post_comments" {if $user->_data['email_post_comments']}checked{/if}>
                                            <label for="email_post_comments">{__("Someone commented on my post")}</label>
                                        </div>
                                    {/if}
                                    {if $system['email_post_shares']}
                                        <div class="checkbox checkbox-primary">
                                            <input type="checkbox" name="email_post_shares" id="email_post_shares" {if $user->_data['email_post_shares']}checked{/if}>
                                            <label for="email_post_shares">{__("Someone shared my post")}</label>
                                        </div>
                                    {/if}
                                    {if $system['email_wall_posts']}
                                        <div class="checkbox checkbox-primary">
                                            <input type="checkbox" name="email_wall_posts" id="email_wall_posts" {if $user->_data['email_wall_posts']}checked{/if}>
                                            <label for="email_wall_posts">{__("Someone posted on my timeline")}</label>
                                        </div>
                                    {/if}
                                    {if $system['email_mentions']}
                                        <div class="checkbox checkbox-primary">
                                            <input type="checkbox" name="email_mentions" id="email_mentions" {if $user->_data['email_mentions']}checked{/if}>
                                            <label for="email_mentions">{__("Someone mentioned me")}</label>
                                        </div>
                                    {/if}
                                    {if $system['email_profile_visits']}
                                        <div class="checkbox checkbox-primary">
                                            <input type="checkbox" name="email_profile_visits" id="email_profile_visits" {if $user->_data['email_profile_visits']}checked{/if}>
                                            <label for="email_profile_visits">{__("Someone visited my profile")}</label>
                                        </div>
                                    {/if}
                                    {if $system['email_friend_requests']}
                                        <div class="checkbox checkbox-primary">
                                            <input type="checkbox" name="email_friend_requests" id="email_friend_requests" {if $user->_data['email_friend_requests']}checked{/if}>
                                            <label for="email_friend_requests">{__("Someone sent me/accepted my friend requset")}</label>
                                        </div>
                                    {/if}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3">
                                    <button type="submit" class="btn btn-primary">{__("Save Changes")}</button>
                                </div>
                            </div>

                            <!-- success -->
                            <div class="alert alert-success mb0 mt10 x-hidden" role="alert"></div>
                            <!-- success -->

                            <!-- error -->
                            <div class="alert alert-danger mb0 mt10 x-hidden" role="alert"></div>
                            <!-- error -->
                        </form>
                    </div>
                {elseif $view == "delete"}
                    <div class="panel-heading with-icon">
                        <!-- panel title -->
                        <i class="fa fa-trash pr5 panel-icon"></i>
                        <strong>{__("Delete Account")}</strong>
                        <!-- panel title -->
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle fa-lg mr10"></i>{__("Once you delete your account you will no longer can access it again")}
                        </div>
                        <div class="text-center">
                            <button class="btn btn-danger js_delete-user"><i class="fa fa-trash mr5"></i>{__("Delete My Account")}</button>
                        </div>
                    </div>
                {/if}

            </div>
        </div>
        <!-- right panel -->

    </div>
</div>
<!-- page content -->

{include file='_footer.tpl'}
