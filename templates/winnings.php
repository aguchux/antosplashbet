<p>&nbsp;</p>
<p>&nbsp;</p>

<div class="session2">
    <div class="wrapper">

        <div class="pull_left session2-sport">
            <h3>ALL WINING ODDS AND GAMES</h3>
            <div class="top-events">
                <div class="top-events__list">

                    <?php while ($odd = mysqli_fetch_object($HomeOdds)) : ?>
                        <a href="javascript:;" class="top-event" style="margin-bottom: 10px;" data-fancybox="" data-src="#<?= $odd->win == 1 ? 'playwin_' . $odd->id : 'playloss_' . $odd->id ?>" target="mainframe">

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
                                <div class="top-event__button">Check Game Result</div>
                                <div class="top-event__coeff"> - </div>
                            </div>
                        </a>


                        <!--Message-->
                        <div class="hidebox">
                            <div id="playwin_<?= $odd->id ?>" class="msgblock">
                                <div class="symblo">
                                    <img src="<?= $assets ?>site\images\index\icon_login-black_playwin.png">
                                </div>
                                <h3><?= $odd->id ?> <span><?= date("jS F Y g:i:s A") ?></span></h3>
                                <div class="clearfix"></div>
                                <div class="item-group">
                                    <div class="items">
                                        <div class="item-pic">
                                            <img src="<?= $assets ?>site\images\index\playwin.png">
                                        </div>
                                        <div class="item-txt">
                                            <center><h4>Hurray, congratulations, this game is a win just as expected!</h4></center>    
                                        </div>
                                        <div class="btn blue checkpromo"><a href="/track">Track Your Bet Now</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Message-->
                        <!--Message-->
                        <div class="hidebox">
                            <div id="playloss_<?= $odd->id ?>" class="msgblock">
                                <div class="symblo">
                                    <img src="<?= $assets ?>site\images\index\icon_login-black_playloss.png">
                                </div>
                                <h3><?= $odd->id ?> <span><?= date("jS F Y g:i:s A") ?></span></h3>
                                <div class="clearfix"></div>
                                <div class="item-group">
                                    <div class="items">
                                        <div class="item-pic">
                                            <img src="<?= $assets ?>site\images\index\playloss.png">
                                        </div>
                                        <div class="item-txt">
                                        <center><h4>We are sorry, this game did not play as expected!</h4></center>    
                                        </div>
                                        <div class="btn blue checkpromo"><a href="/track">Track Your Bet Now</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Message-->

                    <?php endwhile; ?>

                </div>
            </div>
        </div>
    </div>
</div>