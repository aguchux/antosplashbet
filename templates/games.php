
<p>&nbsp;</p>
<p>&nbsp;</p>

<div class="session2">
    <div class="wrapper">

        <div class="pull_left session2-sport">
            <h3>SPORTS MATCHES AND PREDICTIONS FROM SUPPER ODDS</h3>
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