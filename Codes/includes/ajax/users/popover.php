<?php
/**
 * ajax -> users -> popover
 *
 * 
 * 
 */

// fetch bootstrap
require('../../../bootstrap.php');

// check AJAX Request
is_ajax();

// user access
user_access(true);

// valid inputs
$valid['type'] = array('user');
if(!in_array($_GET['type'], $valid['type'])) {
	_error(400);
}
/* check uid */
if(!isset($_GET['uid']) || !is_numeric($_GET['uid'])) {
	_error(400);
}

// get popover
try {

	// initialize the return array
	$return = array();

	// get (user) popover
	$profile = $user->popover($_GET['uid'], $_GET['type']);
	if($profile) {
		/* assign variables */
		$smarty->assign('type', $_GET['type']);
		$smarty->assign('profile', $profile);
		/* return */
		$return['popover'] = $smarty->fetch("ajax.popover.tpl");
	}

	// return & exit
	return_json($return);

}catch (Exception $e) {
	modal(ERROR, __("Error"), $e->getMessage());
}

?>
