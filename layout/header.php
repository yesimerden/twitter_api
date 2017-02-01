<?php

session_start();
include "config.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Twitter</title>
    <link rel="stylesheet" href="css/twitter.css"/>
    <link rel="shortcut icon" href="images/favicon.png">

</head>
<body>

<header>
    <div class="container">
        <div id="logo">
            <h2><a href="index"> <span class="baslık">Twitter</span> </a></h2>
        </div>
    </div>
</header>

<nav class="sol">  <!-- menüyü oluşturduk. yönlendirmeleri sayfalara tanımladık -->
    <ul class="navul">
        <li class="navli"><a class="nava" href="index"> Ana Sayfa </a> </li>
        <li class="navli"><a class="nava" href="profile">Profilim </a> </li>
        <li class="navli"><a class="nava" href='following'>Takip Edilen</a></li>
        <li class="navli"><a class="nava" href='followers'>Takipçiler</a></li>
        <li class="navli"><a class="nava" href='logout'>Çıkış</a></li>
    </ul>
</nav>


<div class="container">
