<?php
/**
 * class -> user
 *
 *
 *
 */

class User {

	public $_logged_in = false;
    public $_is_admin = false;
    public $_data = array();

	private $_cookie_user_id = "c_user";
    private $_cookie_user_token = "xs";
    private $_cookie_user_referrer = "ref";


    /* ------------------------------- */
    /* __construct */
    /* ------------------------------- */


	/**
     * __construct
     *
     * @return void
     */
    public function __construct() {
        global $db, $system;
        if(isset($_COOKIE[$this->_cookie_user_id]) && isset($_COOKIE[$this->_cookie_user_token])) {
            $query = $db->query(sprintf("SELECT users.* FROM users INNER JOIN users_sessions ON users.user_id = users_sessions.user_id WHERE users_sessions.user_id = %s AND users_sessions.session_token = %s", secure($_COOKIE[$this->_cookie_user_id], 'int'), secure($_COOKIE[$this->_cookie_user_token]) )) or _error(SQL_ERROR_THROWEN);
            if($query->num_rows > 0) {
                $this->_data = $query->fetch_assoc();
                $this->_logged_in = true;
                $this->_is_admin = true;
                /* active session */
                $this->_data['active_session'] = $_COOKIE[$this->_cookie_user_token];
                /* get user picture */
                $this->_data['user_picture'] = $this->get_picture($this->_data['user_picture'], $this->_data['user_gender']);
                /* get all friends ids */
                $this->_data['friends_ids'] = $this->get_friends_ids($this->_data['user_id']);
                /* get all followings ids */
                $this->_data['followings_ids'] = $this->get_followings_ids($this->_data['user_id']);
                /* get all friend requests ids */
                $this->_data['friend_requests_ids'] = $this->get_friend_requests_ids();
                /* get all friend requests sent ids */
                $this->_data['friend_requests_sent_ids'] = $this->get_friend_requests_sent_ids();
                /* get friend requests */
                $this->_data['friend_requests'] = $this->get_friend_requests();
                $this->_data['friend_requests_count'] = count($this->_data['friend_requests']);
                /* get friend requests sent */
                $this->_data['friend_requests_sent'] = $this->get_friend_requests_sent();
                $this->_data['friend_requests_sent_count'] = count($this->_data['friend_requests_sent']);
                /* get search log */
                $this->_data['search_log'] = $this->get_search_log();
                /* get new people */
                $this->_data['new_people'] = $this->get_new_people(0, true);
                /* get notifications */
                $this->_data['notifications'] = $this->get_notifications();
            }
        }
    }


    /* ------------------------------- */
    /* Picture & Cover */
    /* ------------------------------- */

    /**
     * get_picture
     *
     * @param string $picture
     * @param string $type
     * @return string
     */
    public static function get_picture($picture, $type) {
        global $system;
        if($picture == "") {
            switch ($type) {
                case 'male':
                    $picture = $system['system_url'].'/content/themes/'.$system['theme'].'/images/blank_profile_male.jpg';
                    break;

                case 'female':
                    $picture = $system['system_url'].'/content/themes/'.$system['theme'].'/images/blank_profile_female.jpg';
                    break;

                case 'article':
                    $picture = $system['system_url'].'/content/themes/'.$system['theme'].'/images/blank_article.jpg';
                    break;
            }
        } else {
            $picture = $system['system_uploads'].'/'.$picture;
        }
        return $picture;
    }



    /* ------------------------------- */
    /* Get Ids */
    /* ------------------------------- */

    /**
     * get_friends_ids
     *
     * @param integer $user_id
     * @return array
     */
    public function get_friends_ids($user_id) {
        global $db;
        $friends = array();
        $get_friends = $db->query(sprintf('SELECT users.user_id FROM friends INNER JOIN users ON (friends.user_one_id = users.user_id AND friends.user_one_id != %1$s) OR (friends.user_two_id = users.user_id AND friends.user_two_id != %1$s) WHERE status = 1 AND (user_one_id = %1$s OR user_two_id = %1$s)', secure($user_id, 'int'))) or _error(SQL_ERROR_THROWEN);
        if($get_friends->num_rows > 0) {
            while($friend = $get_friends->fetch_assoc()) {
                $friends[] = $friend['user_id'];
            }
        }
        return $friends;
    }


    /**
     * get_followings_ids
     *
     * @param integer $user_id
     * @return array
     */
    public function get_followings_ids($user_id) {
        global $db;
        $followings = array();
        $get_followings = $db->query(sprintf("SELECT following_id FROM followings WHERE user_id = %s", secure($user_id, 'int'))) or _error(SQL_ERROR_THROWEN);
        if($get_followings->num_rows > 0) {
            while($following = $get_followings->fetch_assoc()) {
                $followings[] = $following['following_id'];
            }
        }
        return $followings;
    }


    /**
     * get_followers_ids
     *
     * @param integer $user_id
     * @return array
     */
    public function get_followers_ids($user_id) {
        global $db;
        $followers = array();
        $get_followers = $db->query(sprintf("SELECT user_id FROM followings WHERE following_id = %s", secure($user_id, 'int'))) or _error(SQL_ERROR_THROWEN);
        if($get_followers->num_rows > 0) {
            while($follower = $get_followers->fetch_assoc()) {
                $followers[] = $follower['user_id'];
            }
        }
        return $followers;
    }


    /**
     * get_friend_requests_ids
     *
     * @return array
     */
    public function get_friend_requests_ids() {
        global $db;
        $requests = array();
        $get_requests = $db->query(sprintf("SELECT user_one_id FROM friends WHERE status = 0 AND user_two_id = %s", secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
        if($get_requests->num_rows > 0) {
            while($request = $get_requests->fetch_assoc()) {
                $requests[] = $request['user_one_id'];
            }
        }
        return $requests;
    }


    /**
     * get_friend_requests_sent_ids
     *
     * @return array
     */
    public function get_friend_requests_sent_ids() {
        global $db;
        $requests = array();
        $get_requests = $db->query(sprintf("SELECT user_two_id FROM friends WHERE status = 0 AND user_one_id = %s", secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
        if($get_requests->num_rows > 0) {
            while($request = $get_requests->fetch_assoc()) {
                $requests[] = $request['user_two_id'];
            }
        }
        return $requests;
    }


    /* ------------------------------- */
    /* Get Users */
    /* ------------------------------- */


    /**
     * get_friends
     *
     * @param integer $user_id
     * @param integer $offset
     * @return array
     */
    public function get_friends($user_id, $offset = 0) {
        global $db, $system;
        $friends = array();
        $offset *= $system['min_results_even'];
        /* get the target user's privacy */
        $get_privacy = $db->query(sprintf("SELECT user_privacy_friends FROM users WHERE user_id = %s", secure($user_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        $privacy = $get_privacy->fetch_assoc();
        /* check the target user's privacy  */
        if(!$this->_check_privacy($privacy['user_privacy_friends'], $user_id)) {
            return $friends;
        }
        $get_friends = $db->query(sprintf('SELECT users.user_id, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture FROM friends INNER JOIN users ON (friends.user_one_id = users.user_id AND friends.user_one_id != %1$s) OR (friends.user_two_id = users.user_id AND friends.user_two_id != %1$s) WHERE status = 1 AND (user_one_id = %1$s OR user_two_id = %1$s) LIMIT %2$s, %3$s', secure($user_id, 'int'), secure($offset, 'int', false), secure($system['min_results_even'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        if($get_friends->num_rows > 0) {
            while($friend = $get_friends->fetch_assoc()) {
                $friend['user_picture'] = $this->get_picture($friend['user_picture'], $friend['user_gender']);
                /* get the connection between the viewer & the target */
                $friend['connection'] = $this->connection($friend['user_id']);
                $friends[] = $friend;
            }
        }
        return $friends;
    }


    /**
     * get_followings
     *
     * @param integer $user_id
     * @param integer $offset
     * @return array
     */
    public function get_followings($user_id, $offset = 0) {
        global $db, $system;
        $followings = array();
        $offset *= $system['min_results_even'];
        $get_followings = $db->query(sprintf('SELECT users.user_id, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture FROM followings INNER JOIN users ON (followings.following_id = users.user_id) WHERE followings.user_id = %s LIMIT %s, %s', secure($user_id, 'int'), secure($offset, 'int', false), secure($system['min_results_even'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        if($get_followings->num_rows > 0) {
            while($following = $get_followings->fetch_assoc()) {
                $following['user_picture'] = $this->get_picture($following['user_picture'], $following['user_gender']);
                /* get the connection between the viewer & the target */
                $following['connection'] = $this->connection($following['user_id'], false);
                $followings[] = $following;
            }
        }
        return $followings;
    }


    /**
     * get_followers
     *
     * @param integer $user_id
     * @param integer $offset
     * @return array
     */
    public function get_followers($user_id, $offset = 0) {
        global $db, $system;
        $followers = array();
        $offset *= $system['min_results_even'];
        $get_followers = $db->query(sprintf('SELECT users.user_id, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture FROM followings INNER JOIN users ON (followings.user_id = users.user_id) WHERE followings.following_id = %s LIMIT %s, %s', secure($user_id, 'int'), secure($offset, 'int', false), secure($system['min_results_even'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        if($get_followers->num_rows > 0) {
            while($follower = $get_followers->fetch_assoc()) {
                $follower['user_picture'] = $this->get_picture($follower['user_picture'], $follower['user_gender']);
                /* get the connection between the viewer & the target */
                $follower['connection'] = $this->connection($follower['user_id'], false);
                $followers[] = $follower;
            }
        }
        return $followers;
    }


    /**
     * get_friend_requests
     *
     * @param integer $offset
     * @param integer $last_request_id
     * @return array
     */
    public function get_friend_requests($offset = 0, $last_request_id = null) {
        global $db, $system;
        $requests = array();
        $offset *= $system['max_results'];
        if($last_request_id !== null) {
            $get_requests = $db->query(sprintf("SELECT friends.id, friends.user_one_id as user_id, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture FROM friends INNER JOIN users ON friends.user_one_id = users.user_id WHERE friends.status = 0 AND friends.user_two_id = %s AND friends.id > %s ORDER BY friends.id DESC", secure($this->_data['user_id'], 'int'), secure($last_request_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        } else {
            $get_requests = $db->query(sprintf("SELECT friends.id, friends.user_one_id as user_id, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture FROM friends INNER JOIN users ON friends.user_one_id = users.user_id WHERE friends.status = 0 AND friends.user_two_id = %s ORDER BY friends.id DESC LIMIT %s, %s", secure($this->_data['user_id'], 'int'), secure($offset, 'int', false), secure($system['max_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        }
        if($get_requests->num_rows > 0) {
            while($request = $get_requests->fetch_assoc()) {
                $request['user_picture'] = $this->get_picture($request['user_picture'], $request['user_gender']);
                $request['mutual_friends_count'] = $this->get_mutual_friends_count($request['user_id']);
                $requests[] = $request;
            }
        }
        return $requests;
    }


    /**
     * get_friend_requests_sent
     *
     * @param integer $offset
     * @return array
     */
    public function get_friend_requests_sent($offset = 0) {
        global $db, $system;
        $requests = array();
        $offset *= $system['max_results'];
        $get_requests = $db->query(sprintf("SELECT friends.user_two_id as user_id, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture FROM friends INNER JOIN users ON friends.user_two_id = users.user_id WHERE friends.status = 0 AND friends.user_one_id = %s LIMIT %s, %s", secure($this->_data['user_id'], 'int'), secure($offset, 'int', false), secure($system['max_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        if($get_requests->num_rows > 0) {
            while($request = $get_requests->fetch_assoc()) {
                $request['user_picture'] = $this->get_picture($request['user_picture'], $request['user_gender']);
                $request['mutual_friends_count'] = $this->get_mutual_friends_count($request['user_id']);
                $requests[] = $request;
            }
        }
        return $requests;
    }


    /**
     * get_mutual_friends
     *
     * @param integer $user_two_id
     * @param integer $offset
     * @return array
     */
    public function get_mutual_friends($user_two_id, $offset = 0) {
        global $db, $system;
        $mutual_friends = array();
        $offset *= $system['max_results'];
        $mutual_friends = array_intersect($this->_data['friends_ids'], $this->get_friends_ids($user_two_id));
        /* if there is no mutual friends -> return empty array */
        if(count($mutual_friends) == 0) {
            return $mutual_friends;
        }
        /* slice the mutual friends array with system max results */
        $mutual_friends = array_slice($mutual_friends, $offset, $system['max_results']);
        /* if there is no more mutual friends to show -> return empty array */
        if(count($mutual_friends) == 0) {
            return $mutual_friends;
        }
        /* make a list from mutual friends */
        $mutual_friends_list = implode(',',$mutual_friends);
        /* get the user data of each mutual friend */
        $mutual_friends = array();
        $get_mutual_friends = $db->query("SELECT * FROM users WHERE user_id IN ($mutual_friends_list)") or _error(SQL_ERROR_THROWEN);
        if($get_mutual_friends->num_rows > 0) {
            while($mutual_friend = $get_mutual_friends->fetch_assoc()) {
                $mutual_friend['user_picture'] = $this->get_picture($mutual_friend['user_picture'], $mutual_friend['user_gender']);
                $mutual_friend['mutual_friends_count'] = $this->get_mutual_friends_count($mutual_friend['user_id']);
                $mutual_friends[] = $mutual_friend;
            }
        }
        return $mutual_friends;
    }


    /**
     * get_mutual_friends_count
     *
     * @param integer $user_two_id
     * @return integer
     */
    public function get_mutual_friends_count($user_two_id) {
        return count(array_intersect($this->_data['friends_ids'], $this->get_friends_ids($user_two_id)));
    }


    /**
     * get_new_people
     *
     * @param integer $offset
     * @param boolean $random
     * @return array
     */
    public function get_new_people($offset = 0, $random = false) {
        global $db, $system;
        $old_people_ids = array();
        $offset *= $system['min_results'];
        /* merge (friends, followings, friend requests & friend requests sent) and get the unique ids  */
        $old_people_ids = array_unique(array_merge($this->_data['friends_ids'], $this->_data['followings_ids'], $this->_data['friend_requests_ids'], $this->_data['friend_requests_sent_ids']));
        /* add me to this list */
        $old_people_ids[] = $this->_data['user_id'];
        /* make a list from old people */
        $old_people_ids_list = implode(',',$old_people_ids);
        /* get users data not in old people list */
        $new_people = array();
        /* prepare where statement */
        $where = ($system['activation_enabled'])? "WHERE user_activated = '1' AND user_id NOT IN (%s)" : "WHERE user_id NOT IN (%s)";
        if($random) {
            $get_new_people = $db->query(sprintf("SELECT * FROM users ".$where." ORDER BY RAND() LIMIT %s, %s", $old_people_ids_list, secure($offset, 'int', false), secure($system['min_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        } else {
            $get_new_people = $db->query(sprintf("SELECT * FROM users ".$where." LIMIT %s, %s", $old_people_ids_list, secure($offset, 'int', false), secure($system['min_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        }
        if($get_new_people->num_rows > 0) {
            while($user = $get_new_people->fetch_assoc()) {
                $user['user_picture'] = $this->get_picture($user['user_picture'], $user['user_gender']);
                $user['mutual_friends_count'] = $this->get_mutual_friends_count($user['user_id']);
                $new_people[] = $user;
            }
        }
        return $new_people;
    }


    /**
     * get_pro_members
     *
     * @return array
     */
    public function get_pro_members() {
        global $db;
        $pro_members = array();
        $get_pro_members = $db->query("SELECT * FROM users WHERE user_subscribed = '1' ORDER BY RAND() LIMIT 3") or _error(SQL_ERROR_THROWEN);
        if($get_pro_members->num_rows > 0) {
            while($user = $get_pro_members->fetch_assoc()) {
                $user['user_picture'] = $this->get_picture($user['user_picture'], $user['user_gender']);
                $user['mutual_friends_count'] = $this->get_mutual_friends_count($user['user_id']);
                $pro_members[] = $user;
            }
        }
        return $pro_members;
    }


    /**
     * get_users
     *
     * @param string $query
     * @param array $skipped_array
     * @return array
     */
    public function get_users($query, $skipped_array = array()) {
        global $db, $system;
        $users = array();
        if(count($skipped_array) > 0) {
            /* make a skipped list (including the viewer) */
            $skipped_list = implode(',', $skipped_array);
            /* get users */
            $get_users = $db->query(sprintf("SELECT user_id, user_name, user_firstname, user_lastname, user_gender, user_picture FROM users WHERE user_id NOT IN (%s) AND (user_firstname LIKE %s OR user_lastname LIKE %s) ORDER BY user_firstname ASC LIMIT %s", $skipped_list, secure($query, 'search'), secure($query, 'search'), secure($system['min_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        } else {
            /* get users */
            $get_users = $db->query(sprintf("SELECT user_id, user_name, user_firstname, user_lastname, user_gender, user_picture FROM users WHERE user_firstname LIKE %s OR user_lastname LIKE %s ORDER BY user_firstname ASC LIMIT %s", secure($query, 'search'), secure($query, 'search'), secure($system['min_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        }
        if($get_users->num_rows > 0) {
            while($user = $get_users->fetch_assoc()) {
                $user['user_picture'] = $this->get_picture($user['user_picture'], $user['user_gender']);
                $users[] = $user;
            }
        }
        return $users;
    }



    /* ------------------------------- */
    /* Search */
    /* ------------------------------- */

    /**
     * search_quick
     *
     * @param string $query
     * @return array
     */
    public function search_quick($query) {
        global $db, $system;
        $results = array();
        /* search users */
        $get_users = $db->query(sprintf('SELECT user_id, user_name, user_firstname, user_lastname, user_gender, user_picture, user_subscribed, user_verified FROM users WHERE user_name LIKE %1$s OR user_firstname LIKE %1$s OR user_lastname LIKE %1$s LIMIT %2$s', secure($query, 'search'), secure($system['min_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        if($get_users->num_rows > 0) {
            while($user = $get_users->fetch_assoc()) {
                $user['user_picture'] = $this->get_picture($user['user_picture'], $user['user_gender']);
                /* get the connection between the viewer & the target */
                $user['connection'] = $this->connection($user['user_id']);
                $user['sort'] = $user['user_firstname'];
                $user['type'] = 'user';
                $results[] = $user;
            }
        }

        function sort_results($a, $b){
            return strcmp($a["sort"], $b["sort"]);
        }
        usort($results, sort_results);
        return $results;
    }


    /**
     * search
     *
     * @param string $query
     * @return array
     */
    public function search($query) {
        global $db, $system;
        $results = array();
        $offset *= $system['max_results'];
        /* search posts */
        $posts = $this->get_posts( array('query' => $query) );
        if(count($posts) > 0) {
            $results['posts'] = $posts;
        }
        /* search users */
        $get_users = $db->query(sprintf('SELECT user_id, user_name, user_firstname, user_lastname, user_gender, user_picture FROM users WHERE user_name LIKE %1$s OR user_firstname LIKE %1$s OR user_lastname LIKE %1$s ORDER BY user_firstname ASC LIMIT %2$s, %3$s', secure($query, 'search'), secure($offset, 'int', false), secure($system['max_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        if($get_users->num_rows > 0) {
            while($user = $get_users->fetch_assoc()) {
                $user['user_picture'] = $this->get_picture($user['user_picture'], $user['user_gender']);
                /* get the connection between the viewer & the target */
                $user['connection'] = $this->connection($user['user_id']);
                $results['users'][] = $user;
            }
        }

        return $results;
    }


    /**
     * search_users
     *
     * @param string $query
     * @param string $gender
     * @param string $relationship
     * @param string $status
     * @return array
     */
    public function search_users($query, $gender, $relationship, $status) {
        global $db, $system;
        $results = array();
        $offset *= $system['max_results'];
        /* validate gender */
        if(!in_array($gender, array('any', 'male', 'female'))) {
            return $results;
        }
        /* validate relationship */
        if(!in_array($relationship, array('any','single', 'relationship', 'married', "complicated", 'separated', 'divorced', 'widowed'))) {
            return $results;
        }
        /* prepare where statement */
        $where = "";
        /* gender */
        $where .= ($gender != "any")? " AND users.user_gender = '$gender'": "";
        /* relationship */
        $where .= ($relationship != "any")? " AND users.user_relationship = '$relationship'": "";
        /* get users */
        $get_users = $db->query(sprintf('SELECT users.* FROM users WHERE (users.user_name LIKE %1$s OR users.user_firstname LIKE %1$s OR users.user_lastname LIKE %1$s )'.$where.' ORDER BY user_firstname ASC LIMIT %2$s', secure($query, 'search'), secure($system['max_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        if($get_users->num_rows > 0) {
            while($user = $get_users->fetch_assoc()) {
                $user['user_picture'] = $this->get_picture($user['user_picture'], $user['user_gender']);
                /* get the connection between the viewer & the target */
                $user['connection'] = $this->connection($user['user_id']);
                $results[] = $user;
            }
        }
        return $results;
    }


    /**
     * get_search_log
     *
     * @return array
     */
    public function get_search_log() {
        global $db, $system;
        $results = array();
        $get_search_log = $db->query(sprintf("SELECT users_searches.log_id, users_searches.node_type, users.user_id, user_name, user_firstname, user_lastname, user_gender, user_picture, user_subscribed, user_verified FROM users_searches LEFT JOIN users ON users_searches.node_type = 'user' AND users_searches.node_id = users.user_id WHERE users_searches.user_id = %s ORDER BY users_searches.log_id DESC LIMIT %s", secure($this->_data['user_id'], 'int'), secure($system['min_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        if($get_search_log->num_rows > 0) {
            while($result = $get_search_log->fetch_assoc()) {
                switch ($result['node_type']) {
                    case 'user':
                        $result['user_picture'] = $this->get_picture($result['user_picture'], $result['user_gender']);
                        /* get the connection between the viewer & the target */
                        $result['connection'] = $this->connection($result['user_id']);
                        break;

                    }
                $result['type'] = $result['node_type'];
                $results[] = $result;
            }
        }
        return $results;
    }


    /**
     * add_search_log
     *
     * @param integer $node_id
     * @param string $node_type
     * @return void
     */
    public function add_search_log($node_id, $node_type) {
        global $db, $date;
        $db->query(sprintf("INSERT INTO users_searches (user_id, node_id, node_type, time) VALUES (%s, %s, %s, %s)", secure($this->_data['user_id'], 'int'), secure($node_id, 'int'), secure($node_type), secure($date) ));
    }


    /**
     * clear_search_log
     *
     * @return void
     */
    public function clear_search_log() {
        global $db, $system;
        $db->query(sprintf("DELETE FROM users_searches WHERE user_id = %s", secure($this->_data['user_id'], 'int'))) or _error(SQL_ERROR_THROWEN);
    }



    /* ------------------------------- */
    /* User & Connections */
    /* ------------------------------- */

    /**
     * connect
     *
     * @param string $do
     * @param integer $id
     * @param integer $uid
     * @return void
     */
    public function connect($do, $id, $uid = null) {
        global $db;
        switch ($do) {
            case 'friend-accept':
                /* check if there is a friend request from the target to the viewer */
                $check = $db->query(sprintf("SELECT * FROM friends WHERE user_one_id = %s AND user_two_id = %s AND status = 0", secure($id, 'int'), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                /* if no -> return */
                if($check->num_rows == 0) return;
                /* add the target as a friend */
                $db->query(sprintf("UPDATE friends SET status = 1 WHERE user_one_id = %s AND user_two_id = %s", secure($id, 'int'), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                /* post new notification */
                $this->post_notification( array('to_user_id'=>$id, 'action'=>'friend_accept', 'node_url'=>$this->_data['user_name']) );
                /* follow */
                $this->_follow($id);
                break;

            case 'friend-decline':
                /* check if there is a friend request from the target to the viewer */
                $check = $db->query(sprintf("SELECT * FROM friends WHERE user_one_id = %s AND user_two_id = %s AND status = 0", secure($id, 'int'), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                /* if no -> return */
                if($check->num_rows == 0) return;
                /* decline this friend request */
                $db->query(sprintf("UPDATE friends SET status = -1 WHERE user_one_id = %s AND user_two_id = %s", secure($id, 'int'), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                /* unfollow */
                $this->_unfollow($id);
                break;

            case 'friend-add':
                /* check if there is any relation between the viewer & the target */
                $check = $db->query(sprintf('SELECT * FROM friends WHERE (user_one_id = %1$s AND user_two_id = %2$s) OR (user_one_id = %2$s AND user_two_id = %1$s)', secure($this->_data['user_id'], 'int'),  secure($id, 'int') )) or _error(SQL_ERROR_THROWEN);
                /* if yes -> return */
                if($check->num_rows > 0) return;
                /* add the friend request */
                $db->query(sprintf("INSERT INTO friends (user_one_id, user_two_id, status) VALUES (%s, %s, '0')", secure($this->_data['user_id'], 'int'),  secure($id, 'int') )) or _error(SQL_ERROR_THROWEN);
                /* update requests counter +1 */
                $db->query(sprintf("UPDATE users SET user_live_requests_counter = user_live_requests_counter + 1 WHERE user_id = %s", secure($id, 'int') )) or _error(SQL_ERROR_THROWEN);
                /* post new notification */
                $this->post_notification( array('to_user_id'=>$id, 'action'=>'friend_add', 'node_url'=>$this->_data['user_name']) );
                /* follow */
                $this->_follow($id);
                break;

            case 'friend-cancel':
                /* check if there is a request from the viewer to the target */
                $check = $db->query(sprintf("SELECT * FROM friends WHERE user_one_id = %s AND user_two_id = %s AND status = 0", secure($this->_data['user_id'], 'int'),  secure($id, 'int') )) or _error(SQL_ERROR_THROWEN);
                /* if no -> return */
                if($check->num_rows == 0) return;
                /* delete the friend request */
                $db->query(sprintf("DELETE FROM friends WHERE user_one_id = %s AND user_two_id = %s", secure($this->_data['user_id'], 'int'), secure($id, 'int') )) or _error(SQL_ERROR_THROWEN);
                /* update requests counter -1 */
                $db->query(sprintf("UPDATE users SET user_live_requests_counter = IF(user_live_requests_counter=0,0,user_live_requests_counter-1), user_live_notifications_counter = IF(user_live_notifications_counter=0,0,user_live_notifications_counter-1) WHERE user_id = %s", secure($id, 'int') )) or _error(SQL_ERROR_THROWEN);
                /* unfollow */
                $this->_unfollow($id);
                break;

            case 'friend-remove':
                /* check if there is any relation between me & him */
                $check = $db->query(sprintf('SELECT * FROM friends WHERE (user_one_id = %1$s AND user_two_id = %2$s AND status = 1) OR (user_one_id = %2$s AND user_two_id = %1$s AND status = 1)', secure($this->_data['user_id'], 'int'),  secure($id, 'int') )) or _error(SQL_ERROR_THROWEN);
                /* if no -> return */
                if($check->num_rows == 0) return;
                /* delete this friend */
                $db->query(sprintf('DELETE FROM friends WHERE (user_one_id = %1$s AND user_two_id = %2$s AND status = 1) OR (user_one_id = %2$s AND user_two_id = %1$s AND status = 1)', secure($this->_data['user_id'], 'int'),  secure($id, 'int') )) or _error(SQL_ERROR_THROWEN);
                break;

            case 'follow':
                $this->_follow($id);
                break;

            case 'unfollow':
                $this->_unfollow($id);
                break;

            }
    }


    /**
     * connection
     *
     * @param integer $user_id
     * @param boolean $friendship
     * @return string
     */
    public function connection($user_id, $friendship = true) {
        /* check which type of connection (friendship|follow) connections to get */
        if($friendship) {
            /* check if there is a logged user */
            if(!$this->_logged_in) {
                /* no logged user */
                return "add";
            }
            /* check if the viewer is the target */
            if($user_id == $this->_data['user_id']) {
                return "me";
            }
            /* check if the viewer & the target are friends */
            if(in_array($user_id, $this->_data['friends_ids'])) {
                return "remove";
            }
            /* check if the target sent a request to the viewer */
            if(in_array($user_id, $this->_data['friend_requests_ids'])) {
                return "request";
            }
            /* check if the viewer sent a request to the target */
            if(in_array($user_id, $this->_data['friend_requests_sent_ids'])) {
                return "cancel";
            }
            /* there is no relation between the viewer & the target */
            return "add";
        } else {
            /* check if there is a logged user */
            if(!$this->_logged_in) {
                /* no logged user */
                return "follow";
            }
            /* check if the viewer is the target */
            if($user_id == $this->_data['user_id']) {
                return "me";
            }
            if(in_array($user_id, $this->_data['followings_ids'])) {
                /* the viewer follow the target */
                return "unfollow";
            } else {
                /* the viewer not follow the target */
                return "follow";
            }
        }
    }


    /**
     * delete_user
     *
     * @param integer $user_id
     * @return void
     */
    public function delete_user($user_id) {
        global $db;
        /* (check&get) user */
        $get_user = $db->query(sprintf("SELECT * FROM users WHERE user_id = %s", secure($user_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        if($get_user->num_rows == 0) {
            _error(403);
        }
        $user = $get_user->fetch_assoc();
        // delete user
        $can_delete = false;
        /* viewer is the target */
        if($this->_data['user_id'] == $user_id) {
            $can_delete = true;
        }
        /* delete the user */
        if($can_delete) {
            /* delete the user */
            $db->query(sprintf("DELETE FROM users WHERE user_id = %s", secure($user_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        }
    }


    /**
     * _follow
     *
     * @param integer $user_id
     * @return void
     */
    private function _follow($user_id) {
        global $db;
        /* check if the viewer already follow the target */
        $check = $db->query(sprintf("SELECT * FROM followings WHERE user_id = %s AND following_id = %s", secure($this->_data['user_id'], 'int'),  secure($user_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* if yes -> return */
        if($check->num_rows > 0) return;
        /* add as following */
        $db->query(sprintf("INSERT INTO followings (user_id, following_id) VALUES (%s, %s)", secure($this->_data['user_id'], 'int'),  secure($user_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* post new notification */
        $this->post_notification( array('to_user_id' => $user_id, 'action'=> 'follow') );
    }


    /**
     * _unfollow
     *
     * @param integer $user_id
     * @return void
     */
    private function _unfollow($user_id) {
        global $db;
        /* check if the viewer already follow the target */
        $check = $db->query(sprintf("SELECT * FROM followings WHERE user_id = %s AND following_id = %s", secure($this->_data['user_id'], 'int'),  secure($user_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* if no -> return */
        if($check->num_rows == 0) return;
        /* delete from viewer's followings */
        $db->query(sprintf("DELETE FROM followings WHERE user_id = %s AND following_id = %s", secure($this->_data['user_id'], 'int'), secure($user_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* delete notification */
        $this->delete_notification($user_id, 'follow');
    }



    /* ------------------------------- */
    /* Live */
    /* ------------------------------- */

    /**
     * live_counters_reset
     *
     * @param string $counter
     * @return void
     */
    public function live_counters_reset($counter) {
        global $db;
        if($counter == "friend_requests") {
            $db->query(sprintf("UPDATE users SET user_live_requests_counter = 0 WHERE user_id = %s", secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
        } elseif($counter == "notifications") {
            $db->query(sprintf("UPDATE users SET user_live_notifications_counter = 0 WHERE user_id = %s", secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            $db->query(sprintf("UPDATE notifications SET seen = '1' WHERE to_user_id = %s", secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
        }
    }



    /* ------------------------------- */
    /* Notifications */
    /* ------------------------------- */

    /**
     * get_notifications
     *
     * @param integer $offset
     * @param integer $last_notification_id
     * @return array
     */
    public function get_notifications($offset = 0, $last_notification_id = null) {
        global $db, $system;
        $offset *= $system['max_results'];
        $notifications = array();
        if($last_notification_id !== null) {
            $get_notifications = $db->query(sprintf("SELECT notifications.*, users.user_id, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture FROM notifications INNER JOIN users ON notifications.from_user_id = users.user_id WHERE notifications.to_user_id = %s AND notifications.notification_id > %s ORDER BY notifications.notification_id DESC", secure($this->_data['user_id'], 'int'), secure($last_notification_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        } else {
            $get_notifications = $db->query(sprintf("SELECT notifications.*, users.user_id, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture FROM notifications INNER JOIN users ON notifications.from_user_id = users.user_id WHERE notifications.to_user_id = %s ORDER BY notifications.notification_id DESC LIMIT %s, %s", secure($this->_data['user_id'], 'int'), secure($offset, 'int', false), secure($system['max_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        }
        if($get_notifications->num_rows > 0) {
            while($notification = $get_notifications->fetch_assoc()) {
                $notification['user_picture'] = $this->get_picture($notification['user_picture'], $notification['user_gender']);
                $notification['notify_id'] = ($notification['notify_id'])? "?notify_id=".$notification['notify_id'] : "";
                /* parse notification */
                switch ($notification['action']) {
                    case 'friend_add':
                        $notification['icon'] = "fa-user-plus";
                        $notification['url'] = $system['system_url'].'/'.$notification['user_name'];
                        $notification['message'] = __("send you a friend request");
                        break;

                    case 'friend_accept':
                        $notification['icon'] = "fa-user-plus";
                        $notification['url'] = $system['system_url'].'/'.$notification['user_name'];
                        $notification['message'] = __("accepted your friend request");
                        break;

                    case 'follow':
                        $notification['icon'] = "fa-rss";
                        $notification['url'] = $system['system_url'].'/'.$notification['user_name'];
                        $notification['message'] = __("now following you");
                        break;

                    case 'like':
                        $notification['icon'] = "fa-thumbs-o-up";
                        if($notification['node_type'] == "post") {
                            $notification['url'] = $system['system_url'].'/posts/'.$notification['node_url'];
                            $notification['message'] = __("likes your post");

                        } elseif ($notification['node_type'] == "photo") {
                            $notification['url'] = $system['system_url'].'/photos/'.$notification['node_url'];
                            $notification['message'] = __("likes your photo");

                        } elseif ($notification['node_type'] == "post_comment") {
                            $notification['url'] = $system['system_url'].'/posts/'.$notification['node_url'].$notification['notify_id'];
                            $notification['message'] = __("likes your comment");

                        } elseif ($notification['node_type'] == "photo_comment") {
                            $notification['url'] = $system['system_url'].'/photos/'.$notification['node_url'].$notification['notify_id'];
                            $notification['message'] = __("likes your comment");

                        } elseif ($notification['node_type'] == "post_reply") {
                            $notification['url'] = $system['system_url'].'/posts/'.$notification['node_url'].$notification['notify_id'];
                            $notification['message'] = __("likes your reply");

                        } elseif ($notification['node_type'] == "photo_reply") {
                            $notification['url'] = $system['system_url'].'/photos/'.$notification['node_url'].$notification['notify_id'];
                            $notification['message'] = __("likes your reply");
                        }
                        break;

                    case 'comment':
                        $notification['icon'] = "fa-comment";
                        if($notification['node_type'] == "post") {
                            $notification['url'] = $system['system_url'].'/posts/'.$notification['node_url'].$notification['notify_id'];
                            $notification['message'] = __("commented on your post");

                        } elseif ($notification['node_type'] == "photo") {
                            $notification['url'] = $system['system_url'].'/photos/'.$notification['node_url'].$notification['notify_id'];
                            $notification['message'] = __("commented on your photo");
                        }
                        break;

                    case 'reply':
                        $notification['icon'] = "fa-comment";
                        if($notification['node_type'] == "post") {
                            $notification['url'] = $system['system_url'].'/posts/'.$notification['node_url'].$notification['notify_id'];

                        } elseif ($notification['node_type'] == "photo") {
                            $notification['url'] = $system['system_url'].'/photos/'.$notification['node_url'].$notification['notify_id'];
                        }
                        $notification['message'] = __("replied to your comment");
                        break;

                    case 'share':
                        $notification['icon'] = "fa-share";
                        $notification['url'] = $system['system_url'].'/posts/'.$notification['node_url'];
                        $notification['message'] = __("shared your post");
                        break;

                    case 'mention':
                        $notification['icon'] = "fa-comment";
                        switch ($notification['node_type']) {
                            case 'post':
                                $notification['url'] = $system['system_url'].'/posts/'.$notification['node_url'];
                                $notification['message'] = __("mentioned you in a post");
                                break;

                            case 'comment_post':
                                $notification['url'] = $system['system_url'].'/posts/'.$notification['node_url'].$notification['notify_id'];
                                $notification['message'] = __("mentioned you in a comment");
                                break;

                            case 'comment_photo':
                                $notification['url'] = $system['system_url'].'/photos/'.$notification['node_url'].$notification['notify_id'];
                                $notification['message'] = __("mentioned you in a comment");
                                break;

                            case 'reply_post':
                                $notification['url'] = $system['system_url'].'/posts/'.$notification['node_url'].$notification['notify_id'];
                                $notification['message'] = __("mentioned you in a reply");
                                break;

                            case 'reply_photo':
                                $notification['url'] = $system['system_url'].'/photos/'.$notification['node_url'].$notification['notify_id'];
                                $notification['message'] = __("mentioned you in a reply");
                                break;
                        }
                        break;

                    case 'profile_visit':
                        $notification['icon'] = "fa-eye";
                        $notification['url'] = $system['system_url'].'/'.$notification['user_name'];
                        $notification['message'] = __("visited your profile");
                        break;

                    case 'wall':
                        $notification['icon'] = "fa-comment";
                        $notification['url'] = $system['system_url'].'/posts/'.$notification['node_url'];
                        $notification['message'] = __("posted on your wall");
                        break;

                    }
                $notification['full_message'] = $notification['user_firstname']." ".$notification['user_lastname']." ".$notification['message'];
                $notifications[] = $notification;
            }
        }
        return $notifications;
    }


    /**
     * post_notification
     *
     * @param integer $to_user_id
     * @param string $action
     * @param string $node_type
     * @param string $node_url
     * @param string $notify_id
     * @return void
     */
    public function post_notification($args = array()) {
        global $db, $date, $system;
        /* initialize arguments */
        $to_user_id = !isset($args['to_user_id']) ? _error(400) : $args['to_user_id'];
        $from_user_id = !isset($args['from_user_id']) ? $this->_data['user_id'] : $args['from_user_id'];
        $action = !isset($args['action']) ? _error(400) : $args['action'];
        $node_type = !isset($args['node_type']) ? '' : $args['node_type'];
        $node_url = !isset($args['node_url']) ? '' : $args['node_url'];
        $notify_id = !isset($args['notify_id']) ? '' : $args['notify_id'];
        /* if the viewer is the target */
        if($this->_data['user_id'] == $to_user_id) {
            return;
        }
        /* get receiver user */
        $get_receiver = $db->query(sprintf("SELECT * FROM users WHERE user_id = %s", secure($to_user_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        if($get_receiver->num_rows == 0) {
            return;
        }
        /* insert notification */
        $db->query(sprintf("INSERT INTO notifications (to_user_id, from_user_id, action, node_type, node_url, notify_id, time) VALUES (%s, %s, %s, %s, %s, %s, %s)", secure($to_user_id, 'int'), secure($from_user_id, 'int'), secure($action), secure($node_type), secure($node_url), secure($notify_id), secure($date) )) or _error(SQL_ERROR_THROWEN);
        /* update notifications counter +1 */
        $db->query(sprintf("UPDATE users SET user_live_notifications_counter = user_live_notifications_counter + 1 WHERE user_id = %s", secure($to_user_id, 'int') )) or _error(SQL_ERROR_THROWEN);

        // Email Notifications
        if($system['email_notifications']) {
            /* prepare receiver */
            $receiver = $get_receiver->fetch_assoc();
            /* parse notification */
            $notify_id = ($notify_id != '')? "?notify_id=".$notify_id : "";
            switch ($action) {
                case 'friend_add':
                    if($system['email_friend_requests'] && $receiver['email_friend_requests']) {
                        $notification['url'] = $system['system_url'].'/'.$node_url;
                        $notification['message'] = __("send you a friend request");
                    }
                    break;

                case 'friend_accept':
                    if($system['email_friend_requests'] && $receiver['email_friend_requests']) {
                        $notification['url'] = $system['system_url'].'/'.$node_url;
                        $notification['message'] = __("accepted your friend request");
                    }
                    break;

                case 'like':
                    if($system['email_post_likes'] && $receiver['email_post_likes']) {
                        if($node_type == "post") {
                            $notification['url'] = $system['system_url'].'/posts/'.$node_url;
                            $notification['message'] = __("likes your post");

                        } elseif ($node_type == "photo") {
                            $notification['url'] = $system['system_url'].'/photos/'.$node_url;
                            $notification['message'] = __("likes your photo");

                        } elseif ($node_type == "post_comment") {
                            $notification['url'] = $system['system_url'].'/posts/'.$node_url.$notify_id;
                            $notification['message'] = __("likes your comment");

                        } elseif ($node_type == "photo_comment") {
                            $notification['url'] = $system['system_url'].'/photos/'.$node_url.$notify_id;
                            $notification['message'] = __("likes your comment");

                        } elseif ($node_type == "post_reply") {
                            $notification['url'] = $system['system_url'].'/posts/'.$node_url.$notify_id;
                            $notification['message'] = __("likes your reply");

                        } elseif ($node_type == "photo_reply") {
                            $notification['url'] = $system['system_url'].'/photos/'.$node_url.$notify_id;
                            $notification['message'] = __("likes your reply");
                        }
                    }
                    break;

                case 'comment':
                    if($system['email_post_comments'] && $receiver['email_post_comments']) {
                        if($node_type == "post") {
                            $notification['url'] = $system['system_url'].'/posts/'.$node_url.$notify_id;
                            $notification['message'] = __("commented on your post");

                        } elseif ($node_type == "photo") {
                            $notification['url'] = $system['system_url'].'/photos/'.$node_url.$notify_id;
                            $notification['message'] = __("commented on your photo");
                        }
                    }
                    break;

                case 'reply':
                    if($system['email_post_comments'] && $receiver['email_post_comments']) {
                        if($node_type == "post") {
                            $notification['url'] = $system['system_url'].'/posts/'.$node_url.$notify_id;

                        } elseif ($node_type == "photo") {
                            $notification['url'] = $system['system_url'].'/photos/'.$node_url.$notify_id;
                        }
                        $notification['message'] = __("replied to your comment");
                    }
                    break;

                case 'share':
                    if($system['email_post_shares'] && $receiver['email_post_shares']) {
                        $notification['url'] = $system['system_url'].'/posts/'.$node_url;
                        $notification['message'] = __("shared your post");
                    }
                    break;

                case 'mention':
                    if($system['email_mentions'] && $receiver['email_mentions']) {
                        $notification['icon'] = "fa-comment";
                        switch ($node_type) {
                            case 'post':
                                $notification['url'] = $system['system_url'].'/posts/'.$node_url;
                                $notification['message'] = __("mentioned you in a post");
                                break;

                            case 'comment_post':
                                $notification['url'] = $system['system_url'].'/posts/'.$node_url.$notify_id;
                                $notification['message'] = __("mentioned you in a comment");
                                break;

                            case 'comment_photo':
                                $notification['url'] = $system['system_url'].'/photos/'.$node_url.$notify_id;
                                $notification['message'] = __("mentioned you in a comment");
                                break;

                            case 'reply_post':
                                $notification['url'] = $system['system_url'].'/posts/'.$node_url.$notify_id;
                                $notification['message'] = __("mentioned you in a reply");
                                break;

                            case 'reply_photo':
                                $notification['url'] = $system['system_url'].'/photos/'.$node_url.$notify_id;
                                $notification['message'] = __("mentioned you in a reply");
                                break;
                        }
                    }
                    break;

                case 'profile_visit':
                    if($system['email_profile_visits'] && $receiver['email_profile_visits']) {
                        $notification['url'] = $system['system_url'].'/'.$this->_data['user_name'];
                        $notification['message'] = __("visited your profile");
                    }
                    break;

                case 'wall':
                    if($system['email_wall_posts'] && $receiver['email_wall_posts']) {
                        $notification['url'] = $system['system_url'].'/posts/'.$node_url;
                        $notification['message'] = __("posted on your wall");
                    }
                    break;

                default:
                    return;
                    break;
            }
            /* prepare notification email */
            if($notification['message']) {
                $subject = __("New notification from")." ".$system['system_title'];
                $body  = __("Hi")." ".ucwords($receiver['user_firstname']." ".$receiver['user_lastname']).",";
                $body .= "\r\n\r\n".$this->_data['user_firstname']." ".$this->_data['user_lastname']." ".$notification['message'];
                $body .= "\r\n\r\n".$notification['url'];
                $body .= "\r\n\r".$system['system_title']." ".__("Team");
                /* send email */
                _email($receiver['user_email'], $subject, $body);
            }
        }
    }


    /**
     * delete_notification
     *
     * @param integer $to_user_id
     * @param string $action
     * @param string $node_type
     * @param string $node_url
     * @return void
     */
    public function delete_notification($to_user_id, $action, $node_type = '', $node_url = '') {
        global $db;
        /* delete notification */
        $db->query(sprintf("DELETE FROM notifications WHERE to_user_id = %s AND from_user_id = %s AND action = %s AND node_type = %s AND node_url = %s", secure($to_user_id, 'int'), secure($this->_data['user_id'], 'int'), secure($action), secure($node_type), secure($node_url) )) or _error(SQL_ERROR_THROWEN);
        /* update notifications counter -1 */
        $db->query(sprintf("UPDATE users SET user_live_notifications_counter = IF(user_live_notifications_counter=0,0,user_live_notifications_counter-1) WHERE user_id = %s", secure($to_user_id, 'int') )) or _error(SQL_ERROR_THROWEN);
    }



    /* ------------------------------- */
    /* Emoji & Stickers */
    /* ------------------------------- */

    /**
     * get_emojis
     *
     * @return array
     */
    public function get_emojis() {
        global $db;
        $emojis = array();
        $get_emojis = $db->query("SELECT * FROM emojis") or _error(SQL_ERROR_THROWEN);
        if($get_emojis->num_rows > 0) {
            while($emoji = $get_emojis->fetch_assoc()) {
                $emojis[] = $emoji;
            }
        }
        return $emojis;
    }


    /**
     * decode_emoji
     *
     * @param string $text
     * @return string
     */
    public function decode_emoji($text) {
        global $db;
        $get_emojis = $db->query("SELECT * FROM emojis") or _error(SQL_ERROR_THROWEN);
        if($get_emojis->num_rows > 0) {
            while($emoji = $get_emojis->fetch_assoc()) {
                $replacement = '<i class="twa twa-xlg twa-'.$emoji['class'].'"></i>';
                $pattern = preg_quote($emoji['pattern'], '/');
                $text = preg_replace('/(^|\s)'.$pattern.'/', $replacement, $text);
            }
        }
        return $text;
    }


    /**
     * get_stickers
     *
     * @return array
     */
    public function get_stickers() {
        global $db;
        $stickers = array();
        $get_stickers = $db->query("SELECT * FROM stickers") or _error(SQL_ERROR_THROWEN);
        if($get_stickers->num_rows > 0) {
            while($sticker = $get_stickers->fetch_assoc()) {
                $stickers[] = $sticker;
            }
        }
        return $stickers;
    }


    /**
     * decode_stickers
     *
     * @param string $text
     * @return string
     */
    public function decode_stickers($text) {
        global $db, $system;
        $get_stickers = $db->query("SELECT * FROM stickers") or _error(SQL_ERROR_THROWEN);
        if($get_stickers->num_rows > 0) {
            while($sticker = $get_stickers->fetch_assoc()) {
                $replacement = '<img class="" src="'.$system['system_uploads'].'/'.$sticker['image'].'"></i>';
                $text = preg_replace('/(^|\s):STK-'.$sticker['sticker_id'].':/', $replacement, $text);
            }
        }
        return $text;
    }




    /* ------------------------------- */
    /* @Mentions */
    /* ------------------------------- */

    /**
     * get_mentions
     *
     * @param array $matches
     * @return string
     */
    public function get_mentions($matches) {
        global $db;
        $get_user = $db->query(sprintf("SELECT user_id, user_name, user_firstname, user_lastname FROM users WHERE user_name = %s", secure($matches[1]) )) or _error(SQL_ERROR_THROWEN);
        if($get_user->num_rows > 0) {
            $user = $get_user->fetch_assoc();
            $replacement = popover($user['user_id'], $user['user_name'], $user['user_firstname']." ".$user['user_lastname']);
        }else {
            $replacement = $matches[0];
        }
        return $replacement;
    }


    /**
     * post_mentions
     *
     * @param string $text
     * @param integer $node_url
     * @param string $node_type
     * @param string $notify_id
     * @param array $excluded_ids
     * @return void
     */
    public function post_mentions($text, $node_url, $node_type = 'post', $notify_id = '', $excluded_ids = array()) {
        global $db;
        $where_query = "";
        if($excluded_ids) {
            $excluded_list = implode(',',$excluded_ids);
            $where_query = " user_id NOT IN ($excluded_list) AND ";
        }
        $done = array();
        if(preg_match_all('/\[([a-z0-9._]+)\]/', $text, $matches)) {
            foreach ($matches[1] as $username) {
                if($this->_data['user_name'] != $username && !in_array($username, $done)) {
                    $get_user = $db->query(sprintf("SELECT user_id FROM users WHERE ".$where_query." user_name = %s", secure($username) )) or _error(SQL_ERROR_THROWEN);
                    if($get_user->num_rows > 0) {
                        $_user = $get_user->fetch_assoc();
                        $this->post_notification( array('to_user_id'=>$_user['user_id'], 'action'=>'mention', 'node_type'=>$node_type, 'node_url'=>$node_url, 'notify_id'=>$notify_id) );
                        $done[] = $username;
                    }
                }
            }
        }
    }



    /* ------------------------------- */
    /* Popovers */
    /* ------------------------------- */

    /**
     * popover
     *
     * @param integer $id
     * @param string $type
     * @return array
     */
    public function popover($id, $type) {
        global $db;
        $profile = array();
        /* check the type to get */
        if($type == "user") {
            /* get user info */
            $get_profile = $db->query(sprintf("SELECT * FROM users WHERE user_id = %s", secure($id, 'int'))) or _error(SQL_ERROR_THROWEN);
            if($get_profile->num_rows > 0) {
                $profile = $get_profile->fetch_assoc();
                /* get profile picture */
                $profile['user_picture'] = $this->get_picture($profile['user_picture'], $profile['user_gender']);
                /* get followers count */
                $profile['followers_count'] = count($this->get_followers_ids($profile['user_id']));
                /* get mutual friends count between the viewer and the target */
                if($this->_logged_in && $this->_data['user_id'] != $profile['user_id']) {
                    $profile['mutual_friends_count'] = $this->get_mutual_friends_count($profile['user_id']);
                }
                /* get the connection between the viewer & the target */
                if($profile['user_id'] != $this->_data['user_id']) {
                    $profile['we_friends'] = (in_array($profile['user_id'], $this->_data['friends_ids']))? true: false;
                    $profile['he_request'] = (in_array($profile['user_id'], $this->_data['friend_requests_ids']))? true: false;
                    $profile['i_request'] = (in_array($profile['user_id'], $this->_data['friend_requests_sent_ids']))? true: false;
                    $profile['i_follow'] = (in_array($profile['user_id'], $this->_data['followings_ids']))? true: false;
                }
            }
        }
        return $profile;
    }



    /* ------------------------------- */
    /* Publisher */
    /* ------------------------------- */

    /**
     * publisher
     *
     * @param array $args
     * @return array
     */
    public function publisher($args = array()) {
        global $db, $system, $date;
        $post = array();

        /* default */
        $post['user_id'] = $this->_data['user_id'];
        $post['user_type'] = "user";
        $post['in_wall'] = 0;
        $post['wall_id'] = null;

        $post['author_id'] = $this->_data['user_id'];
        $post['post_author_picture'] = $this->_data['user_picture'];
        $post['post_author_url'] = $system['system_url'].'/'.$this->_data['user_name'];
        $post['post_author_name'] = $this->_data['user_firstname']." ".$this->_data['user_lastname'];
        $post['post_author_verified'] = $this->_data['user_verified'];

        /* check the user_type */
        if($args['handle'] == "user") {
            /* check if system allow wall posts */
            if(!$system['wall_posts_enabled']) {
                _error(400);
            }
            /* check if the user is valid & the viewer can post on his wall */
            $check_user = $db->query(sprintf("SELECT * FROM users WHERE user_id = %s",secure($args['id'], 'int'))) or _error(SQL_ERROR_THROWEN);
            if($check_user->num_rows == 0) {
                _error(400);
            }
            $_user = $check_user->fetch_assoc();
            if($_user['user_privacy_wall'] == 'me' || ($_user['user_privacy_wall'] == 'friends' && !in_array($args['id'], $this->_data['friends_ids'])) ) {
                _error(400);
            }
            $post['in_wall'] = 1;
            $post['wall_id'] = $args['id'];
            $post['wall_username'] = $_user['user_name'];
            $post['wall_fullname'] = $_user['user_firstname']." ".$_user['user_lastname'];

        }

        /* prepare post data */
        $post['text'] = $args['message'];
        $post['time'] = $date;
        $post['location'] = (!is_empty($args['location']) && valid_location($args['location']))? $args['location']: '';
        $post['privacy'] = $args['privacy'];
        $post['likes'] = 0;
        $post['comments'] = 0;
        $post['shares'] = 0;

        /* post feeling */
        $post['feeling_action'] = '';
        $post['feeling_value'] = '';
        $post['feeling_icon'] = '';
        if(!is_empty($args['feeling_action']) && !is_empty($args['feeling_value'])) {
            if($args['feeling_action'] != "Feeling") {
                $_feeling_icon = get_feeling_icon($args['feeling_action'], get_feelings());
            } else {
                $_feeling_icon = get_feeling_icon($args['feeling_value'], get_feelings_types());
            }
            if($_feeling_icon) {
                $post['feeling_action'] = $args['feeling_action'];
                $post['feeling_value'] = $args['feeling_value'];
                $post['feeling_icon'] = $_feeling_icon;
            }
        }

        /* prepare post type */
        if($args['link']) {
            if($args['link']->source_type == "link") {
                $post['post_type'] = 'link';
            } else {
                $post['post_type'] = 'media';
            }
        } elseif ($args['video']) {
            $post['post_type'] = 'video';
        } elseif ($args['audio']) {
            $post['post_type'] = 'audio';
        } elseif ($args['file']) {
            $post['post_type'] = 'file';
        } elseif(count($args['photos']) > 0) {
            if(!is_empty($args['album'])) {
                $post['post_type'] = 'album';
            } else {
                $post['post_type'] = 'photos';
            }
        } else {
            if($post['location'] != '') {
                $post['post_type'] = 'map';
            } else {
                $post['post_type'] = '';
            }
        }
				/* insert the post */
        $db->query(sprintf("INSERT INTO posts (user_id, user_type, in_wall, wall_id, post_type, time, location, privacy, text, feeling_action, feeling_value) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", secure($post['user_id'], 'int'), secure($post['user_type']), secure($post['in_wall'], 'int'), secure($post['wall_id'], 'int'), secure($post['post_type']), secure($post['time']), secure($post['location']), secure($post['privacy']), secure($post['text']), secure($post['feeling_action']), secure($post['feeling_value']) )) or _error(SQL_ERROR_THROWEN);
        $post['post_id'] = $db->insert_id;

        switch ($post['post_type']) {
            case 'link':
                $db->query(sprintf("INSERT INTO posts_links (post_id, source_url, source_host, source_title, source_text, source_thumbnail) VALUES (%s, %s, %s, %s, %s, %s)", secure($post['post_id'], 'int'), secure($args['link']->source_url), secure($args['link']->source_host), secure($args['link']->source_title), secure($args['link']->source_text), secure($args['link']->source_thumbnail) )) or _error(SQL_ERROR_THROWEN);
                $post['link']['link_id'] = $db->insert_id;
                $post['link']['post_id'] = $post['post_id'];
                $post['link']['source_url'] = $args['link']->source_url;
                $post['link']['source_host'] = $args['link']->source_host;
                $post['link']['source_title'] = $args['link']->source_title;
                $post['link']['source_text'] = $args['link']->source_text;
                $post['link']['source_thumbnail'] = $args['link']->source_thumbnail;
                break;

            case 'video':
                $db->query(sprintf("INSERT INTO posts_videos (post_id, source) VALUES (%s, %s)", secure($post['post_id'], 'int'), secure($args['video']->source) )) or _error(SQL_ERROR_THROWEN);
                $post['video']['source'] = $args['video']->source;
                break;

            case 'audio':
                $db->query(sprintf("INSERT INTO posts_audios (post_id, source) VALUES (%s, %s)", secure($post['post_id'], 'int'), secure($args['audio']->source) )) or _error(SQL_ERROR_THROWEN);
                $post['audio']['source'] = $args['audio']->source;
                break;

            case 'file':
                $db->query(sprintf("INSERT INTO posts_files (post_id, source) VALUES (%s, %s)", secure($post['post_id'], 'int'), secure($args['file']->source) )) or _error(SQL_ERROR_THROWEN);
                $post['file']['source'] = $args['file']->source;
                break;

            case 'media':
                $db->query(sprintf("INSERT INTO posts_media (post_id, source_url, source_provider, source_type, source_title, source_text, source_html) VALUES (%s, %s, %s, %s, %s, %s, %s)", secure($post['post_id'], 'int'), secure($args['link']->source_url), secure($args['link']->source_provider), secure($args['link']->source_type), secure($args['link']->source_title), secure($args['link']->source_text), secure($args['link']->source_html) )) or _error(SQL_ERROR_THROWEN);
                $post['media']['media_id'] = $db->insert_id;
                $post['media']['post_id'] = $post['post_id'];
                $post['media']['source_url'] = $args['link']->source_url;
                $post['media']['source_type'] = $args['link']->source_type;
                $post['media']['source_provider'] = $args['link']->source_provider;
                $post['media']['source_title'] = $args['link']->source_title;
                $post['media']['source_text'] = $args['link']->source_text;
                $post['media']['source_html'] = $args['link']->source_html;
                break;

            case 'photos':
                if($args['handle'] == "user") {
                    /* check for timeline album */
                    if(!$this->_data['user_album_timeline']) {
                        /* create new timeline album (public by default) */
                        $db->query(sprintf("INSERT INTO posts_photos_albums (user_id, user_type, title) VALUES (%s, 'user', 'Timeline Photos')", secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                        $this->_data['user_album_timeline'] = $db->insert_id;
                        /* update user */
                        $db->query(sprintf("UPDATE users SET user_album_timeline = %s WHERE user_id = %s", secure($this->_data['user_album_timeline'], 'int'), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                    }
                    $album_id = $this->_data['user_album_timeline'];
                }
                foreach ($args['photos'] as $photo) {
                    $db->query(sprintf("INSERT INTO posts_photos (post_id, album_id, source) VALUES (%s, %s, %s)", secure($post['post_id'], 'int'), secure($album_id, 'int'), secure($photo) )) or _error(SQL_ERROR_THROWEN);
                    $post_photo['photo_id'] = $db->insert_id;
                    $post_photo['post_id'] = $post['post_id'];
                    $post_photo['source'] = $photo;
                    $post_photo['likes'] = 0;
                    $post_photo['comments'] = 0;
                    $post['photos'][] = $post_photo;
                }
                $post['photos_num'] = count($post['photos']);
                break;

            case 'album':
                /* create new album */
                $db->query(sprintf("INSERT INTO posts_photos_albums (user_id, user_type, title, privacy) VALUES (%s, %s, %s, %s)", secure($post['user_id'], 'int'), secure($post['user_type']), secure($args['album']), secure($post['privacy']) )) or _error(SQL_ERROR_THROWEN);
                $album_id = $db->insert_id;
                foreach ($args['photos'] as $photo) {
                    $db->query(sprintf("INSERT INTO posts_photos (post_id, album_id, source) VALUES (%s, %s, %s)", secure($post['post_id'], 'int'), secure($album_id, 'int'), secure($photo) )) or _error(SQL_ERROR_THROWEN);
                    $post_photo['photo_id'] = $db->insert_id;
                    $post_photo['post_id'] = $post['post_id'];
                    $post_photo['source'] = $photo;
                    $post_photo['likes'] = 0;
                    $post_photo['comments'] = 0;
                    $post['photos'][] = $post_photo;
                }
                $post['album']['album_id'] = $album_id;
                $post['album']['title'] = $args['album'];
                $post['photos_num'] = count($post['photos']);
                /* get album path */
                if ($post['user_type'] == "user") {
                    $post['album']['path'] = $this->_data['user_name'];
                }
								break;
        }

        /* post mention notifications */
        $this->post_mentions($args['message'], $post['post_id']);

        /* post wall notifications */
        if($post['in_wall']) {
            $this->post_notification( array('to_user_id'=>$post['wall_id'], 'action'=>'wall', 'node_type'=>'post', 'node_url'=>$post['post_id']) );
        }

        /* parse text */
        $post['text_plain'] = htmlentities($post['text'], ENT_QUOTES, 'utf-8');
        $post['text'] = $this->_parse($post['text_plain']);

        /* user can manage the post */
        $post['manage_post'] = true;

        // return
        return $post;
    }


    /**
     * scraper
     *
     * @param string $url
     * @return array
     */
    public function scraper($url) {
        $url_parsed = parse_url($url);
        if(!isset($url_parsed["scheme"]) ) {
            $url = "http://".$url;
        }
        $url = ger_origenal_url($url);
        $advanced = true;
        if($advanced) {
            require_once(ABSPATH.'includes/libs/Embed/v3/autoloader.php');
            $dispatcher = new Embed\Http\CurlDispatcher([
                CURLOPT_FOLLOWLOCATION => false,
            ]);
            $embed = Embed\Embed::create($url, null, $dispatcher);
        } else {
            require_once(ABSPATH.'includes/libs/Embed/v1/autoloader.php');
            $config = [
                'image' => [
                    'class' => 'Embed\\ImageInfo\\M&M'
                ]
            ];
            $embed = Embed\Embed::create($url, $config);
        }
        if($embed) {
            $return = array();
            $return['source_url'] = $url;
            $return['source_title'] = $embed->title;
            $return['source_text'] = $embed->description;
            $return['source_type'] = $embed->type;
            if($return['source_type'] == "link") {
                $return['source_host'] = $url_parsed['host'];
                $return['source_thumbnail'] = $embed->image;
            } else {
                $return['source_html'] = $embed->code;
                $return['source_provider'] = $embed->providerName;
            }
            return $return;
        } else {
            return false;
        }
    }


    /**
     * parse
     *
     * @param string $text
     * @param boolean $nl2br
     * @param boolean $mention
     * @return string
     */
    private function _parse($text, $nl2br = true, $mention = true) {
        /* decode urls */
        $text = decode_urls($text);
        /* decode emoji */
        $text = $this->decode_emoji($text);
        /* decode stickers */
        $text = $this->decode_stickers($text);
        /* decode #hashtag */
        $text = decode_hashtag($text);
        /* decode @mention */
        if($mention) {
            $text = decode_mention($text);
        }
        /* censored words */
        $text = censored_words($text);
        /* nl2br */
        if($nl2br) {
            $text = nl2br($text);
        }
        return $text;
    }



    /* ------------------------------- */
    /* Posts */
    /* ------------------------------- */

    /**
     * get_posts
     *
     * @param array $args
     * @return array
     */
    public function get_posts($args = array()) {
        global $db, $system;
        /* initialize vars */
        $posts = array();
        /* validate arguments */
        $get = !isset($args['get']) ? 'newsfeed' : $args['get'];
        $filter = !isset($args['filter']) ? 'all' : $args['filter'];
        $valid['filter'] = array('all', '', 'photos', 'video', 'audio', 'file', 'article', 'map');
        if(!in_array($filter, $valid['filter'])) {
            _error(400);
        }
        $last_post_id = !isset($args['last_post_id']) ? null : $args['last_post_id'];
        if(isset($args['last_post']) && !is_numeric($args['last_post'])) {
            _error(400);
        }
        $offset = !isset($args['offset']) ? 0 : $args['offset'];
        $offset *= $system['max_results'];
        if(isset($args['query'])) {
            if(is_empty($args['query'])) {
                return $posts;
            } else {
                $query = secure($args['query'], 'search', false);
            }
        }
        $order_query = "ORDER BY posts.post_id DESC";
        $where_query = "";
        /* get postsc */
        switch ($get) {
            case 'newsfeed':
                if(!$this->_logged_in && $query) {
                    $where_query .= "WHERE (";
                    $where_query .= "(posts.text LIKE $query)";
                    /* get only public posts [except wall posts] */
                    $where_query .= " AND (posts.in_wall = '0' AND posts.privacy = 'public')";
                    $where_query .= ")";
                } else {
                    /* get viewer user's newsfeed */
                    $where_query .= "WHERE (";
                    /* get viewer posts */
                    $me = $this->_data['user_id'];
                    $where_query .= "(posts.user_id = $me AND posts.user_type = 'user')";
                    /* get posts from friends still followed */
                    $friends_ids = array_intersect($this->_data['friends_ids'], $this->_data['followings_ids']);
                    if($friends_ids) {
                        $friends_list = implode(',',$friends_ids);
                        /* viewer friends posts -> authors */
                        $where_query .= " OR (posts.user_id IN ($friends_list) AND posts.user_type = 'user' AND posts.privacy = 'friends')";
                        /* viewer friends posts -> their wall posts */
                        $where_query .= " OR (posts.in_wall = '1' AND posts.wall_id IN ($friends_list) AND posts.user_type = 'user' AND posts.privacy = 'friends')";
                    }
                    /* get posts from followings */
                    if($this->_data['followings_ids']) {
                        $followings_list = implode(',',$this->_data['followings_ids']);
                        /* viewer followings posts -> authors */
                        $where_query .= " OR (posts.user_id IN ($followings_list) AND posts.user_type = 'user' AND posts.privacy = 'public')";
                        /* viewer followings posts -> their wall posts */
                        $where_query .= " OR (posts.in_wall = '1' AND posts.wall_id IN ($followings_list) AND posts.user_type = 'user' AND posts.privacy = 'public')";
                    }
                    $where_query .= ")";
                    if($query) {
                        $where_query .= " AND (posts.text LIKE $query)";
                    }
                }
                break;

            case 'posts_profile':
                if(isset($args['id']) && !is_numeric($args['id'])) {
                    _error(400);
                }
                $id = $args['id'];
                /* get target user's posts */
                /* check if there is a viewer user */
                if($this->_logged_in) {
                    /* check if the target user is the viewer */
                    if($id == $this->_data['user_id']) {
                        /* get all posts */
                        $where_query .= "WHERE (";
                        /* get all target posts */
                        $where_query .= "(posts.user_id = $id AND posts.user_type = 'user')";
                        /* get taget wall posts */
                        $where_query .= " OR (posts.wall_id = $id AND posts.in_wall = '1')";
                        $where_query .= ")";
                    } else {
                        /* check if the viewer & the target user are friends */
                        if(in_array($id, $this->_data['friends_ids'])) {
                            $where_query .= "WHERE (";
                            /* get all target posts */
                            $where_query .= "(posts.user_id = $id AND posts.user_type = 'user' AND posts.privacy != 'me' )";
                            /* get taget wall posts */
                            $where_query .= " OR (posts.wall_id = $id AND posts.in_wall = '1')";
                            $where_query .= ")";
                        } else {
                            /* get only public posts [except: wall posts ] */
                            $where_query .= "WHERE (posts.user_id = $id AND posts.user_type = 'user' AND posts.in_wall = '0' AND posts.privacy = 'public')";
                        }
                    }
                } else {
                    /* get only public posts [except: wall posts ] */
                    $where_query .= "WHERE (posts.user_id = $id AND posts.user_type = 'user' AND posts.in_wall = '0' AND posts.privacy = 'public')";
                }
                break;

            case 'saved':
                $id = $this->_data['user_id'];
                $where_query .= "INNER JOIN posts_saved ON posts.post_id = posts_saved.post_id WHERE (posts_saved.user_id = $id)";
                $order_query = "ORDER BY posts_saved.time DESC";
                break;

            default:
                _error(400);
                break;
        }
        /* get his hidden posts to exclude from newsfeed */
        $hidden_posts = $this->_get_hidden_posts($this->_data['user_id']);
        if(count($hidden_posts) > 0) {
            $hidden_posts_list = implode(',',$hidden_posts);
            $where_query .= " AND (posts.post_id NOT IN ($hidden_posts_list))";
        }
        /* filter posts */
        if($filter != "all") {
           $where_query .= " AND (posts.post_type = '$filter')";
        }
        /* get posts */
        if($last_post_id != null && $get != 'saved') {
            $get_posts = $db->query(sprintf("SELECT * FROM (SELECT posts.post_id FROM posts ".$where_query.") posts WHERE posts.post_id > %s ORDER BY posts.post_id DESC", secure($last_post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        } else {
            $get_posts = $db->query(sprintf("SELECT posts.post_id FROM posts ".$where_query." ".$order_query." LIMIT %s, %s", secure($offset, 'int', false), secure($system['max_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        }
        if($get_posts->num_rows > 0) {
            while($post = $get_posts->fetch_assoc()) {
                $post = $this->get_post($post['post_id'], true, true); /* $full_details = true, $pass_privacy_check = true */
                if($post) {
                    $posts[] = $post;
                }
            }
        }
        return $posts;
    }


    /**
     * get_post
     *
     * @param integer $post_id
     * @param boolean $full_details
     * @param boolean $pass_privacy_check
     * @return array
     */
    public function get_post($post_id, $full_details = true, $pass_privacy_check = false) {
        global $db;

        $post = $this->_check_post($post_id, $pass_privacy_check);
        if(!$post) {
            return false;
        }

        /* post type */
        if($post['post_type'] == 'album' || $post['post_type'] == 'photos' || $post['post_type'] == 'profile_picture' || $post['post_type'] == 'profile_cover' ) {
            /* get photos */
            $get_photos = $db->query(sprintf("SELECT * FROM posts_photos WHERE post_id = %s ORDER BY photo_id DESC", secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            $post['photos_num'] = $get_photos->num_rows;
            /* check if photos has been deleted */
            if($post['photos_num'] == 0) {
                return false;
            }
            while($post_photo = $get_photos->fetch_assoc()) {
                $post['photos'][] = $post_photo;
            }
            if($post['post_type'] == 'album') {
                $post['album'] = $this->get_album($post['photos'][0]['album_id'], false);
                if(!$post['album']) {
                    return false;
                }
            }

        } elseif ($post['post_type'] == 'media') {
            /* get media */
            $get_media = $db->query(sprintf("SELECT * FROM posts_media WHERE post_id = %s", secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            /* check if media has been deleted */
            if($get_media->num_rows == 0) {
                return false;
            }
            $post['media'] = $get_media->fetch_assoc();

        } elseif ($post['post_type'] == 'link') {
            /* get link */
            $get_link = $db->query(sprintf("SELECT * FROM posts_links WHERE post_id = %s", secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            /* check if link has been deleted */
            if($get_link->num_rows == 0) {
                return false;
            }
            $post['link'] = $get_link->fetch_assoc();

        } elseif ($post['post_type'] == 'article') {
            /* get article */
            $get_article = $db->query(sprintf("SELECT * FROM posts_articles WHERE post_id = %s", secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            /* check if article has been deleted */
            if($get_article->num_rows == 0) {
                return false;
            }
            $post['article'] = $get_article->fetch_assoc();
            $post['article']['parsed_cover'] = $this->get_picture($post['article']['cover'], 'article');
            $post['article']['title_url'] = get_url_text($post['article']['title']);
            $post['article']['parsed_text'] = htmlspecialchars_decode($post['article']['text'], ENT_QUOTES);
            $post['article']['text_snippet'] = get_snippet_text($post['article']['text']);
            $tags = (!is_empty($post['article']['tags']))? explode(',', $post['article']['tags']): array();
            $post['article']['parsed_tags'] = array_map('get_tag', $tags);


        } elseif ($post['post_type'] == 'video') {
            /* get video */
            $get_video = $db->query(sprintf("SELECT * FROM posts_videos WHERE post_id = %s", secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            /* check if video has been deleted */
            if($get_video->num_rows == 0) {
                return false;
            }
            $post['video'] = $get_video->fetch_assoc();

        } elseif ($post['post_type'] == 'audio') {
            /* get audio */
            $get_audio = $db->query(sprintf("SELECT * FROM posts_audios WHERE post_id = %s", secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            /* check if audio has been deleted */
            if($get_audio->num_rows == 0) {
                return false;
            }
            $post['audio'] = $get_audio->fetch_assoc();

        } elseif ($post['post_type'] == 'file') {
            /* get file */
            $get_file = $db->query(sprintf("SELECT * FROM posts_files WHERE post_id = %s", secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            /* check if file has been deleted */
            if($get_file->num_rows == 0) {
                return false;
            }
            $post['file'] = $get_file->fetch_assoc();

        } elseif ($post['post_type'] == 'shared') {
            /* get origin post */
            $post['origin'] = $this->get_post($post['origin_id'], false);
            /* check if origin post has been deleted */
            if(!$post['origin']) {
                return false;
            }
        }

        /* post feeling */
        if(!is_empty($post['feeling_action']) && !is_empty($post['feeling_value'])) {
            if($post['feeling_action'] != "Feeling") {
                $_feeling_icon = get_feeling_icon($post['feeling_action'], get_feelings());
            } else {
                $_feeling_icon = get_feeling_icon($post['feeling_value'], get_feelings_types());
            }
            if($_feeling_icon) {
                $post['feeling_icon'] = $_feeling_icon;
            }
        }

        /* parse text */
        $post['text_plain'] = $post['text'];
        $post['text'] = $this->_parse($post['text_plain']);

        /* check if get full post details */
        if($full_details) {
            /* get post comments */
            if($post['comments'] > 0) {
                $post['post_comments'] = $this->get_comments($post['post_id'], 0, true, true, $post);
            }
        }

        return $post;
    }


    /**
     * who_likes
     *
     * @param array $args
     * @return array
     */
    public function who_likes($args = array()) {
        global $db, $system;
        /* initialize arguments */
        $post_id = !isset($args['post_id']) ? null : $args['post_id'];
        $photo_id = !isset($args['photo_id']) ? null : $args['photo_id'];
        $comment_id = !isset($args['comment_id']) ? null : $args['comment_id'];
        $offset = !isset($args['offset']) ? 0 : $args['offset'];
        /* initialize vars */
        $users = array();
        $offset *= $system['max_results'];
        if($post_id != null) {
            /* get users who like the post */
            $get_users = $db->query(sprintf('SELECT users.user_id, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture FROM posts_likes INNER JOIN users ON (posts_likes.user_id = users.user_id) WHERE posts_likes.post_id = %s LIMIT %s, %s', secure($post_id, 'int'), secure($offset, 'int', false), secure($system['max_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        } elseif ($photo_id != null) {
            /* get users who like the photo */
            $get_users = $db->query(sprintf('SELECT users.user_id, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture FROM posts_photos_likes INNER JOIN users ON (posts_photos_likes.user_id = users.user_id) WHERE posts_photos_likes.photo_id = %s LIMIT %s, %s', secure($photo_id, 'int'), secure($offset, 'int', false), secure($system['max_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        } else {
            /* get users who like the comment */
            $get_users = $db->query(sprintf('SELECT users.user_id, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture FROM posts_comments_likes INNER JOIN users ON (posts_comments_likes.user_id = users.user_id) WHERE posts_comments_likes.comment_id = %s LIMIT %s, %s', secure($comment_id, 'int'), secure($offset, 'int', false), secure($system['max_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        }
        if($get_users->num_rows > 0) {
            while($_user = $get_users->fetch_assoc()) {
                $_user['user_picture'] = $this->get_picture($_user['user_picture'], $_user['user_gender']);
                /* get the connection between the viewer & the target */
                $_user['connection'] = $this->connection($_user['user_id']);
                /* get mutual friends count */
                $_user['mutual_friends_count'] = $this->get_mutual_friends_count($_user['user_id']);
                $users[] = $_user;
            }
        }
        return $users;
    }


    /**
     * who_shares
     *
     * @param integer $post_id
     * @param integer $offset
     * @return array
     */
    public function who_shares($post_id, $offset = 0) {
        global $db, $system;
        $posts = array();
        $offset *= $system['max_results'];
        $get_posts = $db->query(sprintf('SELECT posts.post_id FROM posts INNER JOIN users ON posts.user_id = users.user_id WHERE posts.post_type = "shared" AND posts.origin_id = %s LIMIT %s, %s', secure($post_id, 'int'), secure($offset, 'int', false), secure($system['max_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        if($get_posts->num_rows > 0) {
            while($post = $get_posts->fetch_assoc()) {
                $post = $this->get_post($post['post_id']);
                if($post) {
                    $posts[] = $post;
                }
            }
        }
        return $posts;
    }


    /**
     * _get_hidden_posts
     *
     * @param integer $user_id
     * @return array
     */
    private function _get_hidden_posts($user_id) {
        global $db;
        $hidden_posts = array();
        $get_hidden_posts = $db->query(sprintf("SELECT post_id FROM posts_hidden WHERE user_id = %s", secure($user_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        if($get_hidden_posts->num_rows > 0) {
            while($hidden_post = $get_hidden_posts->fetch_assoc()) {
                $hidden_posts[] = $hidden_post['post_id'];
            }
        }
        return $hidden_posts;
    }


    /**
     * _check_post
     *
     * @param integer $id
     * @param boolean $pass_privacy_check
     * @param boolean $full_details
     * @return array|false
     */
    private function _check_post($id, $pass_privacy_check = false, $full_details = true) {
        global $db, $system;

        /* get post */
        $get_post = $db->query(sprintf("SELECT posts.*, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture, users.user_picture_id, users.user_cover_id, users.user_verified, users.user_subscribed, users.user_pinned_post FROM posts LEFT JOIN users ON posts.user_id = users.user_id AND posts.user_type = 'user' WHERE NOT (users.user_name <=> NULL ) AND posts.post_id = %s", secure($id, 'int') )) or _error(SQL_ERROR_THROWEN);
        if($get_post->num_rows == 0) {
            return false;
        }
        $post = $get_post->fetch_assoc();

        /* get the author */
        $post['author_id'] = ($post['user_type'] == "user")? $post['user_admin'] : $post['user_id'];
        /* check the post author type */
        if($post['user_type'] == "user") {
            /* user */
            $post['post_author_picture'] = $this->get_picture($post['user_picture'], $post['user_gender']);
            $post['post_author_url'] = $system['system_url'].'/'.$post['user_name'];
            $post['post_author_name'] = $post['user_firstname']." ".$post['user_lastname'];
            $post['post_author_verified'] = $post['user_verified'];
            $post['pinned'] = ( ( $post['post_id'] == $post['user_pinned_post'] ) )? true : false;
        }

        /* check if viewer can manage post [Edit|Pin|Delete] */
        $post['manage_post'] = false;
        if($this->_logged_in) {
            /* viewer is the author of post */
            if($this->_data['user_id'] == $post['author_id']) {
                $post['manage_post'] = true;
            }
        }

        /* full details */
        if($full_details) {
            /* check if wall post */
            if($post['in_wall']) {
                $get_wall_user = $db->query(sprintf("SELECT user_firstname, user_lastname, user_name FROM users WHERE user_id = %s", secure($post['wall_id'] ,'int') )) or _error(SQL_ERROR_THROWEN);
                if($get_wall_user->num_rows == 0) {
                    return false;
                }
                $wall_user = $get_wall_user->fetch_assoc();
                $post['wall_username'] = $wall_user['user_name'];
                $post['wall_fullname'] = $wall_user['user_firstname']." ".$wall_user['user_lastname'];
            }

            /* check if viewer [liked|saved] this post */
            $post['i_save'] = false;
            $post['i_like'] = false;
            if($this->_logged_in) {
                /* save */
                $check_save = $db->query(sprintf("SELECT * FROM posts_saved WHERE user_id = %s AND post_id = %s", secure($this->_data['user_id'], 'int'), secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                if($check_save->num_rows > 0) {
                    $post['i_save'] = true;
                }
                /* like */
                $check_like = $db->query(sprintf("SELECT * FROM posts_likes WHERE user_id = %s AND post_id = %s", secure($this->_data['user_id'], 'int'), secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                if($check_like->num_rows > 0) {
                    $post['i_like'] = true;
                }
            }
        }

        /* check privacy */
        $pass_privacy_check = true;
        if($pass_privacy_check || $this->_check_privacy($post['privacy'], $post['author_id'])) {
            return $post;
        }
        return false;
    }


    /**
     * _check_privacy
     *
     * @param string $privacy
     * @param integer $author_id
     * @return boolean
     */
    private function _check_privacy($privacy, $author_id) {
        if($privacy == 'public') {
            return true;
        }
        if($this->_logged_in) {
            /* check if the viewer is the target */
            if($author_id == $this->_data['user_id']) {
                return true;
            }
            /* check if the viewer and the target are friends */
            if($privacy == 'friends' && in_array($author_id, $this->_data['friends_ids'])) {
                return true;
            }
        }
        return false;
    }



    /* ------------------------------- */
    /* Comments & Replies */
    /* ------------------------------- */

    /**
     * get_comments
     *
     * @param integer $node_id
     * @param integer $offset
     * @param boolean $is_post
     * @param boolean $pass_privacy_check
     * @param array $post
     * @return array
     */
    public function get_comments($node_id, $offset = 0, $is_post = true, $pass_privacy_check = true, $post = array()) {
        global $db, $system;
        $comments = array();
        $offset *= $system['min_results'];
        /* get comments */
        if($is_post) {
            /* get post comments */
            if(!$pass_privacy_check) {
                /* (check|get) post */
                $post = $this->_check_post($node_id, false);
                if(!$post) {
                    return false;
                }
            }
            /* get post comments */
            $get_comments = $db->query(sprintf("SELECT * FROM (SELECT posts_comments.*, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture, users.user_verified FROM posts_comments LEFT JOIN users ON posts_comments.user_id = users.user_id AND posts_comments.user_type = 'user' WHERE NOT (users.user_name <=> NULL ) AND posts_comments.node_type = 'post' AND posts_comments.node_id = %s ORDER BY posts_comments.comment_id DESC LIMIT %s, %s) comments ORDER BY comments.comment_id ASC", secure($node_id, 'int'), secure($offset, 'int', false), secure($system['min_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        } else {
            /* get photo comments */
            /* check privacy */
            if(!$pass_privacy_check) {
                /* (check|get) photo */
                $photo = $this->get_photo($node_id);
                if(!$photo) {
                    _error(403);
                }
                $post = $photo['post'];
            }
            /* get photo comments */
            $get_comments = $db->query(sprintf("SELECT * FROM (SELECT posts_comments.*, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture, users.user_verified FROM posts_comments LEFT JOIN users ON posts_comments.user_id = users.user_id AND posts_comments.user_type = 'user' WHERE NOT (users.user_name <=> NULL ) AND posts_comments.node_type = 'photo' AND posts_comments.node_id = %s ORDER BY posts_comments.comment_id DESC LIMIT %s, %s) comments ORDER BY comments.comment_id ASC", secure($node_id, 'int'), secure($offset, 'int', false), secure($system['min_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        }
        if($get_comments->num_rows == 0) {
            return $comments;
        }
        while($comment = $get_comments->fetch_assoc()) {
            /* get replies */
            if($comment['replies'] > 0) {
                $comment['comment_replies'] = $this->get_replies($comment['comment_id']);
            }
            /* parse text */
            $comment['text_plain'] = $comment['text'];
            $comment['text'] = $this->_parse($comment['text']);
            /* get the comment author */
            if($comment['user_type'] == "user") {
                /* user type */
                $comment['author_id'] = $comment['user_id'];
                $comment['author_picture'] = $this->get_picture($comment['user_picture'], $comment['user_gender']);
                $comment['author_url'] = $system['system_url'].'/'.$comment['user_name'];
                $comment['author_name'] = $comment['user_firstname']." ".$comment['user_lastname'];
                $comment['author_verified'] = $comment['user_verified'];
            }
            /* check if viewer user likes this comment */
            if($this->_logged_in && $comment['likes'] > 0) {
                $check_like = $db->query(sprintf("SELECT * FROM posts_comments_likes WHERE user_id = %s AND comment_id = %s", secure($this->_data['user_id'], 'int'), secure($comment['comment_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                $comment['i_like'] = ($check_like->num_rows > 0)? true: false;
            }
            /* check if viewer can manage comment [Edit|Delete] */
            $comment['edit_comment'] = false;
            $comment['delete_comment'] = false;
            if($this->_logged_in) {
                /* viewer is the author of comment */
                if($this->_data['user_id'] == $comment['author_id']) {
                    $comment['edit_comment'] = true;
                    $comment['delete_comment'] = true;
                }
                /* viewer is the author of post */
                if($this->_data['user_id'] == $post['author_id']) {
                    $comment['delete_comment'] = true;
                }
            }
            $comments[] = $comment;
        }
        return $comments;
    }


    /**
     * get_replies
     *
     * @param integer $comment_id
     * @param integer $offset
     * @return array
     */
    public function get_replies($comment_id, $offset = 0, $pass_check = true) {
        global $db, $system;
        $replies = array();
        $offset *= $system['min_results'];
        if(!$pass_check) {
            $comment = $this->get_comment($comment_id);
            if(!$comment) {
                _error(403);
            }
        }
        /* get replies */
        $get_replies = $db->query(sprintf("SELECT * FROM (SELECT posts_comments.*, users.user_name, users.user_firstname, users.user_lastname, users.user_gender, users.user_picture, users.user_verified FROM posts_comments LEFT JOIN users ON posts_comments.user_id = users.user_id AND posts_comments.user_type = 'user' WHERE NOT (users.user_name <=> NULL ) AND posts_comments.node_type = 'comment' AND posts_comments.node_id = %s ORDER BY posts_comments.comment_id DESC LIMIT %s, %s) comments ORDER BY comments.comment_id ASC", secure($comment_id, 'int'), secure($offset, 'int', false), secure($system['min_results'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
        if($get_replies->num_rows == 0) {
            return $replies;
        }
        while($reply = $get_replies->fetch_assoc()) {
            /* parse text */
            $reply['text_plain'] = $reply['text'];
            $reply['text'] = $this->_parse($reply['text']);
            /* get the reply author */
            if($reply['user_type'] == "user") {
                /* user type */
                $reply['author_id'] = $reply['user_id'];
                $reply['author_picture'] = $this->get_picture($reply['user_picture'], $reply['user_gender']);
                $reply['author_url'] = $system['system_url'].'/'.$reply['user_name'];
                $reply['author_user_name'] = $reply['user_name'];
                $reply['author_name'] = $reply['user_firstname']." ".$reply['user_lastname'];
                $reply['author_verified'] = $reply['user_verified'];
            }
						/* check if viewer user likes this reply */
            if($this->_logged_in && $reply['likes'] > 0) {
                $check_like = $db->query(sprintf("SELECT * FROM posts_comments_likes WHERE user_id = %s AND comment_id = %s", secure($this->_data['user_id'], 'int'), secure($reply['comment_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                $reply['i_like'] = ($check_like->num_rows > 0)? true: false;
            }
            /* check if viewer can manage comment [Edit|Delete] */
            $reply['edit_comment'] = false;
            $reply['delete_comment'] = false;
            if($this->_logged_in) {
                /* viewer is the author of comment */
                if($this->_data['user_id'] == $reply['author_id']) {
                    $reply['edit_comment'] = true;
                    $reply['delete_comment'] = true;
                }
            }
            $replies[] = $reply;
        }
        return $replies;
    }


    /**
     * comment
     *
     * @param string $handle
     * @param integer $node_id
     * @param string $message
     * @param string $photo
     * @return array
     */
    public function comment($handle, $node_id, $message, $photo) {
        global $db, $system, $date;
        $comment = array();

        /* default */
        $comment['node_id'] = $node_id;
        $comment['node_type'] = $handle;
        $comment['text'] = $message;
        $comment['image'] = $photo;
        $comment['time'] = $date;
        $comment['likes'] = 0;
        $comment['replies'] = 0;

        /* check the handle */
        switch ($handle) {
            case 'post':
                /* (check|get) post */
                $post = $this->_check_post($node_id, false, false);
                if(!$post) {
                    _error(403);
                }
                break;

            case 'photo':
                /* (check|get) photo */
                $photo = $this->get_photo($node_id);
                if(!$photo) {
                    _error(403);
                }
                $post = $photo['post'];
                break;

            case 'comment':
                /* (check|get) comment */
                $parent_comment = $this->get_comment($node_id, false);
                if(!$parent_comment) {
                    _error(403);
                }
                $post = $parent_comment['post'];
                break;
        }

        /* check if the viewer is admin of the target post */
        $comment['user_id'] = $this->_data['user_id'];
        $comment['user_type'] = "user";
        $comment['author_picture'] = $this->_data['user_picture'];
        $comment['author_url'] = $system['system_url'].'/'.$this->_data['user_name'];
        $comment['author_user_name'] = $this->_data['user_name'];
        $comment['author_name'] = $this->_data['user_firstname']." ".$this->_data['user_lastname'];
        $comment['author_verified'] = $this->_data['user_verified'];

        /* insert the comment */
        $db->query(sprintf("INSERT INTO posts_comments (node_id, node_type, user_id, user_type, text, image, time) VALUES (%s, %s, %s, %s, %s, %s, %s)", secure($comment['node_id'], 'int'), secure($comment['node_type']), secure($comment['user_id'], 'int'), secure($comment['user_type']), secure($comment['text']), secure($comment['image']), secure($comment['time']) )) or _error(SQL_ERROR_THROWEN);
        $comment['comment_id'] = $db->insert_id;
        /* update (post|photo|comment) (comments|replies) counter */
        switch ($handle) {
            case 'post':
                $db->query(sprintf("UPDATE posts SET comments = comments + 1 WHERE post_id = %s", secure($node_id, 'int') )) or _error(SQL_ERROR_THROWEN);
                break;

            case 'photo':
                $db->query(sprintf("UPDATE posts_photos SET comments = comments + 1 WHERE photo_id = %s", secure($node_id, 'int') )) or _error(SQL_ERROR_THROWEN);
                break;

            case 'comment':
                $db->query(sprintf("UPDATE posts_comments SET replies = replies + 1 WHERE comment_id = %s", secure($node_id, 'int') )) or _error(SQL_ERROR_THROWEN);
                $db->query(sprintf("UPDATE posts SET comments = comments + 1 WHERE post_id = %s", secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                break;
        }

        /* post notification */
        if($handle == "comment") {
            $this->post_notification( array('to_user_id'=>$parent_comment['author_id'], 'action'=>'reply', 'node_type'=>$parent_comment['node_type'], 'node_url'=>$parent_comment['node_id'], 'notify_id'=>'comment_'.$comment['comment_id']) );
            if($post['author_id'] != $parent_comment['author_id']) {
                $this->post_notification( array('to_user_id'=>$post['author_id'], 'action'=>'comment', 'node_type'=>$parent_comment['node_type'], 'node_url'=>$parent_comment['node_id'], 'notify_id'=>'comment_'.$comment['comment_id']) );
            }
        } else {
            $this->post_notification( array('to_user_id'=>$post['author_id'], 'action'=>'comment', 'node_type'=>$handle, 'node_url'=>$node_id, 'notify_id'=>'comment_'.$comment['comment_id']) );
        }

        /* post mention notifications if any */
        if($handle == "comment") {
            $this->post_mentions($comment['text'], $parent_comment['node_id'], "reply_".$parent_comment['node_type'], 'comment_'.$comment['comment_id'], array($post['author_id'], $parent_comment['author_id']));
        } else {
            $this->post_mentions($comment['text'], $node_id, "comment_".$handle, 'comment_'.$comment['comment_id'], array($post['author_id']));
        }

        /* parse text */
        $comment['text_plain'] = htmlentities($comment['text'], ENT_QUOTES, 'utf-8');
        $comment['text'] = $this->_parse($comment['text_plain']);

        /* check if viewer can manage comment [Edit|Delete] */
        $comment['edit_comment'] = true;
        $comment['delete_comment'] = true;

        /* return */
        return $comment;
    }


    /**
     * get_comment
     *
     * @param integer $comment_id
     * @return array|false
     */
    public function get_comment($comment_id, $recursive = true) {
        global $db;
        /* get comment */
        $get_comment = $db->query(sprintf("SELECT posts_comments.* FROM posts_comments WHERE posts_comments.comment_id = %s", secure($comment_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        if($get_comment->num_rows == 0) {
            return false;
        }
        $comment = $get_comment->fetch_assoc();
        /* get the author */
        $comment['author_id'] = ($comment['user_type'] == "user")? $comment['user_id'] : $comment['user_id'];
        /* get post */
        switch ($comment['node_type']) {
            case 'post':
                $post = $this->_check_post($comment['node_id'], false, false);
                /* check if the post has been deleted */
                if(!$post) {
                    return false;
                }
                $comment['post'] = $post;
                break;

            case 'photo':
                /* (check|get) photo */
                $photo = $this->get_photo($comment['node_id']);
                if(!$photo) {
                    return false;
                }
                $comment['post'] = $photo['post'];
                break;

            case 'comment':
                if(!$recursive) {
                    return false;
                }
                /* (check|get) comment */
                $parent_comment = $this->get_comment($comment['node_id'], false);
                if(!$parent_comment) {
                    return false;
                }
                $comment['parent_comment'] = $parent_comment;
                $comment['post'] = $parent_comment['post'];
                break;
        }
        /* check if viewer user likes this comment */
        if($this->_logged_in && $comment['likes'] > 0) {
            $check_like = $db->query(sprintf("SELECT * FROM posts_comments_likes WHERE user_id = %s AND comment_id = %s", secure($this->_data['user_id'], 'int'), secure($comment['comment_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            $comment['i_like'] = ($check_like->num_rows > 0)? true: false;
        }
        return $comment;
    }


    /**
     * delete_comment
     *
     * @param integer $comment_id
     * @return void
     */
    public function delete_comment($comment_id) {
        global $db;
        /* (check|get) comment */
        $comment = $this->get_comment($comment_id);
        if(!$comment) {
            _error(403);
        }
        /* check if viewer can manage comment [Delete] */
        $comment['delete_comment'] = false;
        if($this->_logged_in) {
            /* viewer is the author of comment */
            if($this->_data['user_id'] == $comment['author_id']) {
                $comment['delete_comment'] = true;
            }
            /* viewer is the author of post */
            if($this->_data['user_id'] == $comment['post']['author_id']) {
                $comment['delete_comment'] = true;
            }
          }
        /* delete the comment */
        if($comment['delete_comment']) {
            /* delete the comment */
            $db->query(sprintf("DELETE FROM posts_comments WHERE comment_id = %s", secure($comment_id, 'int') )) or _error(SQL_ERROR_THROWEN);
            /* update comments counter */
            switch ($comment['node_type']) {
                case 'post':
                    $db->query(sprintf("UPDATE posts SET comments = IF(comments=0,0,comments-1) WHERE post_id = %s", secure($comment['node_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                    break;

                case 'photo':
                    $db->query(sprintf("UPDATE posts_photos SET comments = IF(comments=0,0,comments-1) WHERE photo_id = %s", secure($comment['node_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                    break;

                case 'comment':
                    $db->query(sprintf("UPDATE posts_comments SET replies = IF(replies=0,0,replies-1) WHERE comment_id = %s", secure($comment['node_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                    break;
            }
        }
    }


    /**
     * edit_comment
     *
     * @param integer $comment_id
     * @param string $message
     * @param string $photo
     * @return array
     */
    public function edit_comment($comment_id, $message, $photo) {
        global $db, $system;
        /* (check|get) comment */
        $comment = $this->get_comment($comment_id);
        if(!$comment) {
            _error(403);
        }
        /* check if viewer can manage comment [Edit] */
        $comment['edit_comment'] = false;
        if($this->_logged_in) {
            /* viewer is the author of comment */
            if($this->_data['user_id'] == $comment['author_id']) {
                $comment['edit_comment'] = true;
            }
        }
        if(!$comment['edit_comment']) {
            _error(400);
        }
        /* update comment */
        $comment['text'] = $message;
        $comment['image'] = (!is_empty($comment['image']))? $comment['image'] : $photo;
        $db->query(sprintf("UPDATE posts_comments SET text = %s, image = %s WHERE comment_id = %s", secure($comment['text']), secure($comment['image']), secure($comment_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* post mention notifications if any */
        if($comment['node_type'] == "comment") {
            $this->post_mentions($comment['text'], $comment['parent_comment']['node_id'], "reply_".$comment['parent_comment']['node_type'], 'comment_'.$comment['comment_id'], array($comment['post'], $comment['parent_comment']['author_id']));
        } else {
            $this->post_mentions($comment['text'], $comment['node_id'], "comment_".$comment['node_type'], 'comment_'.$comment['comment_id'], array($comment['post']['author_id']));
        }
        /* parse text */
        $comment['text_plain'] = htmlentities($comment['text'], ENT_QUOTES, 'utf-8');
        $comment['text'] = $this->_parse($comment['text_plain']);
        /* return */
        return $comment;
    }


    /**
     * like_comment
     *
     * @param integer $comment_id
     * @return void
     */
    public function like_comment($comment_id) {
        global $db;
        /* (check|get) comment */
        $comment = $this->get_comment($comment_id);
        if(!$comment) {
            _error(403);
        }
        /* like the comment */
        if(!$comment['i_like']) {
            $db->query(sprintf("INSERT INTO posts_comments_likes (user_id, comment_id) VALUES (%s, %s)", secure($this->_data['user_id'], 'int'), secure($comment_id, 'int') )) or _error(SQL_ERROR_THROWEN);
            /* update comment likes counter */
            $db->query(sprintf("UPDATE posts_comments SET likes = likes + 1 WHERE comment_id = %s", secure($comment_id, 'int') )) or _error(SQL_ERROR_THROWEN);
            /* post notification */
            switch ($comment['node_type']) {
                case 'post':
                    $this->post_notification( array('to_user_id'=>$comment['author_id'], 'action'=>'like', 'node_type'=>'post_comment', 'node_url'=>$comment['node_id'], 'notify_id'=>'comment_'.$comment_id) );
                    break;

                case 'photo':
                    $this->post_notification( array('to_user_id'=>$comment['author_id'], 'action'=>'like', 'node_type'=>'photo_comment', 'node_url'=>$comment['node_id'], 'notify_id'=>'comment_'.$comment_id) );
                    break;

                case 'comment':
                    $_node_type = ($comment['parent_comment']['node_type'] == "post")? "post_reply": "photo_reply";
                    $_node_url = $comment['parent_comment']['node_id'];
                    $this->post_notification( array('to_user_id'=>$comment['author_id'], 'action'=>'like', 'node_type'=>$_node_type, 'node_url'=>$_node_url, 'notify_id'=>'comment_'.$comment_id) );
                    break;
            }
        }
    }


    /**
     * unlike_comment
     *
     * @param integer $comment_id
     * @return void
     */
    public function unlike_comment($comment_id) {
        global $db;
        /* (check|get) comment */
        $comment = $this->get_comment($comment_id);
        if(!$comment) {
            _error(403);
        }
        /* unlike the comment */
        if($comment['i_like']) {
            $db->query(sprintf("DELETE FROM posts_comments_likes WHERE user_id = %s AND comment_id = %s", secure($this->_data['user_id'], 'int'), secure($comment_id, 'int') )) or _error(SQL_ERROR_THROWEN);
            /* update comment likes counter */
            $db->query(sprintf("UPDATE posts_comments SET likes = IF(likes=0,0,likes-1) WHERE comment_id = %s", secure($comment_id, 'int') )) or _error(SQL_ERROR_THROWEN);
            /* delete notification */
            switch ($comment['node_type']) {
                case 'post':
                    $this->delete_notification($comment['author_id'], 'like', 'post_comment', $comment['node_id']);
                    break;

                case 'photo':
                    $this->delete_notification($comment['author_id'], 'like', 'photo_comment', $comment['node_id']);
                    break;

                case 'comment':
                    $_node_type = ($comment['parent_comment']['node_type'] == "post")? "post_reply": "photo_reply";
                    $_node_url = $comment['parent_comment']['node_id'];
                    $this->delete_notification($comment['author_id'], 'like', $_node_type, $_node_url);
                    break;
            }
        }
    }


    /* ------------------------------- */
    /* Photos & Albums */
    /* ------------------------------- */

    /**
     * get_photos
     *
     * @param integer $id
     * @param string $type
     * @param integer $offset
     * @param boolean $pass_check
     * @return array
     */
    public function get_photos($id, $type = 'user', $offset = 0, $pass_check = true) {
        global $db, $system;
        $photos = array();
        switch ($type) {
            case 'album':
                $offset *= $system['max_results_even'];
                if($pass_check) {
                    $get_photos = $db->query(sprintf("SELECT * FROM posts_photos WHERE album_id = %s ORDER BY photo_id DESC LIMIT %s, %s", secure($id, 'int'), secure($offset, 'int', false), secure($system['max_results_even'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
                    if($get_photos->num_rows > 0) {
                        while($photo = $get_photos->fetch_assoc()) {
                            $photos[] = $photo;
                        }
                    }
                } else {
                    $album = $this->get_album($id, false);
                    if(!$album) {
                        return $photos;
                    }
                    $get_photos = $db->query(sprintf("SELECT * FROM posts_photos WHERE album_id = %s ORDER BY photo_id DESC LIMIT %s, %s", secure($id, 'int'), secure($offset, 'int', false), secure($system['max_results_even'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
                    if($get_photos->num_rows > 0) {
                        while($photo = $get_photos->fetch_assoc()) {
                            $photo['manage'] = $album['manage_album'];
                            $photos[] = $photo;
                        }
                    }
                }
                break;
            case 'user':
                $offset *= $system['min_results_even'];
                /* get the target user's privacy */
                $get_privacy = $db->query(sprintf("SELECT user_privacy_photos FROM users WHERE user_id = %s", secure($id, 'int') )) or _error(SQL_ERROR_THROWEN);
                $privacy = $get_privacy->fetch_assoc();
                /* check the target user's privacy  */
                if(!$this->_check_privacy($privacy['user_privacy_photos'], $id)) {
                    return $photos;
                }
                $get_photos = $db->query(sprintf("SELECT posts_photos.photo_id, posts_photos.source, posts.privacy FROM posts_photos INNER JOIN posts ON posts_photos.post_id = posts.post_id WHERE posts.user_id = %s AND user_type = 'user' ORDER BY posts_photos.photo_id DESC LIMIT %s, %s", secure($id, 'int'), secure($offset, 'int', false), secure($system['min_results_even'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
                if($get_photos->num_rows > 0) {
                    while($photo = $get_photos->fetch_assoc()) {
                        /* check the photo privacy */
                        if($this->_check_privacy($photo['privacy'], $id)) {
                            $photos[] = $photo;
                        }
                    }
                }
                break;
        }
        return $photos;
    }


    /**
     * get_photo
     *
     * @param integer $photo_id
     * @param boolean $full_details
     * @param boolean $get_gallery
     * @param string $context
     * @return array
     */
    public function get_photo($photo_id, $full_details = false, $get_gallery = false, $context = 'photos') {
        global $db;

        /* get photo */
        $get_photo = $db->query(sprintf("SELECT * FROM posts_photos WHERE photo_id = %s", secure($photo_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        if($get_photo->num_rows == 0) {
            return false;
        }
        $photo = $get_photo->fetch_assoc();

        /* get post */
        $post = $this->_check_post($photo['post_id'], false, $full_details);
        if(!$post) {
            return false;
        }

        /* check if photo can be deleted */
        if ($post['user_type'] == "user") {
            /* check if (cover|profile) photo */
            $photo['can_delete'] = ( ($photo_id == $post['user_picture_id']) OR ($photo_id == $post['user_cover_id']) )? false : true;
        }

        /* check photo type [single|mutiple] */
        $check_single = $db->query(sprintf("SELECT * FROM posts_photos WHERE post_id = %s", secure($photo['post_id'], 'int') ))  or _error(SQL_ERROR_THROWEN);
        $photo['is_single'] = ($check_single->num_rows > 1)? false : true;

        /* get full details */
        if($full_details) {
            if($photo['is_single']) {
                /* single photo => get (likes|comments) of post */

                /* check if viewer likes this post */
                if($this->_logged_in && $post['likes'] > 0) {
                    $check_like = $db->query(sprintf("SELECT * FROM posts_likes WHERE user_id = %s AND post_id = %s", secure($this->_data['user_id'], 'int'), secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                    $photo['i_like'] = ($check_like->num_rows > 0)? true: false;
                }

                /* get post comments */
                if($post['comments'] > 0) {
                    $post['post_comments'] = $this->get_comments($post['post_id'], 0, true, true, $post);
                }

            } else {
                /* mutiple photo => get (likes|comments) of photo */

                /* check if viewer user likes this photo */
                if($this->_logged_in && $photo['likes'] > 0) {
                    $check_like = $db->query(sprintf("SELECT * FROM posts_photos_likes WHERE user_id = %s AND photo_id = %s", secure($this->_data['user_id'], 'int'), secure($photo['photo_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                    $photo['i_like'] = ($check_like->num_rows > 0)? true: false;
                }

                /* get post comments */
                if($photo['comments'] > 0) {
                    $photo['photo_comments'] = $this->get_comments($photo['photo_id'], 0, false, true, $post);
                }

            }
        }

        /* get gallery */
        if($get_gallery) {
            switch ($context) {
                case 'post':
                    $get_post_photos = $db->query(sprintf("SELECT photo_id, source FROM posts_photos WHERE post_id = %s", secure($post['post_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                    while($post_photo = $get_post_photos->fetch_assoc()) {
                        $post_photos[$post_photo['photo_id']] = $post_photo;
                    }
                    $photo['next'] = $post_photos[get_array_key($post_photos, $photo['photo_id'], -1)];
                    $photo['prev'] =  $post_photos[get_array_key($post_photos, $photo['photo_id'], 1)];
                    break;

                case 'album':
                    $get_album_photos = $db->query(sprintf("SELECT photo_id, source FROM posts_photos WHERE album_id = %s", secure($photo['album_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                    while($album_photo = $get_album_photos->fetch_assoc()) {
                        $album_photos[$album_photo['photo_id']] = $album_photo;
                    }
                    $photo['next'] = $album_photos[get_array_key($album_photos, $photo['photo_id'], -1)];
                    $photo['prev'] =  $album_photos[get_array_key($album_photos, $photo['photo_id'], 1)];
                    break;

                case 'photos':
                    if ($post['user_type'] == "user") {
                        $get_target_photos = $db->query(sprintf("SELECT posts_photos.photo_id, posts_photos.source FROM posts INNER JOIN posts_photos ON posts.post_id = posts_photos.post_id WHERE posts.user_type = 'user' AND posts.user_id = %s", secure($post['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                    }
                    while($target_photo = $get_target_photos->fetch_assoc()) {
                        $target_photos[$target_photo['photo_id']] = $target_photo;
                    }
                    $photo['next'] = $target_photos[get_array_key($target_photos, $photo['photo_id'], -1)];
                    $photo['prev'] =  $target_photos[get_array_key($target_photos, $photo['photo_id'], 1)];
                    break;
            }
        }

        /* return post array with photo */
        $photo['post'] = $post;
        return $photo;
    }


    /**
     * delete_photo
     *
     * @param integer $photo_id
     * @return void
     */
    public function delete_photo($photo_id) {
        global $db, $system;
        /* (check|get) photo */
        $photo = $this->get_photo($photo_id);
        if(!$photo) {
            _error(403);
        }
        $post = $photo['post'];
        /* check if viewer can manage post */
        if(!$post['manage_post']) {
            _error(403);
        }
        /* check if photo can be deleted */
        if(!$photo['can_delete']) {
            throw new Exception(__("This photo can't be deleted"));
        }
        /* delete the photo */
        $db->query(sprintf("DELETE FROM posts_photos WHERE photo_id = %s", secure($photo_id, 'int') )) or _error(SQL_ERROR_THROWEN);
    }


    /**
     * like_photo
     *
     * @param integer $photo_id
     * @return void
     */
    public function like_photo($photo_id) {
        global $db;
        /* (check|get) photo */
        $photo = $this->get_photo($photo_id);
        if(!$photo) {
            _error(403);
        }
        $post = $photo['post'];
        /* like the photo */
        $db->query(sprintf("INSERT INTO posts_photos_likes (user_id, photo_id) VALUES (%s, %s)", secure($this->_data['user_id'], 'int'), secure($photo_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* update photo likes counter */
        $db->query(sprintf("UPDATE posts_photos SET likes = likes + 1 WHERE photo_id = %s", secure($photo_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* post notification */
        $this->post_notification( array('to_user_id'=>$post['author_id'], 'action'=>'like', 'node_type'=>'photo', 'node_url'=>$photo_id) );
    }


    /**
     * unlike_photo
     *
     * @param integer $photo_id
     * @return void
     */
    public function unlike_photo($photo_id) {
        global $db;
        /* (check|get) photo */
        $photo = $this->get_photo($photo_id);
        if(!$photo) {
            _error(403);
        }
        $post = $photo['post'];
        /* unlike the photo */
        $db->query(sprintf("DELETE FROM posts_photos_likes WHERE user_id = %s AND photo_id = %s", secure($this->_data['user_id'], 'int'), secure($photo_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* update photo likes counter */
        $db->query(sprintf("UPDATE posts_photos SET likes = IF(likes=0,0,likes-1) WHERE photo_id = %s", secure($photo_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* delete notification */
        $this->delete_notification($post['author_id'], 'like', 'photo', $photo_id);
    }


    /**
     * get_albums
     *
     * @param integer $user_id
     * @param string $type
     * @param integer $offset
     * @return array
     */
    public function get_albums($id, $type = 'user', $offset = 0) {
        global $db, $system;
        /* initialize vars */
        $albums = array();
        $offset *= $system['max_results_even'];
        if(!in_array($type, array('user'))) {
            return $albums;
        }
        switch ($type) {
            case 'user':
                $get_albums = $db->query(sprintf("SELECT album_id FROM posts_photos_albums WHERE user_type = 'user' AND user_id = %s LIMIT %s, %s", secure($id, 'int'), secure($offset, 'int', false), secure($system['max_results_even'], 'int', false) )) or _error(SQL_ERROR_THROWEN);
                break;

          }
        if($get_albums->num_rows > 0) {
            while($album = $get_albums->fetch_assoc()) {
                $album = $this->get_album($album['album_id'], false); /* $full_details = false */
                if($album) {
                    $albums[] = $album;
                }
            }
        }
        return $albums;
    }


    /**
     * get_album
     *
     * @param integer $album_id
     * @param boolean $full_details
     * @return array
     */
    public function get_album($album_id, $full_details = true) {
        global $db, $system;
        $get_album = $db->query(sprintf("SELECT posts_photos_albums.*, users.user_name, users.user_album_pictures, users.user_album_covers, users.user_album_timeline FROM posts_photos_albums LEFT JOIN users ON posts_photos_albums.user_id = users.user_id AND posts_photos_albums.user_type = 'user' WHERE NOT (users.user_name <=> NULL ) AND posts_photos_albums.album_id = %s", secure($album_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        if($get_album->num_rows == 0) {
            return false;
        }
        $album = $get_album->fetch_assoc();
        /* get the author */
        $album['author_id'] = ($album['user_type'] == "user")? $album['user_id'] : $album['user_id'];
        /* check the album privacy  */
        $pass_privacy_check = true;
        if(!$pass_privacy_check) {
            if(!$this->_check_privacy($album['privacy'], $album['author_id'])) {
                return false;
            }
        }
        /* get album path */
        if ($album['user_type'] == "user") {
            $album['path'] = $album['user_name'];
            /* check if (cover|profile|timeline) album */
            $album['can_delete'] = ( ($album_id == $album['user_album_pictures']) OR ($album_id == $album['user_album_covers']) OR ($album_id == $album['user_album_timeline']) )? false : true;
        }
        /* get album cover photo */
        $get_cover = $db->query(sprintf("SELECT source FROM posts_photos WHERE album_id = %s ORDER BY photo_id DESC", secure($album_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        if($get_cover->num_rows == 0) {
            $album['cover'] = $system['system_url'].'/content/themes/'.$system['theme'].'/images/blank_album.jpg';
        } else {
            $cover = $get_cover->fetch_assoc();
            $album['cover'] = $system['system_uploads'].'/'.$cover['source'];
        }
        $album['photos_count'] = $get_cover->num_rows;
        /* check if viewer can manage album [Edit|Update|Delete] */
        $album['manage_album'] = false;
        if($this->_logged_in) {
            /* viewer is the author of post */
            if($this->_data['user_id'] == $album['author_id']) {
                $album['manage_album'] = true;
            }
          }
        /* get album photos */
        if($full_details) {
            $album['photos'] = $this->get_photos($album_id, 'album');

        }
        return $album;
    }


    /**
     * delete_album
     *
     * @param integer $album_id
     * @return void
     */
    public function delete_album($album_id) {
        global $db, $system;
        /* (check|get) album */
        $album = $this->get_album($album_id, false);
        if(!$album) {
            _error(403);
        }
        /* check if viewer can manage album */
        if(!$album['manage_album']) {
            _error(403);
        }
        /* check if album can be deleted */
        if(!$album['can_delete']) {
            throw new Exception(__("This album can't be deleted"));
        }
        /* delete the album */
        $db->query(sprintf("DELETE FROM posts_photos_albums WHERE album_id = %s", secure($album_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* delete all album photos */
        $db->query(sprintf("DELETE FROM posts_photos WHERE album_id = %s", secure($album_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* retrun path */
        $path = $system['system_url']."/".$album['path']."/albums";
        return $path;
    }


    /**
     * edit_album
     *
     * @param integer $album_id
     * @param string $title
     * @return void
     */
    public function edit_album($album_id, $title) {
        global $db;
        /* (check|get) album */
        $album = $this->get_album($album_id, false);
        if(!$album) {
            _error(400);
        }
        /* check if viewer can manage album */
        if(!$album['manage_album']) {
            _error(400);
        }
        /* validate all fields */
        if(is_empty($title)) {
            throw new Exception(__("You must fill in all of the fields"));
        }
        /* edit the album */
        $db->query(sprintf("UPDATE posts_photos_albums SET title = %s WHERE album_id = %s", secure($title), secure($album_id, 'int') )) or _error(SQL_ERROR_THROWEN);
    }


    /**
     * add_photos
     *
     * @param array $args
     * @return array
     */
    public function add_album_photos($args = array()) {
        global $db, $system, $date;
        /* (check|get) album */
        $album = $this->get_album($args['album_id'], false);
        if(!$album) {
            _error(400);
        }
        /* check if viewer can manage album */
        if(!$album['manage_album']) {
            _error(400);
        }
        /* check user_id */
        $user_id = ($album['user_type'] == "user")? $album['user_id'] : $album['user_id'];
        /* check post location */
        $args['location'] = (!is_empty($args['location']) && valid_location($args['location']))? $args['location']: '';
        /* check privacy */
        if ($album['user_type'] == "user") {
            if(!in_array($args['privacy'], array('me', 'friends', 'public'))) {
                $args['privacy'] = 'public';
            }
        }
        /* insert the post */
        $db->query(sprintf("INSERT INTO posts (user_id, user_type, post_type, time, location, privacy, text) VALUES (%s, %s, 'album', %s, %s, %s, %s)", secure($user_id, 'int'), secure($album['user_type']), secure($date), secure($args['location']), secure($args['privacy']), secure($args['message']) )) or _error(SQL_ERROR_THROWEN);
        $post_id = $db->insert_id;
        /* insert new photos */
        foreach ($args['photos'] as $photo) {
            $db->query(sprintf("INSERT INTO posts_photos (post_id, album_id, source) VALUES (%s, %s, %s)", secure($post_id, 'int'), secure($args['album_id'], 'int'), secure($photo) )) or _error(SQL_ERROR_THROWEN);
        }
        /* post mention notifications */
        $this->post_mentions($args['message'], $post_id);
        return $post_id;
    }



    /* ------------------------------- */
    /* Post Reactions */
    /* ------------------------------- */

    /**
     * share
     *
     * @param integer $post_id
     *@return void
     */
    public function share($post_id) {
        global $db, $date;
        /* check if the viewer can share the post */
        $post = $this->_check_post($post_id, true);
        if(!$post || $post['privacy'] != 'public') {
            _error(403);
        }
        // share post
        /* share the origin post */
        if($post['post_type'] == "shared") {
            $origin = $this->_check_post($post['origin_id'], true);
            if(!$origin || $origin['privacy'] != 'public') {
                _error(403);
            }
            $post_id = $origin['post_id'];
            $author_id = $origin['author_id'];
        } else {
            $post_id = $post['post_id'];
            $author_id = $post['author_id'];
        }
        /* insert the new shared post */
        $db->query(sprintf("INSERT INTO posts (user_id, user_type, post_type, origin_id, time, privacy) VALUES (%s, 'user', 'shared', %s, %s, 'public')", secure($this->_data['user_id'], 'int'), secure($post_id, 'int'), secure($date) )) or _error(SQL_ERROR_THROWEN);
        /* update the origin post shares counter */
        $db->query(sprintf("UPDATE posts SET shares = shares + 1 WHERE post_id = %s", secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* post notification */
        $this->post_notification( array('to_user_id'=>$author_id, 'action'=>'share', 'node_type'=>'post', 'node_url'=>$post_id) );
    }


    /**
     * delete_post
     *
     * @param integer $post_id
     * @return void
     */
    public function delete_post($post_id) {
        global $db;
        /* (check|get) post */
        $post = $this->_check_post($post_id, true);
        if(!$post) {
            _error(403);
        }
        /* delete the post */
        if(!$post['manage_post']) {
            _error(403);
        }
        /* delete post */
        $db->query(sprintf("DELETE FROM posts WHERE post_id = %s", secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* delete post photos (if any) */
        $db->query(sprintf("DELETE FROM posts_photos WHERE post_id = %s", secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* delete cover & profile pictures (if any) */
        $refresh = false;
        switch ($post['post_type']) {
            case 'profile_cover':
                /* update user cover */
                $db->query(sprintf("UPDATE users SET user_cover = null, user_cover_id = null WHERE user_id = %s", secure($post['author_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                /* return */
                $refresh = true;
                break;

            case 'profile_picture':
                /* update user picture */
                $db->query(sprintf("UPDATE users SET user_picture = null, user_picture_id = null WHERE user_id = %s", secure($post['author_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                /* return */
                $refresh = true;
                break;

            }
        return $refresh;
    }


    /**
     * edit_post
     *
     * @param integer $post_id
     * @param string $message
     * @return array
     */
    public function edit_post($post_id, $message) {
        global $db, $system;
        /* (check|get) post */
        $post = $this->_check_post($post_id, true);
        if(!$post) {
            _error(403);
        }
        /* check if viewer can edit post */
        if(!$post['manage_post']) {
            _error(403);
        }
        /* update post */
        $db->query(sprintf("UPDATE posts SET text = %s WHERE post_id = %s", secure($message), secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        /* post mention notifications */
        $this->post_mentions($message, $post_id);
        /* parse text */
        $post['text_plain'] = htmlentities($message, ENT_QUOTES, 'utf-8');
        $post['text'] = $this->_parse($post['text_plain']);
        /* return */
        return $post;
    }


    /**
     * edit_privacy
     *
     * @param integer $post_id
     * @param string $privacy
     * @return array
     */
    public function edit_privacy($post_id, $privacy) {
        global $db, $system;
        /* (check|get) post */
        $post = $this->_check_post($post_id, true);
        if(!$post) {
            _error(403);
        }
        /* check if viewer can edit privacy */
        if($post['manage_post'] && $post['user_type'] == 'user') {
            /* update privacy */
            $db->query(sprintf("UPDATE posts SET privacy = %s WHERE post_id = %s", secure($privacy), secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
        } else {
            _error(403);
        }
    }


    /**
     * save_post
     *
     * @param integer $post_id
     * @return array
     */
    public function save_post($post_id) {
        global $db, $date;
        /* (check|get) post */
        $post = $this->_check_post($post_id);
        if(!$post) {
            _error(403);
        }
        /* save post */
        if(!$post['i_save']) {
            $db->query(sprintf("INSERT INTO posts_saved (post_id, user_id, time) VALUES (%s, %s, %s)", secure($post_id, 'int'), secure($this->_data['user_id'], 'int'), secure($date) )) or _error(SQL_ERROR_THROWEN);
        }
    }


    /**
     * unsave_post
     *
     * @param integer $post_id
     * @return array
     */
    public function unsave_post($post_id) {
        global $db;
        /* (check|get) post */
        $post = $this->_check_post($post_id);
        if(!$post) {
            _error(403);
        }
        /* unsave post */
        if($post['i_save']) {
            $db->query(sprintf("DELETE FROM posts_saved WHERE post_id = %s AND user_id = %s", secure($post_id, 'int'), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
        }
    }


    /**
     * pin_post
     *
     * @param integer $post_id
     * @return array
     */
    public function pin_post($post_id) {
        global $db, $date;
        /* (check|get) post */
        $post = $this->_check_post($post_id);
        if(!$post) {
            _error(403);
        }
        /* check if viewer can edit post */
        if(!$post['manage_post']) {
            _error(403);
        }
        /* pin post */
        if(!$post['pinned']) {
            /* check the post author type */
            if($post['user_type'] == "user") {
                /* user */
                /* update user */
                $db->query(sprintf("UPDATE users SET user_pinned_post = %s WHERE user_id = %s", secure($post_id, 'int'), secure($post['author_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            }
				}
    }


    /**
     * unpin_post
     *
     * @param integer $post_id
     * @return array
     */
    public function unpin_post($post_id) {
        global $db, $date;
        /* (check|get) post */
        $post = $this->_check_post($post_id);
        if(!$post) {
            _error(403);
        }
        /* check if viewer can edit post */
        if(!$post['manage_post']) {
            _error(403);
        }
        /* pin post */
        if($post['pinned']) {
            /* check the post author type */
            if($post['user_type'] == "user") {
                /* user */
                /* update user */
                $db->query(sprintf("UPDATE users SET user_pinned_post = '0' WHERE user_id = %s", secure($post['author_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            }
        }
    }


    /**
     * like_post
     *
     * @param integer $post_id
     * @return void
     */
    public function like_post($post_id) {
        global $db;
        /* (check|get) post */
        $post = $this->_check_post($post_id);
        if(!$post) {
            _error(403);
        }
        /* like the post */
        if(!$post['i_like']) {
            $db->query(sprintf("INSERT INTO posts_likes (user_id, post_id) VALUES (%s, %s)", secure($this->_data['user_id'], 'int'), secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
            /* update post likes counter */
            $db->query(sprintf("UPDATE posts SET likes = likes + 1 WHERE post_id = %s", secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
            /* post notification */
            $this->post_notification( array('to_user_id'=>$post['author_id'], 'action'=>'like', 'node_type'=>'post', 'node_url'=>$post_id) );
        }
    }


    /**
     * unlike_post
     *
     * @param integer $post_id
     * @return void
     */
    public function unlike_post($post_id) {
        global $db;
        /* (check|get) post */
        $post = $this->_check_post($post_id);
        if(!$post) {
            _error(403);
        }
        /* unlike the post */
        if($post['i_like']) {
            $db->query(sprintf("DELETE FROM posts_likes WHERE user_id = %s AND post_id = %s", secure($this->_data['user_id'], 'int'), secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
            /* update post likes counter */
            $db->query(sprintf("UPDATE posts SET likes = IF(likes=0,0,likes-1) WHERE post_id = %s", secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
            /* delete notification */
            $this->delete_notification($post['author_id'], 'like', 'post', $post_id);
        }
    }


    /**
     * hide_post
     *
     * @param integer $post_id
     * @return void
     */
    public function hide_post($post_id) {
        global $db;
        /* (check|get) post */
        $post = $this->_check_post($post_id);
        if(!$post) {
            _error(403);
        }
        /* hide the post */
        $db->query(sprintf("INSERT INTO posts_hidden (user_id, post_id) VALUES (%s, %s)", secure($this->_data['user_id'], 'int'), secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
    }


    /**
     * unhide_post
     *
     * @param integer $post_id
     * @return void
     */
    public function unhide_post($post_id) {
        global $db;
        /* (check|get) post */
        $post = $this->_check_post($post_id);
        if(!$post) {
            _error(403);
        }
        /* unhide the post */
        $db->query(sprintf("DELETE FROM posts_hidden WHERE user_id = %s AND post_id = %s", secure($this->_data['user_id'], 'int'), secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
    }


    /* ------------------------------- */
    /* Articles */
    /* ------------------------------- */

    /**
     * get_articles
     *
     * @param array $args
     * @return array
     */
    public function get_articles($args = array()) {
        global $db, $system;
        /* initialize arguments */
        $offset = !isset($args['offset']) ? 0 : $args['offset'];
        $random = !isset($args['random']) ? false : true;
        $results = !isset($args['results']) ? $system['max_results'] : $args['results'];
        /* initialize vars */
        $posts = array();
        $offset *= $results;
        /* get posts */
        $order_query = ($random) ? "ORDER BY RAND()" : "ORDER BY posts.post_id DESC";
        $get_posts = $db->query(sprintf("SELECT posts.post_id FROM posts INNER JOIN posts_articles ON posts.post_id = posts_articles.post_id WHERE posts.post_type = 'article' ".$order_query." LIMIT %s, %s", secure($offset, 'int', false), secure($results, 'int', false) )) or _error(SQL_ERROR_THROWEN);
        if($get_posts->num_rows > 0) {
            while($post = $get_posts->fetch_assoc()) {
                $post = $this->get_post($post['post_id']);
                if($post) {
                    $posts[] = $post;
                }
            }
        }
        return $posts;
    }


    /**
     * post_article
     *
     * @param string $title
     * @param string $text
     * @param string $cover
     * @param string $tags
     * @return integer
     */
    public function post_article($title, $text, $cover, $tags) {
        global $db, $system, $date;
        /* check if blogs enabled */
        if(!$system['blogs_enabled']) {
            throw new Exception(__("This feature has been disabled by the admin"));
        }
        /* validate title */
        if(is_empty($title)) {
            throw new Exception(__("You must enter a title for your article"));
        }
        if(strlen($title) < 3) {
            throw new Exception(__("Article title must be at least 3 characters long. Please try another"));
        }
        /* validate text */
        if(is_empty($text)) {
            throw new Exception(__("You must enter some text for your article"));
        }
        /* insert the post */
        $db->query(sprintf("INSERT INTO posts (user_id, user_type, post_type, time, privacy) VALUES (%s, 'user', 'article', %s, 'public')", secure($this->_data['user_id'], 'int'), secure($date) )) or _error(SQL_ERROR_THROWEN);
        $post_id = $db->insert_id;
        /* insert article */
        $db->query(sprintf("INSERT INTO posts_articles (post_id, cover, title, text, tags) VALUES (%s, %s, %s, %s, %s)", secure($post_id, 'int'), secure($cover), secure($title), secure($text), secure($tags) )) or _error(SQL_ERROR_THROWEN);
        return $post_id;
    }


    /**
     * update_article
     *
     * @param integer $post_id
     * @param string $title
     * @param string $text
     * @param string $cover
     * @param string $tags
     * @return void
     */
    public function edit_article($post_id, $title, $text, $cover, $tags) {
        global $db, $system, $date;
        /* check if blogs enabled */
        if(!$system['blogs_enabled']) {
            throw new Exception(__("This feature has been disabled by the admin"));
        }
        /* (check|get) post */
        $post = $this->_check_post($post_id, true);
        if(!$post) {
            _error(403);
        }
        /* check if viewer can edit post */
        if(!$post['manage_post']) {
            _error(403);
        }
        /* validate title */
        if(is_empty($title)) {
            throw new Exception(__("You must enter a title for your article"));
        }
        if(strlen($title) < 3) {
            throw new Exception(__("Article title must be at least 3 characters long. Please try another"));
        }
        /* validate text */
        if(is_empty($text)) {
            throw new Exception(__("You must enter some text for your article"));
        }
        /* update the article */
        $db->query(sprintf("UPDATE posts_articles SET cover = %s, title = %s, text = %s, tags = %s WHERE post_id = %s", secure($cover), secure($title), secure($text), secure($tags), secure($post_id, 'int') )) or _error(SQL_ERROR_THROWEN);
    }


    /**
     * update_article_views
     *
     * @param integer $article_id
     * @return void
     */
    public function update_article_views($article_id) {
        global $db;
        /* update */
        $db->query(sprintf("UPDATE posts_articles SET views = views + 1 WHERE article_id = %s", secure($article_id, 'int') )) or _error(SQL_ERROR_THROWEN);
    }



    /* ------------------------------- */
    /* User Settings */
    /* ------------------------------- */

    /**
     * settings
     *
     * @param string $edit
     * @param array $args
     * @return void
     */
    public function settings($edit, $args) {
        global $db, $system;
        switch ($edit) {
            case 'username':
                /* validate username */
                if(strtolower($args['username']) != strtolower($this->_data['user_name'])) {
                    if(!valid_username($args['username'])) {
                        throw new Exception(__("Please enter a valid username (a-z0-9_.) with minimum 3 characters long"));
                    }
                    if(reserved_username($args['username'])) {
                        throw new Exception(__("You can't use")." <strong>".$args['username']."</strong> ".__("as username"));
                    }
                    if($this->check_username($args['username'])) {
                        throw new Exception(__("Sorry, it looks like")." <strong>".$args['username']."</strong> ".__("belongs to an existing account"));
                    }
                    /* update user */
                    $db->query(sprintf("UPDATE users SET user_name = %s WHERE user_id = %s", secure($args['username']), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                }
                break;

            case 'email':
                /* validate email */
                if($args['email'] != $this->_data['user_email']) {
                    if(!valid_email($args['email'])) {
                        throw new Exception(__("Please enter a valid email address"));
                    }
                    if($this->check_email($args['email'])) {
                        throw new Exception(__("Sorry, it looks like")." <strong>".$args['email']."</strong> ".__("belongs to an existing account"));
                    }
                    /* generate activation key */
                    $activation_key = get_hash_token();
                    /* update user */
                    $db->query(sprintf("UPDATE users SET user_email = %s, user_activation_key = %s, user_activated = '0' WHERE user_id = %s", secure($args['email']), secure($activation_key), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                    // send activation email
                    /* prepare activation email */
                    $subject = __("Just one more step to get started on")." ".$system['system_title'];
                    $body  = __("Hi")." ".ucwords($this->_data['user_firstname']." ".$this->_data['user_lastname']).",";
                    $body .= "\r\n\r\n".__("To complete the sign-up process, please follow this link:");
                    $body .= "\r\n\r\n".$system['system_url']."/activation/".$this->_data['user_id']."/".$activation_key;
                    $body .= "\r\n\r\n".__("Welcome to")." ".$system['system_title'];
                    $body .= "\r\n\r".$system['system_title']." ".__("Team");
                    /* send email */
                    if(!_email($args['email'], $subject, $body)) {
                        throw new Exception(__("New activation email could not be sent"));
                    }
                }
                break;

            case 'password':
                /* validate all fields */
                if(is_empty($args['current']) || is_empty($args['new']) || is_empty($args['confirm'])) {
                    throw new Exception(__("You must fill in all of the fields"));
                }
                /* validate current password (MD5 check for versions < v2.5) */
                if(md5($args['current']) != $this->_data['user_password'] && !password_verify($args['current'], $this->_data['user_password'])) {
                    throw new Exception(__("Your current password is incorrect"));
                }
                /* validate new password */
                if($args['new'] != $args['confirm']) {
                    throw new Exception(__("Your passwords do not match"));
                }
                if(strlen($args['new']) < 6) {
                    throw new Exception(__("Password must be at least 6 characters long. Please try another"));
                }
                /* update user */
                $db->query(sprintf("UPDATE users SET user_password = %s WHERE user_id = %s", secure(_password_hash($args['new'])), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                break;

            case 'basic':
                /* validate firstname */
                if(is_empty($args['firstname'])) {
                    throw new Exception(__("You must enter first name"));
                }
                if(!valid_name($args['firstname'])) {
                    throw new Exception(__("First name contains invalid characters"));
                }
                if(strlen($args['firstname']) < 3) {
                    throw new Exception(__("First name must be at least 3 characters long. Please try another"));
                }
                /* validate lastname */
                if(is_empty($args['lastname'])) {
                    throw new Exception(__("You must enter last name"));
                }
                if(!valid_name($args['lastname'])) {
                    throw new Exception(__("Last name contains invalid characters"));
                }
                if(strlen($args['lastname']) < 3) {
                    throw new Exception(__("Last name must be at least 3 characters long. Please try another"));
                }
                /* validate gender */
                if($args['gender'] == "none") {
                    throw new Exception(__("Please select either Male or Female"));
                }
                $args['gender'] = ($args['gender'] == "male")? "male" : "female";
                /* validate birthdate */
                if($args['birth_month'] == "none" && $args['birth_day'] == "none" && $args['birth_year'] == "none") {
                    $args['birth_date'] = 'null';
                } else {
                    if(!in_array($args['birth_month'], range(1, 12))) {
                        throw new Exception(__("Please select a valid birth month"));
                    }
                    if(!in_array($args['birth_day'], range(1, 31))) {
                        throw new Exception(__("Please select a valid birth day"));
                    }
                    if(!in_array($args['birth_year'], range(1905, 2015))) {
                        throw new Exception(__("Please select a valid birth year"));
                    }
                    $args['birth_date'] = $args['birth_year'].'-'.$args['birth_month'].'-'.$args['birth_day'];
                }
                /* validate relationship */
                if($args['relationship'] == "none") {
                    $args['relationship'] = 'null';
                } else {
                    $relationships = array('single', 'relationship', 'married', "complicated", 'separated', 'divorced', 'widowed');
                    if(!in_array($args['relationship'], $relationships)) {
                        throw new Exception(__("Please select a valid relationship"));
                    }
                }
                /* validate website */
                if(!is_empty($args['website'])) {
                    if(!valid_url($args['website'])) {
                        throw new Exception(__("Please enter a valid website"));
                    }
                } else {
                    $args['website'] = 'null';
                }
                /* update user */
                $db->query(sprintf("UPDATE users SET user_firstname = %s, user_lastname = %s, user_gender = %s, user_birthdate = %s, user_relationship = %s, user_biography = %s, user_website = %s WHERE user_id = %s", secure($args['firstname']), secure($args['lastname']), secure($args['gender']), secure($args['birth_date']), secure($args['relationship']), secure($args['biography']), secure($args['website']), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                break;

            case 'work':
                /* update user */
                $db->query(sprintf("UPDATE users SET user_work_title = %s, user_work_place = %s WHERE user_id = %s", secure($args['work_title']), secure($args['work_place']), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                break;

            case 'location':
                /* update user */
                $db->query(sprintf("UPDATE users SET user_current_city = %s, user_hometown = %s WHERE user_id = %s", secure($args['city']), secure($args['hometown']), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                break;

            case 'education':
                /* update user */
                $db->query(sprintf("UPDATE users SET user_edu_major = %s, user_edu_school = %s, user_edu_class = %s WHERE user_id = %s", secure($args['edu_major']), secure($args['edu_school']), secure($args['edu_class']), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                break;

            case 'other':
                break;

            case 'privacy':
                $privacy = array('me', 'friends', 'public');
                if(!in_array($args['privacy_wall'], $privacy) || !in_array($args['privacy_birthdate'], $privacy) || !in_array($args['privacy_relationship'], $privacy) || !in_array($args['privacy_basic'], $privacy) || !in_array($args['privacy_work'], $privacy) || !in_array($args['privacy_location'], $privacy) || !in_array($args['privacy_education'], $privacy) || !in_array($args['privacy_other'], $privacy) || !in_array($args['privacy_friends'], $privacy) || !in_array($args['privacy_photos'], $privacy)) {
                    _error(400);
                }
                /* update user */
                $db->query(sprintf("UPDATE users SET user_privacy_wall = %s, user_privacy_birthdate = %s, user_privacy_relationship = %s, user_privacy_basic = %s, user_privacy_work = %s, user_privacy_location = %s, user_privacy_education = %s, user_privacy_other = %s, user_privacy_friends = %s, user_privacy_photos = %s WHERE user_id = %s", secure($args['privacy_wall']), secure($args['privacy_birthdate']), secure($args['privacy_relationship']), secure($args['privacy_basic']), secure($args['privacy_work']), secure($args['privacy_location']), secure($args['privacy_education']), secure($args['privacy_other']), secure($args['privacy_friends']), secure($args['privacy_photos']), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                break;

            case 'notifications':
                /* update user */
                $db->query(sprintf("UPDATE users SET email_post_likes = %s, email_post_comments = %s, email_post_shares = %s, email_wall_posts = %s, email_mentions = %s, email_profile_visits = %s, email_friend_requests = %s WHERE user_id = %s", secure($args['email_post_likes']), secure($args['email_post_comments']), secure($args['email_post_shares']), secure($args['email_wall_posts']), secure($args['email_mentions']), secure($args['email_profile_visits']), secure($args['email_friend_requests']), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                break;

            case 'notifications_sound':
                $args['notifications_sound'] = ($args['notifications_sound'] == 0)? 0 : 1;
                /* update user */
                $db->query(sprintf("UPDATE users SET notifications_sound = %s WHERE user_id = %s", secure($args['notifications_sound']), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                break;

            case 'started':
                /* update user */
                $db->query(sprintf("UPDATE users SET user_work_title = %s, user_work_place = %s, user_current_city = %s, user_hometown = %s, user_edu_major = %s, user_edu_school = %s, user_edu_class = %s WHERE user_id = %s", secure($args['work_title']), secure($args['work_place']), secure($args['city']), secure($args['hometown']), secure($args['edu_major']), secure($args['edu_school']), secure($args['edu_class']), secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                break;
        }
    }



    /* ------------------------------- */
    /* User Sign (in|up|out) */
    /* ------------------------------- */

    /**
     * sign_up
     *
     * @param array $args
     * @return void
     */
    public function sign_up($args) {
    	global $db, $system, $date;
        /* check IP */
        $this->_check_ip();
        if(is_empty($args['first_name']) || is_empty($args['last_name']) || is_empty($args['username']) || is_empty($args['password'])) {
            throw new Exception(__("You must fill in all of the fields"));
        }
        if(!valid_username($args['username'])) {
            throw new Exception(__("Please enter a valid username (a-z0-9_.) with minimum 3 characters long"));
        }
        if(reserved_username($args['username'])) {
            throw new Exception(__("You can't use")." <strong>".$args['username']."</strong> ".__("as username"));
        }
        if($this->check_username($args['username'])) {
            throw new Exception(__("Sorry, it looks like")." <strong>".$args['username']."</strong> ".__("belongs to an existing account"));
        }
        if(!valid_email($args['email'])) {
            throw new Exception(__("Please enter a valid email address"));
        }
        if($this->check_email($args['email'])) {
            throw new Exception(__("Sorry, it looks like")." <strong>".$args['email']."</strong> ".__("belongs to an existing account"));
        }
        if($system['activation_enabled'] && $system['activation_type'] == "sms") {
            /* phone activation */
            if(is_empty($args['phone'])) {
                throw new Exception(__("Please enter a valid phone number"));
            }
            if($this->check_phone($args['phone'])) {
                throw new Exception(__("Sorry, it looks like")." <strong>".$args['phone']."</strong> ".__("belongs to an existing account"));
            }
        } else {
            /* email activation */
            $args['phone'] = 'null';
        }
        if(strlen($args['password']) < 6) {
            throw new Exception(__("Your password must be at least 6 characters long. Please try another"));
        }
        if(!valid_name($args['first_name'])) {
            throw new Exception(__("Your first name contains invalid characters"));
        }
        if(strlen($args['first_name']) < 3) {
            throw new Exception(__("Your first name must be at least 3 characters long. Please try another"));
        }
        if(!valid_name($args['last_name'])) {
            throw new Exception(__("Your last name contains invalid characters"));
        }
        if(strlen($args['last_name']) < 3) {
            throw new Exception(__("Your last name must be at least 3 characters long. Please try another"));
        }
		if($args['gender'] == "none") {
            throw new Exception(__("Please select either Male or Female"));
        }
        $args['gender'] = ($args['gender'] == "male")? "male" : "female";
        /* check age restriction */
        if($system['age_restriction']) {
            if(!in_array($args['birth_month'], range(1, 12))) {
                throw new Exception(__("Please select a valid birth month"));
            }
            if(!in_array($args['birth_day'], range(1, 31))) {
                throw new Exception(__("Please select a valid birth day"));
            }
            if(!in_array($args['birth_year'], range(1905, 2017))) {
                throw new Exception(__("Please select a valid birth year"));
            }
            if(date("Y") - $args['birth_year'] < $system['minimum_age']) {
                throw new Exception(__("Sorry, You must be")." <strong>".$system['minimum_age']."</strong> ".__("years old to register"));
            }
            $args['birth_date'] = $args['birth_year'].'-'.$args['birth_month'].'-'.$args['birth_day'];
        } else {
            $args['birth_date'] = 'null';
        }
        /* check reCAPTCHA */
        if($system['reCAPTCHA_enabled']) {
        	require_once(ABSPATH.'includes/libs/ReCaptcha/autoload.php');
        	$recaptcha = new \ReCaptcha\ReCaptcha($system['reCAPTCHA_secret_key']);
        	$resp = $recaptcha->verify($args['g-recaptcha-response'], get_user_ip());
        	if (!$resp->isSuccess()) {
        		throw new Exception(__("The secuirty check is incorrect. Please try again"));
        	}
        }
        /* generate activation_key */
        $activation_key = ($system['activation_type'] == "email")? get_hash_token(): get_hash_key();
        /* register user */
        $db->query(sprintf("INSERT INTO users (user_name, user_email, user_phone, user_password, user_firstname, user_lastname, user_gender, user_birthdate, user_registered, user_activation_key) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", secure($args['username']), secure($args['email']), secure($args['phone']), secure(_password_hash($args['password'])), secure(ucwords($args['first_name'])), secure(ucwords($args['last_name'])), secure($args['gender']), secure($args['birth_date']), secure($date), secure($activation_key) )) or _error(SQL_ERROR_THROWEN);
        /* get user_id */
        $user_id = $db->insert_id;
        /* send activation */
        if($system['activation_enabled']) {
            if($system['activation_type'] == "email") {
                /* prepare activation email */
                $subject = __("Just one more step to get started on")." ".$system['system_title'];
                $body  = __("Hi")." ".ucwords($args['first_name']." ".$args['last_name']).",";
                $body .= "\r\n\r\n".__("To complete the sign-up process, please follow this link:");
                $body .= "\r\n\r\n".$system['system_url']."/activation/".$user_id."/".$activation_key;
                $body .= "\r\n\r\n".__("Welcome to")." ".$system['system_title'];
                $body .= "\r\n\r".$system['system_title']." ".__("Team");
                /* send email */
                if(!_email($args['email'], $subject, $body)) {
                    throw new Exception(__("Activation email could not be sent. But you can login now"));
                }
            } else {
                /* prepare activation SMS */
                $message  = $system['system_title']." ".__("Activation Token").": ".$activation_key;
                /* send SMS */
                if(!sms_send($args['phone'], $message)) {
                    throw new Exception(__("Activation SMS could not be sent. But you can login now"));
                }
            }
        }
        /* set cookies */
        $this->_set_cookies($user_id);
	}


    /**
     * sign_in
     *
     * @param string $username_email
     * @param string $password
     * @param boolean $remember
     *
     * @return void
     */
    public function sign_in($username_email, $password, $remember = false) {
        global $db, $system;
        /* valid inputs */
        if(is_empty($username_email) || is_empty($password)) {
            throw new Exception(__("You must fill in all of the fields"));
        }
        /* check if username or email */
        if(valid_email($username_email)) {
            $user = $this->check_email($username_email, true);
            if($user === false) {
                throw new Exception(__("The email you entered does not belong to any account"));
            }
            $field = "user_email";
        }else {
            if(!valid_username($username_email)) {
                throw new Exception(__("Please enter a valid email address or username"));
            }
            $user = $this->check_username($username_email, 'user', true);
            if($user === false) {
                throw new Exception(__("The username you entered does not belong to any account"));
            }
            $field = "user_name";
        }
        /* check password */
        if(md5($password) == $user['user_password']) {
            /* validate current password (MD5 check for versions < v2.5) */
            $user['user_password'] = _password_hash($password);
            /* update user password hash from MD5 */
            $db->query(sprintf("UPDATE users SET user_password = %s WHERE user_id = %s", secure($user['user_password']), secure($user['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
        }
        if(!password_verify($password, $user['user_password'])) {
            throw new Exception("<p><strong>".__("Please re-enter your password")."</strong></p><p>".__("The password you entered is incorrect").". ".__("If you forgot your password?")." <a href='".$system['system_url']."/reset'>".__("Request a new one")."</a></p>");
        }
        /* set cookies */
        $this->_set_cookies($user['user_id'], $remember);
    }


    /**
     * sign_out
     *
     * @return void
     */
    public function sign_out() {
        global $db, $date;
        /* delete the session */
        $db->query(sprintf("DELETE FROM users_sessions WHERE session_token = %s AND user_id = %s", secure($_COOKIE[$this->_cookie_user_token]), secure($_COOKIE[$this->_cookie_user_id], 'int') )) or _error(SQL_ERROR_THROWEN);
        /* destroy the session */
        session_destroy();
        /* unset the cookies */
        unset($_COOKIE[$this->_cookie_user_id]);
        unset($_COOKIE[$this->_cookie_user_token]);
        setcookie($this->_cookie_user_id, NULL, -1, '/');
        setcookie($this->_cookie_user_token, NULL, -1, '/');
    }


    /**
     * _set_cookies
     *
     * @param integer $user_id
     * @param boolean $remember
     * @param string $path
     * @return void
     */
    private function _set_cookies($user_id, $remember = false, $path = '/') {
        global $db, $date;
        /* generate new token */
        $session_token = get_hash_token();
        /* set cookies */
        if($remember) {
            $expire = time()+2592000;
            setcookie($this->_cookie_user_id, $user_id, $expire, $path);
            setcookie($this->_cookie_user_token, $session_token, $expire, $path);
        }else {
            setcookie($this->_cookie_user_id, $user_id, 0, $path);
            setcookie($this->_cookie_user_token, $session_token, 0, $path);
        }
        /* insert user token */
        $db->query(sprintf("INSERT INTO users_sessions (session_token, session_date, user_id, user_browser, user_os, user_ip) VALUES (%s, %s, %s, %s, %s, %s)", secure($session_token), secure($date), secure($user_id, 'int'), secure(get_user_browser()), secure(get_user_os()), secure(get_user_ip()) )) or _error(SQL_ERROR_THROWEN);
        /* update last login time */
        $db->query(sprintf("UPDATE users SET user_last_login = %s WHERE user_id = %s", secure($date), secure($user_id, 'int') )) or _error(SQL_ERROR);
    }


    /**
     * _check_ip
     *
     * @return void
     */
    private function _check_ip() {
        global $db, $system;
        if($system['max_accounts'] > 0) {
            $check = $db->query(sprintf("SELECT user_ip, COUNT(*) FROM users_sessions WHERE user_ip = %s GROUP BY user_id", secure(get_user_ip()) )) or _error(SQL_ERROR_THROWEN);
            if($check->num_rows >= $system['max_accounts']) {
                throw new Exception(__("You have reached the maximum number of account for your IP"));
            }
        }
    }



    /* ------------------------------- */
    /* Password */
    /* ------------------------------- */

    /**
     * forget_password
     *
     * @param string $email
     * @param string $recaptcha_response
     * @return void
     */
    public function forget_password($email, $recaptcha_response) {
        global $db, $system;
        if(!valid_email($email)) {
            throw new Exception(__("Please enter a valid email address"));
        }
        if(!$this->check_email($email)) {
            throw new Exception(__("Sorry, it looks like")." ".$email." ".__("doesn't belong to any account"));
        }
        /* check reCAPTCHA */
        if($system['reCAPTCHA_enabled']) {
        	require_once(ABSPATH.'includes/libs/ReCaptcha/autoload.php');
        	$recaptcha = new \ReCaptcha\ReCaptcha($system['reCAPTCHA_secret_key']);
        	$resp = $recaptcha->verify($recaptcha_response, get_user_ip());
        	if (!$resp->isSuccess()) {
        		throw new Exception(__("The secuirty check is incorrect. Please try again"));
        	}
        }
        /* generate reset key */
        $reset_key = get_hash_key(6);
        /* update user */
        $db->query(sprintf("UPDATE users SET user_reset_key = %s, user_reseted = '1' WHERE user_email = %s", secure($reset_key), secure($email) )) or _error(SQL_ERROR_THROWEN);
        /* send reset email */
        /* prepare reset email */
        $subject = __("Forget password activation key!");
        $body  = __("Hi")." ".$email.",";
        $body .= "\r\n\r\n".__("To complete the reset password process, please copy this token:");
        $body .= "\r\n\r\n".__("Token:")." ".$reset_key;
        $body .= "\r\n\r".$system['system_title']." ".__("Team");
        /* send email */
        if(!_email($email, $subject, $body)) {
            throw new Exception(__("Activation key email could not be sent!"));
        }
    }


    /**
     * forget_password_confirm
     *
     * @param string $email
     * @param string $reset_key
     * @return void
     */
    public function forget_password_confirm($email, $reset_key) {
        global $db;
        if(!valid_email($email)) {
        	throw new Exception(__("Invalid email, please try again"));
        }
        /* check reset key */
        $check_key = $db->query(sprintf("SELECT user_reset_key FROM users WHERE user_email = %s AND user_reset_key = %s AND user_reseted = '1'", secure($email), secure($reset_key))) or _error(SQL_ERROR_THROWEN);
        if($check_key->num_rows == 0) {
        	throw new Exception(__("Invalid code, please try again"));
        }
    }


    /**
     * forget_password_reset
     *
     * @param string $email
     * @param string $reset_key
     * @param string $password
     * @param string $confirm
     * @return void
     */
    public function forget_password_reset($email, $reset_key, $password, $confirm) {
        global $db;
        if(!valid_email($email)) {
        	throw new Exception(__("Invalid email, please try again"));
        }
        /* check reset key */
        $check_key = $db->query(sprintf("SELECT user_reset_key FROM users WHERE user_email = %s AND user_reset_key = %s AND user_reseted = '1'", secure($email), secure($reset_key))) or _error(SQL_ERROR_THROWEN);
        if($check_key->num_rows == 0) {
        	throw new Exception(__("Invalid code, please try again"));
        }
        /* check password length */
        if(strlen($password) < 6) {
            throw new Exception(__("Your password must be at least 6 characters long. Please try another"));
        }
        /* check password confirm */
        if($password !== $confirm) {
            throw new Exception(__("Your passwords do not match. Please try another"));
        }
        /* update user password */
        $db->query(sprintf("UPDATE users SET user_password = %s, user_reseted = '0' WHERE user_email = %s", secure(_password_hash($password)), secure($email) )) or _error(SQL_ERROR_THROWEN);
    }



    /* ------------------------------- */
    /* Activation Email */
    /* ------------------------------- */

    /**
     * activation_email_resend
     *
     * @return void
     */
    public function activation_email_resend() {
        global $db, $system;
        /* generate user activation key */
        $activation_key = get_hash_token();
        /* update user */
        $db->query(sprintf("UPDATE users SET user_activation_key = %s WHERE user_id = %s", secure($activation_key), secure($this->_data['user_id']) )) or _error(SQL_ERROR_THROWEN);
        // resend activation email
        /* prepare activation email */
        $subject = __("Just one more step to get started on")." ".$system['system_title'];
        $body  = __("Hi")." ".ucwords($this->_data['user_firstname']." ".$this->_data['user_lastname']).",";
        $body .= "\r\n\r\n".__("To complete the sign-up process, please follow this link:");
        $body .= "\r\n\r\n".$system['system_url']."/activation/".$this->_data['user_id']."/".$activation_key;
        $body .= "\r\n\r\n".__("Welcome to")." ".$system['system_title'];
        $body .= "\r\n\r".$system['system_title']." ".__("Team");
        /* send email */
        if(!_email($this->_data['user_email'], $subject, $body)) {
            throw new Exception(__("Activation email could not be sent"));
        }
    }


    /**
     * activation_email_reset
     *
     * @param string $email
     * @return void
     */
    public function activation_email_reset($email) {
        global $db, $system;
        if(!valid_email($email)) {
            throw new Exception(__("Invalid email, please try again"));
        }
        if($this->check_email($email)) {
            throw new Exception(__("Sorry, it looks like")." ".$email." ".__("belongs to an existing account"));
        }
        /* generate user activation key */
        $activation_key = get_hash_token();
        /* update user */
        $db->query(sprintf("UPDATE users SET user_email = %s, user_activation_key = %s WHERE user_id = %s", secure($email), secure($activation_key), secure($this->_data['user_id']) )) or _error(SQL_ERROR_THROWEN);
        // send activation email
        /* prepare activation email */
        $subject = __("Just one more step to get started on")." ".$system['system_title'];
        $body  = __("Hi")." ".ucwords($this->_data['user_firstname']." ".$this->_data['user_lastname']).",";
        $body .= "\r\n\r\n".__("To complete the sign-up process, please follow this link:");
        $body .= "\r\n\r\n".$system['system_url']."/activation/".$this->_data['user_id']."/".$activation_key;
        $body .= "\r\n\r\n".__("Welcome to")." ".$system['system_title'];
        $body .= "\r\n\r".$system['system_title']." ".__("Team");
        /* send email */
        if(!_email($email, $subject, $body)) {
            throw new Exception(__("Activation email could not be sent. But you can login now"));
        }
    }


    /**
     * activation_email
     *
     * @param integer $id
     * @param string $token
     * @return void
     */
    public function activation_email($id, $token) {
        global $db, $system;
        if($this->_logged_in && !$this->_data['user_activated']) {
            if($this->_data['user_id'] != $id && $this->_data['user_activation_key'] != $token) {
                _error(404);
            }
            $referrer_id = $this->_data['user_referrer_id'];
            /* activate user */
            $db->query(sprintf("UPDATE users SET user_activated = '1' WHERE user_id = %s", secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            /* redirect */
            redirect();
        } else {
            $check_user = $db->query(sprintf("SELECT user_id, user_referrer_id FROM users WHERE user_activated = '0' AND user_id = %s AND user_activation_key = %s", secure($id, 'int'), secure($token) )) or _error(SQL_ERROR_THROWEN);
            if($check_user->num_rows == 0) {
                _error(404);
            }
            $_user = $check_user->fetch_assoc();
            /* activate user */
            $db->query(sprintf("UPDATE users SET user_activated = '1' WHERE user_id = %s", secure($_user['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
            /* set cookies */
            $this->_set_cookies($_user['user_id']);
        }
    }



    /* ------------------------------- */
    /* Activation Phone */
    /* ------------------------------- */

    /**
     * activation_phone_resend
     *
     * @return void
     */
    public function activation_phone_resend() {
        global $db, $system;
        /* generate user activation key */
        $activation_key = get_hash_key();
        /* update user */
        $db->query(sprintf("UPDATE users SET user_activation_key = %s WHERE user_id = %s", secure($activation_key), secure($this->_data['user_id']) )) or _error(SQL_ERROR_THROWEN);
        // resend activation sms
        /* prepare activation SMS */
        $message  = $system['system_title']." ".__("Activation Token").": ".$activation_key;
        /* send SMS */
        if(!sms_send($this->_data['user_phone'], $message)) {
            throw new Exception(__("Activation SMS could not be sent. But you can login now"));
        }
    }


    /**
     * activation_phone_reset
     *
     * @param string $phone
     * @return void
     */
    public function activation_phone_reset($phone) {
        global $db, $system;
        if(is_empty($phone)) {
            throw new Exception(__("Please enter a valid phone number"));
        }
        if($this->check_phone($phone)) {
            throw new Exception(__("Sorry, it looks like")." <strong>".$phone."</strong> ".__("belongs to an existing account"));
        }
        /* generate user activation key */
        $activation_key = get_hash_key();
        /* update user */
        $db->query(sprintf("UPDATE users SET user_phone = %s, user_activation_key = %s WHERE user_id = %s", secure($phone), secure($activation_key), secure($this->_data['user_id']) )) or _error(SQL_ERROR_THROWEN);
        // resend activation sms
        /* prepare activation SMS */
        $message  = $system['system_title']." ".__("Activation Token").": ".$activation_key;
        /* send SMS */
        if(!sms_send($phone, $message)) {
            throw new Exception(__("Activation SMS could not be sent. But you can login now"));
        }
    }


    /**
     * activation_phone
     *
     * @param string $token
     * @return void
     */
    public function activation_phone($token) {
        global $db;
        if(is_empty($token)) {
            throw new Exception(__("Please enter a valid activation key"));
        }
        $check_token = $db->query(sprintf("SELECT * FROM users WHERE user_activated = '0' AND user_id = %s AND user_activation_key = %s", secure($this->_data['user_id'], 'int'), secure($token) )) or _error(SQL_ERROR_THROWEN);
        if($check_token->num_rows == 0) {
            throw new Exception(__("Invalid code, please try again"));
        }
        /* activate user */
        $db->query(sprintf("UPDATE users SET user_activated = '1' WHERE user_id = %s", secure($this->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
    }



    /* ------------------------------- */
    /* Security Checks */
    /* ------------------------------- */

    /**
     * check_email
     *
     * @param string $email
     * @param boolean $return_info
     * @return boolean|array
     *
     */
    public function check_email($email, $return_info = false) {
        global $db;
        $query = $db->query(sprintf("SELECT * FROM users WHERE user_email = %s", secure($email) )) or _error(SQL_ERROR_THROWEN);
        if($query->num_rows > 0) {
            if($return_info) {
                $info = $query->fetch_assoc();
                return $info;
            }
            return true;
        }
        return false;
    }


    /**
     * check_phone
     *
     * @param string $phone
     * @return boolean
     *
     */
    public function check_phone($phone) {
        global $db;
        $query = $db->query(sprintf("SELECT * FROM users WHERE user_phone = %s", secure($phone) )) or _error(SQL_ERROR_THROWEN);
        if($query->num_rows > 0) {
            return true;
        }
        return false;
    }


    /**
     * check_username
     *
     * @param string $username
     * @param string $type
     * @param boolean $return_info
     * @return boolean|array
     */
    public function check_username($username, $type = 'user', $return_info = false) {
        global $db;
        /* check type (user) */
        switch ($type) {
            default:
                $query = $db->query(sprintf("SELECT * FROM users WHERE user_name = %s", secure($username) )) or _error(SQL_ERROR_THROWEN);
                break;
        }
        if($query->num_rows > 0) {
            if($return_info) {
                $info = $query->fetch_assoc();
                return $info;
            }
            return true;
        }
        return false;
    }

}

?>
