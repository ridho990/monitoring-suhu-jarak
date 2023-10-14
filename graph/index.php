
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Suhu Bandar Lampung</title>

		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    	<link rel="stylesheet" type="text/css" href="./style/style.css">
		<!-- 1. Add these JavaScript inclusions in the head of your page -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://code.highcharts.com/stock/highstock.js"></script>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/data.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>

		<!-- 2. Add the JavaScript to initialize the chart on document ready -->
		<script type="text/javascript">
			window.setTimeout("waktu()",1000);
			function waktu() {
				var tanggal = new Date();
				setTimeout("waktu()",1000);
				document.getElementById("jam").innerHTML = tanggal.getHours();
				document.getElementById("menit").innerHTML = tanggal.getMinutes();
				document.getElementById("detik").innerHTML = tanggal.getSeconds();
			}
		</script>

		<script>
			var chart; // global
			/**
			 * Request data from the server, add it to the graph and set a timeout to request again
			 */
			function requestData() {
				$.ajax({
					url: 'live-server-data.php', 
					success: function(point) {
						var series = chart.series[0],
							series = chart.series[1],
							shift = series.data.length > 20; // shift if the series is longer than 20
						// add the point
						chart.series[0].addPoint([point[0], point[1]], true, shift);
						chart.series[1].addPoint([point[0], point[2]], true, shift);
						chart.series[2].addPoint([point[0], point[3]], true, shift);
						setTimeout(requestData, 5000);
					},
					cache: false
				});
			}

			$(document).ready(function() {
			//$('.render_here').each(function(){
				chart = new Highcharts.Chart({
					time: {
						useUTC: true,
						// timezone: 'Asia/Jakarta',
						timezoneOffset: -2 * 60
					},
					chart: {
						renderTo: 'container',
						defaultSeriesType: 'spline',
						events: {
							load: requestData
						}
					},
					title: {
						text: '<p class="title-grafik text-xl">Monitoring Sensor Suhu dan Jarak</p>'
					},
					xAxis: {
						type: 'datetime',
						tickPixelInterval: 150,
						maxZoom: 20 * 1000
					},
					yAxis: {
						minPadding: 0.2,
						maxPadding: 0.2,
						title: {
							text: "Nilai ",
							margin: 20
						}
					},
					series: [
						{
							name: 'Suhu ',
							data: [],
							dashStyle: 'longdash',
							color: "#00FF00"
						},
						{
							name: 'Kelembapan ',
							data: []
						},
						{
							name: 'Jarak',
							data: []
						}
					]
				});
			});
		</script>
	</head>


	<body onLoad="waktu()" >
		<section class="informasi-suhu-jarak flex-col">
			<div class="wrapper-jam-digital flex-col" align="center">
				<h1 class="text-3xl"><span class="text-navy">Internet of </span><span class="text-yellow">Things</span></h1>
				<p class="text-lg text-navy">Ridho Ahmad Fauzi</p>
				<div class="flex-row" id="jam-digital" align="center">
					<div class="bg-blue" id="hours" align="center"><p id="jam"></p></div>
					<div class="bg-purple" id="minute" align="center"><p id="menit"></p></div>
					<div class="bg-pink" id="second" align="center"><p id="detik"></p></div>
				</div>
			</div>
			<div class="wrapper-container-grafik">
				<!-- 3. Add the container -->
				<div class="container-grafik" id="container" ></div>
				</div>
			</div>
		</section>
	</body>

</html>
