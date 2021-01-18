<!-- BEGIN: Content -->
<div class="content">


    <div class="grid grid-cols-12 gap-6">


        <div class="col-span-12 xxl:col-span-6 -mb-0 pb-0">
            <form action="/form/dashboard/agents/add" method="post">
                <?= $Self->tokenize() ?>
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">

                    <div class="intro-y block sm:flex items-center h-10 mt-10">
                        <h2 class="text-lg font-medium truncate mr-5">Create New Agent</h2>
                    </div>


                    <!-- BEGIN: Display Information -->
                    <div class="intro-y box lg:mt-5">
                        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base mr-auto">
                                Update Account Information

                            </h2>
                            <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                                <div class="mr-3">Make Admin</div>
                                <input name="isadmin" value="1" class="input input--switch border" type="checkbox">
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-12 gap-5">

                                <div class="col-span-12 xl:col-span-12">
                                    <div>
                                        <label>Agent Name:</label>
                                        <input type="text" name="fullname" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="Agent's Name">
                                    </div>
                                    <div>
                                        <label>Agent Email:</label>
                                        <input type="email" name="email" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="Agent's Email">
                                    </div>
                                    <div>
                                        <label>Agent Telephone:</label>
                                        <input type="text" name="mobile" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="Agent's Mobile">
                                    </div>
                                    <div>
                                        <label>Agent Password:</label>
                                        <input type="text" name="logon" class="input w-full border bg-gray-100 mt-2" placeholder="Agent's PAssword">
                                    </div>

                                </div>

                                <div class="col-span-12 xl:col-span-12">
                                    <button type="submit" class="button button-span w-full bg-theme-1 text-white mt-3">Create Agent Profile</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- END: Display Information -->



                </div>
                <!-- END: General Report -->
            </form>
        </div>


        <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-0 pb-0"></div>


        <div class="col-span-12 xxl:col-span-3 xxl:border-l border-theme-5 -mb-0 pb-0">
            <?php require "_public/admin.sidebar.php" ?>
        </div>


    </div>

</div>
<!-- END: Content -->