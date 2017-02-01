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

    $accountCredentials = $connectionOauth->get("account/verify_credentials");
    $screen_Name = $accountCredentials->screen_name;

    $profileBanner=$connectionOauth->get("users/profile_banner",array('screen_name'=> $screen_Name));

    $banner=$profileBanner->sizes->web;
    echo"
        <div id ='leftColumn'>
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


        ";

    $myTimeline = $connectionOauth->get("statuses/user_timeline" , array('count' => 50));

    echo "<div class='wall'>
          </br>
          <h1 class='title'>Tweetler</h1>";

    foreach ($myTimeline as $timeLine) {
        $userName = $timeLine->user->name;
        $userImg = $timeLine->user->profile_image_url;
        @$Image = $timeLine->entities->media['0']->media_url;
        echo "
            <div class ='data'>
                <img src='$userImg' alt='$userName' title='$userName' id='userImage'/>
                <h3>$userName</h3>
                <div class='clear'></div>
                <h2>$timeLine->text</h2>
                <br/>
                <img src='$Image' alt=''/>
            </div>
            ";
    }

    echo "</div>";

}

include "layout/footer.php";
