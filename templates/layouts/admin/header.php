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

    <!--Data Tables -->
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.jqueryui.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="<?= $assets ?>css\pos1.scss">
    <link rel="stylesheet" href="<?= $assets ?>css\app.css">
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body class="app">
    <!-- BEGIN: Mobile Menu -->
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="/dashboard" class="flex mr-auto">
                <img alt="SupperOdds" style="height: 50px; margin-bottom:3px;" src="<?= $assets ?>images\logo.png">
            </a>
            <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        </div>
        <ul class="border-t border-theme-24 py-5 hidden">

            <?php if ($UserInfo->role == "agent") : ?>

                <li>
                    <a href="/dashboard/shop" class="menu <?= $menukey == 'shop' ? 'menu--active' : '' ?>">
                        <div class="menu__icon"> <i data-feather="slack"></i> </div>
                        <div class="menu__icon"> My Shop </div>
                    </a>
                </li>

            <?php elseif ($UserInfo->role == "admin") : ?>
            <?php endif; ?>



            <li>
                <a href="/dashboard" class="menu  <?= $menukey == 'dashboard' ? 'menu--active' : '' ?>">
                    <div class="menu__icon"> <i data-feather="home"></i> </div>
                    <div class="menu__title"> Dashboard </div>
                </a>
            </li>

            <li>
                <a href="/dashboard/accounts" class="menu <?= $menukey == 'accounts' ? 'menu--active' : '' ?>">
                    <div class="menu__icon"> <i data-feather="users"></i> </div>
                    <div class="menu__title"> Account & Users </div>
                </a>
            </li>

            <li>
                <a href="/dashboard/payments" class="menu <?= $menukey == 'payments' ? 'menu--active' : '' ?>">
                    <div class="menu__icon"> <i data-feather="credit-card"></i> </div>
                    <div class="menu__title"> Transactions & Payments </div>
                </a>
            </li>
            <li class="menu__devider my-6"></li>

            <?php if ($UserInfo->role == "admin") : ?>
                <li>
                    <a href="/dashboard/agents" class="menu <?= $menukey == 'agents' ? 'menu--active' : '' ?>">
                        <div class="menu__icon"> <i data-feather="users"></i> </div>
                        <div class="menu__title"> Manage Agents </div>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/odds" class="menu <?= $menukey == 'odds' ? 'menu--active' : '' ?>">
                        <div class="menu__icon"> <i data-feather="hard-drive"></i> </div>
                        <div class="menu__title"> Odds & Games </div>
                    </a>
                </li>
            <?php elseif ($UserInfo->role == "agent") : ?>
            <?php endif; ?>



        </ul>
    </div>
    <!-- END: Mobile Menu -->
    <!-- BEGIN: Top Bar -->
    <div class="border-b border-theme-24 -mt-10 md:-mt-5 -mx-3 sm:-mx-8 px-3 sm:px-8 pt-3 md:pt-0 mb-10">
        <div class="top-bar-boxed flex items-center">
            <!-- BEGIN: Logo -->
            <a href="/dashboard" class="-intro-x hidden md:flex">
                <img alt="SupperOdds.com" class="w-10" src="<?= $assets ?>images\logo.png">
                <span class="text-white text-lg ml-3"> AntoSplashBet </span>
            </a>
            <!-- END: Logo -->
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb breadcrumb--light mr-auto"> <a href="/dashboard" class="">Application</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="/dashboard" class="breadcrumb--active">Dashboard</a> </div>
            <!-- END: Breadcrumb -->
            <!-- BEGIN: Search -->
            <div class="intro-x relative mr-3 sm:mr-6">
                <div class="search hidden sm:block">
                    <input type="text" class="search__input input dark:bg-dark-1 placeholder-theme-13" placeholder="Search...">
                    <i data-feather="search" class="search__icon dark:text-gray-300"></i>
                </div>
                <a class="notification notification--light sm:hidden" href=""> <i data-feather="search" class="notification__icon dark:text-gray-300"></i> </a>
                <div class="search-result">
                    <div class="search-result__content">
                        <div class="search-result__content__title">Pages</div>
                        <div class="mb-5">
                            <a href="javascript:;" class="flex items-center">
                                <div class="w-8 h-8 bg-theme-18 text-theme-9 flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-feather="inbox"></i> </div>
                                <div class="ml-3">Mail Settings</div>
                            </a>
                            <a href="javascript:;" class="flex items-center mt-2">
                                <div class="w-8 h-8 bg-theme-17 text-theme-11 flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-feather="users"></i> </div>
                                <div class="ml-3">Users & Permissions</div>
                            </a>
                            <a href="javascript:;" class="flex items-center mt-2">
                                <div class="w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-feather="credit-card"></i> </div>
                                <div class="ml-3">Transactions Report</div>
                            </a>
                        </div>
                        <div class="search-result__content__title">Users</div>
                    </div>
                </div>
            </div>
            <!-- END: Search -->


            <!-- BEGIN: Account Menu -->
            <div class="intro-x dropdown w-8 h-8 relative">
                <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110">
                    <img alt="Midone Tailwind HTML Admin Template" src="<?= $assets ?>images\profile-10.jpg">
                </div>
                <div class="dropdown-box mt-10 absolute w-56 top-0 right-0 z-20">
                    <div class="dropdown-box__content box bg-theme-38 dark:bg-dark-6 text-white">
                        <div class="p-4 border-b border-theme-40 dark:border-dark-3">
                            <div class="font-medium"><?= $UserInfo->fullname ?></div>
                            <div class="text-xs text-theme-41 dark:text-gray-600">Anto Splash Bet <?= ucfirst($UserInfo->role) ?></div>
                        </div>
                        <div class="p-4 border-b border-theme-40 dark:border-dark-3">
                            <div class="font-medium">Available Balance</div>
                            <div class="text-xs text-theme-41 dark:text-gray-600"><?= $Core->Monify($UserInfo->credit) ?></div>
                        </div>
                        <div class="p-2 border-t border-theme-40 dark:border-dark-3">
                            <a href="/auth/logout" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Account Menu -->
        </div>
    </div>
    <!-- END: Top Bar -->
    <!-- BEGIN: Top Menu -->
    <nav class="top-nav">
        <ul>

            <?php if ($UserInfo->role == "agent") : ?>
                <li>
                    <a href="/dashboard/shop" class="top-menu <?= $menukey == 'shop' ? 'top-menu--active' : '' ?>">
                        <div class="top-menu__icon"> <i data-feather="slack"></i> </div>
                        <div class="top-menu__title"> My Shop </div>
                    </a>
                </li>
            <?php elseif ($UserInfo->role == "admin") : ?>
            <?php endif; ?>

            <li>
                <a href="/dashboard" class="top-menu <?= $menukey == 'dashboard' ? 'top-menu--active' : '' ?>">
                    <div class="top-menu__icon"> <i data-feather="home"></i> </div>
                    <div class="top-menu__title"> Dashboard </div>
                </a>
            </li>
            <li>
                <a href="/dashboard/accounts" class="top-menu <?= $menukey == 'accounts' ? 'top-menu--active' : '' ?>">
                    <div class="top-menu__icon"> <i data-feather="users"></i> </div>
                    <div class="top-menu__title"> Account & Users </div>
                </a>
            </li>

            <li>
                <a href="/dashboard/payments" class="top-menu <?= $menukey == 'payments' ? 'top-menu--active' : '' ?>">
                    <div class="top-menu__icon"> <i data-feather="credit-card"></i> </div>
                    <div class="top-menu__title"> Transactions & Payments </div>
                </a>
            </li>

            <li class="menu__devider my-6"></li>

            <?php if ($UserInfo->role == "admin") : ?>
                <li>
                    <a href="/dashboard/agents" class="top-menu <?= $menukey == 'agents' ? 'top-menu--active' : '' ?>">
                        <div class="top-menu__icon"> <i data-feather="users"></i> </div>
                        <div class="top-menu__title"> Manage Agents </div>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/odds" class="top-menu <?= $menukey == 'odds' ? 'top-menu--active' : '' ?>">
                        <div class="top-menu__icon"> <i data-feather="hard-drive"></i> </div>
                        <div class="top-menu__title"> Odds & Games </div>
                    </a>
                </li>
            <?php elseif ($UserInfo->role == "agent") : ?>
            <?php endif; ?>


        </ul>
    </nav>
    <!-- END: Top Menu -->