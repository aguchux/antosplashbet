
                                        <form action="/form/dashboard/preorder/<?= $odd->id ?>" method="post" id="preload_client_<?= $odd->id ?>_form">
                                            <?= $Self->tokenize() ?>
                                            <div class="modal" id="preload_client_<?= $odd->id ?>">
                                                <div class="modal__content">
                                                    <div class="p-5 text-center"> <i data-feather="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
                                                        <div class="text-3xl mt-5">Enter Telephone</div>
                                                        <div class="text-gray-600 mt-2">We can retrieve client record</div>
                                                    </div>
                                                    <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
                                                        <div class="col-span-12 sm:col-span-12">
                                                            <label>Telephone</label>
                                                            <input type="text" class="input w-full border mt-2 flex-1" placeholder="08012345678" name="mobile" required aria-required="true">
                                                        </div>
                                                        <div class="col-span-12 sm:col-span-12">
                                                            <label>Email Address</label>
                                                            <input type="email" class="input w-full border mt-2 flex-1" placeholder="example@gmail.com" name="email">
                                                        </div>

                                                    </div>
                                                    <div class="px-5 py-3 text-right border-t border-gray-200 dark:border-dark-5">
                                                        <button type="button" data-dismiss="modal" class="button w-40 border text-gray-700 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel Order</button>
                                                        <button type="submit" class="button w-40 bg-theme-1 text-white">Continue Order</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
