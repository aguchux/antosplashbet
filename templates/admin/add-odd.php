<!-- BEGIN: Content -->
<div class="content">


    <div class="grid grid-cols-12 gap-6">


        <div class="col-span-12 xxl:col-span-6 -mb-0 pb-0">
            <form action="/form/dashboard/odds/add" method="post">
                <?= $Self->tokenize() ?>
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">

                    <div class="intro-y block sm:flex items-center h-10 mt-10">
                        <h2 class="text-lg font-medium truncate mr-5">Create New Game & Odds</h2>
                    </div>


                    <!-- BEGIN: Display Information -->
                    <div class="intro-y box lg:mt-5">
                        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base mr-auto">
                                Game Information

                            </h2>
                            <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                                <div class="mr-3">Set as winning game</div>
                                <input name="winning" value="1" class="input input--switch border" type="checkbox">
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-12 gap-5">

                                <div class="col-span-12 xl:col-span-12">
                                    <div>
                                        <label>Home Team:</label>
                                        <input type="text" name="home" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="Home" value="<?= $Core->GenTeamCode($loid) ?>">
                                    </div>
                                    <div>
                                        <label>Away Team:</label>
                                        <input type="text" name="away" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="Away" value="<?= $Core->GenTeamCode($loid) ?>">
                                    </div>
                                    <div>
                                        <label>Odd:</label>
                                        <input type="number" name="odds" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="1.00" value="1.00" min="1.00" max="2.00" step="0.01">
                                    </div>
                                    
                                    <hr />
                                    <div class="grid grid-cols-12 gap-5">
                                        <div class="col-span-6 xl:col-span-6">
                                            <label>Date to Draw:</label>
                                            <input type="date" name="playdate" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="Date to Draw">
                                        </div>
                                        <div class="col-span-2 xl:col-span-2">
                                            <label>Hours:</label>
                                            <input type="number" min="1" max="12" name="playdate_hrs" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="1" value="1">
                                        </div>
                                        <div class="col-span-2 xl:col-span-2">
                                            <label>Mins:</label>
                                            <input type="number" min="0" max="59" name="playdate_mins" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="0" value="0">
                                        </div>
                                        <div class="col-span-2 xl:col-span-2">
                                            <label>AM/PM:</label>
                                            <select name="playdate_period" id="playdate_period" class="input w-full border bg-gray-100 mt-2 mb-4">
                                                <option value="AM" selected>AM</option>
                                                <option value="AM">PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="grid grid-cols-12 gap-5">
                                        <div class="col-span-6 xl:col-span-6">
                                            <label>Date of Winning (Cashout):</label>
                                            <input type="date" name="windate" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="Date of Winning">
                                        </div>
                                        <div class="col-span-2 xl:col-span-2">
                                            <label>Hours:</label>
                                            <input type="number" min="1" max="12" name="windate_hrs" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="1" value="1">
                                        </div>
                                        <div class="col-span-2 xl:col-span-2">
                                            <label>Mins:</label>
                                            <input type="number" min="0" max="59" name="windate_mins" class="input w-full border bg-gray-100 mt-2 mb-4" placeholder="0" value="0">
                                        </div>
                                        <div class="col-span-2 xl:col-span-2">
                                            <label>AM/PM:</label>
                                            <select name="windate_period" id="windate_period" class="input w-full border bg-gray-100 mt-2 mb-4">
                                                <option value="AM" selected>AM</option>
                                                <option value="AM">PM</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>

                                    </div>
                                </div>

                                <div class="col-span-12 xl:col-span-12">
                                    <button type="submit" class="button button-span w-full bg-theme-1 text-white mt-3">Create Odd</button>
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