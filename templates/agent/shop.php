<!-- BEGIN: Content -->
<div class="content">
    <div class="grid grid-cols-12 gap-6">


        <div class="col-span-12 xxl:col-span-6 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y block sm:flex items-center h-10 mt-10">
                    <h2 class="text-lg font-medium truncate mr-5">Odds & Games</h2>
                </div>
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
                    <button class="button text-white bg-theme-1 shadow-md mr-2">Add New Odd</button>
                    <div class="dropdown relative">
                        <button class="dropdown-toggle button px-2 box text-gray-700 dark:text-gray-300">
                            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                        </button>
                    </div>
                    <div class="hidden md:block mx-auto text-gray-600">Showing <strong>0</strong> entries</div>
                    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                        <div class="w-56 relative text-gray-700 dark:text-gray-300">
                            <input type="text" class="input w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                        </div>
                    </div>
                </div>

                <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                    <table class="table table-report sm:mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-no-wrap"></th>
                                <th class="whitespace-no-wrap">ID</th>
                                <th class="whitespace-no-wrap">HOME</th>
                                <th class="text-center whitespace-no-wrap">AWAY</th>
                                <th class="text-center whitespace-no-wrap">ODD</th>
                                <th class="text-center whitespace-no-wrap"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php while ($odd = mysqli_fetch_object($Odds)) : ?>

                                <tr class="intro-x">
                                    <td class="w-40">
                                        <div class="flex">
                                            <div class="w-10 h-10 image-fit zoom-in">
                                                <img class="tooltip rounded-full" src="<?= $assets ?>images\logo.png">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= $odd->id ?></td>
                                    <td class="text-center"><strong class="text-theme-10"><?= $odd->home ?></strong></td>

                                    <td class="text-center"><strong class="text-theme-6"><?= $odd->away ?></strong></td>

                                    <td class="text-center"><strong class="text-theme-9"><?= $odd->odds ?></strong></td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center text-theme-10" href="/dashboard/shop/odds/<?= $odd->id ?>/play"> <i data-feather="target" class="w-4 h-4 mr-1"></i> Play This Odd </a>
                                        </div>
                                    </td>

                                </tr>
                            <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>

                <div class="intro-y flex flex-wrap sm:flex-row sm:flex-no-wrap items-center mt-3">
                    <ul class="pagination">
                        <li><a class="pagination__link" href=""> <i class="w-4 h-4" data-feather="chevrons-left"></i> </a></li>
                        <li><a class="pagination__link" href=""> <i class="w-4 h-4" data-feather="chevron-left"></i> </a></li>
                        <li> <a class="pagination__link" href="">...</a> </li>
                        <li> <a class="pagination__link" href="">1</a> </li>
                        <li> <a class="pagination__link pagination__link--active" href="">2</a> </li>
                        <li> <a class="pagination__link" href="">3</a> </li>
                        <li> <a class="pagination__link" href="">...</a> </li>
                        <li><a class="pagination__link" href=""> <i class="w-4 h-4" data-feather="chevron-right"></i> </a></li>
                        <li><a class="pagination__link" href=""> <i class="w-4 h-4" data-feather="chevrons-right"></i> </a></li>
                    </ul>
                    <select class="w-20 input box mt-3 sm:mt-0">
                        <option>10</option>
                        <option>25</option>
                        <option>35</option>
                        <option>50</option>
                    </select>
                </div>

            </div>
            <!-- END: General Report -->

        </div>

        <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-10 pb-0">
            <div class="xxl:pl-6 grid grid-cols-12 gap-6 pt-5">

                <!-- BEGIN: Transactions -->
                <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-3 xxl:mt-3">




                    <?php if (isset($OddsInfo->id)) : ?>

                        <?php if (isset($_REQUEST['with_clients'])) :
                            $MyClient = $Self->data['ThisClient'];
                            $ThisOrder = $Self->data['ThisOrder'];
                        ?>

                            <form action="/form/dashboard/doorder/<?= $OddsInfo->id ?>" method="post">
                                <?= $Self->tokenize() ?>
                                <div class="intro-x flex items-center h-10">
                                    <h2 class="text-lg font-medium truncate mr-5">Receipt & Invoices</h2>
                                </div>
                                <hr class="intro-x flex items-center h-5" />

                                <div class="p-5 text-center"> <i data-feather="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
                                    <div class="text-3xl mt-5">Records Found</div>
                                    <div class="text-gray-600 mt-2">We found a client on record.</div>
                                </div>

                                <a class="intro-x">
                                    <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                        <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                            <img src="<?= $assets ?>images\profile-8.jpg">
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <div class="font-medium"><?= $MyClient->fullname ?></div>
                                            <div class="text-gray-600 text-xs">Seen: <?= $MyClient->lastseen ?></div>
                                        </div>
                                        <div class="text-theme-10"><?= $Core->Monify($ThisOrder->amount) ?></div>
                                    </div>
                                </a>
                                <div class="flex items-center text-gray-700 dark:text-gray-500 mt-5 mb-2">
                                    <input type="checkbox" class="input border mr-2" id="use_this_client" value="<?= $MyClient->mobile ?>" name="use_this_client">
                                    <label class="cursor-pointer select-none" for="use_this_client"><span class=" text-theme-10">Yes, use this client for this order</span></label>
                                </div>
                                <hr class="intro-x flex items-center h-5" />

                                <div class="mb-3"><label>Telephone</label> <input type="tel" required name="mobile" id="xLoadUserData" class="input w-full border mt-2" placeholder="08012345678" value="<?= $MyClient->mobile ?>"> </div>

                                <div class="mb-2"><label>Amount to play</label> <input type="number" required name="amount" class="input w-full border text-theme-10 mt-2 bg-light border" min="100" placeholder="0.00" value="<?= $ThisOrder->amount ?>"> </div>
                                <div class="flex items-center text-gray-700 dark:text-gray-500 mt-5 mb-2">
                                    <label class="cursor-pointer select-none" for="vertical-remember-paid"><span class=" text-theme-6">Ensure you have collected the entered amount in cash deposit.</span></label>
                                </div>
                                <hr class="intro-x flex items-center h-5" />
                                <div class="mb-2"><label>Client Name</label> <input type="text" required name="fullname" class="input w-full border mt-2" placeholder="Full Name" value="<?= $MyClient->fullname ?>"> </div>
                                <div class="mb-2"><label>Email Address</label> <input type="email" name="email" class="input w-full border mt-2" placeholder="example@gmail.com" value="<?= $MyClient->email ?>"> </div>
                                <button type="submit" class="button bg-theme-1 w-full text-white mt-5">Complete Order</button>
                            </form>

                        <?php else : ?>

                            <form action="/form/dashboard/order/<?= $OddsInfo->id ?>" method="post">
                                <?= $Self->tokenize() ?>
                                <div class="intro-x flex items-center h-10">
                                    <h2 class="text-lg font-medium truncate mr-5">Receipt & Invoices</h2>
                                </div>
                                <hr class="intro-x flex items-center h-5" />
                                <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 text-theme-7 mx-auto mt-3"></i>
                                    <div class="text-3xl mt-5">Enter Telephone</div>
                                    <div class="text-gray-600 mt-2">We can retrieve client record</div>
                                </div>

                                <div class="mb-3"><label>Telephone</label> <input type="tel" required name="mobile" id="xLoadUserData" class="input w-full border mt-2" placeholder="08012345678"> </div>

                                <div class="mb-2"><label>Amount to play</label> <input type="number" required name="amount" class="input w-full border text-theme-10 mt-2 bg-light border" min="100" placeholder="0.00"> </div>
                                <div class="flex items-center text-gray-700 dark:text-gray-500 mt-5 mb-2">
                                    <input type="checkbox" checked class="input border mr-2" id="vertical-remember-paid" value="1" name="paid" required aria-required="true">
                                    <label class="cursor-pointer select-none" for="vertical-remember-paid"><span class=" text-theme-6">I confirm user has paid for this game, and I have collected the entered amount in cash deposit.</span></label>
                                </div>
                                <hr class="intro-x flex items-center h-5" />
                                <div class="mb-2"><label>Client Name</label> <input type="text" required name="fullname" class="input w-full border mt-2" placeholder="Full Name"> </div>
                                <div class="mb-2"><label>Email Address</label> <input type="email" name="email" class="input w-full border mt-2" placeholder="example@gmail.com"> </div>
                                <div class="flex items-center text-gray-700 dark:text-gray-500 mt-5 mb-2">
                                    <input type="checkbox" checked readonly class="input border mr-2" id="vertical-remember-me">
                                    <label class="cursor-pointer select-none" for="vertical-remember-me">Save client data for future use</label>
                                </div>
                                <button type="submit" class="button bg-theme-1 w-full text-white mt-5">Complete Order</button>
                            </form>

                        <?php endif; ?>


                    <?php elseif (isset($TransactionInfo->id)) : ?>

                        <form action="/form/dashboard/doorder/<?= $TransactionInfo->id ?>" method="post">
                            <?= $Self->tokenize() ?>
                            <div class="items-center h-10 mt-3">
                                <center><a href="/receipt/<?= $TransactionInfo->id ?>/pdf" target="_blank"  class="truncate mr-5 text-theme-6">--click to print--</a></center>
                            </div>
                            <div id="printable" class="mx-0 my-0 px-0 py-0">
                                <div id="invoice-POS">
                                    <div class="p-5 text-center">
                                        <i data-feather="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
                                        <div class="text-3xl mt-5"><?= $TransactionInfo->id ?>
                                            <hr />
                                        </div>
                                        <div class="text-gray-600 mt-2">Anto Splash Bet GAMES</div>
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
                            <!--End Invoice-->
                            <div class="items-center h-10 mt-3">
                                <center><a href="/receipt/<?= $TransactionInfo->id ?>/pdf" target="_blank" class="truncate mr-5 text-theme-6">--click to print--</a></center>
                            </div>

                        </form>

                    <?php else : ?>

                        <div class="intro-x flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">Recent Receipts & Invoices</h2>
                        </div>
                        <hr class="intro-x flex items-center h-5" />


                    <?php endif; ?>


                </div>
                <!-- BEGIN: Transactions -->

            </div>
        </div>

        <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-0 pb-0">
            <?php require "_public/agent.sidebar.php" ?>
        </div>
    </div>
</div>
<!-- END: Content -->