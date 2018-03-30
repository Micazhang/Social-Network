<?php
/**
 * ajax -> posts -> post
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
if(!in_array($_POST['handle'], array('me', 'user'))) {
	_error(400);
}
/* filter link */
if(isset($_POST['link'])) {
	$_POST['link'] = _json_decode($_POST['link']);
	if(!is_object($_POST['link'])) {
		_error(400);
	}
}
/* filter video */
if(isset($_POST['video'])) {
	$_POST['video'] = _json_decode($_POST['video']);
	if(!is_object($_POST['video'])) {
		_error(400);
	}
}
/* filter audio */
if(isset($_POST['audio'])) {
	$_POST['audio'] = _json_decode($_POST['audio']);
	if(!is_object($_POST['audio'])) {
		_error(400);
	}
}
/* filter file */
if(isset($_POST['file'])) {
	$_POST['file'] = _json_decode($_POST['file']);
	if(!is_object($_POST['file'])) {
		_error(400);
	}
}
/* filter photos */
$photos = array();
if(isset($_POST['photos'])) {
	$_POST['photos'] = _json_decode($_POST['photos']);
	if(!is_object($_POST['photos'])) {
		_error(400);
	}
	/* filter the photos */
	foreach($_POST['photos'] as $photo) {
		$photos[] = $photo;
	}
	if(count($photos) == 0) {
		_error(400);
	}
}

// publisher
try {

	// initialize the return array
	$return = $inputs = array();

	// publish the new post
	if($_POST['handle'] == 'user') {
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			_error(400);
		}
		$inputs['id'] = $_POST['id'];
		/* if privacy set and not valid */
		if(!isset($_POST['privacy']) || !in_array($_POST['privacy'], array('friends', 'public'))) {
			_error(400);
		}
		$inputs['privacy'] = $_POST['privacy'];
		$_get = 'posts_profile';

	} else {
		/* if privacy set and not valid */
		if(!isset($_POST['privacy']) || !in_array($_POST['privacy'], array('me', 'friends', 'public'))) {
			_error(400);
		}
		$inputs['privacy'] = $_POST['privacy'];
		$_get = 'newfeed';

	}
	/* prepare inputs */
	$inputs['handle'] = $_POST['handle'];
	$inputs['message'] = $_POST['message'];
	$inputs['link'] = $_POST['link'];
	$inputs['video'] = $_POST['video'];
	$inputs['audio'] = $_POST['audio'];
	$inputs['file'] = $_POST['file'];
	$inputs['photos'] = $photos;
	$inputs['album'] = $_POST['album'];
	$inputs['location'] = $_POST['location'];
	$inputs['feeling_action'] = $_POST['feeling_action'];
	$inputs['feeling_value'] = $_POST['feeling_value'];
	/* publish */
	$post = $user->publisher($inputs);
	/* assign variables */
	$smarty->assign('post', $post);
	$smarty->assign('_get', $_get);
	/* return */
	$return['post'] = $smarty->fetch("__feeds_post.tpl");

	// return & exit
	return_json($return);

} catch (Exception $e) {
	modal(ERROR, __("Error"), $e->getMessage());
}

?>
