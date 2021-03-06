<?php
if ($Self->auth) {
    $UserInfo = $Core->UserInfo($Self->data['accid']);
}
?>
<!DOCTYPE html>
<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <base href="<?= domain ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $assets ?>site/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= $assets ?>site/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $assets ?>site/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= $assets ?>site/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= $assets ?>site/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= $assets ?>site/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= $assets ?>site/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= $assets ?>site/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $assets ?>site/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= $assets ?>site/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $assets ?>site/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= $assets ?>site/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $assets ?>site/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?= $assets ?>site/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= $assets ?>site/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="GOLOJAN">
    <title>Super Odds Admin</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="<?= $assets ?>css\pos1.scss">
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body>
