<!-- include nav -->
<div class="member_center">
    <div class="wrapper">
        <!-- include js & end -->
        <div class="userdata">
            <div class="block account_money">
                <?php if (isset($ticket)) : ?>
                    <p class="money">Your Ticket: <br /><?= $ticket ?></p>
                <?php else : ?>
                    <p class="money">Track Your Game</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- include js & end -->
        <div class="main_block">
            <?php if (isset($ticket)) : ?>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <div id="printable" class="mx-0 m5-0 px-0 py-5">
                    <div id="invoice-POS">
                        <div class="p-5 text-center">
                            <i data-feather="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">
                                <?= $TransactionInfo->id ?>
                                <hr />
                            </div>
                            <div class="text-gray-600 mt-2">SUPPER ODDS GAMES</div>
                        </div>
                        <div class="text-left ml-5 mb-3">
                            <p><strong>Full Name:
                                    <hr class="p-0 m-0" /></strong>
                                <?= $MyClient->fullname ?></p>
                            <p><strong>Telephone:
                                    <hr class="p-0 m-0" /></strong>
                                <?= $MyClient->mobile ?></p>
                            <p><strong>Email Address:
                                    <hr class="p-0 m-0" /></strong>
                                <?= $MyClient->email ?></p>
                            <p><strong>Transaction Date:
                                    <hr class="p-0 m-0" /></strong>
                                <?= $TransactionInfo->created ?></p>
                        </div>
                        <!--End InvoiceTop-->
                        <div class="text-left ml-5 mb-3">
                            <p><strong>Your Odd:
                                    <hr class="p-0 m-0" /></strong>
                                <span class="text-1xl"><?= $Core->Monify($ThisOddInfo->odds) ?></span></p>
                            <p><strong>Your Stake:
                                    <hr class="p-0 m-0" /></strong>
                                <span class="text-1xl"><?= $Core->Monify($TransactionInfo->amount) ?></span></p>
                            <p><strong>Your Winning:
                                    <hr class="p-0 m-0" /></strong>
                                <span class="text-1xl"><?= $Core->Monify($TransactionInfo->amount * $ThisOddInfo->odds) ?></span></p>
                        </div>
                        <div class="text-center ml-5 mb-3">
                            <div style="width: 100%; margin: 0 auto;"><?= $BarCode ?></div>
                        </div>

                    </div>
                </div>

            <?php else : ?>

                <div class="info_block">
                    <div class="content">
                        <!--Personal information-->
                        <div class="person_info">
                            <form action="/form/trackgame" method="post">
                                <?= $Self->tokenize() ?>

                                <div class="item-group">


                                    <div class="items">
                                        <label for="nameText">Reciept/Ticket Number: </label>
                                        <span><input type="text" name="ticket" id="ticket" placeholder="Ticket ID"></span>
                                        <span class="changepsw"><button class="btn blue" type="submit">Verify My Name</button></span>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            <?php endif; ?>


        </div>
    </div>
</div>