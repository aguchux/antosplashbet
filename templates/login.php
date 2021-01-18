<div class="container sm:px-10">
    <div class="block xl:grid grid-cols-2 gap-4">
        <!-- BEGIN: Login Info -->
        <div class="hidden xl:flex flex-col min-h-screen">
            <a href="/auth/login" class="-intro-x flex items-center pt-5">
                <img class="w-20" src="<?= $assets ?>images\logo.png">
                <span class="text-white text-lg ml-3"> AntoSplashBet </span>
            </a>
            <div class="my-auto">
                <img class="-intro-x w-1/2 -mt-16" src="<?= $assets ?>images\illustration.svg">
                <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                    A few more clicks to
                    <br>
                    sign in to your account.
                </div>
                <div class="-intro-x mt-5 text-lg text-white dark:text-gray-500">Manage all your Anto Splash Bet accounts in one place</div>
            </div>
        </div>
        <!-- END: Login Info -->
        <!-- BEGIN: Login Form -->
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
            <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                    Sign In to Anto Splash Bet
                </h2>
                <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your Odds accounts accounts in one place</div>

                <form action="/form/auth/login" method="post">
                    <?= $Self->tokenize() ?>

                    <div class="intro-x mt-8">
                        <input type="text" name="email" class="intro-x login__input input input--lg border border-gray-300 block" placeholder="Email">
                        <input type="password" name="password" class="intro-x login__input input input--lg border border-gray-300 block mt-4" placeholder="Password">
                    </div>
                    <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                        <div class="flex items-center mr-auto">
                            <input type="checkbox" class="input border mr-2" id="remember-me">
                            <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                        </div>
                        <a href="/auth/reset">Forgot Password?</a>
                    </div>
                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button type="submit" class="button button--lg w-full text-white bg-theme-1 xl:mr-3 align-top">Login</button>
                    </div>
                </form>
                <div class="intro-x mt-10 xl:mt-24 text-gray-700 dark:text-gray-600 text-center xl:text-left">
                    By signin up, you agree to our
                    <br>
                    <a class="text-theme-1 dark:text-theme-10" href="#">Terms and Conditions</a> & <a class="text-theme-1 dark:text-theme-10" href="#">Privacy Policy</a>
                </div>
            </div>

        </div>
        <!-- END: Login Form -->
    </div>
</div>