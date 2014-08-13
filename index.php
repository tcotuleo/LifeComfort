<?php
if (isset($_POST['age'])) {
    $age = $_POST['age'];
} else {
    $age = 30;
}
if (isset($_POST['income'])) {
    $income = $_POST['income'];
} else {
    $income = 60000;
}
if (isset($_POST['income_change'])) {
    $income_change = $_POST['income_change'];
} else {
    $income_change = .05;
}
if (isset($_POST['percent_income'])) {
    $percent_income = $_POST['percent_income'];
} else {
    $percent_income = .10;
}
if (isset($_POST['age_retirement'])) {
    $age_retirement = $_POST['age_retirement'];
} else {
    $age_retirement = 65;
}
if (isset($_POST['current_savings'])) {
    $current_savings = $_POST['current_savings'];
} else {
    $current_savings = 40000;
}
if (isset($_POST['interest_rate'])) {
    $interest_rate = $_POST['interest_rate'];
} else {
    $interest_rate = .065;
}
if (isset($_POST['year_interest'])) {
    $year_interest = $_POST['year_interest'];
} else {
    $year_interest = 15;
}
if (isset($_POST['new_interest'])) {
    $new_interest = $_POST['new_interest'];
} else {
    $new_interest = .07;
}
if (isset($_POST['inflation'])) {
    $inflation = $_POST['inflation'];
} else {
    $inflation = .04;
}
$total_by_year = [];
$total = $current_savings;
$income_current = $income;
array_push($total_by_year,$total);

for ($year=$age;$year<$age_retirement;$year++){
    $total = ($total * (1 + $interest_rate)) + ($income * $percent_income);
    array_push($total_by_year,$total);
    $income_current = $income_current * (1 + $income_change);
    if ($year >= $year_interest){
        $interest = $new_interest;
    }
}
$js_array = json_encode($total_by_year);
print_r($js_array);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="dist/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="dist/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="dist/plugins/jqplot.pointLabels.min.js"></script>
<link rel="stylesheet" type="text/css" href="dist/jquery.jqplot.css" />

<script type="text/javascript" src="dist/plugins/jqplot.pointLabels.min.js"></script>

<script language="javascript" type="text/javascript" src="script.js"></script>
    </head>
    <body>
        <form action="index.php" method="post">
            <p>Age: <input type="text" name="age" value=<?php echo $age ?> /><br>
               Income: <input type="text" name="income" value=<?php echo $income ?> /><br>
               Income Change: <input type="text" name="income_change" value=<?php echo $income_change ?> /><br>
               Percent of Income Contribution: <input type="text" name="percent_income" value=<?php echo $percent_income ?> /><br>
               Age of Retirement: <input type="text" name="age_retirement" value=<?php echo $age_retirement ?> /><br>
               Current Savings: <input type="text" name="current_savings" value=<?php echo $current_savings ?> /><br>
               Interest Rate: <input type="text" name="interest_rate" value=<?php echo $interest_rate ?> /><br>
               Year of Interest Change: <input type="text" name="year_interest" value=<?php echo $year_interest ?> /><br>
               New Interest: <input type="text" name="new_interest" value=<?php echo $new_interest ?> /><br>
               Inflation: <input type="text" name="inflation" value=<?php echo $inflation ?> /><br>
            <p><input type="submit" value="Send it!"></p>
        </form>
        <p>Top of Chart
        <div id="chart1" style="height:450px;width:600px;"> <!-- CHART -->
        </div>
        <script>
            var points = <?php echo $js_array ?>;
            var plot1 = $.jqplot('chart1',[points],
            
            { title:'Retirement Calculator',
              animate: true,
              axes:{xaxis:{min:0},yaxis:{min:0}},
              series:[{color:'#5FAB78'}],
            seriesDefaults: { 
              showMarker:true,
              pointLabels: { show:true } 
            }
            });
        </script>
        <p>Bottom of Chart
    </body>
</html>