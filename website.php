<?php
    //This will start a session
    session_start();
    
    //Align all text to center
    echo "<div style='text-align: center'>";
    
    $page_title = "Login/Register";
    include_once "view/header.php";
    
    //Check if a user is already logged in
    if (isset($_SESSION['username']) && isset($_SESSION['password'])){
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
    }

    //If no user is logged in than display the main login page.
    if(!isset($username) && !isset($password)){
        echo "Welcome Guest! <br> <a href=login.php><button type='button'>Login</button></a> | <a href=register.php><button type='button'>Register</button></a>";
        exit();
    }
    else{
        echo "<p class='pos_fixed'>Welcome, <font color='red'>".$username."</font> <a href=logout.php><button type='button'>Logout</button></a></p>";
    }

    $non_number = FALSE;
    if (isset($_POST['age'])) {
        $age = $_POST['age'];
        if($age < 0 ){
            echo "<p class=\"error_message\">Age cannot be less than 0.";
            $non_number = TRUE;
        }
        if($age > 65 ){
            echo "<p class=\"error_message\">Your current age should be less than 65.";
            $non_number = TRUE;
        }
        
    } else {
        $age = 30;
    }
    if (isset($_POST['income'])) {
        $income = $_POST['income'];
        if(!is_numeric($income)){
            echo "<p class=\"error_message\">Income must be a number";
            $non_number = TRUE;
        }
    } else {
        $income = 60000;
    }
    if (isset($_POST['income_change'])) {
        $income_change = $_POST['income_change'];
        if(!is_numeric($income_change)){
            echo "<p class=\"error_message\">Income change must be a number";
            $non_number = TRUE;
        }
    } else {
        $income_change = 5;
    }
    if (isset($_POST['income_contribute'])) {
        $income_contribute = $_POST['income_contribute'];
        if(!is_numeric($income_contribute)){
            echo "<p class=\"error_message\">Income contribution must be a number";
            $non_number = TRUE;
        }
    } else {
        $income_contribute = 10;
    }
    if (isset($_POST['age_retirement'])) {
        $age_retirement = $_POST['age_retirement'];
        if($age_retirement < 0 ){
            echo "<p class=\"error_message\">Retirement age cannot be less than 0.";
            $non_number = TRUE;
        }
        if($age_retirement < $age ){
            echo "<p class=\"error_message\">Your retirement age should not be less than your current age.";
            $non_number = TRUE;
        }
        if(!is_numeric($age_retirement)){
            echo "<p class=\"error_message\">Age of retirement must be a number";
            $non_number = TRUE;
        }
    } else {
        $age_retirement = 65;
    }
    if (isset($_POST['current_savings'])) {
        $current_savings = $_POST['current_savings'];
        if(!is_numeric($current_savings)){
            echo "<p class=\"error_message\">Current savings must be a number";
            $non_number = TRUE;
        }
    } else {
        $current_savings = 40000;
    }
    if (isset($_POST['interest_rate'])) {
        $interest_rate = $_POST['interest_rate'];
        if(!is_numeric($interest_rate)){
            echo "<p class=\"error_message\">Interest rate must be a number";
            $non_number = TRUE;
        }
    } else {
        $interest_rate = 6.5;
    }
    if (isset($_POST['year_interest'])) {
        $year_interest = $_POST['year_interest'];
        if(!is_numeric($year_interest)){
            echo "<p class=\"error_message\">Year of interest change must be a number";
            $non_number = TRUE;
        }
    } else {
        $year_interest = 15;
    }
    if (isset($_POST['new_interest'])) {
        $new_interest = $_POST['new_interest'];
        if(!is_numeric($new_interest)){
            echo "<p class=\"error_message\">New interest must be a number";
            $non_number = TRUE;
        }
    } else {
        $new_interest = 7;
    }
    if (isset($_POST['inflation'])) {
        $inflation = $_POST['inflation'];
        if(!is_numeric($inflation)){
            echo "<p class=\"error_message\">Inflation must be a number";
            $non_number = TRUE;
        }
    } else {
        $inflation = 4;
    }

    $chart_array = [];

    if (!$non_number) {
        $total = floatval($current_savings);
        $inflation_total = floatval($current_savings);
        $income_current = $income;
        
        $title = array("Age", "Total", "Adjusted for inflation");
        $chart_entry = array(strval($age), $total, $inflation_total);
        array_push($chart_array, $title);
        array_push($chart_array,$chart_entry);
        
        $interest_rate_effective = $interest_rate;
        
        for ($year=$age;$year<$age_retirement;$year++){
            
            if (($year - $age) >= $year_interest){
                $interest_rate_effective = $new_interest;
            }
            
            $total = round(($total * (1 + ($interest_rate_effective/100))) + ($income_current * ($income_contribute/100)),2);
            $inflation_total = round((($inflation_total * (1 + ($interest_rate_effective/100))) + ($income_current * ($income_contribute/100)))*(1-($inflation/100)),2);
            $chart_entry = array(strval($year+1), $total, $inflation_total);
            array_push($chart_array,$chart_entry);
            $income_current = $income_current * (1 + ($income_change/100));
            $last_total=$total;
            $last_inflation=$inflation_total;
        }
    }
    else{
        array_push($chart_array, 0, 0);
    }
    
    $chart_array_json = json_encode($chart_array);
?>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      
      // Load the Visualization API and the piechart package.
      google.load("visualization", "1", {packages:["corechart"]});
      
      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);
      
      //Populate JavaScript array with PHP Array
      var chart_array = <?php echo $chart_array_json ?>;
      
      // Callback that creates and populates a data table,
      // instantiates the line graph, passes in the data and
      // draws it.
      function drawChart() {
        var data = google.visualization.arrayToDataTable(chart_array);

        var options = {
          title: 'Retirement Savings',
          hAxis: {title:'Age'},
          vAxis: {title:'Net Worth'},
          animation:{
            duration: 1000,
            easing: 'out',
          }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>
    
    <!--Display the values form -->
    <div id="values">
        <table align='center'> 
            <p id="values_title">Values </p>
            <form action='website.php' method='post'>
                <tr> <td>Age: </td><td> <input type="text" name="age" value=<?php echo $age ?> /><br> </td></tr>
                <tr> <td>Income: </td><td> <input type="text" name="income" value=<?php echo $income ?> /><br> </td></tr>
                <tr> <td>Income Change %: </td><td> <input type="text" name="income_change" value=<?php echo $income_change ?> /><br> </td></tr>
                <tr> <td>Income Contribution %: </td><td> <input type="text" name="income_contribute" value=<?php echo $income_contribute ?> /><br> </td></tr>
                <tr> <td>Age of Retirement: </td><td> <input type="text" name="age_retirement" value=<?php echo $age_retirement ?> /><br> </td></tr>
                <tr> <td>Current Savings: </td><td> <input type="text" name="current_savings" value=<?php echo $current_savings ?> /><br> </td></tr>
                <tr> <td>Interest Rate %: </td><td> <input type="text" name="interest_rate" value=<?php echo $interest_rate ?> /><br> </td></tr>
                <tr> <td>Year of Interest Change: </td><td> <input type="text" name="year_interest" value=<?php echo $year_interest ?> /><br> </td></tr>
                <tr> <td>New Interest %: </td><td> <input type="text" name="new_interest" value=<?php echo $new_interest ?> /><br> </td></tr>
                <tr> <td>Inflation %: </td><td> <input type="text" name="inflation" value=<?php echo $inflation ?> /><br></td></tr>
                <tr> <td><input id='button' type="submit" value="Calculate"></td> </tr>
            </form>
        </table>
    </div>
        
    <!--Display the chart -->
    <div id="chart_div" style="width: 900px; height: 500px;"></div>

    <!--Display the summary message -->
    <div id="message">
        <?php echo "<h3>By age " . $age_retirement . " you will have $" . $last_total . ".</h3>";
              echo "<p><h3>That is $" . $last_inflation . " when adjusted for " . $inflation . "% inflation.</h3>"?>
    </div>
<?php
    include "view/footer.php";
?>