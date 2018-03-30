<?php
/**
 * notifications
 *
 * 
 * 
 */

// fetch bootstrap
require('bootstrap.php');

// user access
user_access();

// page header
page_header(__("Notifications"));


// notifications
try {

	// reset live counters
	$user->live_counters_reset('notifications');

} catch (Exception $e) {
	_error(__("Error"), $e->getMessage());
}

// page footer
page_footer("notifications");

?>
