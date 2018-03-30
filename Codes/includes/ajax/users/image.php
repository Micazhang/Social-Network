<?php
/**
 * ajax -> users -> image
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

// remove image (picture|cover)
try {

	// initialize the return array
	$return = array();

	switch ($_POST['handle']) {
		case 'cover-user':
			/* update user cover */
			$db->query(sprintf("UPDATE users SET user_cover = null, user_cover_id = null WHERE user_id = %s", secure($user->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
			break;

		case 'picture-user':
			/* update user picture */
			$db->query(sprintf("UPDATE users SET user_picture = null, user_picture_id = null WHERE user_id = %s", secure($user->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
			/* return */
			$return['file'] = $user->get_picture('', $user->_data['user_gender']);
			break;

		default:
			_error(400);
			break;
	}

	// return & exit
	return_json($return);

}catch (Exception $e) {
	modal(ERROR, __("Error"), $e->getMessage());
}

?>
