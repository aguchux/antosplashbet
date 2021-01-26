<div id="DOM_element_id_in_your_website_1611050568434"></div>

<script>
  (function(b, s, p, o, r, t) {
    b["broadage"] = b["broadage"] || [];
    if (!b["broadage"].length) {
      r = document.createElement(s);
      t = document.getElementsByTagName(s)[0];
      r.async = true;
      r.src = p;
      t.parentNode.insertBefore(r, t);
    }
    b["broadage"].push({ "bundleId": o.bundleId, "widgets": o.widgets, "accountId": o.accountId });
  })(window, "script", "//cdn-saas.broadage.com/widgets/loader/loader.js", {
    "bundleId": ["soccer-fx"],
    "accountId": "c5feca02-8056-4606-a529-73a61c825390",
    "widgets": {
      "soccerFixture": [{
        "element": "DOM_element_id_in_your_website_1611050568434",
        "tournamentId": 3,
        "options": {
          "detailedScoreVerticalSlide": true,
          "redirectType": "_parent"
        }
      }]
    }
  });
</script>