<!DOCTYPE html>
<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <base href="<?= domain ?>">
</head>

<body style="padding: 0; margin: 5; color: #000000;">
    <div id="invoice-POS">
        <div class="text-center">
            <div class="text-3xl">
                <h2><small style="color:#000000;">Game I.D:</small><br /><?= $TransactionInfo->id ?></h2>
            </div>
            <div style="margin: 1px auto;font-size: 150%;">Anto Splash Bet GAMES</div>
        </div>
        <hr class="my-0 p-0" />
        <div class="text-left" style="margin-left: 0px; font-size: 140%; padding-left:5px">
            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Full Name:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $MyClient->fullname ?></p>
            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Telephone:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $MyClient->mobile ?></p>
            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Email:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $MyClient->email ?></p>
            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Date:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $TransactionInfo->created ?></p>
        </div>
        <div class="text-left" style="margin-left: 0px; font-size: 140%; padding-left:5px">
            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Odd:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($ThisOddInfo->odds) ?></p>
            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Stake:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($TransactionInfo->amount) ?></p>
            <p style="border-bottom: 1px dotted #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Your Winning:</strong><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $Core->Monify($TransactionInfo->amount * $ThisOddInfo->odds)  ?></p>
        </div>

    </div>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>
        window.print();
    </script>
</body>

</html>