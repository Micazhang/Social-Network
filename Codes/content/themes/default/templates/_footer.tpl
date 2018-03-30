<!-- footer -->
<div class="container">
	<div class="row footer">
		<p align="right">
				{__("The 2018 Winter Project - Social Network. Min Guo & Qiuxuan Zhang")}
		</p>
	</div>
</div>
<!-- footer -->

</div>
<!-- main wrapper -->

<!-- Dependencies CSS [Twemoji-Awesome|Flag-Icon] -->
{if !$user->_logged_in}
<link rel="stylesheet" href="{$system['system_url']}/includes/assets/css/font-awesome/css/font-awesome.min.css">
{/if}
<link rel="stylesheet" href="{$system['system_url']}/includes/assets/css/twemoji-awesome/twemoji-awesome.min.css">
<link rel="stylesheet" href="{$system['system_url']}/includes/assets/css/flag-icon/css/flag-icon.min.css">
<!-- Dependencies CSS [Twemoji-Awesome|Flag-Icon] -->

<!-- JS Files -->
{include file='_js_files.tpl'}
<!-- JS Files -->

<!-- JS Templates -->
{include file='_js_templates.tpl'}
<!-- JS Templates -->

<!-- Analytics Code -->
{if $system['analytics_code']}{html_entity_decode($system['analytics_code'], ENT_QUOTES)}{/if}
<!-- Analytics Code -->

{if $user->_logged_in}
	<!-- Notification -->
	<audio id="notification_sound">
		<source src="{$system['system_url']}/includes/assets/sounds/notification.mp3" type="audio/mpeg">
	</audio>
	<!-- Notification -->
	<!-- Call -->
	<audio id="call_sound">
		<source src="{$system['system_url']}/includes/assets/sounds/call.mp3" type="audio/mpeg">
	</audio>
	<!-- Call -->
	<!-- Video -->
	<audio id="video_sound">
		<source src="{$system['system_url']}/includes/assets/sounds/video.mp3" type="audio/mpeg">
	</audio>
	<!-- Video -->
{/if}

</body>
</html>
