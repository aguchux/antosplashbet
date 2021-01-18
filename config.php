<?

/*
 * Copyright (C) 2014-2013 Golojan IBS Corp. (www.golojan.com)
 * Distributed under the terms of the license described in COPYING
 */
// constants

define("supper", 1);

define("version", "2.0.0");
define("main_site_logo", "large"); //or 'small'
define("small_logo_height", 30);
define("large_logo_height", 60);

define("debug", true);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

define('DIR', __DIR__);
define("display_error", true);
define("language", "en_US");
define("appname", "ZantPHP");
define("url", __DIR__);
define("baseurl", __DIR__);
define("apps_dir", "./_apps/");
define("templates_dir", "./templates/");

define("templates_default", "404");
define("templates_default_route", "/error/404/");

define("vendor_dir", "./vendor/");
define("bower_dir", "./bower_components/");

define("assets_dir", "./templates/assets/");
define("layouts_dir", "./templates/layouts/");
define("template_file_extension", "php");
define("store_dir", "./_store/");
define("public_dir", "./_public/");
define("server", "remote");
define("use_token_security", true);
define("encrypt_salt", "7WAO342QFANY6IKBF7L7SWEUU79WL3VMT920VB5NQMW");
define("default_timezone", "Africa/Lagos");
define("offset_timezone", true);
define("session_path", "./_sessions/");
define("session_timout", 20);
define("session_delete_timout", 30);
define("auth_session_key", "logged_in");
define("auth_url", "/auth/login");
define("num_results_on_page", 5);

define("domain", "https://antosplashbet.com/");

define("db_host", "107.182.235.44");
define("db_user", "zuxvirll_axdir");
define("db_password", "q0DU50X8pwzSCAlttG3455k27lXCD3nDm");
define("db", "zuxvirll_axdir");

define("enable_otp_on_logon", true);
define("otp_live_time", 1);
define("otp_code_digits", 6);

define("use_express_login", true);
define("reset_with_temp_password", true);

define("smslive_owner_email", "agu.chux@yahoo.com");
define("smslive_subaccount", "EBSGFINANCE");
define("smslive_subaccount_password", "q0DU50X8pwzSCAlttGOryk27XBxjylXCD3nDm");
define("smslive_api_key", "acdd4023-b6af-4479-a8a7-9ee45278c319");

define("smslive_callback_url", "http://antosplashbet.com/auth/smslive247/callback");

define("notix_name", "Antosplashbet");
define("notix_email", "antosplashbet@gmail.com");