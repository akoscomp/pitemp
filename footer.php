<!-- SCRIPTS -->
    <script src="js/functions.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("[name='my-checkbox']").bootstrapSwitch();
	    //$.plot($("#flot-placeholder"), [ [[0, 0], [1, 1]] ], { yaxis: { max: 1 } });
            read();
        });
        var count = 0;
        var timer = $.timer(function() {
            $('#counter').html(++count);
            read();
        });
        timer.set({ time : 60000, autostart : true });
        $('.btn').button()
    </script>

    </body>
</html>
