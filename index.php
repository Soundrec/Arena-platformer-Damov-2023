<?php
	require_once('api/config.php'); // Include the config file
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	
	
?>
<html>
	
	<head>
		<meta charset="utf-8">
		<!-- <link rel="import" href="game.html">f -->
		
		<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
		<!-- <title>Unity WebGL Player | WebPlatGame</title> -->
		<!-- <link rel="shortcut icon" href="TemplateData/favicon.ico"> -->
		<!-- <link rel="stylesheet" href="TemplateData/style.css"> -->
		<!-- 
			<link rel="preload" href="game.html" as="game"
			type="html">
		-->
		
		<link rel="shortcut icon" href="images//icon.png" type="image/x-icon">
		<title>
			Doom Arena
		</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet">
	</head>
	<body>
		<!-- <a href="f1.html"> f1 </a> -->
		<div id="container">
			<canvas id="canvas" class="layer1">
			</canvas>
			
			<!-- <a href="http://google.com/" onclick="location.replace('http://google.com/'),'_top'">Google</a> -->
			<a href="game.html">
				<div id="overlay" class="box-1">
					<div class="btn btn-one">
						<span>START GAME</span>
					</div>
				</div>
			</a>
			<a href="#scores">
				<div id="overlay" class="box-2">
					<div class="btn btn-one">
						<span>RECORDS</span>
					</div>
				</div>
			</a>
			<div id="overlay" class="box-3">
				<span class="tooltip"> 
					<div class="btn btn-one">
						<!-- <span> -->
						ABOUT
						<span class="tooltiptext">
							This game and website were made by students of Siberian State Aerospace University in 2023
							
							<!-- </span> -->
						</span>
					</span>
				</div>
			</div>
			
		</div>
		
		<!-- <a href="#x" class = "goverlay" id="game"> </a>
			<div class = "popup"> f
		-->
		<!-- 
			<div id="unity-container" class="unity-desktop">
			<canvas id="unity-canvas" width=960 height=600></canvas>
			<div id="unity-loading-bar">
			<div id="unity-logo"></div>
			<div id="unity-progress-bar-empty">
			<div id="unity-progress-bar-full"></div>
			</div>
			</div>
			<div id="unity-warning"> </div>
			<div id="unity-footer">
			<div id="unity-webgl-logo"></div>
			<div id="unity-fullscreen-button"></div>
			<div id="unity-build-title">WebPlatGame</div>
			</div>
			</div>
			
			<script>
			var container = document.querySelector("#unity-container");
			var canvas = document.querySelector("#unity-canvas");
			var loadingBar = document.querySelector("#unity-loading-bar");
			var progressBarFull = document.querySelector("#unity-progress-bar-full");
			var fullscreenButton = document.querySelector("#unity-fullscreen-button");
			var warningBanner = document.querySelector("#unity-warning");
			
			function unityShowBanner(msg, type) {
			function updateBannerVisibility() {
			warningBanner.style.display = warningBanner.children.length ? 'block' : 'none';
			}
			var div = document.createElement('div');
			div.innerHTML = msg;
			warningBanner.appendChild(div);
			if (type == 'error') div.style = 'background: red; padding: 10px;';
			else {
			if (type == 'warning') div.style = 'background: yellow; padding: 10px;';
			setTimeout(function() {
            warningBanner.removeChild(div);
            updateBannerVisibility();
			}, 5000);
			}
			updateBannerVisibility();
			}
			
			var buildUrl = "Build";
			var loaderUrl = buildUrl + "/Web.loader.js";
			var config = {
			dataUrl: buildUrl + "/Web.data.unityweb",
			frameworkUrl: buildUrl + "/Web.framework.js.unityweb",
			codeUrl: buildUrl + "/Web.wasm.unityweb",
			streamingAssetsUrl: "StreamingAssets",
			companyName: "DefaultCompany",
			productName: "WebPlatGame",
			productVersion: "1.0",
			showBanner: unityShowBanner,
			};
			if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
			var meta = document.createElement('meta');
			meta.name = 'viewport';
			meta.content = 'width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, shrink-to-fit=yes';
			document.getElementsByTagName('head')[0].appendChild(meta);
			container.className = "unity-mobile";
			canvas.className = "unity-mobile";
			unityShowBanner('WebGL builds are not supported on mobile devices.');
			} else {
			canvas.style.width = "960px";
			canvas.style.height = "600px";
			}
			loadingBar.style.display = "block";
			
			var script = document.createElement("script");
			script.src = loaderUrl;
			script.onload = () => {
			createUnityInstance(canvas, config, (progress) => {
			progressBarFull.style.width = 100 * progress + "%";
			}).then((unityInstance) => {
			loadingBar.style.display = "none";
			fullscreenButton.onclick = () => {
            unityInstance.SetFullscreen(1);
			};
			}).catch((message) => {
			alert(message);
			});
			};
			document.body.appendChild(script);
			</script>
		-->
		<!-- 	<a class="close" href="#close"> </a> 
			</div>	
		-->	
		<a href="#x" class = "goverlay" id="scores"> </a>
		<div class = "popup">
			<h2>HIGHSCORES</h2>
			<?php
				function toTime($milliseconds) {
					$t = round($milliseconds/1000);
					return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
				}
				// Retrieve data from the players table
				$sql = "SELECT username, time, score FROM temp";
				$result = mysqli_query($conn, $sql);
				
				// Create HTML table header
				echo "<table>";
				echo "<tr><th>Username</th><th>Time</th><th>Score</th></tr>";
				
				// Loop through each row of the result and create a table row
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo "<td>".$row['username']."</td>";
					echo "<td>".toTime($row['time'])."</td>";
					echo "<td>".$row['score']."</td>";
					echo "</tr>";
				}
				
				// Close the HTML table
				echo "</table>";
				
				// Free up memory
				mysqli_free_result($result);
			?>
			<a class="close" href="#close"> </a> 
		</div>
		
		
	</body>
	<script src="script.js"></script>
</html>