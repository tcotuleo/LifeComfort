<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="dist/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="dist/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="dist/jquery.jqplot.css" />

<script language="javascript" type="text/javascript" src="script.js"></script>
    </head>
    <body>
        <div class="dataforchart"> <!-- VALUES -->
            <input type="text" value="5">
            <input type="text" value="2">
            <input type="text" value="8">
            <input type="text" value="1">
        </div>
        <div id="chart1" style="height:300px;width:400px;"> <!-- CHART -->
        </div>
        <p>Top of Chart
        <div id="chartdiv" style="height:300px;width:400px; "></div>
        <script>
            $(document).ready(function() {
            $('.dataforchart').each(function(){

            var points = [];
            $(this).children("input").each(function(index) {
                points[index] = $(this).val();
            });
            var age = $('input[name=age]').val();
            var firstLine = 2;
            $.jqplot('chart1',  [points],{
                title:'Exponential Line',
                axes:{yaxis:{min:0, max:240}},
                series:[{color:'#5FAB78'}]
            });
            });
            });
        </script>
        <p>Bottom of Chart
    </body>
</html>