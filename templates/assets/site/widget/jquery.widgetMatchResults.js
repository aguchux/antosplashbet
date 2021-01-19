// ---------------------------------
// ---------- widgetMatchResults ----------
// ---------------------------------
// Widget for MatchResults Display
// ------------------------
;
(function($, window, document, undefined) {

    var widgetMatchResults = 'widgetMatchResults';

    function Plugin(element, options) {
        this.element = element;
        this._name = widgetMatchResults;
        this._defaults = $.fn.widgetMatchResults.defaults;
        this.options = $.extend({}, this._defaults, options);

        this.init();
    }

    $.extend(Plugin.prototype, {

        // Initialization logic
        init: function() {
            this.buildCache();
            this.bindEvents();
            this.initialContent(this.options.matchResultsDetailsAjaxURL, this.options.match_id, this.options.action, this.options.Widgetkey, this.options.leagueLogo);
        },

        // Remove plugin instance completely
        destroy: function() {
            this.unbindEvents();
            this.$element.removeData();
        },

        // Cache DOM nodes for performance
        buildCache: function() {
            this.$element = $(this.element);
        },

        // Bind events that trigger actions
        bindEvents: function() {
            var plugin = this;
        },

        // Unbind events that trigger actions
        unbindEvents: function() {
            this.$element.off('.' + this._name);
        },

        initialContent: function(matchResultsDetailsAjaxURL, match_id, action, Widgetkey, leagueLogo) {

            // Get widget location
            var matchResultsLocation = $(this.element);

             // Adding the "widgetMatchResults" class for styling and easyer targeting
            matchResultsLocation.addClass('widgetMatchResults');

            // If backgroundColor setting is set, here we activate the color
            if (this.options.backgroundColor) {
                matchResultsLocation.css('background-color', this.options.backgroundColor);
            }

            // If widgetWidth setting is set, here we set the width of the list
            if (this.options.widgetWidth) {
                matchResultsLocation.css('width', this.options.widgetWidth);
            }

            // We send a request to server for Match infos
            $.ajax({
                url: matchResultsDetailsAjaxURL,
                cache: false,
                data: {
                    action: action,
                    Widgetkey: Widgetkey,
                    match_id: match_id,
                    from: sessionStorage.getItem('fixturesDate'),
                    to: sessionStorage.getItem('fixturesDate'),
                    timezone: getTimeZone()
                },
                dataType: 'json'
            }).done(function(res) {
                // If server send results we populate HTML with sended information
                if (!res.error) {

                    // Check if we get the time
                    var seeWhatMatchDetailsToShow = setInterval(function() {
                        if (timeForFixtures.length > 0) {
                            // If date is in local storage or event status dose not exist we show predefined HTML
                            if ((sessionStorage.getItem('fixturesDate') > timeForFixtures) || (res[0].match_status == null)) {
                                // Hide loading screen
                                $('.loading').hide();
                                // Details for match
                                var otherMatchDetails = '<div class="otherMatchDetails">';
                                otherMatchDetails += '<div class="otherMatchDetailsInfos">';
                                otherMatchDetails += '<div class="leagueImg" style="background-image: url(\'' + (((leagueLogo == '') || (leagueLogo == 'null') || (leagueLogo == null) || (leagueLogo == 'https://apiv2.apifootball.com/badges/logo_leagues/-1')) ? 'img/no-img.png' : leagueLogo) + '\');"></div>';
                                otherMatchDetails += '<div>' + res[0].country_name + ': ' + res[0].league_name + '</div>';
                                otherMatchDetails += '</div>';
                                var formattedDate = new Date(res[0].match_date);
                                var d = formattedDate.getDate();
                                var m = formattedDate.getMonth() + 1;
                                var y = formattedDate.getFullYear();
                                otherMatchDetails += '<div>' + (d < 10 ? '0' + d : d) + '.' + (m < 10 ? '0' + m : m) + '.' + y + ' ' + res[0].match_time + '</div>';
                                otherMatchDetails += '</div>';
                                $(matchResultsLocation).prepend(otherMatchDetails);

                                // Add hook in HTML for Match Results Tab content infos
                                $(matchResultsLocation).append('<section id="matchResultsContentTable"></section>');
                                var htmlConstructor = '<div id="matchResultsDates">';
                                htmlConstructor += '<div id="matchResultsDatesTitle">';
                                if (!res.error) {
                                    htmlConstructor += '<div class="match_hometeam_name">';
                                    htmlConstructor += '<div class="match_hometeam_name_part">';
                                    htmlConstructor += '<div class="match_hometeam_name_part_img">';
                                    htmlConstructor += '<div class="image-style-for-flag" style="background-image: url(\'' + ((!res[0].team_home_badge) ? 'img/no-img.png' : ((res[0].team_home_badge == '') ? 'img/no-img.png' : res[0].team_home_badge)) + '\');"></div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="match_hometeam_name_part_name">';
                                    htmlConstructor += '<div>' + res[0].match_hometeam_name + '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="event_info">';
                                    htmlConstructor += '<div class="event_info_score">';
                                    htmlConstructor += '<div>-</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="event_info_status">';
                                    htmlConstructor += '<div>' + ((res[0].match_status) ? res[0].match_status : '') + '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="match_awayteam_name_part">';
                                    htmlConstructor += '<div class="match_awayteam_name_part_img">';
                                    htmlConstructor += '<div class="image-style-for-flag" style="background-image: url(\'' + ((!res[0].team_away_badge) ? 'img/no-img.png' : ((res[0].team_away_badge == '') ? 'img/no-img.png' : res[0].team_away_badge)) + '\');"></div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="match_awayteam_name_part_name">';
                                    htmlConstructor += '<div>' + res[0].match_awayteam_name + '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '</div>';
                                }
                                htmlConstructor += '</div>';
                                htmlConstructor += '<div class="nav-tab-wrapper-all">';
                                htmlConstructor += '<ul class="nav-tab-wrapper-all-container">';
                                htmlConstructor += '<li><span><a href="#matchSummary" class="matchResults-h2 nav-tab nav-tab-active">Match Summary</a></span></li>';
                                htmlConstructor += '</ul>';
                                htmlConstructor += '</div>';
                                htmlConstructor += '<section id="matchSummary" class="tab-content active">';
                                htmlConstructor += '<div class="tab-container futureMatch">';
                                htmlConstructor += '<p>No live score information available now.</p>';
                                htmlConstructor += '</div>';
                                htmlConstructor += '</section>';
                                $('#matchResultsContentTable').append(htmlConstructor);

                                // Remove Fixture Date from local storage
                                sessionStorage.removeItem('fixturesDate');

                                // Added close button in HTML
                                $('#matchResultsContentTable').append('<p class="closeWindow">close window</p>');
                                // Added click function to close window
                                $('.closeWindow').click(function() {
                                    window.close();
                                });

                                // Added click function to header close window
                                $('.backButton').click(function() {
                                    window.close();
                                });

                            } else {

                                // If server send details for match we populate HTML
                                // Set key for Home Team
                                var hometeamKeyMain = res[0].match_hometeam_id;
                                // Set key for Away Team
                                var awayteamKeyMain = res[0].match_awayteam_id;

                                // Hide loading sreen
                                $('.loading').hide();

                                // Details for match
                                var otherMatchDetails = '<div class="otherMatchDetails">';
                                otherMatchDetails += '<div class="otherMatchDetailsInfos">';
                                otherMatchDetails += '<div class="leagueImg" style="background-image: url(\'' + (((leagueLogo == '') || (leagueLogo == 'null') || (leagueLogo == null) || (leagueLogo == 'https://apiv2.apifootball.com/badges/logo_leagues/-1')) ? 'img/no-img.png' : leagueLogo) + '\');"></div>';
                                otherMatchDetails += '<div>' + res[0].country_name + ': ' + res[0].league_name + '</div>';
                                otherMatchDetails += '</div>';
                                var formattedDate = new Date(res[0].match_date);
                                var d = formattedDate.getDate();
                                var m = formattedDate.getMonth() + 1;
                                var y = formattedDate.getFullYear();
                                otherMatchDetails += '<div>' + (d < 10 ? '0' + d : d) + '.' + (m < 10 ? '0' + m : m) + '.' + y + ' ' + res[0].match_time + '</div>';
                                otherMatchDetails += '</div>';
                                $(matchResultsLocation).prepend(otherMatchDetails);
                                // Added click function to header close window
                                $('.backButton').click(function() {
                                    window.close();
                                });
                                // Add hook in HTML for Match Results Tab content infos
                                $(matchResultsLocation).append('<section id="matchResultsContentTable"></section>');
                                var htmlConstructor = '<div id="matchResultsDates">';
                                htmlConstructor += '<div id="matchResultsDatesTitle">';
                                if (!res.error) {
                                    htmlConstructor += '<div class="match_hometeam_name">';
                                    htmlConstructor += '<div class="match_hometeam_name_part">';
                                    htmlConstructor += '<div class="match_hometeam_name_part_img">';
                                    htmlConstructor += '<div class="image-style-for-flag" style="background-image: url(\'' + (((res[0].team_home_badge == '') || (res[0].team_home_badge == 'null') || (res[0].team_home_badge == null)) ? 'img/no-img.png' : res[0].team_home_badge) + '\');"></div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="match_hometeam_name_part_name">';
                                    htmlConstructor += '<div>' + res[0].match_hometeam_name + '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="event_info">';
                                    htmlConstructor += '<div class="event_info_score">';
                                    htmlConstructor += '<div>' + res[0].match_hometeam_score + ' - ' + res[0].match_awayteam_score + '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="event_info_status">';
                                    var removeNumericAdd = res[0].match_status.replace('+', '');
                                    htmlConstructor += '<div class="' + (($.isNumeric(removeNumericAdd) || (removeNumericAdd == 'Half Time')) ? 'matchIsLive' : '') + '"> ' + (($.isNumeric(removeNumericAdd) || (removeNumericAdd == 'Half Time')) ? res[0].match_status + ((removeNumericAdd == 'Half Time') ? '' : '\'') : res[0].match_status) + '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="match_awayteam_name_part">';
                                    htmlConstructor += '<div class="match_awayteam_name_part_img">';
                                    htmlConstructor += '<div class="image-style-for-flag" style="background-image: url(\'' + (((res[0].team_away_badge == '') || (res[0].team_away_badge == 'null') || (res[0].team_away_badge == null)) ? 'img/no-img.png' : res[0].team_away_badge) + '\');"></div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="match_awayteam_name_part_name">';
                                    htmlConstructor += '<div>' + res[0].match_awayteam_name + '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '</div>';
                                }
                                htmlConstructor += '</div>';
                                htmlConstructor += '<div class="nav-tab-wrapper-all">';
                                htmlConstructor += '<ul class="nav-tab-wrapper-all-container">';
                                htmlConstructor += '<li><span><a href="#matchSummary" class="matchResults-h2 nav-tab nav-tab-active">Match Summary</a></span></li>';
                                htmlConstructor += '<li><span><a href="#matchStatistics" class="matchResults-h2 nav-tab">Statistics</a></span></li>';
                                htmlConstructor += '<li><span><a href="#lineups" class="matchResults-h2 nav-tab">Lineups</a></span></li>';
                                htmlConstructor += '<li><span><a href="#matchh2h" class="matchResults-h2 nav-tab">H2H</a></span></li>';
                                htmlConstructor += '<li><span><a href="#matchStandings" class="matchResults-h2 nav-tab">Standings</a></span></li>';
                                htmlConstructor += '<li><span><a href="#matchTopScorers" class="matchResults-h2 nav-tab">Top Scorers</a></span></li>';
                                htmlConstructor += '</ul>';
                                htmlConstructor += '</div>';

                                // Populate Match Summary section
                                htmlConstructor += '<section id="matchSummary" class="tab-content active">';
                                htmlConstructor += '<div class="tab-container">';
                                
                                var substitutions_home_array = [res[0].substitutions.home];
                                substitutions_home_array[0].forEach(function (whatTeam) {
                                    whatTeam.whatTeam = 'home_team';
                                });

                                var substitutions_away_array = [res[0].substitutions.away];
                                substitutions_away_array[0].forEach(function (whatTeam) {
                                    whatTeam.whatTeam = 'away_team';
                                });

                                var multipleArrays = [res[0].goalscorer, substitutions_home_array[0], substitutions_away_array[0], res[0].cards];
                                var flatArray = [].concat.apply([], multipleArrays);
                                var nrArray = flatArray;
                                nrArray.sort(naturalCompare);
                                if (nrArray.length == 0) {
                                    htmlConstructor += '<p class="" style="border-left: solid 0px transparent; margin-left:auto; margin-right:auto; margin-top: 13px; text-align:center;">Sorry, no data!</p>';
                                } else {
                                    var htmlCC = 0;
                                    var htmlCC2 = 0;
                                    $.each(nrArray, function(key, value) {
                                        if ((value.time < 46) || (value.time.indexOf("45+") >= 0)) {
                                            if (htmlCC == 0) {
                                                htmlConstructor += '<div class="lineupsTitle">1st Half</div>';
                                            }
                                            if ((value.home_scorer || value.away_scorer) && value.score !== "substitution") {
                                                htmlConstructor += '<div class="' + ((value.home_scorer) ? 'action_home' : 'action_away') + '">' + ((value.home_scorer) ? value.time + '\'<div class="imgMatchSummary" style="background-image: url(img/ball.png);"></div>' + value.home_scorer : '') + ' ' + ((value.away_scorer) ? value.time + '\'' + '<div class="imgMatchSummary" style="background-image: url(img/ball.png);"></div>' + value.away_scorer : '') + '</div>';
                                            }
                                            if ((value.home_scorer == '') && (value.away_scorer == '')) {
                                                htmlConstructor += '<div class="action_unknown">' + (value.time + '\'<div class="imgMatchSummary" style="background-image: url(img/ball.png);"></div>') + '</div>';
                                            }
                                            if (value.home_fault || value.away_fault) {
                                                htmlConstructor += '<div class="' + ((value.home_fault) ? 'action_home' : 'action_away') + '">' + ((value.home_fault) ? value.time + '\' ' + ((value.card == 'yellow card') ? '<div class="imgMatchSummary" style="background-image: url(img/yellow_card.svg);"></div>' : '<div class="imgMatchSummary" style="background-image: url(img/red_card.svg);"></div>') + ' ' + value.home_fault : '') + ' ' + ((value.away_fault) ? value.time + '\'' + ' ' + ((value.card == 'yellow card') ? '<div class="imgMatchSummary" style="background-image: url(img/yellow_card.svg);"></div>' : '<div class="imgMatchSummary" style="background-image: url(img/red_card.svg);"></div>') + ' ' + value.away_fault : '') + '</div>';
                                            }
                                            if ((value.home_fault == '') && (value.away_fault == '')) {
                                                htmlConstructor += '<div class="action_unknown">' + ((value.card == 'yellow card') ? '<div class="imgMatchSummary" style="background-image: url(img/yellow_card.svg);"></div>' : '<div class="imgMatchSummary" style="background-image: url(img/red_card.svg);"></div>') + '</div>';
                                            }
                                            if (value.substitution) {
                                                htmlConstructor += '<div class="' + ((value.whatTeam == 'home_team') ? 'action_home' : 'action_away') + '">' + ((value.whatTeam == 'home_team') ? value.time + '\'<div class="imgMatchSummary" style="background-image: url(img/match_red.png);"></div>' + value.substitution + '<div class="imgMatchSummary" style="background-image: url(img/match_green.png);"></div>' : '') + ' ' + ((value.whatTeam == 'away_team') ? value.time + '\'' + '<div class="imgMatchSummary" style="background-image: url(img/match_green.png);"></div>' + value.substitution + '<div class="imgMatchSummary" style="background-image: url(img/match_red.png);"></div>' : '') + '</div>';
                                            }
                                            htmlCC++;
                                        } else {
                                            if (htmlCC == 0) {
                                                htmlConstructor += '<div class="lineupsTitle">1st Half</div>';
                                                htmlConstructor += '<div class="noHalfEvent">-</div>';
                                            }
                                            htmlCC++
                                        }
                                        if ((value.time > 45) || (value.time.indexOf("90+") >= 0)) {
                                            if (htmlCC2 == 0) {
                                                htmlConstructor += '<div class="lineupsTitle">2nd Half</div>';
                                            }
                                            if ((value.home_scorer || value.away_scorer) && value.score !== "substitution") {
                                                htmlConstructor += '<div class="' + ((value.home_scorer) ? 'action_home' : 'action_away') + '">' + ((value.home_scorer) ? value.time + '\'<div class="imgMatchSummary" style="background-image: url(img/ball.png);"></div>' + value.home_scorer : '') + ' ' + ((value.away_scorer) ? value.time + '\'' + '<div class="imgMatchSummary" style="background-image: url(img/ball.png);"></div>' + value.away_scorer : '') + '</div>';
                                            }
                                            if ((value.home_scorer == '') && (value.away_scorer == '')) {
                                                htmlConstructor += '<div class="action_unknown">' + (value.time + '\'<div class="imgMatchSummary" style="background-image: url(img/ball.png);"></div>') + '</div>';
                                            }
                                            if (value.home_fault || value.away_fault) {
                                                htmlConstructor += '<div class="' + ((value.home_fault) ? 'action_home' : 'action_away') + '">' + ((value.home_fault) ? value.time + '\' ' + ((value.card == 'yellow card') ? '<div class="imgMatchSummary" style="background-image: url(img/yellow_card.svg);"></div>' : '<div class="imgMatchSummary" style="background-image: url(img/red_card.svg);"></div>') + ' ' + value.home_fault : '') + ' ' + ((value.away_fault) ? value.time + '\'' + ' ' + ((value.card == 'yellow card') ? '<div class="imgMatchSummary" style="background-image: url(img/yellow_card.svg);"></div>' : '<div class="imgMatchSummary" style="background-image: url(img/red_card.svg);"></div>') + ' ' + value.away_fault : '') + '</div>';
                                            }
                                            if (value.substitution) {
                                                htmlConstructor += '<div class="' + ((value.whatTeam == 'home_team') ? 'action_home' : 'action_away') + '">' + ((value.whatTeam == 'home_team') ? value.time + '\'<div class="imgMatchSummary" style="background-image: url(img/match_red.png);"></div>' + value.substitution + '<div class="imgMatchSummary" style="background-image: url(img/match_green.png);"></div>' : '') + ' ' + ((value.whatTeam == 'away_team') ? value.time + '\'' + '<div class="imgMatchSummary" style="background-image: url(img/match_green.png);"></div>' + value.substitution + '<div class="imgMatchSummary" style="background-image: url(img/match_red.png);"></div>' : '') + '</div>';
                                            }
                                            htmlCC2++;
                                        }
                                    });
                                }
                                htmlConstructor += '</div>';
                                if ((res[0].match_referee != '') || (res[0].match_stadium != '')) {
                                    htmlConstructor += '<div>';
                                    htmlConstructor += '<div class="matchExtraInfosTitle">Match Information</div>';
                                    htmlConstructor += '<div class="matchExtraInfos">' + ((res[0].match_referee != '') ? 'Referee: ' + res[0].match_referee : '') + ' ' + ((res[0].match_stadium != '') ? 'Stadium: ' + res[0].match_stadium : '') + '</div>';
                                    htmlConstructor += '</div>';
                                }
                                htmlConstructor += '</section>';

                                // Populate Match Statistics section
                                htmlConstructor += '<section id="matchStatistics" class="tab-content">';
                                htmlConstructor += '<div class="tab-container">';
                                if (res[0].statistics.length == 0) {
                                    htmlConstructor += '<p class="" style="border-left: solid 0px transparent; margin-left:auto; margin-right:auto; margin-top: 13px; text-align:center;">Sorry, no data!</p>';
                                } else {
                                    $.each(res[0].statistics, function(key, value) {
                                        if (JSON.stringify(value).indexOf('%') > -1) {
                                            htmlConstructor += '<div class="matchStatisticsRow">';
                                            htmlConstructor += '<div class="matchStatisticsRowText">';
                                            htmlConstructor += '<div class="matchStatisticsRowHome">' + value.home + '</div>';
                                            htmlConstructor += '<div class="matchStatisticsRowType">' + value.type + '</div>';
                                            htmlConstructor += '<div class="matchStatisticsRowAway">' + value.away + '</div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '<div class="matchStatisticsRowBar">';
                                            htmlConstructor += '<div class="matchStatisticsRowBarHome">';
                                            htmlConstructor += '<div class="matchStatisticsRowBarHomeBg">';
                                            htmlConstructor += '<div class="matchStatisticsRowHomeLine" style="width:' + value.home + ';background-color:' + ((value.home > value.away) ? 'red' : '') + ';"></div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '<div class="matchStatisticsRowBarAway">';
                                            htmlConstructor += '<div class="matchStatisticsRowBarAwayBg">';
                                            htmlConstructor += '<div class="matchStatisticsRowAwayLine" style="width:' + value.away + ';background-color:' + ((value.away > value.home) ? 'red' : '') + ';"></div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '</div>';
                                        } else {
                                            var x = parseInt(value.home) + parseInt(value.away);
                                            var xx = 100 / x;
                                            var tt = xx * value.home;
                                            var vv = xx * value.away;
                                            htmlConstructor += '<div class="matchStatisticsRow">';
                                            htmlConstructor += '<div class="matchStatisticsRowText">';
                                            htmlConstructor += '<div class="matchStatisticsRowHome">' + value.home + '</div>';
                                            htmlConstructor += '<div class="matchStatisticsRowType">' + value.type + '</div>';
                                            htmlConstructor += '<div class="matchStatisticsRowAway">' + value.away + '</div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '<div class="matchStatisticsRowBar">';
                                            htmlConstructor += '<div class="matchStatisticsRowBarHome">';
                                            htmlConstructor += '<div class="matchStatisticsRowBarHomeBg">';
                                            htmlConstructor += '<div class="matchStatisticsRowHomeLine" style="width:' + tt + '%;background-color:' + ((tt > vv) ? 'red' : '') + ';"></div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '<div class="matchStatisticsRowBarAway">';
                                            htmlConstructor += '<div class="matchStatisticsRowBarAwayBg">';
                                            htmlConstructor += '<div class="matchStatisticsRowAwayLine" style="width:' + vv + '%;background-color:' + ((vv > tt) ? 'red' : '') + ';"></div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '</div>';
                                            htmlConstructor += '</div>';
                                        }
                                    });
                                }
                                htmlConstructor += '</div>';
                                htmlConstructor += '</section>';

                                // Populate Match Lineups section
                                htmlConstructor += '<section id="lineups" class="tab-content">';
                                htmlConstructor += '<div class="tab-container">';
                                htmlConstructor += '<div class="lineupsTitle">Starting Lineups</div>';
                                htmlConstructor += '<div class="lineupsContainer">';
                                if ((res[0].lineup.home.starting_lineups.length == 0) || (res[0].lineup.away.starting_lineups.length == 0)) {
                                    htmlConstructor += '<p class="" style="border-left: solid 0px transparent; margin-left:auto; margin-right:auto; margin-top: 13px;">Sorry, no data!</p>';
                                } else {
                                    htmlConstructor += '<div class="col-left">';
                                    $.each(res[0].lineup.home.starting_lineups, function(key, value) {
                                        htmlConstructor += '<div class="lineupsContainerHome"><div class="lineupsNb">' + ((value.lineup_number == '-1' ? ' ' : value.lineup_number)) + '</div> <div class="lineupsFlag" style="background-image: url(\'' + res[0].team_home_badge + '\');"></div> <div class="lineupsPlayer">' + value.lineup_player + '</div></div>';
                                    });
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="col-right">';
                                    $.each(res[0].lineup.away.starting_lineups, function(key, value) {
                                        htmlConstructor += '<div class="lineupsContainerAway"><div class="lineupsPlayer">' + value.lineup_player + '</div> <div class="lineupsFlag" style="background-image: url(\'' + res[0].team_away_badge + '\');"></div> <div class="lineupsNb">' + ((value.lineup_number == '-1' ? ' ' : value.lineup_number)) + '</div></div>';
                                    });
                                    htmlConstructor += '</div>';
                                }
                                htmlConstructor += '</div>';

                                // Populate Match Substitutes section
                                htmlConstructor += '<div class="lineupsTitle">Substitutes</div>';
                                htmlConstructor += '<div class="lineupsContainer">';
                                if ((res[0].lineup.home.substitutes.length == 0) || (res[0].lineup.away.substitutes.length == 0)) {
                                    htmlConstructor += '<p class="" style="border-left: solid 0px transparent; margin-left:auto; margin-right:auto; margin-top: 13px;">Sorry, no data!</p>';
                                } else {
                                    htmlConstructor += '<div class="col-left">';
                                    $.each(res[0].lineup.home.substitutes, function(key, value) {
                                        htmlConstructor += '<div class="lineupsContainerHome"><div class="lineupsNb">' + ((value.lineup_number == '-1' ? ' ' : value.lineup_number)) + '</div> <div class="lineupsFlag" style="background-image: url(\'' + res[0].team_home_badge + '\');"></div> <div class="lineupsPlayer">' + value.lineup_player + '</div></div>';
                                    });
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="col-right">';
                                    $.each(res[0].lineup.away.substitutes, function(key, value) {
                                        htmlConstructor += '<div class="lineupsContainerAway"><div class="lineupsPlayer">' + value.lineup_player + '</div> <div class="lineupsFlag" style="background-image: url(\'' + res[0].team_away_badge + '\');"></div> <div class="lineupsNb">' + ((value.lineup_number == '-1' ? ' ' : value.lineup_number)) + '</div></div>';
                                    });
                                    htmlConstructor += '</div>';
                                }
                                htmlConstructor += '</div>';
                                htmlConstructor += '<div class="lineupsTitle">Coaches</div>';
                                htmlConstructor += '<div class="lineupsContainer">';
                                if ((res[0].lineup.home.coach.length == 0) || (res[0].lineup.away.coach.length == 0)) {
                                    htmlConstructor += '<p class="" style="border-left: solid 0px transparent; margin-left:auto; margin-right:auto; margin-top: 13px;">Sorry, no data!</p>';
                                } else {
                                    htmlConstructor += '<div class="col-left">';
                                    $.each(res[0].lineup.home.coach, function(key, value) {
                                        htmlConstructor += '<div class="lineupsContainerHome"><div class="lineupsNb"></div> <div class="lineupsFlag" style="background-image: url(\'' + res[0].team_home_badge + '\');"></div> <div class="lineupsPlayer">' + value.lineup_player + '</div></div>';
                                    });
                                    htmlConstructor += '</div>';
                                    htmlConstructor += '<div class="col-right">';
                                    $.each(res[0].lineup.away.coach, function(key, value) {
                                        htmlConstructor += '<div class="lineupsContainerAway"><div class="lineupsPlayer">' + value.lineup_player + '</div> <div class="lineupsFlag" style="background-image: url(\'' + res[0].team_away_badge + '\');"></div> <div class="lineupsNb"></div></div>';
                                    });
                                    htmlConstructor += '</div>';
                                }
                                htmlConstructor += '</div>';
                                htmlConstructor += '</div>';
                                htmlConstructor += '</section>';

                                // Populate Match H2H (Head to head) section
                                htmlConstructor += '<section id="matchh2h" class="tab-content">';
                                htmlConstructor += '<div class="tab-container">';
                                var htmlInsideTabsConstructorh2h = '';
                                // Send server request for H2H
                                $.ajax({
                                    url: matchResultsDetailsAjaxURL,
                                    cache: false,
                                    data: {
                                        action: 'get_H2H',
                                        Widgetkey: Widgetkey,
                                        firstTeam: res[0].match_hometeam_name,
                                        secondTeam: res[0].match_awayteam_name,
                                        timezone:getTimeZone()
                                    },
                                    dataType: 'json'
                                }).done(function(res2) {
                                    // If server send results we populate HTML with sended information
                                    if(!res2.error){
                                        htmlInsideTabsConstructorh2h += '<div class="flex-table header">';
                                        htmlInsideTabsConstructorh2h += '<div title="hh22hh" class="flex-row matchh2hHeader fix-width" role="columnheader">Last matches: ' + res[0].match_hometeam_name + '</div>';
                                        htmlInsideTabsConstructorh2h += '</div>';
                                        htmlInsideTabsConstructorh2h += '<div class="tablele-container">';
                                        htmlInsideTabsConstructorh2h += '<div class="table__body">';
                                        $.each(res2.firstTeam_lastResults, function(key, value) {
                                            var event_final_result_class = value.match_hometeam_score + ' - ' + value.match_awayteam_score;
                                            var event_final_result_class_away = value.match_awayteam_score;
                                            var event_final_result_class_home = value.match_hometeam_score;
                                            var formattedDate = new Date(value.match_date);
                                            var d = formattedDate.getDate();
                                            var m = formattedDate.getMonth() + 1;
                                            var y = formattedDate.getFullYear().toString().substr(-2);
                                            var value_country_name = value.country_name.toString().toLowerCase();
                                            htmlInsideTabsConstructorh2h += '<div class="flex-table row" role="rowgroup">';
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row matchh2hDate" role="cell">' + (d < 10 ? '0' + d : d) + '.' + (m < 10 ? '0' + m : m) + '.' + y + '</div>';
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row matchh2hFlags" role="cell"><div class="matchh2hFlag" style="background-image: url(\'' + (((leagueLogo == '') || (leagueLogo == 'null') || (leagueLogo == null) || (leagueLogo == 'https://apiv2.apifootball.com/badges/logo_leagues/-1')) ? 'img/no-img.png' : leagueLogo) + '\');"></div></div>';
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row countryNameStyle" role="cell">' + value_country_name + '</div>';
                                            if (event_final_result_class_home > event_final_result_class_away) {
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hWinnerHome flex-row fix-width ' + (((res[0].match_hometeam_name == value.match_hometeam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_hometeam_name + '</div>';
                                                htmlInsideTabsConstructorh2h += '<div class="flex-row fix-width ' + (((res[0].match_hometeam_name == value.match_awayteam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_awayteam_name + '</div>';
                                            } else if (event_final_result_class_home < event_final_result_class_away) {
                                                htmlInsideTabsConstructorh2h += '<div class="flex-row fix-width ' + (((res[0].match_hometeam_name == value.match_hometeam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_hometeam_name + '</div>';
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hWinnerAway flex-row fix-width ' + (((res[0].match_hometeam_name == value.match_awayteam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_awayteam_name + '</div>';
                                            } else if (event_final_result_class_home == event_final_result_class_away) {
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hEqual flex-row fix-width ' + (((res[0].match_hometeam_name == value.match_hometeam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_hometeam_name + '</div>';
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hEqual flex-row fix-width ' + (((res[0].match_hometeam_name == value.match_awayteam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_awayteam_name + '</div>';
                                            }
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row matchh2hEventFinalResult" role="cell">' + event_final_result_class + '</div>';
                                            htmlInsideTabsConstructorh2h += '</div>';
                                        });
                                        htmlInsideTabsConstructorh2h += '</div>';
                                        htmlInsideTabsConstructorh2h += '</div>';
                                        htmlInsideTabsConstructorh2h += '<div class="flex-table header">';
                                        htmlInsideTabsConstructorh2h += '<div title="hh22hh" class="flex-row matchh2hHeader fix-width" role="columnheader">Last matches: ' + res[0].match_awayteam_name + '</div>';
                                        htmlInsideTabsConstructorh2h += '</div>';
                                        htmlInsideTabsConstructorh2h += '<div class="tablele-container">';
                                        htmlInsideTabsConstructorh2h += '<div class="table__body">';
                                        $.each(res2.secondTeam_lastResults, function(key, value) {
                                            var event_final_result_class = value.match_hometeam_score + ' - ' + value.match_awayteam_score;
                                            var event_final_result_class_away = value.match_awayteam_score;
                                            var event_final_result_class_home = value.match_hometeam_score;
                                            var formattedDate = new Date(value.match_date);
                                            var d = formattedDate.getDate();
                                            var m = formattedDate.getMonth() + 1;
                                            var y = formattedDate.getFullYear().toString().substr(-2);
                                            var value_country_name = value.country_name.toString().toLowerCase();
                                            htmlInsideTabsConstructorh2h += '<div class="flex-table row" role="rowgroup">';
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row matchh2hDate" role="cell">' + (d < 10 ? '0' + d : d) + '.' + (m < 10 ? '0' + m : m) + '.' + y + '</div>';
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row matchh2hFlags" role="cell"><div class="matchh2hFlag" style="background-image: url(\'' + (((leagueLogo == '') || (leagueLogo == 'null') || (leagueLogo == null) || (leagueLogo == 'https://apiv2.apifootball.com/badges/logo_leagues/-1')) ? 'img/no-img.png' : leagueLogo) + '\');"></div></div>';
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row countryNameStyle" role="cell">' + value_country_name + '</div>';
                                            if (event_final_result_class_home > event_final_result_class_away) {
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hWinnerHome flex-row fix-width ' + (((res[0].match_awayteam_name == value.match_hometeam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_hometeam_name + '</div>';
                                                htmlInsideTabsConstructorh2h += '<div class="flex-row fix-width ' + (((res[0].match_awayteam_name == value.match_awayteam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_awayteam_name + '</div>';
                                            } else if (event_final_result_class_home < event_final_result_class_away) {
                                                htmlInsideTabsConstructorh2h += '<div class="flex-row fix-width ' + (((res[0].match_awayteam_name == value.match_hometeam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_hometeam_name + '</div>';
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hWinnerAway flex-row fix-width ' + (((res[0].match_awayteam_name == value.match_awayteam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_awayteam_name + '</div>';
                                            } else if (event_final_result_class_home == event_final_result_class_away) {
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hEqual flex-row fix-width ' + (((res[0].match_awayteam_name == value.match_hometeam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_hometeam_name + '</div>';
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hEqual flex-row fix-width ' + (((res[0].match_awayteam_name == value.match_awayteam_name)) ? 'selectedMatchH2H' : '') + '" role="cell">' + value.match_awayteam_name + '</div>';
                                            }
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row matchh2hEventFinalResult" role="cell">' + event_final_result_class + '</div>';
                                            htmlInsideTabsConstructorh2h += '</div>';
                                        });
                                        htmlInsideTabsConstructorh2h += '</div>';
                                        htmlInsideTabsConstructorh2h += '</div>';
                                        htmlInsideTabsConstructorh2h += '<div class="flex-table header">';
                                        htmlInsideTabsConstructorh2h += '<div title="hh22hh" class="flex-row matchh2hHeader fix-width" role="columnheader">Head-to-head matches: ' + res[0].match_hometeam_name + ' - ' + res[0].match_awayteam_name + '</div>';
                                        htmlInsideTabsConstructorh2h += '</div>';
                                        htmlInsideTabsConstructorh2h += '<div class="tablele-container">';
                                        htmlInsideTabsConstructorh2h += '<div class="table__body">';
                                        $.each(res2.firstTeam_VS_secondTeam, function(key, value) {
                                            var event_final_result_class = value.match_hometeam_score + ' - ' + value.match_awayteam_score;
                                            var event_final_result_class_away = value.match_awayteam_score;
                                            var event_final_result_class_home = value.match_hometeam_score;
                                            var formattedDate = new Date(value.match_date);
                                            var d = formattedDate.getDate();
                                            var m = formattedDate.getMonth() + 1;
                                            var y = formattedDate.getFullYear().toString().substr(-2);
                                            var value_country_name = value.country_name.toString().toLowerCase();
                                            htmlInsideTabsConstructorh2h += '<div class="flex-table row" role="rowgroup">';
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row matchh2hDate" role="cell">' + (d < 10 ? '0' + d : d) + '.' + (m < 10 ? '0' + m : m) + '.' + y + '</div>';
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row matchh2hFlags" role="cell"><div class="matchh2hFlag" style="background-image: url(\'' + (((leagueLogo == '') || (leagueLogo == 'null') || (leagueLogo == null) || (leagueLogo == 'https://apiv2.apifootball.com/badges/logo_leagues/-1')) ? 'img/no-img.png' : leagueLogo) + '\');"></div></div>';
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row countryNameStyle" role="cell">' + value_country_name + '</div>';
                                            if (event_final_result_class_home > event_final_result_class_away) {
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hWinnerHome flex-row fix-width" role="cell">' + value.match_hometeam_name + '</div>';
                                                htmlInsideTabsConstructorh2h += '<div class="flex-row fix-width" role="cell">' + value.match_awayteam_name + '</div>';
                                            } else if (event_final_result_class_home < event_final_result_class_away) {
                                                htmlInsideTabsConstructorh2h += '<div class="flex-row fix-width" role="cell">' + value.match_hometeam_name + '</div>';
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hWinnerAway flex-row fix-width" role="cell">' + value.match_awayteam_name + '</div>';
                                            } else if (event_final_result_class_home == event_final_result_class_away) {
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hEqual flex-row fix-width" role="cell">' + value.match_hometeam_name + '</div>';
                                                htmlInsideTabsConstructorh2h += '<div class="teamClassStyleH2hEqual flex-row fix-width" role="cell">' + value.match_awayteam_name + '</div>';
                                            }
                                            htmlInsideTabsConstructorh2h += '<div class="flex-row matchh2hEventFinalResult" role="cell">' + event_final_result_class + '</div>';
                                            htmlInsideTabsConstructorh2h += '</div>';
                                        });
                                        htmlInsideTabsConstructorh2h += '</div>';
                                        htmlInsideTabsConstructorh2h += '</div>';
                                        $('#matchh2h .tab-container').append(htmlInsideTabsConstructorh2h);
                                    } else {
                                        htmlInsideTabsConstructorh2h += '<p class="" style="border-left: solid 0px transparent; margin-left:auto; margin-right:auto; margin-top: 13px; text-align:center;">Sorry, no data!</p>';
                                        $('#matchh2h .tab-container').append(htmlInsideTabsConstructorh2h);
                                    }
                                });
                                htmlConstructor += '</div>';
                                htmlConstructor += '</section>';

                                // Populate Match Top Scorers section
                                htmlConstructor += '<section id="matchTopScorers" class="tab-content">';
                                htmlConstructor += '<div class="tab-container">';
                                var htmlInsideTabsConstructorTS = '';
                                // Send server request for Topscorers
                                $.ajax({
                                    url: matchResultsDetailsAjaxURL,
                                    cache: false,
                                    data: {
                                        action: 'get_topscorers',
                                        Widgetkey: Widgetkey,
                                        league_id: res[0].league_id
                                    },
                                    dataType: 'json'
                                }).done(function(res) {
                                    // If server send results we populate HTML with sended information
                                    if (!res.error) {
                                        htmlInsideTabsConstructorTS += '<div class="tablele-container">';
                                        htmlInsideTabsConstructorTS += '<div class="flex-table header">';
                                        htmlInsideTabsConstructorTS += '<div title="Rank" class="flex-row first fix-width" role="columnheader">#</div>';
                                        htmlInsideTabsConstructorTS += '<div title="Player" class="flex-row players" role="columnheader">Player</div>';
                                        htmlInsideTabsConstructorTS += '<div title="Team" class="flex-row playerTeam fix-width" role="columnheader">Team</div>';
                                        htmlInsideTabsConstructorTS += '<div title="Goals" class="flex-row goals" role="columnheader">G</div>';
                                        htmlInsideTabsConstructorTS += '</div>';
                                        htmlInsideTabsConstructorTS += '<div class="table__body">';
                                        $.each(res, function(key, value) {
                                            htmlInsideTabsConstructorTS += '<div class="flex-table row" role="rowgroup">';
                                            htmlInsideTabsConstructorTS += '<div class="flex-row first fix-width" role="cell">' + value.player_place + '.</div>';
                                            htmlInsideTabsConstructorTS += '<div class="flex-row players" role="cell"><a href="#">' + value.player_name + '</a></div>';
                                            htmlInsideTabsConstructorTS += '<div class="flex-row playerTeam" role="cell"><a href="#">' + value.team_name + '</a></div>';
                                            htmlInsideTabsConstructorTS += '<div class="flex-row goals fix-width" role="cell">' + value.goals + '</div>';
                                            htmlInsideTabsConstructorTS += '</div>';
                                        });
                                        htmlInsideTabsConstructorTS += '</div>';
                                        htmlInsideTabsConstructorTS += '</div>';
                                    } else {
                                        htmlInsideTabsConstructorTS += '<p class="" style="border-left: solid 0px transparent; margin-left:auto; margin-right:auto; margin-top: 13px; text-align:center;">Sorry, no data!</p>';
                                    }
                                    $('#matchTopScorers .tab-container').append(htmlInsideTabsConstructorTS);
                                });
                                htmlConstructor += '</div>';
                                htmlConstructor += '</section>';

                                // Populate Match Standings section
                                htmlConstructor += '<section id="matchStandings" class="tab-content">';
                                htmlConstructor += '<div class="tab-container">';
                                // Send server request for Standings
                                $.ajax({
                                    url: matchResultsDetailsAjaxURL,
                                    cache: false,
                                    data: {
                                        action: 'get_standings',
                                        Widgetkey: Widgetkey,
                                        league_id: res[0].league_id
                                    },
                                    dataType: 'json'
                                }).done(function(res) {
                                    var newStand = {
                                        'total': [],
                                        'home': [],
                                        'away': []
                                    };
                                    var i = 0;

                                    if (!res.error) {
                                        $.each(res, function(key, value) {
                                            var ii = i++;
                                            newStand['total'][ii] = {
                                                'country_name': value['country_name'],
                                                'league_id': value['league_id'],
                                                'league_name': value['league_name'],
                                                'team_id': value['team_id'],
                                                'team_name': value['team_name'],
                                                'league_round': value['league_round'],
                                                'league_position': value['overall_league_position'],
                                                'league_payed': value['overall_league_payed'],
                                                'league_W': value['overall_league_W'],
                                                'league_D': value['overall_league_D'],
                                                'league_L': value['overall_league_L'],
                                                'league_GF': value['overall_league_GF'],
                                                'league_GA': value['overall_league_GA'],
                                                'league_PTS': value['overall_league_PTS'],
                                                'promotion': value['overall_promotion']
                                            };
                                            newStand['home'][ii] = {
                                                'country_name': value['country_name'],
                                                'league_id': value['league_id'],
                                                'league_name': value['league_name'],
                                                'team_id': value['team_id'],
                                                'team_name': value['team_name'],
                                                'league_round': value['league_round'],
                                                'league_position': value['home_league_position'],
                                                'league_payed': value['home_league_payed'],
                                                'league_W': value['home_league_W'],
                                                'league_D': value['home_league_D'],
                                                'league_L': value['home_league_L'],
                                                'league_GF': value['home_league_GF'],
                                                'league_GA': value['home_league_GA'],
                                                'league_PTS': value['home_league_PTS']
                                            };
                                            newStand['away'][ii] = {
                                                'country_name': value['country_name'],
                                                'league_id': value['league_id'],
                                                'league_name': value['league_name'],
                                                'team_id': value['team_id'],
                                                'team_name': value['team_name'],
                                                'league_round': value['league_round'],
                                                'league_position': value['away_league_position'],
                                                'league_payed': value['away_league_payed'],
                                                'league_W': value['away_league_W'],
                                                'league_D': value['away_league_D'],
                                                'league_L': value['away_league_L'],
                                                'league_GF': value['away_league_GF'],
                                                'league_GA': value['away_league_GA'],
                                                'league_PTS': value['away_league_PTS']
                                            };
                                        });
                                    }
                                    // If server send results hide loading
                                    $('.loading').hide();
                                    var htmlInsideTabsConstructorS = '<div class="nav-tab-wrapper">';
                                    var firstElementInJson = 0;
                                    var htmlConstructorS = '';
                                    $.each(newStand, function(key, value) {
                                        var sorted = sortByKey(newStand[key], 'key');
                                        var sorted_array = sortByKeyAsc(sorted, "league_round");
                                        var groubedByTeam = groupBy(sorted_array, 'league_round');
                                        var leagueRoundMatchResult = '';
                                        var leagueRoundName = '';
                                        $.each(groubedByTeam, function(keyss, valuess) {
                                            $.each(valuess, function(keyssss, valuessss) {
                                                if (valuessss.team_id == hometeamKeyMain) {
                                                    leagueRoundName = valuessss.league_round;
                                                    leagueRoundMatchResult = valuessss.league_round;
                                                }
                                            });
                                        });
                                        var onlySelectedGroup = groubedByTeam[leagueRoundMatchResult];
                                        if (firstElementInJson == 0) {
                                            htmlConstructorS += '<a href="#' + key + '" class="standing-h2 nav-tab nav-tab-active">' + key + '</a>';
                                            htmlInsideTabsConstructorS += '<section id="' + key + '" class="tab-content active">';
                                            htmlInsideTabsConstructorS += '<div class="tablele-container">';
                                            if ($.isEmptyObject(onlySelectedGroup)) {
                                                htmlInsideTabsConstructorS += '<div class="flex-table header" role="rowgroup">';
                                                htmlInsideTabsConstructorS += '<div title="Rank" class="flex-row first fix-width" role="columnheader">#</div>';
                                                htmlInsideTabsConstructorS += '<div title="Team" class="flex-row teams" role="columnheader">Team</div>';
                                                htmlInsideTabsConstructorS += '<div title="Matches Played" class="flex-row fix-width" role="columnheader">MP</div>';
                                                htmlInsideTabsConstructorS += '<div title="Wins" class="flex-row fix-width" role="columnheader">W</div>';
                                                htmlInsideTabsConstructorS += '<div title="Draws" class="flex-row fix-width" role="columnheader">D</div>';
                                                htmlInsideTabsConstructorS += '<div title="Losses" class="flex-row fix-width" role="columnheader">L</div>';
                                                htmlInsideTabsConstructorS += '<div title="Goals" class="flex-row goals" role="columnheader">G</div>';
                                                htmlInsideTabsConstructorS += '<div title="Points" class="flex-row fix-width" role="columnheader">Pts</div>';
                                                htmlInsideTabsConstructorS += '</div>';
                                                htmlInsideTabsConstructorS += '<div class="table__body">';
                                                htmlInsideTabsConstructorS += '<div class="flex-table-error row" role="rowgroup">';
                                                htmlInsideTabsConstructorS += '<p class="" style="border-left: solid 0px transparent; margin-left:auto; margin-right:auto; margin-top: 5px;">Sorry, no data!</p>';
                                                htmlInsideTabsConstructorS += '</div>';
                                                htmlInsideTabsConstructorS += '</div>';
                                            } else {
                                                htmlInsideTabsConstructorS += '<div class="flex-table header">';
                                                htmlInsideTabsConstructorS += '<div title="Rank" class="flex-row first fix-width" role="columnheader">#</div>';
                                                htmlInsideTabsConstructorS += '<div title="' + ((!leagueRoundName) ? "Team" : leagueRoundName) + '" class="flex-row teams" role="columnheader">' + ((!leagueRoundName) ? "Team" : leagueRoundName) + '</div>';
                                                htmlInsideTabsConstructorS += '<div title="Matches Played" class="flex-row fix-width" role="columnheader">MP</div>';
                                                htmlInsideTabsConstructorS += '<div title="Wins" class="flex-row fix-width" role="columnheader">W</div>';
                                                htmlInsideTabsConstructorS += '<div title="Draws" class="flex-row fix-width" role="columnheader">D</div>';
                                                htmlInsideTabsConstructorS += '<div title="Losses" class="flex-row fix-width" role="columnheader">L</div>';
                                                htmlInsideTabsConstructorS += '<div title="Goals" class="flex-row goals" role="columnheader">G</div>';
                                                htmlInsideTabsConstructorS += '<div title="Points" class="flex-row fix-width" role="columnheader">Pts</div>';
                                                htmlInsideTabsConstructorS += '</div>';
                                                htmlInsideTabsConstructorS += '<div class="table__body">';
                                                var colorForStanding = ['colorOne', 'colorTwo', 'colorThree', 'colorFour', 'colorFive', 'colorSix', 'colorSeven', 'colorEight', 'colorNine', 'colorTen'];
                                                var colorStringValue = -1;
                                                var stringToCompareStandings = '';
                                                $.each(onlySelectedGroup, function(keys, values) {
                                                    htmlInsideTabsConstructorS += '<div class="flex-table row" role="rowgroup">';
                                                    if (values.promotion) {
                                                        if (stringToCompareStandings != values.promotion) {
                                                            stringToCompareStandings = values.promotion;
                                                            colorStringValue++;
                                                            colorForStanding[colorStringValue];
                                                            htmlInsideTabsConstructorS += '<div class="flex-row first-sticky fix-width ' + colorForStanding[colorStringValue] + '" title="' + values.promotion + '" role="cell">' + values.league_position + '.</div>';
                                                        } else if (stringToCompareStandings == values.promotion) {
                                                            colorForStanding[colorStringValue];
                                                            htmlInsideTabsConstructorS += '<div class="flex-row first-sticky fix-width ' + colorForStanding[colorStringValue] + '" title="' + values.promotion + '" role="cell">' + values.league_position + '.</div>';
                                                        }
                                                    } else if (!values.promotion) {
                                                        colorStringValue = $(colorForStanding).length / 2;
                                                        htmlInsideTabsConstructorS += '<div class="flex-row first-sticky fix-width ' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + '" role="cell">' + values.league_position + '.</div>';
                                                    }
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row teams" role="cell"><a href="#" onclick="windowPreventOpening()">' + values.team_name + '</a></div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row fix-width" role="cell">' + values.league_payed + '</div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row fix-width" role="cell">' + values.league_W + '</div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row fix-width" role="cell">' + values.league_D + '</div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row fix-width" role="cell">' + values.league_L + '</div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row goals" role="cell">' + values.league_GF + ':' + values.league_GA + '</div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row fix-width" role="cell">' + values.league_PTS + '</div>';
                                                    htmlInsideTabsConstructorS += '</div>';
                                                });
                                                htmlInsideTabsConstructorS += '</div>';
                                            }
                                            htmlInsideTabsConstructorS += '</div>';
                                            htmlInsideTabsConstructorS += '</section>';
                                            firstElementInJson++
                                        } else {
                                            htmlConstructorS += '<a href="#' + key + '" class="standing-h2 nav-tab">' + key + '</a>';
                                            htmlInsideTabsConstructorS += '<section id="' + key + '" class="tab-content">';
                                            htmlInsideTabsConstructorS += '<div class="tablele-container">';
                                            if ($.isEmptyObject(onlySelectedGroup)) {
                                                htmlInsideTabsConstructorS += '<div class="flex-table header" role="rowgroup">';
                                                htmlInsideTabsConstructorS += '<div title="Rank" class="flex-row first fix-width" role="columnheader">#</div>';
                                                htmlInsideTabsConstructorS += '<div title="Team" class="flex-row teams" role="columnheader">Team</div>';
                                                htmlInsideTabsConstructorS += '<div title="Matches Played" class="flex-row fix-width" role="columnheader">MP</div>';
                                                htmlInsideTabsConstructorS += '<div title="Wins" class="flex-row fix-width" role="columnheader">W</div>';
                                                htmlInsideTabsConstructorS += '<div title="Draws" class="flex-row fix-width" role="columnheader">D</div>';
                                                htmlInsideTabsConstructorS += '<div title="Losses" class="flex-row fix-width" role="columnheader">L</div>';
                                                htmlInsideTabsConstructorS += '<div title="Goals" class="flex-row goals" role="columnheader">G</div>';
                                                htmlInsideTabsConstructorS += '<div title="Points" class="flex-row fix-width" role="columnheader">Pts</div>';
                                                htmlInsideTabsConstructorS += '</div>';
                                                htmlInsideTabsConstructorS += '<div class="table__body">';
                                                htmlInsideTabsConstructorS += '<div class="flex-table-error row" role="rowgroup">';
                                                htmlInsideTabsConstructorS += '<p class="" style="border-left: solid 0px transparent; margin-left:auto; margin-right:auto; margin-top: 5px;">Sorry, no data!</p>';
                                                htmlInsideTabsConstructorS += '</div>';
                                                htmlInsideTabsConstructorS += '</div>';
                                            } else {
                                                htmlInsideTabsConstructorS += '<div class="flex-table header">';
                                                htmlInsideTabsConstructorS += '<div title="Rank" class="flex-row first fix-width" role="columnheader">#</div>';
                                                htmlInsideTabsConstructorS += '<div title="' + ((!leagueRoundName) ? "Team" : leagueRoundName) + '" class="flex-row teams" role="columnheader">' + ((!leagueRoundName) ? "Team" : leagueRoundName) + '</div>';
                                                htmlInsideTabsConstructorS += '<div title="Matches Played" class="flex-row fix-width" role="columnheader">MP</div>';
                                                htmlInsideTabsConstructorS += '<div title="Wins" class="flex-row fix-width" role="columnheader">W</div>';
                                                htmlInsideTabsConstructorS += '<div title="Draws" class="flex-row fix-width" role="columnheader">D</div>';
                                                htmlInsideTabsConstructorS += '<div title="Losses" class="flex-row fix-width" role="columnheader">L</div>';
                                                htmlInsideTabsConstructorS += '<div title="Goals" class="flex-row goals" role="columnheader">G</div>';
                                                htmlInsideTabsConstructorS += '<div title="Points" class="flex-row fix-width" role="columnheader">Pts</div>';
                                                htmlInsideTabsConstructorS += '</div>';
                                                htmlInsideTabsConstructorS += '<div class="table__body">';

                                                var sortStandingTabs = onlySelectedGroup;
                                                sortStandingTabs.sort(function(a, b){
                                                    return b.league_PTS-a.league_PTS
                                                });

                                                var league_position_nb = 1;
                                                $.each(sortStandingTabs, function(keys, values) {
                                                    htmlInsideTabsConstructorS += '<div class="flex-table row" role="rowgroup">';
                                                    htmlInsideTabsConstructorS += '<div class="flex-row first fix-width" role="cell">' + league_position_nb + '.</div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row teams" role="cell"><a href="#" onclick="windowPreventOpening()">' + values.team_name + '</a></div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row fix-width" role="cell">' + values.league_payed + '</div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row fix-width" role="cell">' + values.league_W + '</div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row fix-width" role="cell">' + values.league_D + '</div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row fix-width" role="cell">' + values.league_L + '</div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row goals" role="cell">' + values.league_GF + ':' + values.league_GA + '</div>';
                                                    htmlInsideTabsConstructorS += '<div class="' + (((hometeamKeyMain == values.team_id) || (awayteamKeyMain == values.team_id)) ? 'selectedMatchStandings' : '') + ' flex-row fix-width" role="cell">' + values.league_PTS + '</div>';
                                                    htmlInsideTabsConstructorS += '</div>';
                                                    league_position_nb++;
                                                });
                                                htmlInsideTabsConstructorS += '</div>';
                                            }
                                            htmlInsideTabsConstructorS += '</div>';
                                            htmlInsideTabsConstructorS += '</section>';
                                        }
                                    });
                                    htmlInsideTabsConstructorS += '</div>';
                                    $('#matchStandings .tab-container').append(htmlInsideTabsConstructorS);
                                    $('#matchStandings .nav-tab-wrapper').prepend(htmlConstructorS);
                                
                                    // Switching tabs on click
                                    $('#matchStandings .nav-tab').unbind('click').on('click', function(e) {
                                        e.preventDefault();
                                        //Toggle tab link
                                        $(this).addClass('nav-tab-active').siblings().removeClass('nav-tab-active');
                                        //Toggle target tab
                                        $($(this).attr('href')).addClass('active').siblings().removeClass('active');
                                    });
                                });
                                htmlConstructor += '</div>';
                                htmlConstructor += '</section>';
                                htmlConstructor += '</div>';
                                htmlConstructor += '</div>';
                                $('#matchResultsContentTable').append(htmlConstructor);
                                // Added close button in HTML
                                $('#matchResultsContentTable').append('<p class="closeWindow">close window</p>');
                                // Added click function to close window
                                $('.closeWindow').click(function() {
                                    window.close();
                                });
                                // Switching tabs on click
                                $('.nav-tab').unbind('click').on('click', function(e) {
                                    e.preventDefault();
                                    //Toggle tab link
                                    $(this).addClass('nav-tab-active').parent().parent().siblings().find('a').removeClass('nav-tab-active');
                                    //Toggle target tab
                                    $($(this).attr('href')).addClass('active').siblings().removeClass('active');
                                });
                            }
                            clearInterval(seeWhatMatchDetailsToShow);
                        }
                    }, 10);
                } else {
                    // If server not sending data, show pop-up and after click closing window
                    alert('Sorry, no data!');
                    window.close();
                }

            }).fail(function(error) {

            });
        },

        callback: function() {

        }

    });

    $.fn.widgetMatchResults = function(options) {
        this.each(function() {
            if (!$.data(this, "plugin_" + widgetMatchResults)) {
                $.data(this, "plugin_" + widgetMatchResults, new Plugin(this, options));
            }
        });
        return this;
    };

    $.fn.widgetMatchResults.defaults = {
        // Widgetkey will be set in jqueryGlobals.js and can be obtained from your account
        Widgetkey: Widgetkey,
        // Action for this widget
        action: 'get_events',
        // Link to server data
        matchResultsDetailsAjaxURL: 'https://apiv2.apifootball.com/?',
        // Background color for your Leagues Widget
        backgroundColor: null,
        // Width for your widget
        widgetWidth: '100%',
        // Set the match Id (it will be set automaticaly when you click on a match)
        match_id: (sessionStorage.getItem('matchDetailsKey') ? sessionStorage.getItem('matchDetailsKey') : null),
        // Set the match league logo (it will be set automaticaly when you click on a match)
        leagueLogo: (sessionStorage.getItem('leagueLogo') ? sessionStorage.getItem('leagueLogo') : 'img/no-img.png')
    };

})(jQuery, window, document);