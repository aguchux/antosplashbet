<?php


define('DOT', '.');
require_once DOT . "/bootstrap.php";

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;

//Home page//
$Route->add(
    '/',
    function () {

        $Core = new Apps\Core;
        $Template = new Apps\Template("/auth/login");
        $Template->assign("title", "Welcome to Anto Splash Bet");
        $Template->addheader("layouts.site.header");
        $Template->addfooter("layouts.site.footer");
        $Template->assign("HomeOdds", $Core->HomeOdds(6));
        $Template->assign("menukey", "home");
        $Template->render("home");
    },
    'GET'
);
//Home page//

$Route->add(
    '/cron/play',
    function () {
        $Core = new Apps\Core;
        $Odds = $Core->UnPlayedOdds();
        while ($odd = mysqli_fetch_object($Odds)) {

            $playdate = $odd->playdate;

            $playdate_hrs = str_pad($odd->playdate_hrs, 2, '0', STR_PAD_LEFT);
            $playdate_mins = str_pad($odd->playdate_mins, 2, '0', STR_PAD_LEFT);

            $playdate = "{$playdate} {$playdate_hrs}:{$playdate_mins}:00 {$odd->playdate_period}";
            $playdate = date("Y-m-d g:i:s A", strtotime($playdate));

            $tik_palydate = strtotime($playdate);
            $cycle = $Core->PlayTime($tik_palydate);

            if ($cycle <= 1) {
                $Core->SetOddsInfo($odd->id, "played", 1);
                $Core->SetOddsInfo($odd->id, "dateplayed", time());


                $subject = "Odd #{$odd->id} has just played";
                $body = "
                   Odd #{$odd->id} has just played
                ";

                $Core->sendMail(notix_email, notix_name, $subject, $body);
            }
        }
    },
    'GET'
);


$Route->add(
    '/reciept/test',
    function () {

        $Core = new Apps\Core;
        $Template = new Apps\Template;
        try {
            // Enter the share name for your USB printer here
            $connector = null;
            //$connector = new WindowsPrintConnector("Receipt Printer");

            /* Print a "Hello world" receipt" */
            $connector = new CupsPrintConnector("ZJ-58");
            $printer = new Printer($connector);
            $printer->text("Hello World!\n");

            $printer->cut();
            $printer->close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    },
    'GET'
);


$Route->add(
    '/pages/{page}',
    function ($page) {

        $Core = new Apps\Core;
        $Template = new Apps\Template;
        $Template->assign("title", "Welcome to Supper Odds");
        $Template->addheader("layouts.site.header");
        $Template->addfooter("layouts.site.footer");
        $Template->assign("menukey", $page);

        switch ($page) {
            case 'games':
                $Template->assign("HomeOdds", $Core->HomeOdds());
                break;
            case 'winnings':
                $Template->assign("HomeOdds", $Core->PlayedOdds());
                break;
        }



        $Template->render("{$page}");
    },
    'GET'
);


$Route->add(
    '/pages/{ticket}/track',
    function ($ticket) {

        $Core = new Apps\Core;
        $Template = new Apps\Template;
        $Template->assign("title", "Welcome to Supper Odds");
        $Template->addheader("layouts.site.header");
        $Template->addfooter("layouts.site.footer");
        $Template->assign("menukey", "track");
        $Template->assign("ticket", $ticket);
        $TransactionInfo = $Core->TransactionInfo($ticket);
        $Template->assign("TransactionInfo", $TransactionInfo);

        $ThisOddInfo = $Core->OddsInfo($TransactionInfo->odd);
        $Template->assign("ThisOddInfo", $ThisOddInfo);

        $MyClient = $Core->ClientInfo($TransactionInfo->clientid);
        $Template->assign("MyClient", $MyClient);

        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $BarCode = $generator->getBarcode($TransactionInfo->id, $generator::TYPE_CODE_93);
        $Template->assign("BarCode", $BarCode);

        $Template->assign("HomeOdds", $Core->Odds());

        $Template->render("track");
    },
    'GET'
);



$Route->add(
    '/form/trackgame',
    function () {

        $Core = new Apps\Core;
        $Template = new Apps\Template;
        $data = $Core->post($_POST);

        $ticket = $data->ticket;
        $TransactionInfo = $Core->TransactionInfo($ticket);
        $id = $TransactionInfo->id;
        if (isset($id)) {
            $Template->redirect("/pages/{$id}/track");
        } else {
            $Template->redirect("/pages/track");
        }
    },
    'POST'
);



$Route->add(
    '/auth/login',
    function () {
        $Template = new Apps\Template;
        $Template->assign("title", "Login - Anto Splash Bet");
        $Template->addheader("layouts.admin.auth-header");
        $Template->addfooter("layouts.admin.footer");
        $Template->render("login");
    },
    'GET'
);


$Route->add(
    '/auth/fundsout',
    function () {
        $Template = new Apps\Template;
        $Template->assign("title", "Out of funds - Anto Splash Bet");
        $Template->addheader("layouts.admin.auth-header");
        $Template->addfooter("layouts.admin.footer");
        $Template->render("fundsout");
    },
    'GET'
);


$Route->add(
    '/form/auth/login',
    function () {

        $Core = new Apps\Core;
        $Template = new Apps\Template;
        $data = $Core->post($_POST);

        $email = $data->email;
        $password = $data->password;

        $Login = $Core->UserLogin($email, $password);
        if ((int)$Login->accid) {
            if ((int)$Login->enabled) {
                $Template->authorize($Login->accid);
                $Template->redirect("/dashboard");
            }
            $Template->redirect("/auth/login");
        }
        $Template->redirect("/auth/login");
    },
    'POST'
);

$Route->add(
    '/form/dashboard/updateagent/{agentid}',
    function ($agentid) {

        $Core = new Apps\Core;
        $Template = new Apps\Template("/auth/login");
        $data = $Core->post($_POST);

        $enabled = 0;
        if (isset($data->enabled)) {
            $enabled = 1;
        }
        $Core->SetUserInfo($agentid, "enabled", $enabled);

        $fullname = $data->fullname;
        $Core->SetUserInfo($agentid, "fullname", $fullname);

        $email = $data->email;
        $Core->SetUserInfo($agentid, "email", $email);

        $mobile = $data->mobile;
        $Core->SetUserInfo($agentid, "mobile", $mobile);

        $password = $data->logon;
        $Core->SetUserInfo($agentid, "password", $password);

        $isadmin = false;
        $role = "agent";
        if (isset($data->isadmin)) {
            $isadmin = true;
            $role = "admin";
        }

        $Core->SetUserInfo($agentid, "is_admin", $isadmin);
        $Core->SetUserInfo($agentid, "role", $role);

        $Template->redirect("/dashboard/agents/{$agentid}/manage");
    },
    'POST'
);


$Route->add(
    '/form/dashboard/addfund/{agentid}',
    function ($agentid) {

        $Core = new Apps\Core;
        $Template = new Apps\Template("/auth/login");
        $data = $Core->post($_POST);
        $accid = $Template->data['accid'];

        $amount = $data->credit;

        $Agent = $Core->UserInfo($agentid);
        $abc = floatval($Agent->credit);
        $aac = floatval($amount + $abc);

        $Core->CreditAgent($agentid, $abc, $amount, $aac, $accid);
        $Core->SetUserInfo($agentid, "credit", $aac);

        $Template->redirect("/dashboard/agents/{$agentid}/manage");
    },
    'POST'
);



$Route->add(
    '/auth/register',
    function () {
        $Template = new Apps\Template;
        $Template->assign("title", "Register - AntoSplashBet.com");
        $Template->addheader("layouts.admin.auth-header");
        $Template->addfooter("layouts.admin.footer");
        $Template->render("register");
    },
    'GET'
);


$Route->add(
    '/auth/reset',
    function () {
        $Template = new Apps\Template;
        $Template->assign("title", "Reset Password - AntoSplashBet.com");
        $Template->addheader("layouts.admin.auth-header");
        $Template->addfooter("layouts.admin.footer");
        $Template->render("reset");
    },
    'GET'
);

$Route->add(
    '/form/auth/reset',
    function () {

        $Core = new Apps\Core;
        $Template = new Apps\Template;
        $data = $Core->post($_POST);

        $Template->redirect("/auth/login");
    },
    'POST'
);



$Route->add(
    '/form/dashboard/agents/add',
    function () {

        $Core = new Apps\Core;
        $Template = new Apps\Template;
        $createdby = $Template->data['accid'];

        $data = $Core->post($_POST);
        $fullname = $data->fullname;
        $email = $data->email;
        $mobile = $data->mobile;
        $password = $data->logon;

        $role = "agent";
        $isadmin = false;
        if (isset($data->isadmin)) {
            $role = "admin";
            $isadmin = true;
        }

        $agentid = $Core->AddAgent($fullname, $email, $mobile, $password, $createdby, $role, $isadmin);
        if ($agentid) {
            $Template->redirect("/dashboard/agents/{$agentid}/manage");
        }
        $Template->redirect("/dashboard/agents");
    },
    'POST'
);


$Route->add(
    '/form/dashboard/odds/add',
    function () {

        $Core = new Apps\Core;
        $Template = new Apps\Template;
        $accid = $Template->data['accid'];

        $data = $Core->post($_POST);

        $home = $data->home;
        $away = $data->away;
        $odds = $data->odds;
        $playdate = $data->playdate;

        $win = false;
        if (isset($data->winning)) {
            $win = 1;
        }

        $playdate = $data->playdate;
        $playdate_hrs = $data->playdate_hrs;
        $playdate_mins = $data->playdate_mins;
        $playdate_period = $data->playdate_period;

        $windate_hrs = $data->windate_hrs;
        $windate_mins = $data->windate_mins;
        $windate_period = $data->windate_period;
        $windate = $data->windate;

        $oddid = $Core->AddNewOdd($home, $away, $odds, $win, $accid, $playdate, $playdate_hrs, $playdate_mins, $playdate_period, $windate, $windate_hrs, $windate_mins, $windate_period);
        if ($oddid) {
            $Template->redirect("/dashboard/odds/{$oddid}/manage");
        }

        $Template->redirect("/dashboard/ods");
    },
    'POST'
);


$Route->add(
    '/form/dashboard/odds/{oddid}/manage',
    function ($oddid) {

        $Core = new Apps\Core;
        $Template = new Apps\Template;
        $accid = $Template->data['accid'];

        $data = $Core->post($_POST);

        //$ThisOdd = $Core->OddsInfo($oddid);

        $home = $data->home;
        $Core->SetOddsInfo($oddid, "home", $home);
        $away = $data->away;
        $Core->SetOddsInfo($oddid, "away", $away);
        $odds = $data->odds;
        $Core->SetOddsInfo($oddid, "odds", $odds);

        $playdate_hrs = $data->playdate_hrs;
        $Core->SetOddsInfo($oddid, "playdate_hrs", $playdate_hrs);
        $playdate_mins = $data->playdate_mins;
        $Core->SetOddsInfo($oddid, "playdate_mins", $playdate_mins);
        $playdate_period = $data->playdate_period;
        $Core->SetOddsInfo($oddid, "playdate_period", $playdate_period);
        $playdate = $data->playdate;
        $Core->SetOddsInfo($oddid, "playdate", $playdate);

        $win = false;
        if (isset($data->winning)) {
            $win = 1;
        }
        $Core->SetOddsInfo($oddid, "win", $win);

        $Template->redirect("/dashboard/odds/{$oddid}/manage");
    },
    'POST'
);


$Route->add('/form/dashboard/doorder/{oddid}', function ($oddid) {

    $Core = new Apps\Core;
    $Template = new Apps\Template;
    $accid = $Template->data['accid'];

    $data = $Core->post($_POST);

    $fullname = $data->fullname;
    $email = $data->email;
    $mobile = $data->mobile;
    $amount = $data->amount;
    $paid = true;

    $use_this_client = null;
    if (isset($data->use_this_client)) {
        $use_this_client = $data->use_this_client;
        $Client = $Core->ClientInfo($use_this_client);
        $clientid = $Client->id;
    } else {
        $clientid = $Core->CreateClient($accid, $fullname, $email, $mobile);
    }
    if ($clientid) {
        $orderid = $Core->NewTransaction($accid, $clientid, $oddid, $amount, $paid);
        if ($orderid) {
            $Core->DebitAgent($accid, $amount);

            $Template->removedata("ThisClient");
            $Template->removedata("ThisOrder");

            $Template->redirect("/receipt/{$orderid}/print");



            //$Template->redirect("/dashboard/shop/transactions/{$orderid}/invoice");

        }
    }

    $Template->redirect("/dashboard/shop/odds/{$oddid}/play");
}, 'POST');




$Route->add('/form/dashboard/order/{oddid}', function ($oddid) {

    $Core = new Apps\Core;
    $Template = new Apps\Template;
    $accid = $Template->data['accid'];

    $data = $Core->post($_POST);
    $OddsInfo = $Core->OddsInfo($oddid);

    $fullname = $data->fullname;
    $email = $data->email;
    $mobile = $data->mobile;
    $amount = $data->amount;

    $UserInfo = $Core->UserInfo($accid);
    $credit =  (float) $UserInfo->credit;
    $_amount = (float) $amount;

    if($credit < $_amount){
        $Template->redirect("/auth/fundsout");
    }

    $paid = false;
    if (isset($data->paid)) {
        $paid = true;
    }

    $HasClient = $Core->SearchClient($mobile);

    if (!$HasClient) {
        //Client doesnt exist//
        $clientid = $Core->CreateClient($accid, $fullname, $email, $mobile);
        if ($clientid) {
            $orderid = $Core->NewTransaction($accid, $clientid, $oddid, $amount, $paid);
            if ($orderid) {
                $Core->DebitAgent($accid, $amount);


                $transid = $orderid;

                $TransactionInfo = $Core->TransactionInfo($transid);
                $Template->assign("TransactionInfo", $TransactionInfo);
                $MyClient = $Core->ClientInfo($TransactionInfo->clientid);
                $Template->assign("MyClient", $MyClient);

                $oddid = $TransactionInfo->odd;
                $ThisOddInfo = $Core->OddsInfo($oddid);
                $Template->assign("ThisOddInfo", $ThisOddInfo);

                $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                $BarCode = $generator->getBarcode($TransactionInfo->id, $generator::TYPE_CODE_93);
                $BarCode = "{$BarCode}";
                $Template->assign("BarCode", $BarCode);

                $PDF = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [100, 300]]);

                ob_start();
?>

                <!DOCTYPE html>
                <html lang="en" class="light">
                <!-- BEGIN: Head -->

                <head>
                    <meta charset="utf-8">
                    <base href="<?= domain ?>">
                    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
                    <!------ Include the above in your HEAD tag ---------->
                </head>

                <body style="padding: 0; margin: 5; color: #000000;">
                    <div id="invoice-POS">
                        <div class="text-center">
                            <div class="text-3xl">
                                <h2><small style="color:#000000;">Game I.D:</small><br /><?= $TransactionInfo->id ?></h2>
                            </div>
                            <div style="margin: 1px auto;font-size: 150%;">SUPPER ODDS GAMES</div>
                        </div>
                        <hr class="my-0 p-0" />
                        <div class="text-left" style="margin-left: 0px; font-size: 140%; padding-left:5px">
                            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Full Name:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $MyClient->fullname ?></p>
                            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Telephone:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $MyClient->mobile ?></p>
                        </div>
                        <div class="text-left" style="margin-left: 0px; font-size: 140%; padding-left:5px">
                            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Odd:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($ThisOddInfo->odds) ?></p>
                            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Stake:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($TransactionInfo->amount) ?></p>
                            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Winning:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($TransactionInfo->amount * $ThisOddInfo->odds)  ?></p>
                        </div>

                        <div class="text-left" style="margin-left: 0px; font-size: 140%; padding-left:5px">
                            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Stake Date:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $TransactionInfo->created ?></p>
                            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Draw Date:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $ThisOddInfo->playdate ?></p>
                            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Winning Date:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $ThisOddInfo->windate ?></p>
                        </div>

                    </div>
                    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
                    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

                </body>

                </html>

    <?php

                $HTMLoutput = ob_get_contents();
                ob_end_clean();
                $PDF->WriteHTML($HTMLoutput);
                $PDF->Output("./_store/transactions/{$transid}.pdf", 'D');
                $Template->assign("pdf_file", "./_store/transactions/{$transid}.pdf");



                $Template->redirect("/dashboard/shop/transactions/{$orderid}/invoice");
            }
        }
    } else {

        //Client exist in database//
        $Template->store("ThisClient", $Core->ClientInfo($mobile));
        $Template->store("ThisOrder", $data);

        $Template->redirect("/dashboard/shop/odds/{$oddid}/play?with_clients=true");



        //$Template->redirect("/dashboard/shop/odds/{$oddid}/play");
    }
}, 'POST');



$Route->add("/ajax/clients/get", function () {

    echo (999);
}, 'POST');


$Route->add('/ajax/data/agent-users', function () {

    $Core = new Apps\Core;

    $Template = new Apps\Template("/auth/login");
    $Template->addheader("layouts.admin.header");
    $Template->addfooter("layouts.admin.footer");

    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $role = $UserInfo->role;
    $data = array();
    switch ($role) {
        case 'agent':
            $Account = $Core->MyClients($accid);
            while ($user = mysqli_fetch_object($Account)) {
                $data[] = array(
                    'id' => $user->id,
                    'fullname' => $user->fullname,
                    'email' => $user->email,
                );
            }
            break;
        case 'admin':
            $Account = $Core->MyClients($accid);
            while ($user = mysqli_fetch_object($Account)) {
                $data[] = array(
                    'id' => $user->id,
                    'fullname' => $user->fullname,
                    'email' => $user->email,
                );
            }
            break;
    }

    print_r(json_encode($data));
}, 'POST');



$Route->add(
    '/dashboard',
    function () {
        $Core = new Apps\Core;
        $Template = new Apps\Template("/auth/login");

        $accid = $Template->data['accid'];
        $UserInfo = $Core->UserInfo($accid);
        $role = $UserInfo->role;

        switch ($role) {
            case 'agent':
                $Template->assign("Transactions", $Core->MyTransactions($Template->data['accid']));
                break;
            case 'admin':
                $Template->assign("Transactions", $Core->Transactions());
                $Template->assign("Agents", $Core->adminUsers());
                break;
        }

        $Template->addheader("layouts.admin.header");
        $Template->addfooter("layouts.admin.footer");
        $Template->assign("menukey", "dashboard");

        $Template->render("{$role}.dashboard");
    },
    'GET'
);



$Route->add('/dashboard/{page}', function ($page) {

    $Core = new Apps\Core;
    $Template = new Apps\Template("/auth/login");
    $Template->addheader("layouts.admin.header");
    $Template->addfooter("layouts.admin.footer");

    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $role = $UserInfo->role;

    $Template->assign("Agents", $Core->adminUsers());

    $Template->assign("menukey", $page);
    switch ($page) {
        case 'accounts':
            $MyClients = $Core->MyClients($accid);
            $Template->assign("MyClients", $MyClients);
            break;
        case 'agents':
            $AllAgents = $Core->adminUsers();
            $Template->assign("AllAgents", $AllAgents);
            break;
        case 'tickets':
            # code...
            break;
        case 'shop':
            $Template->assign("Transactions", $Core->MyTransactions($Template->data['accid']));
            $Template->assign("Odds", $Core->Odds());
            break;
        case 'odds':
            $Odds = $Core->AdminOdds();
            $Template->assign("Odds", $Odds);
            $MyTransactions = $Core->MyTransactions($Template->data['accid']);
            $Template->assign("Transactions", $MyTransactions);
            # code...
            break;
        case 'payments':
            $MyTransactions = $Core->MyTransactions($Template->data['accid']);
            $Template->assign("Transactions", $MyTransactions);
            break;
    }

    $Template->render("{$role}.{$page}");
}, 'GET');







$Route->add('/dashboard/shop/odds/{oddid}/play', function ($oddid) {

    $Core = new Apps\Core;
    $Template = new Apps\Template("/auth/login");
    $Template->addheader("layouts.admin.header");
    $Template->addfooter("layouts.admin.footer");

    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $role = $UserInfo->role;

    $Template->assign("menukey", "shop");

    $Template->assign("Transactions", $Core->MyTransactions($Template->data['accid']));
    $Template->assign("Agents", $Core->adminUsers());
    $Template->assign("Odds", $Core->Odds());
    $Template->assign("OddsInfo", $Core->OddsInfo($oddid));


    $Template->render("{$role}.shop");
}, 'GET');


$Route->add('/dashboard/shop/transactions/{transid}/invoice', function ($transid) {

    $Core = new Apps\Core;
    $Template = new Apps\Template("/auth/login");
    $Template->addheader("layouts.admin.header");
    $Template->addfooter("layouts.admin.footer");

    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $role = $UserInfo->role;

    $TransactionInfo = $Core->TransactionInfo($transid);
    $Template->assign("TransactionInfo", $TransactionInfo);
    $ClientInfo = $Core->ClientInfo($TransactionInfo->clientid);
    $Template->assign("MyClient", $ClientInfo);

    $oddid = $TransactionInfo->odd;

    $Template->assign("menukey", "shop");

    $Template->assign("Transactions", $Core->MyTransactions($Template->data['accid']));
    $Template->assign("Agents", $Core->adminUsers());
    $Template->assign("Odds", $Core->Odds());
    $Template->assign("ThisOddInfo", $Core->OddsInfo($oddid));

    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $BarCode = $generator->getBarcode($TransactionInfo->id, $generator::TYPE_CODE_93);
    $Template->assign("BarCode", $BarCode);

    $Template->render("{$role}.shop");
}, 'GET');





$Route->add('/receipt/{transid}/print', function ($transid) {

    $Core = new Apps\Core;
    $Template = new Apps\Template("/auth/login");

    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $role = $UserInfo->role;

    $TransactionInfo = $Core->TransactionInfo($transid);
    $Template->assign("TransactionInfo", $TransactionInfo);
    $MyClient = $Core->ClientInfo($TransactionInfo->clientid);
    $Template->assign("MyClient", $MyClient);

    $oddid = $TransactionInfo->odd;
    $ThisOddInfo = $Core->OddsInfo($oddid);
    $Template->assign("ThisOddInfo", $ThisOddInfo);

    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $BarCode = $generator->getBarcode($TransactionInfo->id, $generator::TYPE_CODE_93);
    $BarCode = "{$BarCode}";
    $Template->assign("BarCode", $BarCode);

    $PDF = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [100, 300]]);

    ob_start();
    ?>

    <!DOCTYPE html>
    <html lang="en" class="light">
    <!-- BEGIN: Head -->

    <head>
        <meta charset="utf-8">
        <base href="<?= domain ?>">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <!------ Include the above in your HEAD tag ---------->
    </head>

    <body style="padding: 0; margin: 5; color: #000000;">
        <div id="invoice-POS">
            <div class="text-center">
                <div class="text-3xl">
                    <h2><small style="color:#000000;">Game I.D:</small><br /><?= $TransactionInfo->id ?></h2>
                </div>
                <div style="margin: 1px auto;font-size: 150%;">SUPPER ODDS GAMES</div>
            </div>
            <hr class="my-0 p-0" />
            <div class="text-left" style="margin-left: 0px; font-size: 140%; padding-left:5px">
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Full Name:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $MyClient->fullname ?></p>
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Telephone:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $MyClient->mobile ?></p>
            </div>
            <div class="text-left" style="margin-left: 0px; font-size: 140%; padding-left:5px">
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Odd:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($ThisOddInfo->odds) ?></p>
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Stake:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($TransactionInfo->amount) ?></p>
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Winning:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($TransactionInfo->amount * $ThisOddInfo->odds)  ?></p>
            </div>
            <div class="text-left" style="margin-left: 0px; font-size: 140%; padding-left:5px">
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Stake Date:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $TransactionInfo->created ?></p>
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Draw Date:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $ThisOddInfo->playdate ?></p>
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Winning Date:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $ThisOddInfo->windate ?></p>
            </div>


        </div>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

    </body>

    </html>

<?php

    $HTMLoutput = ob_get_contents();
    ob_end_clean();
    $PDF->WriteHTML($HTMLoutput);
    $PDF->Output("./_store/transactions/{$transid}.pdf", 'D');
    $Template->assign("pdf_file", "./_store/transactions/{$transid}.pdf");

    $Template->render("receipt");
}, 'GET');


$Route->add('/receipt/{transid}/pdf', function ($transid) {

    $Core = new Apps\Core;
    $Template = new Apps\Template("/auth/login");
    $PDF = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [100, 300]]);
    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $Template->assign("UserInfo", $UserInfo);
    $role = $UserInfo->role;

    $TransactionInfo = $Core->TransactionInfo($transid);
    $Template->assign("TransactionInfo", $TransactionInfo);
    $MyClient = $Core->ClientInfo($TransactionInfo->clientid);
    $Template->assign("MyClient", $MyClient);
    $oddid = $TransactionInfo->odd;
    $ThisOddInfo = $Core->OddsInfo($oddid);
    $Template->assign("ThisOddInfo", $ThisOddInfo);

    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $BarCode = $generator->getBarcode($TransactionInfo->id, $generator::TYPE_CODE_93);
    $BarCode = "{$BarCode}";
    $Template->assign("BarCode", $BarCode);
    ob_start();

?>

    <!DOCTYPE html>
    <html lang="en" class="light">
    <!-- BEGIN: Head -->

    <head>
        <meta charset="utf-8">
        <base href="<?= domain ?>">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <!------ Include the above in your HEAD tag ---------->
    </head>

    <body style="padding: 0; margin: 5; color: #000000;">
        <div id="invoice-POS">
            <div class="text-center">
                <div class="text-3xl">
                    <h2><small style="color:#000000;">Game I.D:</small><br /><?= $TransactionInfo->id ?></h2>
                </div>
                <div style="margin: 1px auto;font-size: 150%;">SUPPER ODDS GAMES</div>
            </div>
            <hr class="my-0 p-0" />
            <div class="text-left" style="margin-left: 0px; font-size: 140%; padding-left:5px">
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Full Name:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $MyClient->fullname ?></p>
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Telephone:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $MyClient->mobile ?></p>
            </div>
            <div class="text-left" style="margin-left: 0px; font-size: 140%; padding-left:5px">
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Odd:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($ThisOddInfo->odds) ?></p>
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Stake:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($TransactionInfo->amount) ?></p>
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Winning:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($TransactionInfo->amount * $ThisOddInfo->odds)  ?></p>
            </div>

            <div class="text-left" style="margin-left: 0px; font-size: 140%; padding-left:5px">
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Stake Date:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $TransactionInfo->created ?></p>
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Draw Date:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $ThisOddInfo->playdate ?></p>
                <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Winning Date:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $ThisOddInfo->windate ?></p>
            </div>


        </div>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

    </body>

    </html>

<?php

    $HTMLoutput = ob_get_contents();
    ob_end_clean();
    $PDF->WriteHTML($HTMLoutput);
    $pdf = $PDF->Output("./_store/transactions/{$transid}.pdf", 'D');
    $Template->assign("pdf_file", "./_store/transactions/{$transid}.pdf");
}, 'GET');




$Route->add('/dashboard/agents/{agentid}/manage', function ($agentid) {

    $Core = new Apps\Core;
    $Template = new Apps\Template("/auth/login");
    $Template->addheader("layouts.admin.header");
    $Template->addfooter("layouts.admin.footer");

    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $role = $UserInfo->role;



    $AgentInfo = $Core->UserInfo($agentid);
    $Template->assign("AgentInfo", $AgentInfo);
    $Template->assign("Agents", $Core->adminUsers());
    $Template->assign("Transactions", $Core->MyTransactions($AgentInfo->accid));

    $MyClients = $Core->MyClients($accid);
    $Template->assign("MyClients", $MyClients);
    $Template->assign("menukey", "agents");

    $Template->render("{$role}.manage-agent");
}, 'GET');





$Route->add('/dashboard/agents/add', function () {

    $Core = new Apps\Core;
    $Template = new Apps\Template("/auth/login");
    $Template->addheader("layouts.admin.header");
    $Template->addfooter("layouts.admin.footer");

    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $role = $UserInfo->role;

    $Template->assign("Agents", $Core->adminUsers());

    $MyClients = $Core->MyClients($accid);
    $Template->assign("MyClients", $MyClients);
    $Template->assign("menukey", "agents");

    $Template->render("{$role}.add-agent");
}, 'GET');



$Route->add('/dashboard/odds/{oddid}/manage', function ($oddid) {

    $Core = new Apps\Core;
    $Template = new Apps\Template("/auth/login");
    $Template->addheader("layouts.admin.header");
    $Template->addfooter("layouts.admin.footer");

    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $role = $UserInfo->role;

    $OddsInfo = $Core->OddsInfo($oddid);
    $Template->assign("OddsInfo", $OddsInfo);

    $Template->assign("Agents", $Core->adminUsers());

    $MyClients = $Core->MyClients($accid);
    $Template->assign("MyClients", $MyClients);

    $Template->assign("menukey", "odds");

    $loid = $Core->LastOddId();
    $Template->assign("loid", $loid);

    $Template->render("{$role}.manage-odd");
}, 'GET');





$Route->add('/dashboard/odds/{oddid}/delete', function ($oddid) {

    $Core = new Apps\Core;
    $Template = new Apps\Template("/auth/login");

    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $role = $UserInfo->role;

    $del = $Core->mysqli("DELETE sup_odds.* FROM sup_odds WHERE id='{$oddid}'");

    $Template->redirect("/dashboard/odds");
}, 'GET');




$Route->add('/dashboard/odds/add', function () {

    $Core = new Apps\Core;
    $Template = new Apps\Template("/auth/login");
    $Template->addheader("layouts.admin.header");
    $Template->addfooter("layouts.admin.footer");

    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $role = $UserInfo->role;

    $Template->assign("Agents", $Core->adminUsers());

    $MyClients = $Core->MyClients($accid);
    $Template->assign("MyClients", $MyClients);
    $Template->assign("menukey", "odds");

    $loid = $Core->LastOddId();
    $Template->assign("loid", $loid);

    $Template->render("{$role}.add-odd");
}, 'GET');




$Route->add(
    '/auth/logout',
    function () {
        $Template = new Apps\Template;
        $Template->expire();
        $Template->cleanAll(session_delete_timout);
        $Template->redirect("/auth/login");
    },
    'GET'
);









$Route->add('/reciept/{transid}', function ($transid) {

    $Core = new Apps\Core;
    $Template = new Apps\Template("/auth/login");

    $accid = $Template->data['accid'];
    $UserInfo = $Core->UserInfo($accid);
    $role = $UserInfo->role;

    /* Fill in your own connector here */
}, 'GET');




$Route->run('/');
