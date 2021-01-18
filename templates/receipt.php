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
    <link rel="stylesheet" href="<?= $assets ?>css\pos2.scss">
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->

<body>
    <div class="items-center h-10 mt-3">
        <center><a href="javascript:;" onclick="javascript:printDiv('printable')" class="truncate mr-5 text-theme-6">--click to print--</a></center>
    </div>
    <div id="printable" class="mx-0 my-0 px-0 py-0">
        <div id="invoice-POS">
            <div class="text-center">
                <center>
                    <img src="https://supperodds.com/sologo.png" class="my-0" style="width: 100px;">
                    <div class="text-3xl">
                        <h2><?= $TransactionInfo->id ?></h2>
                    </div>
                    <div class="text-gray-600">SUPPER ODDS GAMES</div>
                </center>
            </div>
            <hr class="my-1 p-0" />
            <div class="text-left ml-5 mb-0">
                <div style="margin-bottom:1px;"><strong>Full Name:</strong><br /><?= $MyClient->fullname ?><br /></div>
                <div style="margin-bottom:1px;"><strong>Telephone:</strong><br /><?= $MyClient->mobile ?><br /></div>
                <div style="margin-bottom:1px;"><strong>Email Address:</strong><br /><?= $MyClient->email ?><br /></div>
                <div style="margin-bottom:1px;"><strong>Transaction Date:</strong><br /><?= $TransactionInfo->created ?></div>
            </div>
            <hr class="my-1 p-0" />
            <!--End InvoiceTop-->
            <div class="text-left ml-5 mb-0">
                <div style="margin-bottom:1px;"><strong>Your Odd:</strong><br /><span class="text-1xl"><?= $Core->Monify($ThisOddInfo->odds) ?></span></div>
                <div style="margin-bottom:1px;"><strong>Your Stake:</strong><br /><span class="text-1xl"><?= $Core->Monify($TransactionInfo->amount) ?></span></div>
                <div style="margin-bottom:1px;"><strong>Your Winning:</strong><br /><span class="text-1xl"><?= $Core->Monify($TransactionInfo->amount * $ThisOddInfo->odds) ?></span></div>
            </div>
            <hr class="my-1 p-0" />
            <div class="text-center ml-5 mb-3">
                <div style="width: 100%; margin: 0 auto;"><?= $BarCode ?></div>
            </div>
        </div>
    </div>
    <!--End Invoice-->
    <div class="items-center h-10 mt-3">
        <center><a href="javascript:;" onclick="javascript:printDiv('printable')" class="truncate mr-5 text-theme-6">--click to print--</a></center>
    </div>
    <!-- BEGIN: JS Assets-->

    <script src="<?= $assets ?>js\app.js"></script>
    <script>
        $('a[href*="#"]').click(function(e) {
            e.preventDefault();
        });
    </script>
    <script src="<?= $assets ?>js\apps.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            window.print();
        }
    </script>
    <!-- END: JS Assets-->
</body>

</html>