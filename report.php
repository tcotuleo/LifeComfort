<?php
    //This will start a session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $chart_array_json = $_SESSION['chart_array_json'];
    
    include"view/header.php";
?>
<div class='print-card'>
    <input type='submit' name='print_report' class='login login-submit' onClick="window.print()" value='Print'></input>
</div>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);
      
      //Populate JavaScript array with PHP Array
      var chart_array = <?php echo $chart_array_json ?>;

      function drawTable() {
        var data = new google.visualization.arrayToDataTable(chart_array);

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {showRowNumber: true});
      }
    </script>
  </head>
  <body>
      <div id="table_div" style='width: 700px; display: block; margin: 0 auto;'></div>
<?php include"view/footer.php";?>

