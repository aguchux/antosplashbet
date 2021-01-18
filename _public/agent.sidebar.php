<div class="xxl:pl-6 grid grid-cols-12 gap-6">

    <!-- BEGIN: Transactions -->
    <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-3 xxl:mt-3">
        <div class="intro-x flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5">
                Other Agents: <strong class="text-theme-10"><?= $Core->CountUsers()->ousers ?></strong> / <strong class="text-theme-6"><?= $Core->CountUsers()->nusers ?></strong>
            </h2>
        </div>
        <div class="mt-5">

            <a class="intro-x">
                <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                    <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                        <img src="<?= $assets ?>images\profile-8.jpg">
                    </div>
                    <div class="ml-4 mr-auto">
                        <div class="font-medium"><?= $UserInfo->fullname ?></div>
                        <div class="text-gray-600 text-xs">Seen: <?= $UserInfo->lastseen ?></div>
                    </div>
                    <div class="text-theme-10"><?= $Core->Monify($UserInfo->credit) ?></div>
                </div>
            </a>


            <a href="/dashboard/accounts" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-theme-15 dark:border-dark-5 text-theme-16 dark:text-gray-600">Manage Clients & Users</a>


        </div>
    </div>

</div>