<?php
/**
 * index
 *
 * 
 * 
 */

// fetch bootstrap
require('bootstrap.php');

try {

	// check user logged in
	if(!$user->_logged_in) {

		// page header
		page_header(__("Welcome to").' '.$system['system_title']);

	} else {

		// user access
		user_access();

		// get view content
		switch ($_GET['view']) {
			case '':
				// page header
				page_header($system['system_title']);

				// prepare publisher
				$smarty->assign('feelings', get_feelings());
				$smarty->assign('feelings_types', get_feelings_types());

				// check daytime messages
				$daytime_msg_enabled = (isset($_COOKIE['dt_msg']))? false : $system['daytime_msg_enabled'];
				$smarty->assign('daytime_msg_enabled', $daytime_msg_enabled);

				// get posts (newsfeed)
				$posts = $user->get_posts();
				/* assign variables */
				$smarty->assign('posts', $posts);
				break;

			case 'saved':
				// page header
				page_header(__("Saved Posts"));

				// get posts (saved)
				$posts = $user->get_posts( array('get' => 'saved') );
				/* assign variables */
				$smarty->assign('posts', $posts);
				break;

			case 'articles':
				// page header
				page_header(__("My Articles"));

				// get posts (articles)
				$posts = $user->get_posts( array('get' => 'posts_profile', 'id' => $user->_data['user_id'], 'filter' => 'article' ) );
				/* assign variables */
				$smarty->assign('posts', $posts);
				break;

			default:
				_error(404);
				break;
		}
		/* assign variables */
		$smarty->assign('view', $_GET['view']);

		}


		} catch (Exception $e) {
	_error(__("Error"), $e->getMessage());
}

// page footer
page_footer("index");

?>
