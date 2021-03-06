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
        if(!is_numeric($age)){
            echo "<p class=\"error_message\">Age must be a number";
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

    $total_by_year = [];
    $inflation_by_year = [];

    if (!$non_number) {
        $total = $current_savings;
        $inflation_total = $current_savings;
        $income_current = $income;
        array_push($total_by_year,$total);
        array_push($inflation_by_year,$inflation_total);
        $interest_rate_effective = $interest_rate;
        
        for ($year=$age;$year<$age_retirement;$year++){
            
            if (($year - $age) >= $year_interest){
                $interest_rate_effective = $new_interest;
            }
            
            $total = round(($total * (1 + ($interest_rate_effective/100))) + ($income_current * ($income_contribute/100)),2);
            $inflation_total = round((($inflation_total * (1 + ($interest_rate_effective/100))) + ($income_current * ($income_contribute/100)))*(1-($inflation/100)),2);
            array_push($total_by_year,$total);
            array_push($inflation_by_year,$inflation_total);
            $income_current = $income_current * (1 + ($income_change/100));
        }
    }
    else{
        array_push($total_by_year,0);
        array_push($inflation_by_year,0);
    }
    
    $total_array = json_encode($total_by_year);
    $inflation_array = json_encode($inflation_by_year);
?>
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
    <div id="chart1" style="height:450px;width:600px;"></div>
    
    <!--Display the summary message -->
    <div id="message">
        <?php echo "<h3>By age " . $age_retirement . " you will have $" . end($total_by_year) . ".</h3>";
              echo "<p><h3>That is $" . end($inflation_by_year) . " when adjusted for " . $inflation . "% inflation.</h3>"?>
    </div>
    
    <script>
        var total = <?php echo $total_array ?>;
        var inflation = <?php echo $inflation_array ?>;
        var plot1 = $.jqplot('chart1',[total,inflation],{ 
            title:'Retirement Calculator',
            animate: true,
            axes:{xaxis:{min:0},yaxis:{min:0}},
            series:[{color:'#5FAB78'}],
            seriesDefaults:{ 
                showMarker:true,
                pointLabels: { show:false },
                shadow: true   // show shadow or not.
            }
        });
    </script>
 
<?php
    include "view/footer.php";
?>