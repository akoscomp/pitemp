<!-- SCRIPTS -->
    <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="http://jchavannes.com/include/scripts/3p/jquery.timer.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <!--<script src="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.js"></script>-->
    <script src="js/bootstrap-switch.min.js"></script>
    <script src="js/functions.js"></script>
    <script>
        $(document).ready(function() {
            $("[name='my-checkbox']").bootstrapSwitch();
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
