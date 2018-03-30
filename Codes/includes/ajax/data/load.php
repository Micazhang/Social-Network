<?php
/**
 * ajax -> data -> load
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
if(!isset($_POST['offset']) || !is_numeric($_POST['offset'])) {
	_error(400);
}

// load more data
try {

	// initialize the return array
	$return = array();

	// initialize the attach type
	$append = true;

	// get data
	/* get newsfeed & saved posts */
	if($_POST['get'] == "newsfeed" || $_POST['get'] == "saved") {
		$data = $user->get_posts( array('get' => $_POST['get'], 'filter' => $_POST['filter'], 'offset' => $_POST['offset']) );


		}



	/* get profile posts*/
	} elseif ($_POST['get'] == "posts_profile") {
		/* check id */
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			_error(400);
		}
		$data = $user->get_posts( array('get' => $_POST['get'], 'filter' => $_POST['filter'], 'offset' => $_POST['offset'], 'id' => $_POST['id']) );


		}



	/* get who shares the post */
	} elseif ($_POST['get'] == "shares") {
		/* check id */
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			_error(400);
		}
		$data = $user->who_shares($_POST['id'], $_POST['offset']);


	/* get articles */
	} elseif ($_POST['get'] == "articles") {
		$data = $user->get_articles( array('offset' => $_POST['offset']) );


	/* get post comments */
	} elseif ($_POST['get'] == "post_comments") {
		/* check id */
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			_error(400);
		}
		$append = false;
		$data = $user->get_comments($_POST['id'], $_POST['offset'], true, false);


	/* get photo comments */
	} elseif ($_POST['get'] == "photo_comments") {
		/* check id */
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			_error(400);
		}
		$append = false;
		$data = $user->get_comments($_POST['id'], $_POST['offset'], false, false);


	/* get comment replies */
	} elseif ($_POST['get'] == "comment_replies") {
		/* check id */
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			_error(400);
		}
		$append = false;
		$data = $user->get_replies($_POST['id'], $_POST['offset'], false);


	/* get photos */
	} elseif ($_POST['get'] == "photos") {
		/* check uid */
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			_error(400);
		}
		$data = $user->get_photos($_POST['id'], $_POST['type'], $_POST['offset'], false);
		$context = ($_POST['type'] == "album")? "album" : "photos";
		$smarty->assign('context', $context);


	/* get albums */
	} elseif ($_POST['get'] == "albums") {
		/* check uid */
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			_error(400);
		}
		$data = $user->get_albums($_POST['id'], $_POST['type'], $_POST['offset']);


	/* get who likes the post */
	} elseif ($_POST['get'] == "post_likes") {
		/* check id */
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			_error(400);
		}
		$data = $user->who_likes( array('post_id' => $_POST['id'], 'offset' => $_POST['offset']) );


	/* get who likes the photo */
	} elseif ($_POST['get'] == "photo_likes") {
		/* check id */
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			_error(400);
		}
		$data = $user->who_likes( array('photo_id' => $_POST['id'], 'offset' => $_POST['offset']) );


	/* get who likes the comment */
	} elseif ($_POST['get'] == "comment_likes") {
		/* check id */
		if(!isset($_POST['id']) || !is_numeric($_POST['id'])) {
			_error(400);
		}
		$data = $user->who_likes( array('comment_id' => $_POST['id'], 'offset' => $_POST['offset']) );

	}


	/* get friend requests */
	} elseif ($_POST['get'] == "friend_requests") {
		$data = $user->get_friend_requests($_POST['offset']);


	/* get mutual friends */
	} elseif ($_POST['get'] == "friend_requests_sent") {
		$data = $user->get_friend_requests_sent($_POST['offset']);


	/* get mutual friends */
	} elseif ($_POST['get'] == "mutual_friends") {
		/* check uid */
		if(!isset($_POST['uid']) || !is_numeric($_POST['uid'])) {
			_error(400);
		}
		$data = $user->get_mutual_friends($_POST['uid'], $_POST['offset']);


	/* get new people */
	} elseif ($_POST['get'] == "new_people") {
		$data = $user->get_new_people($_POST['offset']);


	/* get friends */
	} elseif ($_POST['get'] == "friends") {
		/* check uid */
		if(!isset($_POST['uid']) || !is_numeric($_POST['uid'])) {
			_error(400);
		}
		$data = $user->get_friends($_POST['uid'], $_POST['offset']);


	/* get followers */
	} elseif ($_POST['get'] == "followers") {
		/* check uid */
		if(!isset($_POST['uid']) || !is_numeric($_POST['uid'])) {
			_error(400);
		}
		$data = $user->get_followers($_POST['uid'], $_POST['offset']);


	/* get followings */
	} elseif ($_POST['get'] == "followings") {
		/* check uid */
		if(!isset($_POST['uid']) || !is_numeric($_POST['uid'])) {
			_error(400);
		}
		$data = $user->get_followings($_POST['uid'], $_POST['offset']);


	/* get notifications */
	} elseif ($_POST['get'] == "notifications") {
		$data = $user->get_notifications($_POST['offset']);


	/* bad request */
	} else {
		_error(400);
	}

	// handle data
	if(count($data) > 0) {
		/* assign variables */
		$smarty->assign('offset', $_POST['offset']);
		$smarty->assign('get', $_POST['get']);
		$smarty->assign('data', $data);
		/* return */
		$return['append'] = $append;
		$return['data'] = $smarty->fetch("ajax.load_more.tpl");
	}

	// return & exit
	return_json($return);

} catch (Exception $e) {
	modal(ERROR, __("Error"), $e->getMessage());
}

?>
