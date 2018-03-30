<?php
/**
 * ajax -> data -> upload
 *
 * 
 * 
 */

// fetch bootstrap
require('../../../bootstrap.php');

// fetch image class
require('../../class-image.php');

// check AJAX Request
is_ajax();

// check secret
if($_SESSION['secret'] != $_POST['secret']) {
    _error(403);
}

// user access
user_access(true);

// check type
if(!isset($_POST["type"])) {
    _error(403);
}

// check handle
if(!isset($_POST["handle"])) {
    _error(403);
}

// check multiple
if(!isset($_POST["multiple"])) {
    _error(403);
}

// upload
try {

    switch ($_POST["type"]) {
        case 'photos':
            // check photo upload enabled
            if($_POST['handle'] == 'publisher' && !$system['photos_enabled']) {
                modal(MESSAGE, __("Not Allowed"), __("This feature has been disabled"));
            }

            // get allowed file size
            if($_POST['handle'] == 'picture-user') {
                $max_allowed_size = $system['max_avatar_size'] * 1024;
            } elseif ($_POST['handle'] == 'cover-user') {
                $max_allowed_size = $system['max_cover_size'] * 1024;
            } else {
                $max_allowed_size = $system['max_photo_size'] * 1024;
            }

            /* check & create uploads dir */
            $folder = 'photos';
            $depth = '../../../';
            if(!file_exists($depth.$system['uploads_directory'].'/'.$folder)) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder, 0777, true);
            }
            if(!file_exists($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y'))) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y'), 0777, true);
            }
            if(!file_exists($system['uploads_directory'].'/'.$folder.'/' . date('Y') . '/' . date('m'))) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y') . '/' . date('m'), 0777, true);
            }

            if($_POST["multiple"] == "true") {

                $files = array();
                foreach($_FILES['file'] as $key => $val) {
                    for($i=0; $i < count($val); $i++) {
                        $files[$i][$key] = $val[$i];
                    }
                }

                $return_files = array();
                $files_num = count($files);
                foreach ($files as $file) {

                    // valid inputs
                    if(!isset($file) || $file["error"] != UPLOAD_ERR_OK) {
                        if($files_num > 1) {
                            continue;
                        } else {
                            modal(MESSAGE, __("Upload Error"), __("Something wrong with upload! Is 'upload_max_filesize' set correctly?"));
                        }
                    }

                    // check file size
                    if($file["size"] > $max_allowed_size) {
                        if($files_num > 1) {
                            continue;
                        } else {
                            modal(MESSAGE, __("Upload Error"), __("The file size is so big"));
                        }
                    }

                    /* prepare new file name */
                    $directory = $folder.'/'. date('Y') . '/' . date('m') . '/';
                    $prefix = $system['uploads_prefix'].'_'.get_hash_token();
                    $image = new Image($file["tmp_name"]);
                    $image_tmp_name = $directory.$prefix.'_tmp'.$image->_img_ext;
                    $image_new_name = $directory.$prefix.$image->_img_ext;
                    $path_tmp = $depth.$system['uploads_directory'].'/'.$image_tmp_name;
                    $path_new = $depth.$system['uploads_directory'].'/'.$image_new_name;

                    /* check if the file uploaded successfully */
                    if(!@move_uploaded_file($file['tmp_name'], $path_tmp)) {
                        if($files_num > 1) {
                            continue;
                        } else {
                            modal(MESSAGE, __("Upload Error"), __("Sorry, can not upload the file"));
                        }
                    }

                    /* save the new image */
                    $image->save($path_new, $path_tmp);

                    /* delete the tmp image */
                    unlink($path_tmp);

                    /* return */
                    $return_files[] = $image_new_name;
                }

                // return the return_files & exit
                return_json(array("files" => $return_files));

            } else {

                // valid inputs
                if(!isset($_FILES["file"]) || $_FILES["file"]["error"] != UPLOAD_ERR_OK) {
                    modal(MESSAGE, __("Upload Error"), __("Something wrong with upload! Is 'upload_max_filesize' set correctly?"));
                }

                // check file size
                if($_FILES["file"]["size"] > $max_allowed_size) {
                    modal(MESSAGE, __("Upload Error"), __("The file size is so big"));
                }

                /* prepare new file name */
                $directory = $folder.'/'. date('Y') . '/' . date('m') . '/';
                $prefix = $system['uploads_prefix'].'_'.get_hash_token();
                $image = new Image($_FILES["file"]["tmp_name"]);
                $image_tmp_name = $directory.$prefix.'_tmp'.$image->_img_ext;
                $image_new_name = $directory.$prefix.$image->_img_ext;
                $path_tmp = $depth.$system['uploads_directory'].'/'.$image_tmp_name;
                $path_new = $depth.$system['uploads_directory'].'/'.$image_new_name;

                /* check if the file uploaded successfully */
                if(!@move_uploaded_file($_FILES['file']['tmp_name'], $path_tmp)) {
                    modal(MESSAGE, __("Upload Error"), __("Sorry, can not upload the file"));
                }

                /* save the new image */
                $resize = ($_POST['handle'] == 'x-image')? false: true;
                $image->save($path_new, $path_tmp, $resize);

                /* delete the tmp image */
                unlink($path_tmp);

                // check the handle
                switch ($_POST['handle']) {

                    case 'cover-user':
                        /* check for cover album */
                        if(!$user->_data['user_album_covers']) {
                            /* create new cover album */
                            $db->query(sprintf("INSERT INTO posts_photos_albums (user_id, user_type, title, privacy) VALUES (%s, 'user', 'Cover Photos', 'public')", secure($user->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                            $user->_data['user_album_covers'] = $db->insert_id;
                            /* update user cover album id */
                            $db->query(sprintf("UPDATE users SET user_album_covers = %s WHERE user_id = %s", secure($user->_data['user_album_covers'], 'int'), secure($user->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                        }

                        /* insert updated cover photo post */
                        $db->query(sprintf("INSERT INTO posts (user_id, user_type, post_type, time, privacy) VALUES (%s, 'user', 'profile_cover', %s, 'public')", secure($user->_data['user_id'], 'int'), secure($date) )) or _error(SQL_ERROR_THROWEN);
                        $post_id = $db->insert_id;
                        /* insert new cover photo to album */
                        $db->query(sprintf("INSERT INTO posts_photos (post_id, album_id, source) VALUES (%s, %s, %s)", secure($post_id, 'int'), secure($user->_data['user_album_covers'], 'int'), secure($image_new_name) )) or _error(SQL_ERROR_THROWEN);
                        $photo_id = $db->insert_id;
                        /* update user cover */
                        $db->query(sprintf("UPDATE users SET user_cover = %s, user_cover_id = %s WHERE user_id = %s", secure($image_new_name), secure($photo_id, 'int'), secure($user->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                        break;

                    case 'picture-user':
                        /* check for profile pictures album */
                        if(!$user->_data['user_album_pictures']) {
                            /* create new profile pictures album */
                            $db->query(sprintf("INSERT INTO posts_photos_albums (user_id, user_type, title, privacy) VALUES (%s, 'user', 'Profile Pictures', 'public')", secure($user->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                            $user->_data['user_album_pictures'] = $db->insert_id;
                            /* update user profile picture album id */
                            $db->query(sprintf("UPDATE users SET user_album_pictures = %s WHERE user_id = %s", secure($user->_data['user_album_pictures'], 'int'), secure($user->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                        }
                        /* insert updated profile picture post */
                        $db->query(sprintf("INSERT INTO posts (user_id, user_type, post_type, time, privacy) VALUES (%s, 'user', 'profile_picture', %s, 'public')", secure($user->_data['user_id'], 'int'), secure($date) )) or _error(SQL_ERROR_THROWEN);
                        $post_id = $db->insert_id;
                        /* insert new profile picture to album */
                        $db->query(sprintf("INSERT INTO posts_photos (post_id, album_id, source) VALUES (%s, %s, %s)", secure($post_id, 'int'), secure($user->_data['user_album_pictures'], 'int'), secure($image_new_name) )) or _error(SQL_ERROR_THROWEN);
                        $photo_id = $db->insert_id;
                        /* update user profile picture */
                        $db->query(sprintf("UPDATE users SET user_picture = %s, user_picture_id = %s WHERE user_id = %s", secure($image_new_name), secure($photo_id, 'int'), secure($user->_data['user_id'], 'int') )) or _error(SQL_ERROR_THROWEN);
                        break;

                }

                // return the file new name & exit
                return_json(array("file" => $image_new_name));
            }

            break;

        case 'video':
            // check video upload enabled
            if(!$system['videos_enabled']) {
                modal(MESSAGE, __("Not Allowed"), __("This feature has been disabled"));
            }

            // valid inputs
            if(!isset($_FILES["file"]) || $_FILES["file"]["error"] != UPLOAD_ERR_OK) {
                modal(MESSAGE, __("Upload Error"), __("Something wrong with upload! Is 'upload_max_filesize' set correctly?"));
            }

            // check file size
            $max_allowed_size = $system['max_video_size'] * 1024;
            if($_FILES["file"]["size"] > $max_allowed_size) {
                modal(MESSAGE, __("Upload Error"), __("The file size is so big"));
            }

            // check file extesnion
            $extension = get_extension($_FILES['file']['name']);
            if(!valid_extension($extension, $system['video_extensions'])) {
                modal(MESSAGE, __("Upload Error"), __("The file type is not valid or not supported"));
            }

            /* check & create uploads dir */
            $folder = 'videos';
            $depth = '../../../';
            if(!file_exists($depth.$system['uploads_directory'].'/'.$folder)) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder, 0777, true);
            }
            if(!file_exists($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y'))) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y'), 0777, true);
            }
            if(!file_exists($system['uploads_directory'].'/'.$folder.'/' . date('Y') . '/' . date('m'))) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y') . '/' . date('m'), 0777, true);
            }

            /* prepare new file name */
            $directory = $folder.'/'. date('Y') . '/' . date('m') . '/';
            $prefix = $system['uploads_prefix'].'_'.get_hash_token();
            $file_name = $directory.$prefix.'.'.$extension;
            $path = $depth.$system['uploads_directory'].'/'.$file_name;

            /* check if the file uploaded successfully */
            if(!@move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
                modal(MESSAGE, __("Upload Error"), __("Sorry, can not upload the file"));
            }

            // return the file new name & exit
            return_json(array("file" => $file_name));
            break;

        case 'audio':
            // check audio upload enabled
            if(!$system['audio_enabled']) {
                modal(MESSAGE, __("Not Allowed"), __("This feature has been disabled"));
            }

            // valid inputs
            if(!isset($_FILES["file"]) || $_FILES["file"]["error"] != UPLOAD_ERR_OK) {
                modal(MESSAGE, __("Upload Error"), __("Something wrong with upload! Is 'upload_max_filesize' set correctly?"));
            }

            // check file size
            $max_allowed_size = $system['max_audio_size'] * 1024;
            if($_FILES["file"]["size"] > $max_allowed_size) {
                modal(MESSAGE, __("Upload Error"), __("The file size is so big"));
            }

            // check file extesnion
            $extension = get_extension($_FILES['file']['name']);
            if(!valid_extension($extension, $system['audio_extensions'])) {
                modal(MESSAGE, __("Upload Error"), __("The file type is not valid or not supported"));
            }

            /* check & create uploads dir */
            $folder = 'sounds';
            $depth = '../../../';
            if(!file_exists($depth.$system['uploads_directory'].'/'.$folder)) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder, 0777, true);
            }
            if(!file_exists($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y'))) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y'), 0777, true);
            }
            if(!file_exists($system['uploads_directory'].'/'.$folder.'/' . date('Y') . '/' . date('m'))) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y') . '/' . date('m'), 0777, true);
            }

            /* prepare new file name */
            $directory = $folder.'/'. date('Y') . '/' . date('m') . '/';
            $prefix = $system['uploads_prefix'].'_'.get_hash_token();
            $file_name = $directory.$prefix.'.'.$extension;
            $path = $depth.$system['uploads_directory'].'/'.$file_name;

            /* check if the file uploaded successfully */
            if(!@move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
                modal(MESSAGE, __("Upload Error"), __("Sorry, can not upload the file"));
            }

            // return the file new name & exit
            return_json(array("file" => $file_name));
            break;

        case 'file':
            // check file upload enabled
            if(!$system['file_enabled']) {
                modal(MESSAGE, __("Not Allowed"), __("This feature has been disabled"));
            }

            // valid inputs
            if(!isset($_FILES["file"]) || $_FILES["file"]["error"] != UPLOAD_ERR_OK) {
                modal(MESSAGE, __("Upload Error"), __("Something wrong with upload! Is 'upload_max_filesize' set correctly?"));
            }

            // check file size
            $max_allowed_size = $system['max_file_size'] * 1024;
            if($_FILES["file"]["size"] > $max_allowed_size) {
                modal(MESSAGE, __("Upload Error"), __("The file size is so big"));
            }

            // check file extesnion
            $extension = get_extension($_FILES['file']['name']);
            if(!valid_extension($extension, $system['file_extensions'])) {
                modal(MESSAGE, __("Upload Error"), __("The file type is not valid or not supported"));
            }

            /* check & create uploads dir */
            $folder = 'files';
            $depth = '../../../';
            if(!file_exists($depth.$system['uploads_directory'].'/'.$folder)) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder, 0777, true);
            }
            if(!file_exists($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y'))) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y'), 0777, true);
            }
            if(!file_exists($system['uploads_directory'].'/'.$folder.'/' . date('Y') . '/' . date('m'))) {
                @mkdir($depth.$system['uploads_directory'].'/'.$folder.'/' . date('Y') . '/' . date('m'), 0777, true);
            }

            /* prepare new file name */
            $directory = $folder.'/'. date('Y') . '/' . date('m') . '/';
            $prefix = $system['uploads_prefix'].'_'.get_hash_token();
            $file_name = $directory.$prefix.'.'.$extension;
            $path = $depth.$system['uploads_directory'].'/'.$file_name;

            /* check if the file uploaded successfully */
            if(!@move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
                modal(MESSAGE, __("Upload Error"), __("Sorry, can not upload the file"));
            }

            // return the file new name & exit
            return_json(array("file" => $file_name));
            break;
    }

} catch (Exception $e) {
    modal(ERROR, __("Error"), $e->getMessage());
}

?>
