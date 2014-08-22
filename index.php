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
    $income_change = 50;
}
if (isset($_POST['income_contribute'])) {
    $income_contribute = $_POST['income_contribute'];
} else {
    $income_contribute = 10;
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
    $interest_rate = 6.5;
}
if (isset($_POST['year_interest'])) {
    $year_interest = $_POST['year_interest'];
} else {
    $year_interest = 15;
}
if (isset($_POST['new_interest'])) {
    $new_interest = $_POST['new_interest'];
} else {
    $new_interest = 7;
}
if (isset($_POST['inflation'])) {
    $inflation = $_POST['inflation'];
} else {
    $inflation = 4;
}

$total_by_year = [];
$inflation_by_year = [];
$total = $current_savings;
$inflation_total = $current_savings;
$income_current = $income;
array_push($total_by_year,$total);
array_push($inflation_by_year,$inflation_total);

for ($year=$age;$year<$age_retirement;$year++){
    if (($year - $age) >= $year_interest){
        $interest_rate = ($new_interest);
    }
    $total = round(($total * (1 + ($interest_rate/100))) + ($income * ($income_contribute/100)),2);
    $inflation_total = round(($inflation_total * (1 + ($interest_rate/100))) + ($income * ($income_contribute/100)),2);
    $inflation_total = round($inflation_total*(1-($inflation/100)),2);
    array_push($total_by_year,$total);
    array_push($inflation_by_year,$inflation_total);
    $income_current = $income_current * (1 + ($income_change/100));
}
$total_array = json_encode($total_by_year);
$inflation_array = json_encode($inflation_by_year);

include "/view/header.php";
?>
        
        <div id="values">
            <table> 
                <tr> <td>
            <table border="1"><p id="values_title">Values
            <form action="index.php" method="post">
                
                    <p>
                    <tr> <td>Age: </td> <td> <input type="text" name="age" value=<?php echo $age ?> /><br> </td></tr>
                    <tr> <td>Income: </td> <td><input type="text" name="income" value=<?php echo $income ?> /><br> </td></tr>
                    <tr> <td>Income Change %: </td> <td><input type="text" name="income_change" value=<?php echo $income_change ?> /><br> </td></tr>
                    <tr> <td>Income Contribution %: </td> <td><input type="text" name="income_contribute" value=<?php echo $income_contribute ?> /><br> </td></tr>
                    <tr> <td>Age of Retirement: </td> <td><input type="text" name="age_retirement" value=<?php echo $age_retirement ?> /><br> </td></tr>
                    <tr> <td>Current Savings: </td> <td><input type="text" name="current_savings" value=<?php echo $current_savings ?> /><br> </td></tr>
                    <tr> <td>Interest Rate %: </td> <td><input type="text" name="interest_rate" value=<?php echo $interest_rate ?> /><br> </td></tr>
                    <tr> <td>Year of Interest Change: </td> <td><input type="text" name="year_interest" value=<?php echo $year_interest ?> /><br> </td></tr>
                    <tr> <td>New Interest %: </td> <td><input type="text" name="new_interest" value=<?php echo $new_interest ?> /><br> </td></tr>
                    <tr> <td>Inflation %: </td> <td><input type="text" name="inflation" value=<?php echo $inflation ?> /><br></td></tr>
                <p>
                </table>
                        <input id='button' type="submit" value="Calculate"> </td> </tr>
            
            </form>
        </div>
        <div id="chart1" style="height:450px;width:600px;"> <!-- CHART -->
        </div>
            </table>
        <div id="message">
        <?php echo "<h2>By age " . $age_retirement . " you will have $" . end($total_by_year) . ".</h2>";
              echo "<p><h2>That is $" . end($inflation_by_year) . " when adjusted for " . $inflation . "% inflation."?>
        </div>
        <script>
            var total = <?php echo $total_array ?>;
            var inflation = <?php echo $inflation_array ?>;
            var plot1 = $.jqplot('chart1',[total,inflation],
            { title:'Retirement Calculator',
              animate: true,
              axes:{xaxis:{min:1},yaxis:{min:0}},
              series:[{color:'#5FAB78'}],
            seriesDefaults: { 
              showMarker:true,
              pointLabels: { show:false },
              shadow: true   // show shadow or not.
            }
            });
        </script>
        
<?php
include "view/footer.php";
?>