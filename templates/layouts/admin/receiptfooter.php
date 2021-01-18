<!-- BEGIN: JS Assets-->

<script src="<?= $assets ?>js\app.js"></script>
<script>
    $('a[href*="#"]').click(function(e) {
        e.preventDefault();
    });
</script>

<script src="<?= $assets ?>js\apps.js"></script>
<script language="javascript" type="text/javascript">
    function printDiv(divID) {

        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.documentElement.innerHTML;

        //Reset the page's HTML with div's HTML only
        var a = window.open('', '', 'top=0,left=0,height=300, width=100%'); 
        a.body.innerHTML =
            "<html><head><title></title></head>" +
            "<body>" +
            <center><h2></h2></center>
            "</body>" +
            "</html>";
        //Print Page
        a.print();

        //Restore orignal HTML
        document.documentElement.innerHTML = oldPage;

    }
</script>


<!-- END: JS Assets-->
</body>

</html>