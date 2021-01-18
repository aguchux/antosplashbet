<!-- BEGIN: Content -->
<div class="content">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">

                <div class="intro-y block sm:flex items-center h-10 mt-10">
                    <h2 class="text-lg font-medium truncate mr-5">Transactions & Payments</h2>

                    <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                        <button class="button box flex items-center text-gray-700 dark:text-gray-300"> <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to Excel </button>
                        <button class="ml-3 button box flex items-center text-gray-700 dark:text-gray-300"> <i data-feather="file-text" class="hidden sm:block w-4 h-4 mr-2"></i> Export to PDF </button>

                    </div>

                </div>
                <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                    <table class="table table-report sm:mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-no-wrap"></th>
                                <th class="whitespace-no-wrap">DATE/TIME</th>
                                <th class="whitespace-no-wrap">CLIENT</th>
                                <th class="text-center whitespace-no-wrap">ODD</th>
                                <th class="text-center whitespace-no-wrap">AMOUNT</th>
                                <th class="text-center whitespace-no-wrap">STATUS</th>
                                <th class="text-center whitespace-no-wrap">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php while ($trnx = mysqli_fetch_object($Transactions)) : $Client = $Core->ClientInfo($trnx->clientid); ?>

                                <tr class="intro-x">
                                    <td class="w-40">
                                        <div class="flex">
                                            <div class="w-10 h-10 image-fit zoom-in">
                                                <img class="tooltip rounded-full" src="<?= $assets ?>images\logo.png">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= date("jS F Y g:i A", strtotime($trnx->created)) ?></td>
                                    <td>
                                        <a href="" class="font-medium whitespace-no-wrap"><?= $Client->fullname ?></a>
                                        <div class="text-gray-600 text-xs whitespace-no-wrap">Sport &amp; Outdoor</div>
                                    </td>

                                    <td class="text-center"><?= $trnx->odd ?></td>

                                    <td class="text-center"><?= $Core->Monify($trnx->amount) ?></td>
                                    <td class="w-40">
                                        <div class="flex items-center justify-center <?= $trnx->status == 'paid' ? 'text-theme-9' : 'text-theme-6' ?>"> <i data-feather="<?= $trnx->status == 'paid' ? 'check-square' : 'alert-circle' ?>" class="w-4 h-4 mr-2"></i> <?= ucfirst($trnx->status) ?> </div>
                                    </td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="/receipt/<?= $trnx->id ?>/pdf" target="_blank"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Print Reciept </a>
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
        <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-0 pb-0">
            <?php require "_public/admin.sidebar.php" ?>
        </div>
    </div>
</div>
<!-- END: Content -->