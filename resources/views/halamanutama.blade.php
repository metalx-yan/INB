<!DOCTYPE html>
<html>
<title>Dashboard Staff PDM</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>

<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<body>

	

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-wide w3-padding w3-card">
    <a href="#home" class="w3-bar-item w3-button"><b>BNI</b> PDM</a>
    <!-- Float links to the right. Hide them on small screens -->
    <div class="w3-right w3-hide-small">
      <a href="#projects" class="w3-bar-item w3-button">Performance</a>
      <a href="#about" class="w3-bar-item w3-button">Contact</a>
	  <a href="login" class="w3-bar-item w3-button">Login DBMA</a>
    </div>
  </div>
</div>


<!-- Header -->
<header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
  <img class="bni" src="/assets/bni.png" alt="bni" width="1500" height="800">
  <div class="w3-display-middle w3-margin-top w3-center">
    <h1 class="w3-xxlarge w3-text-white"><span class="bni"><b>BNI</b></span> <span class="w3-hide-small w3-text-light-grey">Architects</span></h1>
  </div>
</header>
</head>
<body>




<!-- Page content -->
<div class="w3-content w3-padding" style="max-width:1564px">

  <!-- Project Section --><div class="w3-container w3-padding-32" id="projects">
	<h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Performance Deposito</h3>
	<figure class="highcharts-figure">
			<div id="container2"></div>
			
		</figure>
	<div>
		<section>
	
		<style>#container2 {
				height: auto; 
			}
			
			.highcharts-figure, .highcharts-data-table table {
				min-width: 310px; 
				max-width: 500px;
				margin: 1em auto;
			}
			
			.highcharts-data-table table {
				font-family: Verdana, sans-serif;
				border-collapse: collapse;
				border: 1px solid #EBEBEB;
				margin: 10px auto;
				text-align: center;
				width: 100%;
				max-width: 500px;
			}
			.highcharts-data-table caption {
				padding: 1em 0;
				font-size: 1.2em;
				color: #555;
			}
			.highcharts-data-table th {
				font-weight: 600;
				padding: 0.5em;
			}
			.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
				padding: 0.5em;
			}
			.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
				background: #f8f8f8;
			}
			.highcharts-data-table tr:hover {
				background: #f1f7ff;
			}
			</style>
		</section>
		<?php
		$target = 100;
		$saldo = 1900000000;
		$deposit =1 ;
		$tabungan= 20000;
		?>
		<script align="left">Highcharts.chart('container2', {
	
				chart: {
					align:screenLeft,
					type: 'gauge',
					plotBackgroundColor: null,
					plotBackgroundImage: null,
					plotBorderWidth: 0,
					plotShadow: false
				},
			
				title: {
					text: ''
				},
			
				pane: {
					startAngle:-150,
					endAngle:150,
					background: [{
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#FFF'],
								[1, '#333']
							]
						},
						borderWidth: 0,
						outerRadius: '109%'
					}, {
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#333'],
								[1, '#FFF']
							]
						},
						borderWidth: 1,
						outerRadius: '107%'
					}, {
						// default background
					}, {
						backgroundColor: '#DDD',
						borderWidth: 0,
						outerRadius: '105%',
						innerRadius: '103%'
					}]
				},
			
				// the value axis
				yAxis: {
					min: 0,
					max: <?php echo $target; ?>,// maximum dalam persen Supaya dashboard enak dibaca
			
					minorTickInterval: 'auto',
					minorTickWidth: 1,
					minorTickLength: 10,
					minorTickPosition: 'inside',
					minorTickColor: '#666',
			
					tickPixelInterval: 30,
					tickWidth: 2,
					tickPosition: 'inside',
					tickLength: 10,
					tickColor: '#666',
					labels: {
						step: 2,
						rotation: 'auto'
					},
					title: {
						text: 'Deposito <?php echo $target; ?>'
					},
					plotBands: [{
						from: 0,
						to: 94,
						color: '#DF5353' // green indikator warna 
					}, {
						from: 95,
						to: 96,
						color: '#DDDF0D' // yellow
					}, {
						from: 98,
						to: 100,
						color: '#008000' // red
					}]
				},
			
				series: [{
					name: 'Saldo',
					data: [
						<?php echo $saldo; ?>], // UNTUK TABUNGAN HARI INI [DATA]
					tooltip: {
						valueSuffix: ''
					}
				}]
			
			},
			// Add some life
			function (chart) {
				if (!chart.renderer.forExport) {
					setInterval(function () {
						var point = chart.series[0].points[0],
							newVal,
							inc = Math.round((Math.random() - 0.5) * 20);
			
						newVal = point.y + inc;
						if (newVal < 0 || newVal > 200) {
							newVal = point.y - inc;
						}
			
						point.update(newVal);
			
					}, 3000);
				}
			});</script>
			
  </div>

  </table>

  <div class="w3-container w3-padding-32" id="projects">
	<h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Performance TaBI BNI</h3>
	<figure class="highcharts-figure">
			<div id="container3"></div>
			
		</figure>
	<div>
		<section>
	<table>
		<tr>
			<td>
		<style>#container3 {
				height: auto; 
			}
			
			.highcharts-figure, .highcharts-data-table table {
				min-width: 310px; 
				max-width: 500px;
				margin: 1em auto;
			}
			
			.highcharts-data-table table {
				font-family: Verdana, sans-serif;
				border-collapse: collapse;
				border: 1px solid #EBEBEB;
				margin: 10px auto;
				text-align: center;
				width: 50%;
				max-width: 10px;
			}
			.highcharts-data-table caption {
				padding: 1em 0;
				font-size: 1.2em;
				color: #555;
			}
			.highcharts-data-table th {
				font-weight: 600;
				padding: 0.5em;
			}
			.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
				padding: 0.5em;
			}
			.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
				background: #f8f8f8;
			}
			.highcharts-data-table tr:hover {
				background: #f1f7ff;
			}
			</style>
		</section>
		<?php
		$target = 100;
		$saldo = 59;
		$deposit = 15;
		?>
		<script>Highcharts.chart('container3', {
	
				chart: {
					type: 'gauge',
					plotBackgroundColor: null,
					plotBackgroundImage: null,
					plotBorderWidth: 0,
					plotShadow: false
				},
			
				title: {
					text: ''
				},
			
				pane: {
					startAngle: -150,
					endAngle: 150,
					background: [{
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#FFF'],
								[1, '#333']
							]
						},
						borderWidth: 0,
						outerRadius: '109%'
					}, {
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#333'],
								[1, '#FFF']
							]
						},
						borderWidth: 1,
						outerRadius: '107%'
					}, {
						// default background
					}, {
						backgroundColor: '#DDD',
						borderWidth: 0,
						outerRadius: '105%',
						innerRadius: '103%'
					}]
				},
			
				// the value axis
				yAxis: {
					min: 0,
					max: <?php echo $target; ?>,// maximum dalam persen Supaya dashboard enak dibaca
			
					minorTickInterval: 'auto',
					minorTickWidth: 1,
					minorTickLength: 10,
					minorTickPosition: 'inside',
					minorTickColor: '#666',
			
					tickPixelInterval: 30,
					tickWidth: 2,
					tickPosition: 'inside',
					tickLength: 10,
					tickColor: '#666',
					labels: {
						step: 2,
						rotation: 'auto'
					},
					title: {
						text: 'Maxi Target <?php echo $target; ?>'
					},
					plotBands: [{
						from: 0,
						to: 94,
						color: '#DF5353' // green indikator warna 
					}, {
						from: 95,
						to: 96,
						color: '#DDDF0D' // yellow
					}, {
						from: 98,
						to: 100,
						color: '#008000' // red
					}]
				},
			
				series: [{
					name: 'Saldo',
					data: [<?php echo $saldo; ?>], // UNTUK TABUNGAN HARI INI [DATA]
					tooltip: {
						valueSuffix: ''
					}
				}]
			
			},
			// Add some life
			function (chart) {
				if (!chart.renderer.forExport) {
					setInterval(function () {
						var point = chart.series[0].points[0],
							newVal,
							inc = Math.round((Math.random() - 0.5) * 20);
			
						newVal = point.y + inc;
						if (newVal < 0 || newVal > 200) {
							newVal = point.y - inc;
						}
			
						point.update(newVal);
			
					}, 1500);
				}
			});</script>
			
  </div>
 
  </table>

  <div class="w3-container w3-padding-32" id="projects">
	<h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Performance Tabungan Perorangan</h3>
	<figure class="highcharts-figure">
			<div id="container"></div>
			
		</figure>
	<div>
		<section>
	<table>
		<tr>
			<td>
		<style>#container {
				height: auto; 
			}
			
			.highcharts-figure, .highcharts-data-table table {
				min-width: 310px; 
				max-width: 500px;
				margin: 1em auto;
			}
			
			.highcharts-data-table table {
				font-family: Verdana, sans-serif;
				border-collapse: collapse;
				border: 1px solid #EBEBEB;
				margin: 10px auto;
				text-align: center;
				width: 100%;
				max-width: 500px;
			}
			.highcharts-data-table caption {
				padding: 1em 0;
				font-size: 1.2em;
				color: #555;
			}
			.highcharts-data-table th {
				font-weight: 600;
				padding: 0.5em;
			}
			.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
				padding: 0.5em;
			}
			.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
				background: #f8f8f8;
			}
			.highcharts-data-table tr:hover {
				background: #f1f7ff;
			}
			</style>
		</section>
		<?php
		$target = 100;
		$saldo = 59;
		$deposit = 15;
		?>
		<script>Highcharts.chart('container', {
	
				chart: {
					type: 'gauge',
					plotBackgroundColor: null,
					plotBackgroundImage: null,
					plotBorderWidth: 0,
					plotShadow: false
				},
			
				title: {
					text: ''
				},
			
				pane: {
					startAngle: -150,
					endAngle: 150,
					background: [{
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#FFF'],
								[1, '#333']
							]
						},
						borderWidth: 0,
						outerRadius: '109%'
					}, {
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#333'],
								[1, '#FFF']
							]
						},
						borderWidth: 1,
						outerRadius: '107%'
					}, {
						// default background
					}, {
						backgroundColor: '#DDD',
						borderWidth: 0,
						outerRadius: '105%',
						innerRadius: '103%'
					}]
				},
			
				// the value axis
				yAxis: {
					min: 0,
					max: <?php echo $target; ?>,// maximum dalam persen Supaya dashboard enak dibaca
			
					minorTickInterval: 'auto',
					minorTickWidth: 1,
					minorTickLength: 10,
					minorTickPosition: 'inside',
					minorTickColor: '#666',
			
					tickPixelInterval: 30,
					tickWidth: 2,
					tickPosition: 'inside',
					tickLength: 10,
					tickColor: '#666',
					labels: {
						step: 2,
						rotation: 'auto'
					},
					title: {
						text: 'Maxi Target <?php echo $target; ?>'
					},
					plotBands: [{
						from: 0,
						to: 94,
						color: '#DF5353' // green indikator warna 
					}, {
						from: 95,
						to: 96,
						color: '#DDDF0D' // yellow
					}, {
						from: 98,
						to: 100,
						color: '#008000' // red
					}]
				},
			
				series: [{
					name: 'Saldo',
					data: [<?php echo $saldo; ?>], // UNTUK TABUNGAN HARI INI [DATA]
					tooltip: {
						valueSuffix: ''
					}
				}]
			
			},
			// Add some life
			function (chart) {
				if (!chart.renderer.forExport) {
					setInterval(function () {
						var point = chart.series[0].points[0],
							newVal,
							inc = Math.round((Math.random() - 0.5) * 20);
			
						newVal = point.y + inc;
						if (newVal < 0 || newVal > 200) {
							newVal = point.y - inc;
						}
			
						point.update(newVal);
			
					}, 3000);
				}
			});</script>
			
  </div>
 
  </table>
  <div class="w3-container w3-padding-32" id="projects">
	<h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Performance BNI Dollar</h3>
	<figure class="highcharts-figure">
			<div id="container7"></div>
			
		</figure>
	<div>
		<section>
	<table>
		<tr>
			<td>
		<style>#container7 {
				height: auto; 
			}
			
			.highcharts-figure, .highcharts-data-table table {
				min-width: 310px; 
				max-width: 500px;
				margin: 1em auto;
			}
			
			.highcharts-data-table table {
				font-family: Verdana, sans-serif;
				border-collapse: collapse;
				border: 1px solid #EBEBEB;
				margin: 10px auto;
				text-align: center;
				width: 100%;
				max-width: 500px;
			}
			.highcharts-data-table caption {
				padding: 1em 0;
				font-size: 1.2em;
				color: #555;
			}
			.highcharts-data-table th {
				font-weight: 600;
				padding: 0.5em;
			}
			.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
				padding: 0.5em;
			}
			.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
				background: #f8f8f8;
			}
			.highcharts-data-table tr:hover {
				background: #f1f7ff;
			}
			</style>
		</section>
		<?php
		$target = 100;
		$saldo = 59;
		$deposit = 15;
		?>
		<script>Highcharts.chart('container7', {
	
				chart: {
					type: 'gauge',
					plotBackgroundColor: null,
					plotBackgroundImage: null,
					plotBorderWidth: 0,
					plotShadow: false,
					plotBorderWidth: auto
				},
			
				title: {
					text: ''
				},
			
				pane: {
					startAngle: -150,
					endAngle: 150,
					background: [{
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#FFF'],
								[1, '#333']
							]
						},
						borderWidth: 0,
						outerRadius: '109%'
					}, {
						backgroundColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
							stops: [
								[0, '#333'],
								[1, '#FFF']
							]
						},
						borderWidth: 1,
						outerRadius: '107%'
					}, {
						// default background
					}, {
						backgroundColor: '#DDD',
						borderWidth: 0,
						outerRadius: '105%',
						innerRadius: '103%'
					}]
				},
			
				// the value axis
				yAxis: {
					min: 0,
					max: <?php echo $target; ?>,// maximum dalam persen Supaya dashboard enak dibaca
			
					minorTickInterval: 'auto',
					minorTickWidth: 1,
					minorTickLength: 10,
					minorTickPosition: 'inside',
					minorTickColor: '#666',
			
					tickPixelInterval: 30,
					tickWidth: 2,
					tickPosition: 'inside',
					tickLength: 10,
					tickColor: '#666',
					labels: {
						step: 2,
						rotation: 'auto'
					},
					title: {
						text: 'Maxi Target <?php echo $target; ?>'
					},
					plotBands: [{
						from: 0,
						to: 94,
						color: '#DF5353' // green indikator warna 
					}, {
						from: 95,
						to: 96,
						color: '#DDDF0D' // yellow
					}, {
						from: 98,
						to: 100,
						color: '#008000' // red
					}]
				},
			
				series: [{
					name: 'Saldo',
					data: [<?php echo $saldo; ?>], // UNTUK TABUNGAN HARI INI [DATA]
					tooltip: {
						valueSuffix: ''
					}
				}]
			
			},
			// Add some life
			function (chart) {
				if (!chart.renderer.forExport) {
					setInterval(function () {
						var point = chart.series[0].points[0],
							newVal,
							inc = Math.round((Math.random() - 0.5) * 20);
			
						newVal = point.y + inc;
						if (newVal < 0 || newVal > 200) {
							newVal = point.y - inc;
						}
			
						point.update(newVal);
			
					}, 3000);
				}
			});</script>
		  
</div>

</table>
  
  <!-- developer call center -->
  <div class="w3-container w3-padding-32" id="about">
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16" align="center">Developer Cell Center PDM <br>(548458484)</h3>
  </div>

</div>

  <!-- About Section 
  <div class="w3-container w3-padding-32" id="about">
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16" align="center">Contact Us</h3>
  </div>

  <div class="w3-row-padding w3-grayscale">
    <div class="w3-col l3 m6 w3-margin-bottom">
      <img src="/w3images/team2.jpg" alt="John" style="width:100%">
	  <h3>hi</h3>
      <p class="w3-opacity">CEO & Founder</p>
      <p>0212</p>
      <p><button class="w3-button w3-light-grey w3-block">Contact</button></p>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <img src="/w3images/team1.jpg" alt="Jane" style="width:100%">
      <h3>Jane Doe</h3>
      <p class="w3-opacity">Architect</p>
      <p>025845825545</p>
      <p><button class="w3-button w3-light-grey w3-block">Contact</button></p>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <img src="/w3images/team3.jpg" alt="Mike" style="width:100%">
      <h3>Mike Ross</h3>
      <p class="w3-opacity">Architect</p>
      <p>05205125050</p>
      <p><button class="w3-button w3-light-grey w3-block">Contact</button></p>
    </div>
    <div class="w3-col l3 m6 w3-margin-bottom">
      <img src="/w3images/team4.jpg" alt="Dan" style="width:100%">
      <h3>Dan Star</h3>
      <p class="w3-opacity">Architect</p>
      <p>054659656556</p>
      <p><button class="w3-button w3-light-grey w3-block">Contact</button></p>
    </div>
  </div>-->

<!-- End page content -->
</div>


<!-- Footer -->
<footer class="w3-center w3-black w3-padding-16">
  <p>Powered by <a href="2020" title="W3.CSS" target="_blank" class="w3-hover-text-green">BNI - STAFF PDM</a></p>
</footer>



</body>
</html>