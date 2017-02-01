<?php

include "layout/header.php";

require "vendor/TwitterOAuth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

if (!isset($_SESSION['access_token']))
{
  include 'login.php';
}
else
{
  $accessToken = $_SESSION['access_token'];
  $connectionOauth = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
  $connectionOauth->setTimeouts(30, 30);

  $accountCredentials = $connectionOauth->get("account/verify_credentials");
  $screen_Name = $accountCredentials->screen_name;

  $profileBanner=$connectionOauth->get("users/profile_banner",array('screen_name'=> $screen_Name));

  $banner=$profileBanner->sizes->web;
  echo"<div id ='leftColumn'>
  <img src='$banner->url' alt='$accountCredentials->name' title='$accountCredentials->name' id='profileBanner' />
  <img src='$accountCredentials->profile_image_url' alt='$accountCredentials->name' title='$accountCredentials->name' id='profileImage' />
  <hroup>
  <h6>$accountCredentials->name <span>(@$accountCredentials->screen_name)</span></h6>
  <h6> Tweetler :<span> $accountCredentials->statuses_count </span></h6>
  <h6> Takip Edilen :<span> $accountCredentials->friends_count </span></h6>
  <h6> Takipçiler :<span> $accountCredentials->followers_count </span></h6>
  </hroup>
  <div class='clear'></div>
  <span> $accountCredentials->description </span>
  </div>

  <div id ='rightColumn'>
  Tweet Gönder (140 Karakter) <br/><br/>
  <textarea class='tweet' id='tweet'> </textarea>
  <br/><br/>
  <input type='button' value='Tweet Gönder' onclick='tweetPost()'/>
  <div id='resultTweet'></div>
  <div class='clear'></div>
  <br/>
  <div class='clear'></div>
  <div class='wall'>
  <br/>
  <h1 class='title'>Takipçiler</h1> ";

  $followers = $connectionOauth->get("followers/list" , array('count' => 200));
  $friendship= $connectionOauth->get("friendship/show");

  foreach ($followers->users as $follower) {
    $screenName=$follower->screen_name;
    echo "<div class ='data'>
    <img src='$follower->profile_image_url' alt='$follower->name' title='$follower->name' id='userImage'/>
    <h3>$follower->name</h3>
    <h3><a href='user.php?screenname=$screenName'>@$screenName</a></h3>
    </div>
    ";
    // echo "<div>";
    // if($friendship->following==false)
    // {
    //   echo "<div id='follow'><input type='button' class='follow' value='Follow' onclick='follow()' /></div>";
    //   echo "<div id='remove' style='display:none'><input type='button' class='remove' value='Following' onclick='unfollow()'/></div>";
    // }
    // else
    // {
    //   echo "<div id='follow' style='display:none'><input type='button' class='follow' value='Follow' onclick='follow()' /></div>";
    //   echo "<div id='remove'><input type='button' class='remove' value='Following' onclick='unfollow()'/></div>";
    // }"
    // };
}

  echo "</div>";

}

include "layout/footer.php";
