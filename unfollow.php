<?php

session_start();
include "config.php";

require "vendor/TwitterOAuth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;


    $accessToken = $_SESSION['access_token'];
    $connectionOauth = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
    $connectionOauth->setTimeouts(30, 30);

    $followers = $connectionOauth->get("followers/list" , array('count' => 200));
    $connectionOauth->post('friendships/destroy',
                          array('screen_name' => $followers->screen_name,'follow'=>true));
