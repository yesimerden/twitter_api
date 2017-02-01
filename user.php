<?php
include "layout/header.php";
require "vendor/TwitterOAuth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
if (!isset($_SESSION['access_token'])) {
    include 'login.php';
}
else
{
    $accessToken = $_SESSION['access_token'];
    $connectionOauth = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
    $connectionOauth->setTimeouts(30, 30);

    $screen_Name = $_GET['screenname'];
    $_SESSION[$screen_Name] = $_GET['screenname'];

    $userInfo = $connectionOauth->get("users/show",array('screen_name' => $screen_Name));

    $profileBanner=$connectionOauth->get("users/profile_banner",array('screen_name'=> $screen_Name));

    $banner=$profileBanner->sizes->web;
    echo"
          <div id ='leftColumn'>
          <img src='$banner->url' alt='$userInfo->name' title='$userInfo->name' id='profileBanner' />
          <img src='$userInfo->profile_image_url' alt='$userInfo->name' title='$userInfo->name' id='profileImage' />
              <hroup>
                  <h6>$userInfo->name <span>(@$userInfo->screen_name)</span></h6>
                  <h6> Tweetler :<span> $userInfo->statuses_count </span></h6>
                  <h6> Takip Edilen :<span> $userInfo->friends_count </span></h6>
                  <h6> Takipçiler :<span> $userInfo->followers_count </span></h6>
              </hroup>
              <div class='clear'></div>
              <span> $userInfo->description </span>
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
        ";

    echo "<div class='wall'>
          <br/>
          <h1 class='title'>Tweetler</h1>";

          $userTimeline = $connectionOauth->get("statuses/user_timeline",array('count'=>50,'screen_name' => $screen_Name));
    foreach ($userTimeline as $usertimeLine) {

        $userName = $usertimeLine->user->name;
        $userImg = $usertimeLine->user->profile_image_url;
        @$Image = $usertimeLine->entities->media['0']->media_url;
        echo "
            <div class ='data'>
                <img src='$userImg' alt='$userName' title='$userName' id='userImage'/>
                <h3>$userName</h3>
                <div class='clear'></div>
                <h2>$usertimeLine->text</h2>
                <br/>
                <img src='$Image' alt=''/>
            </div>
            ";
    }

    echo "</div>";

}

include "layout/footer.php";
