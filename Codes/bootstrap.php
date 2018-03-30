<?php
/**
 * bootstrap
 *
 * 
 * 
 */

// set system version
define('SYS_VER', '2.5.1');


// set absolut & base path
define('ABSPATH',dirname(__FILE__).'/');
define('BASEPATH',dirname($_SERVER['PHP_SELF']));


// check the config file
if(!file_exists(ABSPATH.'includes/config.php')) {
    /* the config file doesn't exist -> start the installer */
    header('Location: ./install');
}


// get system configurations
require_once(ABSPATH.'includes/config.php');


// enviroment settings
if(DEBUGGING) {
    ini_set("display_errors", true);
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    ini_set("display_errors", false);
    error_reporting(0);
}


// get functions
require_once(ABSPATH.'includes/functions.php');


// check system URL
check_system_url();


// start session
session_start();
/* set session secret */
if(!isset($_SESSION['secret'])) {
    $_SESSION['secret'] = get_hash_token();
}


// i18n config
require_once(ABSPATH.'includes/libs/gettext/gettext.inc');
T_setlocale(LC_MESSAGES, DEFAULT_LOCALE);
$domain = 'messages';
T_bindtextdomain($domain, ABSPATH .'content/languages/locale');
T_bind_textdomain_codeset($domain, 'UTF-8');
T_textdomain($domain);


// connect to the database
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$db->set_charset('utf8');
if(mysqli_connect_error()) {
    _error(DB_ERROR);
}


// get system options
$get_options = $db->query("SELECT * FROM system_options") or _error(SQL_ERROR);
$system = $get_options->fetch_assoc();
/* set system URL */
$system['system_url'] = SYS_URL;
/* set system version */
$system['system_version'] = SYS_VER;
/* set session hash */
$session_hash = session_hash($system['session_hash']);
/* set system uploads */
$system['system_uploads'] = $system['system_url'].'/'.$system['uploads_directory'];
/* get system theme */
$get_theme = $db->query("SELECT * FROM system_themes WHERE system_themes.default = '1'") or _error(SQL_ERROR);
$theme = $get_theme->fetch_assoc();
$system['theme'] = $theme['name'];



// time config
date_default_timezone_set( 'UTC' );
$time = time();
$minutes_to_add = 0;
$DateTime = new DateTime();
$DateTime->add(new DateInterval('PT' . $minutes_to_add . 'M'));
$date = $DateTime->format('Y-m-d H:i:s');


// smarty config
require_once(ABSPATH.'includes/libs/Smarty/Smarty.class.php');
$smarty = new Smarty;
$smarty->template_dir = ABSPATH.'content/themes/'.$system['theme'].'/templates';
$smarty->compile_dir = ABSPATH.'content/themes/'.$system['theme'].'/templates_compiled';
$smarty->cache_dir = ABSPATH.'content/themes/'.$system['theme'].'/cache';
$smarty->loadFilter('output', 'trimwhitespace');


// get user & online friends if chat enabled
require_once(ABSPATH.'includes/class-user.php');
try {
    $user = new User();
} catch (Exception $e) {
    _error(SQL_ERROR);
}


// check if system is live
if(!$system['system_live'] && ( (!$user->_logged_in && !isset($override_shutdown)) ) ) {
    _error(__('System Message'), "<p class='text-center'>".$system['system_message']."</p>");
}


// assign system varibles
$smarty->assign('secret', $_SESSION['secret']);
$smarty->assign('session_hash', $session_hash);
$smarty->assign('__', __);
$smarty->assign('system', $system);
$smarty->assign('date', $date);
$smarty->assign('user', $user);

?>
