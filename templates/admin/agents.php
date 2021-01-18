<!-- BEGIN: Content -->
<div class="content">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y block sm:flex items-center h-10 mt-10">
                    <h2 class="text-lg font-medium truncate mr-5">Manage Agents</h2>
                </div>

                <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
                    <button class="button text-white bg-theme-1 shadow-md mr-2">Add New Agent</button>
                    <div class="dropdown relative">
                        <button class="dropdown-toggle button px-2 box text-gray-700 dark:text-gray-300">
                            <a href="/dashboard/agents/add" class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </a>
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
                                <th class="whitespace-no-wrap">AGENT NAME</th>
                                <th class="text-center whitespace-no-wrap">EMAIL</th>
                                <th class="text-center whitespace-no-wrap">TELEPHONE</th>
                                <th class="text-center whitespace-no-wrap">BALANCE</th>
                                <th class="text-center whitespace-no-wrap"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php while ($Client = mysqli_fetch_object($AllAgents)) : ?>

                                <tr class="intro-x">
                                    <td class="w-40">
                                        <div class="flex">
                                            <div class="w-10 h-10 image-fit zoom-in">
                                                <img class="rounded-full" src="<?= $assets ?>images\profile-8.jpg">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= $Client->accid ?></td>
                                    <td><a href="#" class="font-medium whitespace-no-wrap"><?= $Client->fullname ?></a></td>

                                    <td class="text-center"><?= $Client->email ?></td>

                                    <td class="text-center"><?= $Client->mobile ?></td>
                                    <td class="text-center"><?= $Core->Monify($Client->credit) ?></td>

                                    <td class="text-center"><?= $Client->created ?></td>
                                    
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                        <a class="flex items-center text-theme-9 mr-5" href="/dashboard/agents/<?= $Client->accid ?>/manage"> <i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit Agent </a>
                                        <a class="flex items-center text-theme-6" href="javascript:;"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
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