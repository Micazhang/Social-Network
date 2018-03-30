<?php
/**
 * settings
 *
 *
 *
 */

// fetch bootstrap
require('bootstrap.php');

// user access
user_access();

try {

	// get view content
	switch ($_GET['view']) {
		case '':
			// page header
			page_header(__("Settings")." &rsaquo; ".__("Account Settings"));
			break;

		case 'profile':
			// page header
			page_header(__("Settings")." &rsaquo; ".__("Edit Profile"));

			// parse birthdate
			$user->_data['user_birthdate_parsed'] = date_parse($user->_data['user_birthdate']);

		case 'privacy':
			// page header
			page_header(__("Settings")." &rsaquo; ".__("Privacy Settings"));
			break;

		

		case 'notifications':
			if(!$system['email_notifications']) {
				_error(404);
			}
			if(!$system['email_post_likes'] && !$system['email_post_comments'] && !$system['email_post_shares'] && !$system['email_wall_posts'] && !$system['email_mentions'] && !$system['email_profile_visits'] && !$system['email_friend_requests'] && !$system['email_page_likes'] && !$system['email_group_joins']) {
                _error(404);
            }
			// page header
			page_header(__("Settings")." &rsaquo; ".__("Email Notifications"));
			break;

		case 'delete':
			if(!$system['delete_accounts_enabled']) {
				_error(404);
			}
			// page header
			page_header(__("Settings")." &rsaquo; ".__("Delete Account"));
			break;

		default:
		_error(404);
	}
	/* assign variables */
	$smarty->assign('view', $_GET['view']);

} catch (Exception $e) {
	_error(__("Error"), $e->getMessage());
}

// page footer
page_footer("settings");

?>
