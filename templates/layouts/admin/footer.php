<!-- BEGIN: JS Assets-->

<script src="<?= $assets ?>js\app.js"></script>
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="http://html2canvas.hertzen.com/build/html2canvas.js"></script>
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
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
            "<html><head><title></title></head><body>" +
            divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;

    }
</script>


<!-- END: JS Assets-->
</body>

</html>