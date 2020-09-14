<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

  if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
  }

  require_once(DIR_WS_CLASSES . 'twitteroauth/twitteroauth.php');

  define('CONSUMER_KEY', 'p3nrpnvQgJ3fA5lDuV8T2T03S');
  define('CONSUMER_SECRET', 'fA4sNKHOJsSbEhYBEC89ZWe2zyMiVrJt0ktdC3kc7fM5t6cEP3');

  // User Access Token
  define('ACCESS_TOKEN', '220247306-joboej55lNSDqSlfGfcg9Xrc5MQAbBXgLtQki1Bq');
  define('ACCESS_SECRET', 'PVw0qd5DERF7xtxcvuX7s6KRsqAeoXrVz9DZ2xGWtGLkw');

  // Check if keys are in place
  if (CONSUMER_KEY === '' || CONSUMER_SECRET === '' || CONSUMER_KEY === 'CONSUMER_KEY_HERE' || CONSUMER_SECRET === 'CONSUMER_SECRET_HERE'){
    $zc_show_twitter = false;
  }else{
    $zc_show_twitter = true;
  }

  if($zc_show_twitter == true){

    $list_box_contents = array();

    // If count of tweets is not fall back to default setting
    $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $number = filter_input(INPUT_GET, 'count', FILTER_SANITIZE_NUMBER_INT);
    $exclude_replies = filter_input(INPUT_GET, 'exclude_replies', FILTER_SANITIZE_SPECIAL_CHARS);
    $list_slug = filter_input(INPUT_GET, 'list_slug', FILTER_SANITIZE_SPECIAL_CHARS);
    $hashtag = filter_input(INPUT_GET, 'hashtag', FILTER_SANITIZE_SPECIAL_CHARS);
    
    /**
     * Gets connection with user Twitter account
     * @param  String $cons_key     Consumer Key
     * @param  String $cons_secret  Consumer Secret Key
     * @param  String $oauth_token  Access Token
     * @param  String $oauth_secret Access Secrete Token
     * @return Object               Twitter Session
     */
    function getConnectionWithToken($cons_key, $cons_secret, $oauth_token, $oauth_secret){
      $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_secret);
      return $connection;
    }
    
    // Connect
    $connection = getConnectionWithToken(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_SECRET);
    
    // Get Tweets

    $params = array(
        'count' => $value['count_tweet'] + 1,
        'exclude_replies' => 'true',
        'screen_name' => $value['username']
    );

    $url = '/statuses/user_timeline';

    $tweets = $connection->get($url, $params);

    $row = 0;
    $col = 0;

    if(is_array($tweets)){
      foreach ($tweets as $tweet) {
        $list_box_contents[$row][$col] = array(
          'params'  => 'class="pt-carousel-item item-standard"',
          'text'    => '<div class="pt-carousel-item"><div class="tweet-avatar"><img src="' . $tweet->user->profile_image_url_https . '" alt="' . $tweet->user->screen_name . '" class="img-circle"></div><p class="tweet-text">' . $tweet->text . '</p><p class="tweet-date"><i class="fa fa-twitter"></i> ' . date('D, j F Y',strtotime($tweet->created_at)) . '</p></div>'
        );
        $col++;
      }
    }
  }

