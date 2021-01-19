<!-- include Meta -->
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport'>
	<meta name="viewport" content="width=device-width">
	<base href="<?= domain ?>" />
	<title>
		<?= $title ?>
	</title>

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


	<link rel="stylesheet" type="text/css" href="<?= $assets ?>site\widget\main-style.css">
	<link rel="stylesheet" type="text/css" href="<?= $assets ?>site\widget\widgetCountries.css">

	<link rel="stylesheet" href="<?= $assets ?>site/css\slick.css">
	<link rel="stylesheet" href="<?= $assets ?>site/css\slick-theme.css">
	<link rel="stylesheet" href="<?= $assets ?>site/css\odometer-theme-default.css">
	<link rel="stylesheet" href="<?= $assets ?>site/css\jquery.fancybox.css">
	<link rel="stylesheet" href="<?= $assets ?>css\pos1.scss">
	<link rel="stylesheet" href="<?= $assets ?>site/css\main.css">

	<script src="<?= $assets ?>site\widget\jqueryGlobals.js"></script>
	<script src="<?= $assets ?>site\widget\jquery.widgetCountries.js" type="text/javascript"></script>


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn’t work if you view the page via file:// -->

	<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="headerMenuDisplay">
	<!-- include Header -->
	<header>
		<div class="wrapper">
			<div class="logo icon-logo pull_left">
				<a href="/">
					<img style="height: 50px; margin-bottom:3px;" src="<?= $assets ?>site\images\index\logo-head.png">
				</a>
			</div>
			<div class="icon account pull_right">
				<a href="/auth/login"></a>
				<span class="username">Agent Login</span>
			</div>
			<div class="icon message pull_right notify"><a data-fancybox="" data-src="#playbox" href="javascript:;" target="mainframe"></a>MESSAGE</div>
			<div class="icon livechat pull_right">info@antosplashbet.com</div>
		</div>


	</header>
	<!-- include Header -->
	<nav>
		<div class="wrapper">
			<a href="/">
				<div class="link <?= $menukey == 'home' ? 'onfocus' : '' ?>">HOME</div>
			</a>
			<a href="/pages/games">
				<div class="link <?= $menukey == 'games' ? 'onfocus' : '' ?>">GAMES & PREDICTIONS</div>
			</a>
			<a href="/pages/winnings">
				<div class="link <?= $menukey == 'winnings' ? 'onfocus' : '' ?>">WINNING ODDS & RESULTS</div>
			</a>
			<a href="/pages/contact-us">
				<div class="link <?= $menukey == 'contact-us' ? 'onfocus' : '' ?>">HELP CENTER</div>
			</a>
			<a href="/pages/track">
				<div class="link <?= $menukey == 'track' ? 'onfocus' : '' ?>">TRACK YOUR GAME</div>
			</a>
			<div class="money pull_right">
				<form action="/form/trackgame" method="post">
					<?= $Self->tokenize() ?>
					<span class="currency"><input type="text" name="ticket" id="ticket" style="margin: 0; font-size: 20px; text-align: center; width: 200px;;"></span>
					<button type="submit" class="btn green charge" style="margin: 0;">Track Bet</button>
				</form>
			</div>
		</div>

	</nav>