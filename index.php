<html>
	<head>
		<meta charset="utf-8" />
		<title>USD/TZS</title>
		<link href="bootstrap.min.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<?php
			$sql_connection = mysqli_connect("localhost","ongeza", "ongeza1234","pesa");
			 	if (mysqli_connect_errno())
				{
				  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}

			
			$result = mysqli_query($sql_connection,"SELECT * 
				FROM exchangerate ");
			
			@$num_results = mysqli_num_rows($result);
			
			mysqli_close($sql_connection);
		?>
		<?php 
			$sql_connection = mysqli_connect("localhost","ongeza", "ongeza1234","pesa");
			 	if (mysqli_connect_errno())
				{
				  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}

			
			$res = mysqli_query($sql_connection,"SELECT * 
				FROM exchangerate ");
			if ($res !== false) {
			    $output = Array();
			    while ($row = mysqli_fetch_assoc($res)) {
			        $DateTimeArray = $row["date"];
			        $MYvalue1 = $row["rate_tz"];
			        
			        
			        $dateArray = explode('-', $DateTimeArray);
			        
			        $year = $dateArray[0];
			        $month = $dateArray[1] - 1; 
			        $day = $dateArray[2];
			        
			       
			        
			        $output[] = "[new Date($year, $month, $day), $MYvalue1]";
			    }
			}
			mysqli_close($sql_connection);
		?>
		<div class="container">
			<header>
				<h2 align="center">Exchange rate record for June 2015</h2>
			</header>
			<div class="col-md-4">
				<table class="table table-hover table-bordered">
					<legend align="center">Tanzanian Shillings (TZS) to 1 US Dollar (USD)</legend>
					<thead>
						<th>Date</th>
						<th>Rate</th>
					</thead>
					<tbody>
						<?php 
						
						for ($i=0; $i<$num_results; $i++) {
							$num=mysqli_fetch_assoc($result);
							$f1=$num["date"];
							$f2=$num["rate_tz"];
							
						    
						?>	
						<tr>
							<td><?php echo $f1; ?></td>
							<td><?php echo $f2; ?></td>
						</tr>
						<?php
						
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="col-md-8">
				<div id='chart_div' style='width: 800px; height: 500px;'></div>
			</div>
		</div>

		<script src="jquery-1.10.2.min.js"></script>
		<script src="bootstrap.min.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['annotationchart']}]}"></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {'packages':['annotationchart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', 'rate_tz');
        // data.addColumn('string', 'Kepler title');
        // data.addColumn('string', 'Kepler text');
        // data.addColumn('number', 'Gliese 163 mission');
        // data.addColumn('string', 'Gliese title');
        // data.addColumn('string', 'Gliese text');

   
        data.addRows([
		<?php echo implode(',', $output); ?>
        ]);


        var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div'));

        var options = {
          displayAnnotations: true
        };

        chart.draw(data, options);
      }
    </script>
	</body>
</html>
