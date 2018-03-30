-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2018 at 02:50 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sssccc`
--

-- --------------------------------------------------------

--
-- Table structure for table `emojis`
--

CREATE TABLE `emojis` (
  `emoji_id` int(10) UNSIGNED NOT NULL,
  `pattern` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `emojis`
--

INSERT INTO `emojis` (`emoji_id`, `pattern`, `class`) VALUES
(1, ':)', 'smile'),
(2, '(&lt;', 'joy'),
(3, ':D', 'smiley'),
(4, ':(', 'worried'),
(5, ':relaxed:', 'relaxed'),
(6, ':P', 'stuck-out-tongue'),
(7, ':O', 'open-mouth'),
(8, ':/', 'confused'),
(9, ';)', 'wink'),
(10, ';(', 'sob'),
(11, 'B|', 'sunglasses'),
(12, ':disappointed:', 'disappointed'),
(13, ':yum:', 'yum'),
(14, '^_^', 'grin'),
(15, ':no_mouth:', 'no-mouth'),
(16, '*_*', 'heart-eyes'),
(17, '*)', 'kissing-heart'),
(18, 'O:)', 'innocent'),
(19, ':angry:', 'angry'),
(20, ':rage:', 'rage'),
(21, ':smirk:', 'smirk'),
(22, ':flushed:', 'flushed'),
(23, ':satisfied:', 'satisfied'),
(24, ':relieved:', 'relieved'),
(25, ':sleeping:', 'sleeping'),
(26, ':stuck_out_tongue:', 'stuck-out-tongue'),
(27, ':stuck_out_tongue_closed_eyes:', 'stuck-out-tongue-closed-eyes'),
(28, ':frowning:', 'frowning'),
(29, ':anguished:', 'anguished'),
(30, ':open_mouth:', 'open-mouth'),
(31, ':grimacing:', 'grimacing'),
(32, ':hushed:', 'hushed'),
(33, ':expressionless:', 'expressionless'),
(34, ':unamused:', 'unamused'),
(35, ':sweat_smile:', 'sweat-smile'),
(36, ':sweat:', 'sweat'),
(37, ':confounded:', 'confounded'),
(38, ':weary:', 'weary'),
(39, ':pensive:', 'pensive'),
(40, ':fearful:', 'fearful'),
(41, ':cold_sweat:', 'cold-sweat'),
(42, ':persevere:', 'persevere'),
(43, ':cry:', 'cry'),
(44, ':astonished:', 'astonished'),
(45, ':scream:', 'scream'),
(46, ':mask:', 'mask'),
(47, ':tired_face:', 'tired-face'),
(48, ':triumph:', 'triumph'),
(49, ':dizzy_face:', 'dizzy-face'),
(50, ':imp:', 'imp'),
(51, ':smiling_imp:', 'smiling-imp'),
(52, ':neutral_face:', 'neutral-face'),
(53, ':alien:', 'alien'),
(54, ':yellow_heart:', 'yellow-heart'),
(55, ':blue_heart:', 'blue-heart'),
(56, ':blue_heart:', 'blue-heart'),
(57, ':heart:', 'heart'),
(58, ':green_heart:', 'green-heart'),
(59, ':broken_heart:', 'broken-heart'),
(60, ':heartbeat:', 'heartbeat'),
(61, ':heartpulse:', 'heartpulse'),
(62, ':two_hearts:', 'two-hearts'),
(63, ':revolving_hearts:', 'revolving-hearts'),
(64, ':cupid:', 'cupid'),
(65, ':sparkling_heart:', 'sparkling-heart'),
(66, ':sparkles:', 'sparkles'),
(67, ':star:', 'star'),
(68, ':star2:', 'star2'),
(69, ':dizzy:', 'dizzy'),
(70, ':boom:', 'boom'),
(71, ':exclamation:', 'exclamation'),
(72, ':anger:', 'anger'),
(73, ':question:', 'question'),
(74, ':grey_exclamation:', 'grey-exclamation'),
(75, ':grey_question:', 'grey-question'),
(76, ':zzz:', 'zzz'),
(77, ':dash:', 'dash'),
(78, ':sweat_drops:', 'sweat-drops'),
(79, ':notes:', 'notes'),
(80, ':musical_note:', 'musical-note'),
(81, ':fire:', 'fire'),
(82, ':poop:', 'poop'),
(83, ':thumbsup:', 'thumbsup'),
(84, ':thumbsdown:', 'thumbsdown'),
(85, ':ok_hand:', 'ok-hand'),
(86, ':punch:', 'punch'),
(87, ':fist:', 'fist'),
(88, ':v:', 'v'),
(89, ':wave:', 'wave'),
(90, ':hand:', 'hand'),
(91, ':raised_hand:', 'raised-hand'),
(92, ':open_hands:', 'open-hands'),
(93, ':point_up:', 'point-up'),
(94, ':point_down:', 'point-down'),
(95, ':point_left:', 'point-left'),
(96, ':point_right:', 'point-right'),
(97, ':raised_hands:', 'raised-hands'),
(98, ':pray:', 'pray'),
(99, ':clap:', 'clap'),
(100, ':muscle:', 'muscle'),
(101, ':runner:', 'runner'),
(102, ':couple:', 'couple'),
(103, ':family:', 'family'),
(104, ':two_men_holding_hands:', 'two-men-holding-hands'),
(105, ':two_women_holding_hands:', 'two-women-holding-hands'),
(106, ':dancer:', 'dancer'),
(107, ':dancers:', 'dancers'),
(108, ':ok_woman:', 'ok-woman'),
(109, ':no_good:', 'no-good'),
(110, ':information_desk_person:', 'information-desk-person'),
(111, ':bride_with_veil:', 'bride-with-veil'),
(112, ':couplekiss:', 'couplekiss'),
(113, ':couple_with_heart:', 'couple-with-heart'),
(114, ':nail_care:', 'nail-care'),
(115, ':boy:', 'boy'),
(116, ':girl:', 'girl'),
(117, ':woman:', 'woman'),
(118, ':man:', 'man'),
(119, ':baby:', 'baby'),
(120, ':older_woman:', 'older-woman'),
(121, ':older_man:', 'older-man'),
(122, ':cop:', 'cop'),
(123, ':angel:', 'angel'),
(124, ':princess:', 'princess'),
(125, ':smiley_cat:', 'smiley-cat'),
(126, ':smile_cat:', 'smile-cat'),
(127, ':heart_eyes_cat:', 'heart-eyes-cat'),
(128, ':kissing_cat:', 'kissing-cat'),
(129, ':smirk_cat:', 'smirk-cat'),
(130, ':scream_cat:', 'scream-cat'),
(131, ':crying_cat_face:', 'crying-cat-face'),
(132, ':joy_cat:', 'joy-cat'),
(133, ':pouting_cat:', 'pouting-cat'),
(134, ':japanese_ogre:', 'japanese-ogre'),
(135, ':see_no_evil:', 'see-no-evil'),
(136, ':hear_no_evil:', 'hear-no-evil'),
(137, ':speak_no_evil:', 'speak-no-evil'),
(138, ':guardsman:', 'guardsman'),
(139, ':skull:', 'skull'),
(140, ':feet:', 'feet'),
(141, ':lips:', 'lips'),
(142, ':kiss:', 'kiss'),
(143, ':droplet:', 'droplet'),
(144, ':ear:', 'ear'),
(145, ':eyes:', 'eyes'),
(146, ':nose:', 'nose'),
(147, ':tongue:', 'tongue'),
(148, ':love_letter:', 'love-letter'),
(149, ':speech_balloon:', 'speech-balloon'),
(150, ':thought_balloon:', 'thought-balloon'),
(151, ':sunny:', 'sunny');

-- --------------------------------------------------------

--
-- Table structure for table `followings`
--

CREATE TABLE `followings` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `following_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Dumping data for table `followings`
--

INSERT INTO `followings` (`user_id`, `following_id`) VALUES
(1, 2),
(1, 4),
(2, 1),
(2, 2),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_one_id` int(10) UNSIGNED NOT NULL,
  `user_two_id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_one_id`, `user_two_id`, `status`) VALUES
(3, 2, 1, 1),
(2, 4, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(10) UNSIGNED NOT NULL,
  `to_user_id` int(10) UNSIGNED NOT NULL,
  `from_user_id` int(10) UNSIGNED NOT NULL,
  `action` varchar(32) NOT NULL,
  `node_type` varchar(32) NOT NULL,
  `node_url` varchar(255) NOT NULL,
  `notify_id` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `seen` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `to_user_id`, `from_user_id`, `action`, `node_type`, `node_url`, `notify_id`, `time`, `seen`) VALUES
(1, 1, 2, 'friend_add', '', 'mia', '', '2018-03-13 15:53:43', '1'),
(9, 1, 2, 'profile_visit', '', '', '', '2018-03-13 19:40:13', '1'),
(3, 2, 1, 'friend_accept', '', 'adwin', '', '2018-03-13 15:54:04', '1'),
(4, 2, 1, 'follow', '', '', '', '2018-03-13 15:54:04', '1'),
(5, 1, 4, 'friend_add', '', 'mica', '', '2018-03-13 16:44:53', '1'),
(6, 1, 4, 'follow', '', '', '', '2018-03-13 16:44:53', '1'),
(7, 4, 2, 'profile_visit', '', '', '', '2018-03-13 19:38:48', '1'),
(8, 1, 2, 'profile_visit', '', '', '', '2018-03-13 19:39:01', '1'),
(11, 1, 2, 'profile_visit', '', '', '', '2018-03-13 20:12:31', '1'),
(12, 1, 2, 'profile_visit', '', '', '', '2018-03-14 03:00:20', '1'),
(13, 2, 4, 'profile_visit', '', '', '', '2018-03-14 15:00:26', '1'),
(14, 2, 4, 'profile_visit', '', '', '', '2018-03-14 16:04:38', '1'),
(15, 4, 2, 'profile_visit', '', '', '', '2018-03-21 16:09:29', '0'),
(16, 1, 2, 'profile_visit', '', '', '', '2018-03-28 15:50:02', '1'),
(17, 1, 2, 'profile_visit', '', '', '', '2018-03-28 15:50:15', '1'),
(18, 4, 2, 'profile_visit', '', '', '', '2018-03-28 15:50:26', '0'),
(19, 1, 2, 'friend_add', '', 'mia', '', '2018-03-30 00:05:38', '1'),
(20, 1, 2, 'follow', '', '', '', '2018-03-30 00:05:38', '1'),
(21, 2, 1, 'friend_accept', '', 'adwin', '', '2018-03-30 00:06:01', '1'),
(22, 2, 1, 'follow', '', '', '', '2018-03-30 00:06:01', '1'),
(23, 4, 1, 'friend_accept', '', 'adwin', '', '2018-03-30 00:06:02', '0'),
(24, 4, 1, 'follow', '', '', '', '2018-03-30 00:06:02', '0');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_type` enum('user') NOT NULL,
  `in_wall` enum('0','1') NOT NULL DEFAULT '0',
  `wall_id` int(10) UNSIGNED DEFAULT NULL,
  `post_type` varchar(32) NOT NULL,
  `origin_id` int(10) UNSIGNED DEFAULT NULL,
  `time` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `privacy` varchar(32) NOT NULL,
  `text` longtext,
  `feeling_action` varchar(32) DEFAULT NULL,
  `feeling_value` varchar(255) DEFAULT NULL,
  `likes` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comments` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `shares` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `user_type`, `in_wall`, `wall_id`, `post_type`, `origin_id`, `time`, `location`, `privacy`, `text`, `feeling_action`, `feeling_value`, `likes`, `comments`, `shares`) VALUES
(44, 4, 'user', '0', 0, 'audio', NULL, '2018-03-14 16:09:34', '', 'friends', 'erfaef', '', '', 0, 0, 0),
(43, 4, 'user', '0', 0, 'video', NULL, '2018-03-14 16:09:05', '', 'me', 'dsafdsa ^_^ ', 'Feeling', 'Loved', 0, 0, 0),
(42, 4, 'user', '0', NULL, 'article', NULL, '2018-03-14 16:08:25', NULL, 'public', NULL, NULL, NULL, 0, 0, 0),
(41, 4, 'user', '0', 0, 'album', NULL, '2018-03-14 14:59:21', '', 'friends', '', '', '', 1, 3, 0),
(40, 4, 'user', '0', 0, 'file', NULL, '2018-03-14 14:58:42', '', 'friends', 'this is the first text', '', '', 0, 0, 0),
(39, 4, 'user', '0', 0, 'audio', NULL, '2018-03-14 14:57:58', '', 'friends', 'a chinese song', 'Listening To', 'flower', 0, 0, 0),
(38, 4, 'user', '0', 0, 'video', NULL, '2018-03-14 14:57:17', '', 'public', 'omw to Toronto :flushed: ', '', '', 0, 0, 0),
(37, 4, 'user', '0', NULL, 'article', NULL, '2018-03-14 14:56:37', NULL, 'public', NULL, NULL, NULL, 0, 0, 0),
(36, 4, 'user', '0', 0, 'photos', NULL, '2018-03-14 14:54:58', '', 'me', 'hahahah', 'Feeling', 'Satisfied', 0, 0, 0),
(35, 4, 'user', '0', 0, '', NULL, '2018-03-14 14:54:29', '', 'public', 'good morning', '', '', 0, 0, 0),
(34, 2, 'user', '0', 0, '', NULL, '2018-03-14 06:39:04', '', 'public', 'have a nice day', '', '', 0, 3, 0),
(33, 2, 'user', '0', 0, 'photos', NULL, '2018-03-14 05:48:04', '', 'public', '', '', '', 1, 2, 0),
(32, 2, 'user', '0', 0, 'audio', NULL, '2018-03-14 05:47:49', '', 'public', '', '', '', 0, 0, 0),
(31, 2, 'user', '0', 0, 'video', NULL, '2018-03-14 05:47:24', '', 'public', '', '', '', 0, 1, 0),
(30, 2, 'user', '0', 0, 'video', NULL, '2018-03-14 05:40:21', '', 'public', '', '', '', 0, 0, 0),
(29, 2, 'user', '0', 0, 'photos', NULL, '2018-03-14 05:39:51', '', 'public', '', '', '', 0, 0, 0),
(28, 2, 'user', '0', 0, 'video', NULL, '2018-03-14 05:35:45', '', 'public', '', '', '', 0, 0, 0),
(27, 2, 'user', '0', 0, 'audio', NULL, '2018-03-14 05:35:06', '', 'public', '', '', '', 0, 0, 0),
(26, 2, 'user', '0', 0, 'photos', NULL, '2018-03-14 05:34:51', '', 'public', '', '', '', 0, 0, 0),
(45, 4, 'user', '0', 0, 'file', NULL, '2018-03-14 16:10:33', '', 'friends', 'fedafe', '', '', 0, 0, 0),
(46, 2, 'user', '0', 0, '', NULL, '2018-03-28 14:20:58', '', 'public', 'what a nice day today! no rain no wind.#weather', '', '', 0, 0, 0),
(47, 2, 'user', '0', 0, '', NULL, '2018-03-28 14:21:38', '', 'public', 'It&#039;s a sunny day. The weather is good. #weather', '', '', 0, 0, 0),
(48, 2, 'user', '0', 0, '', NULL, '2018-03-28 14:27:47', '', 'public', 'good school, good teachers #University of Windor', '', '', 0, 1, 0),
(49, 2, 'user', '0', 0, '', NULL, '2018-03-28 14:33:37', '', 'public', ' U of W is a great school, love it because of nice and wonderful teachers. #university', '', '', 0, 0, 0),
(50, 2, 'user', '0', 0, '', NULL, '2018-03-28 15:12:50', '', 'me', 'Spring is coming. #weather', '', '', 1, 3, 0),
(51, 2, 'user', '0', 0, 'album', NULL, '2018-03-30 00:02:24', '', 'public', '', '', '', 0, 0, 0),
(52, 2, 'user', '0', NULL, 'profile_picture', NULL, '2018-03-30 00:02:37', NULL, 'public', NULL, NULL, NULL, 0, 0, 0),
(53, 2, 'user', '0', NULL, 'profile_cover', NULL, '2018-03-30 00:02:51', NULL, 'public', NULL, NULL, NULL, 0, 0, 0),
(54, 2, 'user', '0', 0, '', NULL, '2018-03-30 00:11:33', '', 'public', 'fadkjg', '', '', 0, 0, 0),
(55, 2, 'user', '0', 0, '', NULL, '2018-03-30 00:15:28', '', 'friends', 'jffff', '', '', 0, 0, 0),
(56, 2, 'user', '0', 0, '', NULL, '2018-03-30 00:20:26', '', 'public', 'hhiio\n', '', '', 0, 0, 0),
(57, 2, 'user', '0', 0, '', NULL, '2018-03-30 00:20:58', '', 'public', 'adg ', '', '', 0, 0, 0),
(58, 2, 'user', '0', 0, '', NULL, '2018-03-30 00:25:11', '', 'friends', 'hjfk', '', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts_articles`
--

CREATE TABLE `posts_articles` (
  `article_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `cover` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `tags` text NOT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `posts_articles`
--

INSERT INTO `posts_articles` (`article_id`, `post_id`, `cover`, `title`, `text`, `tags`, `views`) VALUES
(2, 37, 'photos/2018/03/_9ee8aa08847af575876ace98b0605310.jpg', 'project', '&lt;p&gt;our project is great!&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;lol&lt;/strong&gt;&lt;/p&gt;', 'project', 2),
(3, 42, 'photos/2018/03/_79f3d4edce22e837bf15a7cf7ab859c2.jpg', 'fds', '&lt;p&gt;fas&lt;strong&gt;dfd&lt;/strong&gt;&lt;/p&gt;', 'fdas', 6);

-- --------------------------------------------------------

--
-- Table structure for table `posts_audios`
--

CREATE TABLE `posts_audios` (
  `audio_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `source` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `posts_audios`
--

INSERT INTO `posts_audios` (`audio_id`, `post_id`, `source`) VALUES
(9, 44, 'sounds/2018/03/_bb3ea74e343f1768d35e9aa24a61fbb6.mp3'),
(8, 39, 'sounds/2018/03/_c41f008f7c996c8f2793115494c8ddb0.mp3'),
(7, 32, 'sounds/2018/03/_fa7fb04d302f56d15355255418f090e9.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `posts_comments`
--

CREATE TABLE `posts_comments` (
  `comment_id` int(10) UNSIGNED NOT NULL,
  `node_id` int(10) UNSIGNED NOT NULL,
  `node_type` enum('post','photo','comment') NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_type` enum('user') NOT NULL,
  `text` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL,
  `likes` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `replies` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts_comments`
--

INSERT INTO `posts_comments` (`comment_id`, `node_id`, `node_type`, `user_id`, `user_type`, `text`, `image`, `time`, `likes`, `replies`) VALUES
(52, 50, 'comment', 2, 'user', 'fssfdasf (&lt; ', '', '2018-03-30 00:05:00', 0, 0),
(51, 50, 'comment', 2, 'user', 'fssfdasf', '', '2018-03-30 00:04:55', 0, 0),
(48, 34, 'post', 2, 'user', 'jkljk', 'photos/2018/03/_146bee0d23b8fa0257a6ef7d4d23a9bf.jpg', '2018-03-21 16:22:19', 0, 0),
(49, 48, 'post', 2, 'user', 'love U of W', '', '2018-03-28 14:30:05', 0, 0),
(47, 34, 'post', 2, 'user', 'jklj', 'photos/2018/03/_146bee0d23b8fa0257a6ef7d4d23a9bf.jpg', '2018-03-21 16:22:19', 0, 0),
(50, 50, 'post', 2, 'user', 'jgfhf', '', '2018-03-30 00:04:43', 1, 2),
(45, 34, 'post', 2, 'user', 'jkljkl;', '', '2018-03-21 16:21:15', 0, 0),
(44, 41, 'post', 4, 'user', 'hhhh', '', '2018-03-14 15:36:40', 0, 0),
(42, 41, 'post', 4, 'user', 'jdksal', '', '2018-03-14 14:59:30', 0, 0),
(43, 41, 'post', 4, 'user', 'hkhjk', '', '2018-03-14 15:04:52', 0, 0),
(41, 31, 'post', 2, 'user', '111', '', '2018-03-14 06:35:52', 0, 0),
(40, 33, 'post', 2, 'user', 'good', '', '2018-03-14 05:48:32', 0, 0),
(39, 33, 'post', 2, 'user', 'good', '', '2018-03-14 05:48:27', 0, 0),
(30, 19, 'post', 2, 'user', 'haha', '', '2018-03-14 03:38:22', 0, 0),
(31, 19, 'post', 2, 'user', ':sunny: ', '', '2018-03-14 03:42:50', 0, 0),
(32, 20, 'post', 2, 'user', '*_* ', '', '2018-03-14 03:44:55', 0, 0),
(33, 19, 'post', 2, 'user', 'sunny day', '', '2018-03-14 03:47:21', 0, 0),
(34, 18, 'post', 2, 'user', 'also like', '', '2018-03-14 03:51:35', 0, 0),
(35, 20, 'post', 2, 'user', 'warm song', '', '2018-03-14 03:54:46', 0, 0),
(36, 19, 'post', 2, 'user', 'hi', '', '2018-03-14 04:09:24', 0, 0),
(37, 18, 'post', 2, 'user', '168', '', '2018-03-14 04:21:14', 0, 0),
(38, 20, 'post', 2, 'user', 'wonderfu', '', '2018-03-14 04:28:49', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts_comments_likes`
--

CREATE TABLE `posts_comments_likes` (
  `comment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `posts_comments_likes`
--

INSERT INTO `posts_comments_likes` (`comment_id`, `user_id`) VALUES
(50, 2);

-- --------------------------------------------------------

--
-- Table structure for table `posts_files`
--

CREATE TABLE `posts_files` (
  `file_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `source` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `posts_files`
--

INSERT INTO `posts_files` (`file_id`, `post_id`, `source`) VALUES
(1, 40, 'files/2018/03/_4307f1a9bab50fa5dadaed7c748c0602.txt'),
(2, 45, 'files/2018/03/_e27c1970ec859f56e1bc2df30f72b674.txt');

-- --------------------------------------------------------

--
-- Table structure for table `posts_hidden`
--

CREATE TABLE `posts_hidden` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `posts_hidden`
--

INSERT INTO `posts_hidden` (`post_id`, `user_id`) VALUES
(34, 2),
(48, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2);

-- --------------------------------------------------------

--
-- Table structure for table `posts_likes`
--

CREATE TABLE `posts_likes` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts_likes`
--

INSERT INTO `posts_likes` (`post_id`, `user_id`) VALUES
(33, 2),
(41, 4),
(50, 2);

-- --------------------------------------------------------

--
-- Table structure for table `posts_links`
--

CREATE TABLE `posts_links` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `source_url` tinytext NOT NULL,
  `source_host` varchar(255) NOT NULL,
  `source_title` varchar(255) NOT NULL,
  `source_text` text NOT NULL,
  `source_thumbnail` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts_media`
--

CREATE TABLE `posts_media` (
  `media_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) NOT NULL,
  `source_url` text NOT NULL,
  `source_provider` varchar(255) NOT NULL,
  `source_type` varchar(255) NOT NULL,
  `source_title` varchar(255) DEFAULT NULL,
  `source_text` text,
  `source_html` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts_photos`
--

CREATE TABLE `posts_photos` (
  `photo_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `album_id` int(10) UNSIGNED DEFAULT NULL,
  `source` varchar(255) NOT NULL,
  `likes` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `comments` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts_photos`
--

INSERT INTO `posts_photos` (`photo_id`, `post_id`, `album_id`, `source`, `likes`, `comments`) VALUES
(22, 53, 5, 'photos/2018/03/_f7dc062bf6428794bd2b9599aa2120ad.jpg', 0, 0),
(21, 52, 4, 'photos/2018/03/_b42ac726ef72121ba1f506e2d424c00f.jpg', 0, 0),
(20, 51, 3, 'photos/2018/03/_663c4e7ad1c664597e3c63e80885bc8d.jpg', 0, 0),
(19, 51, 3, 'photos/2018/03/_ba73c331b35d1fa11490f81213522c2f.jpg', 0, 0),
(18, 51, 3, 'photos/2018/03/_b930d4fdf92b8686579e95d0e556281a.jpg', 0, 0),
(17, 41, 2, 'photos/2018/03/_f0d132f47cf512dcb10d0eac664cf4f7.jpg', 0, 0),
(16, 41, 2, 'photos/2018/03/_33a685f9d58ab1de4a7814b27697b949.jpg', 0, 0),
(15, 36, 0, 'photos/2018/03/_597a7fd784a6276509d4eb031f70b435.jpg', 0, 0),
(14, 33, 0, 'photos/2018/03/_6ed59f5780ec2e7de20045bc2a8491de.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts_photos_albums`
--

CREATE TABLE `posts_photos_albums` (
  `album_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_type` enum('user') NOT NULL,
  `title` varchar(255) NOT NULL,
  `privacy` enum('me','friends','public','custom') NOT NULL DEFAULT 'public'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts_photos_albums`
--

INSERT INTO `posts_photos_albums` (`album_id`, `user_id`, `user_type`, `title`, `privacy`) VALUES
(2, 4, 'user', 'fantastic china', 'friends'),
(3, 2, 'user', 'china', 'public'),
(4, 2, 'user', 'Profile Pictures', 'public'),
(5, 2, 'user', 'Cover Photos', 'public');

-- --------------------------------------------------------

--
-- Table structure for table `posts_photos_likes`
--

CREATE TABLE `posts_photos_likes` (
  `photo_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Table structure for table `posts_saved`
--

CREATE TABLE `posts_saved` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts_saved`
--

INSERT INTO `posts_saved` (`post_id`, `user_id`, `time`) VALUES
(41, 4, '2018-03-14 15:57:25');

-- --------------------------------------------------------

--
-- Table structure for table `posts_videos`
--

CREATE TABLE `posts_videos` (
  `video_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `source` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `posts_videos`
--

INSERT INTO `posts_videos` (`video_id`, `post_id`, `source`) VALUES
(12, 43, 'videos/2018/03/_31b34d0f23783704a8b981c707b18362.mp4'),
(11, 38, 'videos/2018/03/_d9a03f96e137d7638e9fd102a66df6a9.mp4'),
(10, 31, 'videos/2018/03/_76cad2b4e7377253321638c2ec115e06.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `stickers`
--

CREATE TABLE `stickers` (
  `sticker_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `stickers`
--

INSERT INTO `stickers` (`sticker_id`, `image`) VALUES
(1, 'stickers/1.png'),
(2, 'stickers/2.png'),
(3, 'stickers/3.png'),
(4, 'stickers/4.png'),
(5, 'stickers/5.png'),
(6, 'stickers/6.png'),
(7, 'stickers/7.png'),
(8, 'stickers/8.png'),
(9, 'stickers/9.png'),
(10, 'stickers/10.png'),
(11, 'stickers/11.png'),
(12, 'stickers/12.png'),
(13, 'stickers/13.png'),
(14, 'stickers/14.png'),
(15, 'stickers/15.png'),
(16, 'stickers/16.png'),
(17, 'stickers/17.png'),
(18, 'stickers/18.png');

-- --------------------------------------------------------

--
-- Table structure for table `system_options`
--

CREATE TABLE `system_options` (
  `ID` int(10) UNSIGNED NOT NULL,
  `system_public` enum('0','1') NOT NULL DEFAULT '1',
  `system_live` enum('0','1') NOT NULL DEFAULT '1',
  `system_message` text NOT NULL,
  `system_title` varchar(255) NOT NULL DEFAULT 'Sngine',
  `system_description` text NOT NULL,
  `system_keywords` text NOT NULL,
  `system_email` varchar(255) DEFAULT NULL,
  `blogs_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `daytime_msg_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `profile_notification_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `wall_posts_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `smart_yt_player` enum('0','1') NOT NULL DEFAULT '1',
  `geolocation_enabled` enum('0','1') NOT NULL DEFAULT '0',
  `geolocation_key` varchar(255) DEFAULT NULL,
  `default_privacy` enum('public','friends','me') NOT NULL DEFAULT 'friends',
  `registration_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `registration_type` enum('free','paid') NOT NULL DEFAULT 'free',
  `activation_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `activation_type` enum('email','sms') NOT NULL DEFAULT 'email',
  `age_restriction` enum('0','1') NOT NULL DEFAULT '0',
  `minimum_age` tinyint(1) UNSIGNED DEFAULT NULL,
  `getting_started` enum('0','1') NOT NULL DEFAULT '1',
  `delete_accounts_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `max_accounts` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `email_smtp_enabled` enum('0','1') NOT NULL DEFAULT '0',
  `email_smtp_authentication` enum('0','1') NOT NULL DEFAULT '1',
  `email_smtp_ssl` enum('0','1') NOT NULL DEFAULT '0',
  `email_smtp_server` varchar(255) DEFAULT NULL,
  `email_smtp_port` varchar(255) DEFAULT NULL,
  `email_smtp_username` varchar(255) DEFAULT NULL,
  `email_smtp_password` varchar(255) DEFAULT NULL,
  `email_smtp_setfrom` varchar(255) DEFAULT NULL,
  `email_notifications` enum('0','1') NOT NULL DEFAULT '1',
  `email_post_likes` enum('0','1') NOT NULL DEFAULT '1',
  `email_post_comments` enum('0','1') NOT NULL DEFAULT '1',
  `email_post_shares` enum('0','1') NOT NULL DEFAULT '1',
  `email_wall_posts` enum('0','1') NOT NULL DEFAULT '1',
  `email_mentions` enum('0','1') NOT NULL DEFAULT '1',
  `email_profile_visits` enum('0','1') NOT NULL DEFAULT '1',
  `email_friend_requests` enum('0','1') NOT NULL DEFAULT '1',
  `system_phone` varchar(255) DEFAULT NULL,
  `uploads_directory` varchar(255) NOT NULL DEFAULT 'content/uploads',
  `uploads_prefix` varchar(255) DEFAULT 'sngine',
  `max_avatar_size` int(10) UNSIGNED NOT NULL DEFAULT '5120',
  `max_cover_size` int(10) UNSIGNED NOT NULL DEFAULT '5120',
  `photos_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `max_photo_size` int(10) UNSIGNED NOT NULL DEFAULT '5120',
  `videos_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `max_video_size` int(10) UNSIGNED NOT NULL DEFAULT '5120',
  `video_extensions` text NOT NULL,
  `audio_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `max_audio_size` int(10) UNSIGNED NOT NULL DEFAULT '5120',
  `audio_extensions` text NOT NULL,
  `file_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `max_file_size` int(10) UNSIGNED NOT NULL DEFAULT '5120',
  `file_extensions` text NOT NULL,
  `censored_words_enabled` enum('0','1') NOT NULL DEFAULT '1',
  `censored_words` text NOT NULL,
  `reCAPTCHA_enabled` enum('0','1') NOT NULL DEFAULT '0',
  `reCAPTCHA_site_key` varchar(255) DEFAULT NULL,
  `reCAPTCHA_secret_key` varchar(255) DEFAULT NULL,
  `session_hash` varchar(255) NOT NULL,
  `data_heartbeat` int(10) UNSIGNED NOT NULL DEFAULT '5',
  `offline_time` int(10) UNSIGNED NOT NULL DEFAULT '10',
  `min_results` int(10) UNSIGNED NOT NULL DEFAULT '5',
  `max_results` int(10) UNSIGNED NOT NULL DEFAULT '10',
  `min_results_even` int(10) UNSIGNED NOT NULL DEFAULT '5',
  `max_results_even` int(10) UNSIGNED NOT NULL DEFAULT '12',
  `analytics_code` text NOT NULL,
  `system_logo` varchar(255) DEFAULT NULL,
  `system_wallpaper_default` enum('0','1') NOT NULL DEFAULT '1',
  `system_wallpaper` varchar(255) DEFAULT NULL,
  `system_random_profiles` enum('0','1') NOT NULL DEFAULT '1',
  `system_favicon_default` enum('0','1') NOT NULL DEFAULT '1',
  `system_favicon` varchar(255) DEFAULT NULL,
  `system_ogimage_default` enum('0','1') NOT NULL DEFAULT '1',
  `system_ogimage` varchar(255) DEFAULT NULL,
  `css_customized` enum('0','1') NOT NULL DEFAULT '0',
  `css_background` varchar(32) DEFAULT NULL,
  `css_link_color` varchar(32) DEFAULT NULL,
  `css_header` varchar(32) DEFAULT NULL,
  `css_header_search` varchar(32) DEFAULT NULL,
  `css_header_search_color` varchar(32) DEFAULT NULL,
  `css_btn_primary` varchar(32) DEFAULT NULL,
  `css_menu_background` varchar(32) DEFAULT NULL,
  `css_custome_css` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `system_options`
--

INSERT INTO `system_options` (`ID`, `system_public`, `system_live`, `system_message`, `system_title`, `system_description`, `system_keywords`, `system_email`, `blogs_enabled`, `daytime_msg_enabled`, `profile_notification_enabled`, `wall_posts_enabled`, `smart_yt_player`, `geolocation_enabled`, `geolocation_key`, `default_privacy`, `registration_enabled`, `registration_type`, `activation_enabled`, `activation_type`, `age_restriction`, `minimum_age`, `getting_started`, `delete_accounts_enabled`, `max_accounts`, `email_smtp_enabled`, `email_smtp_authentication`, `email_smtp_ssl`, `email_smtp_server`, `email_smtp_port`, `email_smtp_username`, `email_smtp_password`, `email_smtp_setfrom`, `email_notifications`, `email_post_likes`, `email_post_comments`, `email_post_shares`, `email_wall_posts`, `email_mentions`, `email_profile_visits`, `email_friend_requests`, `system_phone`, `uploads_directory`, `uploads_prefix`, `max_avatar_size`, `max_cover_size`, `photos_enabled`, `max_photo_size`, `videos_enabled`, `max_video_size`, `video_extensions`, `audio_enabled`, `max_audio_size`, `audio_extensions`, `file_enabled`, `max_file_size`, `file_extensions`, `censored_words_enabled`, `censored_words`, `reCAPTCHA_enabled`, `reCAPTCHA_site_key`, `reCAPTCHA_secret_key`, `session_hash`, `data_heartbeat`, `offline_time`, `min_results`, `max_results`, `min_results_even`, `max_results_even`, `analytics_code`, `system_logo`, `system_wallpaper_default`, `system_wallpaper`, `system_random_profiles`, `system_favicon_default`, `system_favicon`, `system_ogimage_default`, `system_ogimage`, `css_customized`, `css_background`, `css_link_color`, `css_header`, `css_header_search`, `css_header_search_color`, `css_btn_primary`, `css_menu_background`, `css_custome_css`) VALUES
(1, '1', '1', '', 'M&M', '', '', 'me@qq.com', '1', '1', '1', '1', '1', '0', NULL, 'public', '1', 'free', '1', 'email', '0', 1, '1', '1', 0, '1', '1', '1', '', '', '', '', NULL, '0', '0', '0', '0', '0', '0', '0', '0', NULL, 'content/uploads', '', 5120, 5120, '1', 5120, '1', 5120, 'mp4, mov', '1', 512000, 'mp3, wav', '1', 5120, 'txt, zip', '1', 'pussy,fuck,shit,asshole,dick,tits,boobs', '0', NULL, NULL, '1Zaaa-1mbbb-1Bccc-1lrrr-1Keee-scriptbase', 5, 10, 5, 10, 6, 12, '', NULL, '1', NULL, '1', '1', NULL, '1', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `system_themes`
--

CREATE TABLE `system_themes` (
  `theme_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `default` enum('0','1') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `system_themes`
--

INSERT INTO `system_themes` (`theme_id`, `name`, `default`) VALUES
(1, 'default', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(64) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_phone` varchar(64) DEFAULT NULL,
  `user_password` varchar(64) NOT NULL,
  `user_activated` enum('0','1') NOT NULL DEFAULT '0',
  `user_activation_key` varchar(64) DEFAULT NULL,
  `user_reseted` enum('0','1') NOT NULL DEFAULT '0',
  `user_reset_key` varchar(64) DEFAULT NULL,
  `user_subscribed` enum('0','1') NOT NULL DEFAULT '0',
  `user_subscription_date` datetime DEFAULT NULL,
  `user_started` enum('0','1') NOT NULL DEFAULT '0',
  `user_verified` enum('0','1') NOT NULL DEFAULT '0',
  `user_live_requests_counter` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_live_requests_lastid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_live_notifications_counter` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_live_notifications_lastid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) DEFAULT NULL,
  `user_gender` enum('male','female') NOT NULL,
  `user_picture` varchar(255) DEFAULT NULL,
  `user_picture_id` int(10) UNSIGNED DEFAULT NULL,
  `user_cover` varchar(255) DEFAULT NULL,
  `user_cover_id` int(10) UNSIGNED DEFAULT NULL,
  `user_album_pictures` int(10) UNSIGNED DEFAULT NULL,
  `user_album_covers` int(10) UNSIGNED DEFAULT NULL,
  `user_album_timeline` int(10) UNSIGNED DEFAULT NULL,
  `user_pinned_post` int(10) UNSIGNED DEFAULT NULL,
  `user_registered` datetime DEFAULT NULL,
  `user_last_login` datetime DEFAULT NULL,
  `user_birthdate` date DEFAULT NULL,
  `user_relationship` varchar(255) DEFAULT NULL,
  `user_biography` text,
  `user_website` varchar(255) DEFAULT NULL,
  `user_work_title` varchar(255) DEFAULT NULL,
  `user_work_place` varchar(255) DEFAULT NULL,
  `user_current_city` varchar(255) DEFAULT NULL,
  `user_hometown` varchar(255) DEFAULT NULL,
  `user_edu_major` varchar(255) DEFAULT NULL,
  `user_edu_school` varchar(255) DEFAULT NULL,
  `user_edu_class` varchar(255) DEFAULT NULL,
  `user_privacy_wall` enum('me','friends','public') NOT NULL DEFAULT 'friends',
  `user_privacy_birthdate` enum('me','friends','public') NOT NULL DEFAULT 'public',
  `user_privacy_relationship` enum('me','friends','public') NOT NULL DEFAULT 'public',
  `user_privacy_basic` enum('me','friends','public') NOT NULL DEFAULT 'public',
  `user_privacy_work` enum('me','friends','public') NOT NULL DEFAULT 'public',
  `user_privacy_location` enum('me','friends','public') NOT NULL DEFAULT 'public',
  `user_privacy_education` enum('me','friends','public') NOT NULL DEFAULT 'public',
  `user_privacy_other` enum('me','friends','public') NOT NULL DEFAULT 'public',
  `user_privacy_friends` enum('me','friends','public') NOT NULL DEFAULT 'public',
  `user_privacy_photos` enum('me','friends','public') NOT NULL DEFAULT 'public',
  `email_post_likes` enum('0','1') NOT NULL DEFAULT '1',
  `email_post_comments` enum('0','1') NOT NULL DEFAULT '1',
  `email_post_shares` enum('0','1') NOT NULL DEFAULT '1',
  `email_wall_posts` enum('0','1') NOT NULL DEFAULT '1',
  `email_mentions` enum('0','1') NOT NULL DEFAULT '1',
  `email_profile_visits` enum('0','1') NOT NULL DEFAULT '1',
  `email_friend_requests` enum('0','1') NOT NULL DEFAULT '1',
  `user_referrer_id` int(10) DEFAULT NULL,
  `notifications_sound` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_phone`, `user_password`, `user_activated`, `user_activation_key`, `user_reseted`, `user_reset_key`, `user_subscribed`, `user_subscription_date`, `user_started`, `user_verified`, `user_live_requests_counter`, `user_live_requests_lastid`, `user_live_notifications_counter`, `user_live_notifications_lastid`, `user_firstname`, `user_lastname`, `user_gender`, `user_picture`, `user_picture_id`, `user_cover`, `user_cover_id`, `user_album_pictures`, `user_album_covers`, `user_album_timeline`, `user_pinned_post`, `user_registered`, `user_last_login`, `user_birthdate`, `user_relationship`, `user_biography`, `user_website`, `user_work_title`, `user_work_place`, `user_current_city`, `user_hometown`, `user_edu_major`, `user_edu_school`, `user_edu_class`, `user_privacy_wall`, `user_privacy_birthdate`, `user_privacy_relationship`, `user_privacy_basic`, `user_privacy_work`, `user_privacy_location`, `user_privacy_education`, `user_privacy_other`, `user_privacy_friends`, `user_privacy_photos`, `email_post_likes`, `email_post_comments`, `email_post_shares`, `email_wall_posts`, `email_mentions`, `email_profile_visits`, `email_friend_requests`, `user_referrer_id`, `notifications_sound`) VALUES
(1, 'adwin', 'me@qq.com', NULL, '$2y$10$QJN3pZznGjrBad8SCVg2ZOsZ6t34NKu2tVreqLz1xh3GERV9cPo9y', '1', NULL, '0', NULL, '0', NULL, '1', '1', 0, 0, 0, 0, 'adwin', NULL, 'male', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-11 00:36:02', '2018-03-30 00:05:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'friends', 'public', 'public', 'public', 'public', 'public', 'public', 'public', 'public', 'public', '1', '1', '1', '1', '1', '1', '1', NULL, '0'),
(2, 'mia', 'mia.m.g@outlook.com', NULL, '$2y$10$rUE5/DRryYSb9tZ7yd8w2u8x34/dLhmoiHJbCh40jxEtM0YkT8BS2', '1', 'bfbcb5afe056470f784cdc8e30a30335', '0', '9yRXxD', '0', NULL, '1', '0', 0, 0, 0, 0, 'Mia', 'Guoo', 'female', 'photos/2018/03/_b42ac726ef72121ba1f506e2d424c00f.jpg', 21, 'photos/2018/03/_f7dc062bf6428794bd2b9599aa2120ad.jpg', 22, 4, 5, NULL, NULL, '2018-03-11 00:36:44', '2018-03-30 00:33:09', '1993-04-23', 'single', 'pretty', NULL, 'Database', 'Toronto', 'Windsor', 'China', 'Master of Applied Computing', 'University of Windsor', '2017MAC', 'friends', 'public', 'public', 'public', 'public', 'public', 'public', 'public', 'public', 'public', '1', '1', '1', '1', '1', '1', '1', NULL, '0'),
(4, 'mica', 'zqx.5549@gmail.com', NULL, '$2y$10$DYI6KJ9EALMIBKIo51q30.a5gqvz6YofmBh7lf1ZF2d97s0mDJ.LK', '1', 'ecd07052a8ee6e71a539c3614b4eb9c8', '0', NULL, '0', NULL, '1', '0', 0, 0, 4, 0, 'Mica', 'Zhang', 'female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-13 16:41:46', '2018-03-21 16:06:59', '1993-06-16', 'single', 'yeah', NULL, 'president', 'windsor', 'windsor', 'bengbu', 'MAC', 'U of W', '2017MAC', 'friends', 'public', 'public', 'public', 'public', 'public', 'public', 'public', 'public', 'public', '1', '1', '1', '1', '1', '1', '1', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `users_searches`
--

CREATE TABLE `users_searches` (
  `log_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `node_id` int(10) UNSIGNED NOT NULL,
  `node_type` varchar(32) NOT NULL,
  `time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users_searches`
--

INSERT INTO `users_searches` (`log_id`, `user_id`, `node_id`, `node_type`, `time`) VALUES
(1, 2, 1, 'user', '2018-03-13 19:39:01'),
(2, 4, 2, 'user', '2018-03-14 16:04:38');

-- --------------------------------------------------------

--
-- Table structure for table `users_sessions`
--

CREATE TABLE `users_sessions` (
  `session_id` int(10) UNSIGNED NOT NULL,
  `session_token` varchar(64) NOT NULL,
  `session_date` datetime NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_browser` varchar(64) NOT NULL,
  `user_os` varchar(64) NOT NULL,
  `user_ip` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users_sessions`
--

INSERT INTO `users_sessions` (`session_id`, `session_token`, `session_date`, `user_id`, `user_browser`, `user_os`, `user_ip`) VALUES
(160, '41af5f82e6746b1fee7505731f9a1815', '2018-03-30 00:33:09', 2, 'Edge', 'Windows 10', '::1'),
(145, 'dc7becaa1c6cdc330526021f3a58b522', '2018-03-28 15:10:08', 2, 'Edge', 'Windows 10', '::1'),
(144, 'b207506867fe05c01500564bd766d860', '2018-03-27 15:13:45', 2, 'Edge', 'Windows 10', '::1'),
(143, '255c013e7ab745b7c704a403c0f426b1', '2018-03-21 16:09:15', 2, 'Unknown Browser', 'Windows 10', '::1'),
(136, '5cfcb09452fe924b41ec767d9aa5a21d', '2018-03-14 16:14:32', 1, 'Edge', 'Windows 10', '::1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emojis`
--
ALTER TABLE `emojis`
  ADD PRIMARY KEY (`emoji_id`);

--
-- Indexes for table `followings`
--
ALTER TABLE `followings`
  ADD UNIQUE KEY `user_id_following_id` (`user_id`,`following_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_one_id_user_two_id` (`user_one_id`,`user_two_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `posts_articles`
--
ALTER TABLE `posts_articles`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `posts_audios`
--
ALTER TABLE `posts_audios`
  ADD PRIMARY KEY (`audio_id`);

--
-- Indexes for table `posts_comments`
--
ALTER TABLE `posts_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts_comments_likes`
--
ALTER TABLE `posts_comments_likes`
  ADD UNIQUE KEY `comment_id_user_id` (`comment_id`,`user_id`);

--
-- Indexes for table `posts_files`
--
ALTER TABLE `posts_files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `posts_hidden`
--
ALTER TABLE `posts_hidden`
  ADD UNIQUE KEY `post_id_user_id` (`post_id`,`user_id`);

--
-- Indexes for table `posts_likes`
--
ALTER TABLE `posts_likes`
  ADD UNIQUE KEY `post_id_user_id` (`post_id`,`user_id`);

--
-- Indexes for table `posts_links`
--
ALTER TABLE `posts_links`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `posts_media`
--
ALTER TABLE `posts_media`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `posts_photos`
--
ALTER TABLE `posts_photos`
  ADD PRIMARY KEY (`photo_id`);

--
-- Indexes for table `posts_photos_albums`
--
ALTER TABLE `posts_photos_albums`
  ADD PRIMARY KEY (`album_id`);

--
-- Indexes for table `posts_photos_likes`
--
ALTER TABLE `posts_photos_likes`
  ADD UNIQUE KEY `user_id_photo_id` (`user_id`,`photo_id`);

--
-- Indexes for table `posts_saved`
--
ALTER TABLE `posts_saved`
  ADD UNIQUE KEY `post_id_user_id` (`post_id`,`user_id`);

--
-- Indexes for table `posts_videos`
--
ALTER TABLE `posts_videos`
  ADD PRIMARY KEY (`video_id`);

--
-- Indexes for table `stickers`
--
ALTER TABLE `stickers`
  ADD PRIMARY KEY (`sticker_id`);

--
-- Indexes for table `system_options`
--
ALTER TABLE `system_options`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `system_themes`
--
ALTER TABLE `system_themes`
  ADD PRIMARY KEY (`theme_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_phone` (`user_phone`);

--
-- Indexes for table `users_searches`
--
ALTER TABLE `users_searches`
  ADD PRIMARY KEY (`log_id`),
  ADD UNIQUE KEY `node_id_node_type` (`node_id`,`node_type`);

--
-- Indexes for table `users_sessions`
--
ALTER TABLE `users_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD UNIQUE KEY `session_token` (`session_token`),
  ADD KEY `user_ip` (`user_ip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emojis`
--
ALTER TABLE `emojis`
  MODIFY `emoji_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `posts_articles`
--
ALTER TABLE `posts_articles`
  MODIFY `article_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts_audios`
--
ALTER TABLE `posts_audios`
  MODIFY `audio_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts_comments`
--
ALTER TABLE `posts_comments`
  MODIFY `comment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `posts_files`
--
ALTER TABLE `posts_files`
  MODIFY `file_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts_links`
--
ALTER TABLE `posts_links`
  MODIFY `link_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts_media`
--
ALTER TABLE `posts_media`
  MODIFY `media_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts_photos`
--
ALTER TABLE `posts_photos`
  MODIFY `photo_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `posts_photos_albums`
--
ALTER TABLE `posts_photos_albums`
  MODIFY `album_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts_videos`
--
ALTER TABLE `posts_videos`
  MODIFY `video_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `stickers`
--
ALTER TABLE `stickers`
  MODIFY `sticker_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `system_options`
--
ALTER TABLE `system_options`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_themes`
--
ALTER TABLE `system_themes`
  MODIFY `theme_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_searches`
--
ALTER TABLE `users_searches`
  MODIFY `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_sessions`
--
ALTER TABLE `users_sessions`
  MODIFY `session_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
