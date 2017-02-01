<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "layout/header.php";
 /*
  * header diğer sayfalarda ortak olduğundan include ederek aldım.
 */
require "vendor/TwitterOAuth/autoload.php"; /* kütüphanesini ekledik. */
use Abraham\TwitterOAuth\TwitterOAuth;      /* Kütüphaneyi kullanmak için use komutunu kullandık.*/

if (!isset($_SESSION['access_token'])) { /*eğer access_token yoksa login php sayfasını include ettik.*/
    include 'login.php';
}
else /* giriş yapılmışsa (access_token) varsa buradan devam edecek */
{
    $accessToken = $_SESSION['access_token'];
    $connectionOauth = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
    $connectionOauth->setTimeouts(30, 30);
    /*
     * Üstteki 3 satır apidenaldığımız json veriyi çekmek için gerekli
     */

    $accountCredentials = $connectionOauth->get("account/verify_credentials");
    /*
     * kullanıcı bilgilerini aldık api ile, apiden aldığım json verileri aşağı kısımda bu aldıklarımı yazdırdım .
    */
    $screen_Name = $accountCredentials->screen_name;

    $profileBanner=$connectionOauth->get("users/profile_banner",array('screen_name'=> $screen_Name));

    $banner=$profileBanner->sizes->web;
    echo"
        <div id ='leftColumn'> <!-- sayfanın sonunda profil bilgilerini yerleştirdim -->
            <img src='$banner->url' alt='$accountCredentials->name' title='$accountCredentials->name' id='profileBanner' />
            <img src='$accountCredentials->profile_image_url' alt='$accountCredentials->name' title='$accountCredentials->name' id='profileImage' />
        <div>
                <h6>$accountCredentials->name <a href='profile'>(@$accountCredentials->screen_name)</a></h6>
                <h6> Tweetler :<span> $accountCredentials->statuses_count </span></h6>
                <h6> Takip Edilen :<span> $accountCredentials->friends_count </span></h6>
                <h6> Takipçiler :<span> $accountCredentials->followers_count </span></h6>
            </div>
            <div class='clear'></div>
            <span> $accountCredentials->description </span>
            <br>
            <br>
            <br>
            <h2 class='title'>Trend Topics</h2>
            <br>";
    $basliklar = $connectionOauth->get("https://api.twitter.com/1.1/trends/place.json?id=1");
    $baslik=array();
    $baslik=json_decode(json_encode($basliklar),true);
    // $decode = json_decode($basliklar, true);
    // echo $decode;

    $globalTrends= $baslik[0]->trends;


    foreach ($globalTrends as $trend) {
        echo $trend['name'];
    }

        echo"</div>

        <div id ='rightColumn'> <!--sayfanın sağına tweet atma ve ana sayfayı yerleştirdik-->
            Tweet Gönder (140 Karakter) <br/><br/>
            <textarea class='tweet' id='tweet'> </textarea>
            <br/><br/>
            <input type='button' value='Tweet Gönder' onclick='tweetPost()'/>
            <div id='resultTweet'></div>
            <div class='clear'></div>
            <br/>
        <div class='clear'></div>

        ";

    $homeTimeline = $connectionOauth->get("statuses/home_timeline");

    echo "<div class='wall'>
          <br/>
          <h1 class='title'>Tweetler</h1>
          ";

    foreach ($homeTimeline as $timeLine) {
        $userName = $timeLine->user->name;
        $userImg = $timeLine->user->profile_image_url;
        @$Image = $timeLine->entities->media['0']->media_url;
        $screenName=$timeLine->user->screen_name;

        echo "
            <div class ='data'>
                <img src='$userImg' alt='$userName' title='$userName' id='userImage'/>
                <h3>$userName</h3>
                <h3><a href='user.php?screenname=$screenName'>@$screenName</a></h3>

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
