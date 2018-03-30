<?php
/**
 * post
 *
 * 
 * 
 */

// fetch bootstrap
require('bootstrap.php');

// user access
if(!$system['system_public']) {
	user_access();
}

// valid inputs
if(!isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
	_error(404);
}

try {

	// get post
	$post = $user->get_post($_GET['post_id']);
	if(!$post)  {
		_error(404);
	}
	/* assign variables */
	$smarty->assign('post', $post);

} catch (Exception $e) {
	_error(__("Error"), $e->getMessage());
}

// page header
page_header($post['post_author_name']);

// page footer
page_footer("post");

?>
