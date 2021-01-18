<!-- BEGIN: Content -->
<div class="content">


    <div class="grid grid-cols-12 gap-6">


        <div class="col-span-12 xxl:col-span-6 -mb-0 pb-0">
            <form action="/form/dashboard/updateagent/<?= $AgentInfo->accid ?>" method="post">
                <?= $Self->tokenize() ?>
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">

                    <div class="intro-y block sm:flex items-center h-10 mt-10">
                        <h2 class="text-lg font-medium truncate mr-5">Manage - <?= $AgentInfo->fullname ?></h2>

                        <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <div class="mr-3">Disable This Agent</div>
                            <input name="enabled" value="1" class="input input--switch border" <?= $AgentInfo->enabled ? 'checked' : '' ?> type="checkbox">
                        </div>

                    </div>


                    <!-- BEGIN: Display Information -->
                    <div class="intro-y box lg:mt-5">
                        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base mr-auto">
                                Update Account Information

                            </h2>
                            <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                                <div class="mr-3">Make Admin</div>
                                <input name="isadmin" value="1" class="input input--switch border" <?= $AgentInfo->is_admin ? 'checked' : '' ?> type="checkbox">
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-12 gap-5">

                                <div class="col-span-12 xl:col-span-12">
                                    <div>
                                        <label>Agent Name:</label>
                                        <input type="text" name="fullname" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="Agent's Name" value="<?= $AgentInfo->fullname ?>">
                                    </div>
                                    <div>
                                        <label>Agent Email:</label>
                                        <input type="email" name="email" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="Agent's Email" value="<?= $AgentInfo->email ?>">
                                    </div>
                                    <div>
                                        <label>Agent Telephone:</label>
                                        <input type="text" name="mobile" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="Agent's Mobile" value="<?= $AgentInfo->mobile ?>">
                                    </div>
                                    <div>
                                        <label>Agent Password:</label>
                                        <input type="text" name="logon" class="input w-full border bg-gray-100 mt-2" placeholder="Agent's PAssword" value="<?= $AgentInfo->password ?>">
                                    </div>

                                </div>

                                <div class="col-span-12 xl:col-span-12">
                                    <button type="submit" class="button button-span w-full bg-theme-1 text-white mt-3">Update Profile</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- END: Display Information -->



                </div>
                <!-- END: General Report -->



                <?php if ($AgentInfo->accid) : ?>

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
                                                <a class="flex items-center mr-3" href="/receipt/<?= $trnx->id ?>/pdf"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Print Reciept </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>

                            </tbody>
                        </table>
                    </div>


                <?php endif; ?>
            </form>
        </div>


        <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-0 pb-0">
            <form action="/form/dashboard/addfund/<?= $AgentInfo->accid ?>" method="post">
                <?= $Self->tokenize() ?>
                <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                    <div class="text-center h2 mt-5">
                        <h2 style="font-size: 200%;">Credit this Agent</h2>
                    </div>
                    <div class="text-center h1 mt-5 pt-5">
                        <h1 style="font-size: 400%;"><?= $Core->Monify($AgentInfo->credit) ?></h1>
                        <label>Wallet Balance</label>
                    </div>
                    <div class="text-center h1 mt-5 pb-5">
                        <input type="number" name="credit" min="1000" step="1000" style="text-align: center; font-size: 250%;" class="input w-full border bg-gray-100 mt-2" style="font-size: larger;" placeholder="0.00" value="1000">
                    </div>
                    <div class="text-center h1 mt-5 pb-5">
                        <button type="submit" class="button button-span w-full bg-theme-1 text-white mt-3">Add Credit Fund</button>
                    </div>
                </div>

            </form>
        </div>


        <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-0 pb-0">
            <?php require "_public/admin.sidebar.php" ?>
        </div>


    </div>

</div>
<!-- END: Content -->