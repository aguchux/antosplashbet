<!-- include Header -->

<div class="banner">

    <div class="slider slider1 active">
        <img src="<?= $assets ?>site\images\banners\banner.png" class="pre-banner">
        <img src="<?= $assets ?>site\images\banners\banner1.jpg" class="object-fit-cover">
        <div class="word">
            <!-- <img src="images/banners/banner.png"  alt="pre-banner" class="pre-banner"/>  -->
            <img src="<?= $assets ?>site\images\banners\banner1_text.png">
        </div>
    </div>
    <div class="slider slider2">
        <img src="<?= $assets ?>site\images\banners\banner.png" class="pre-banner">
        <img src="<?= $assets ?>site\images\banners\banner2.jpg" class="object-fit-cover">
        <div class="word">
            <!-- <img src="images/banners/banner.png"  alt="pre-banner" class="pre-banner"/>  -->
            <img src="<?= $assets ?>site\images\banners\banner2_text.png">
        </div>
    </div>
    <div class="slider slider2">
        <img src="<?= $assets ?>site\images\banners\banner.png" class="pre-banner">
        <img src="<?= $assets ?>site\images\banners\banner3.jpg" class="object-fit-cover">
        <div class="word">
            <!-- <img src="images/banners/banner.png"  alt="pre-banner" class="pre-banner"/>  -->
            <img src="<?= $assets ?>site\images\banners\banner3_text.png">
        </div>
    </div>
    <div class="slider slider2">
        <img src="<?= $assets ?>site\images\banners\banner.png" class="pre-banner">
        <img src="<?= $assets ?>site\images\banners\banner4.jpg" class="object-fit-cover">
        <div class="word">
            <!-- <img src="images/banners/banner.png"  alt="pre-banner" class="pre-banner"/>  -->
            <img src="<?= $assets ?>site\images\banners\banner4_text.png">
        </div>
    </div>

</div>

<div class="marquee">
    <div class="wrapper">
        <div class="icon_notify">Notice</div>
        <div class="word">
            <p class="list active"></p>
            <p class="list"></p>
        </div>
    </div>
</div>

<div class="session2">
    <div class="wrapper">
        <div class="pull_left session2-num">
            <div class="block">
                <p class="title">To Get a Super Big Win Now!</p>
                <p class="subtitle">=BIG WIN SUPPERODDS AMOUNT=</p>
                <div class="slots">
                    <div class="dollar">&#x20A6;</div>
                    <div class="num"></div>
                </div>
            </div>
        </div>


        <div class="container">
            <section id="widgetCountries"></section>
            <section id="widgetLeague"></section>
            <section id="widgetLiveScore"></section>
        </div>



        <div class="pull_left session2-sport">
            <h3>SPORTS MATCHES AND PREDICTIONS FROM SUPPER</h3>
            <div class="top-events">
                <div class="top-events__list">
                    <?php while ($odd = mysqli_fetch_object($HomeOdds)) : ?>
                        <a href="javascript:;" class="top-event" style="margin-bottom: 10px;" data-fancybox="" data-src="#playbox" target="mainframe">

                            <div class="top-event__league">
                                <h2 style="font-size: 200%;"><?= $odd->id ?></h2>
                            </div>
                            <div class="top-event__main">
                                <div class="top-event__team"><img src="<?= $assets ?>site\images\index\home.png" class="top-event__team-logo" alt="<?= $odd->home ?>">
                                    <div class="top-event__team-name"><?= $odd->home ?></div>
                                </div>
                                <div class="top-event__date">
                                    <div class="top-event__date-day">Our Odds</div>
                                    <div class="top-event__date-time"><?= $odd->odds ?></div>
                                </div>
                                <div class="top-event__team"><img src="<?= $assets ?>site\images\index\away.png" class="top-event__team-logo" alt="<?= $odd->away ?>">
                                    <div class="top-event__team-name"><?= $odd->away ?></div>
                                </div>
                            </div>
                            <div class="top-event__coeffs">
                                <div class="top-event__coeff"> - </div>
                                <div class="top-event__button">Place a bet</div>
                                <div class="top-event__coeff"> - </div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>