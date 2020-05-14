<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Play</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<?php include("header.php"); ?>

	<div class="float-left" style="margin-top: 20%; margin-left: 10%;">
		<div id="divChrono" style="margin-left: 8%; margin-bottom: 10%;">00:00</div>
		<div style="margin-bottom: 10%; margin-right: 10%;">
			<form id="formChrono">
				<input type="button" class="btn btn-success mt-1" id="bStart" value="Start" onClick="fStart()" />
				<input type="button" class="btn btn-danger mt-1" id="bStop" value="Stop" onClick="fStop()" />
			</form>
		</div>
		<div style="margin-top: 2%; margin-left: -1.5%;">
			<script type="text/javascript">
				var playerLives = ['&#128154;', '&#128154;', '&#128154;'];
				var hearts = playerLives.join("");
				document.write(hearts)
			</script>
		</div>
	</div>
	
	
	<div class="text-center float-left" style="margin-left: 6.5%; margin-top: 5%;">
		<canvas id="zone" width="600" height="600" style="background-color:#2c3e50;">Désolé, votre navigateur (ou sa version) ne prend pas en charge les "canvas".</canvas>
		<script type="text/javascript">
			var canvas = document.getElementById('zone');
		</script>
	</div>

	<script type="text/javascript">
		var setTm=0;
		var tmStart=0;
		var tmNow=0;
		var tmInterv=0;
		var tTime=[];
			var nTime=0; //compteur des temps intermédiaires
			function affTime(tm){ //affichage du compteur
				var vMin=tm.getMinutes();
				var vSec=tm.getSeconds();
				if (vMin < 10){
					vMin="0"+vMin;
				}
				if (vSec < 10){
					vSec = "0"+vSec;
				}
				document.getElementById("divChrono").innerHTML = vMin+":"+vSec;
			}
			function fChrono(){
				tmNow = new Date();
				Interv = tmNow-tmStart;
				tmInterv = new Date(Interv);
				affTime(tmInterv);
			}
			function fStart(){
				fStop();
				if (tmInterv == 0) {
					tmStart = new Date();
				}
   				else { //si on repart après un clic sur Stop
   					tmNow = new Date();
   					Pause = tmNow-tmInterv;
   					tmStart = new Date(Pause);
   				}
   				setTm=setInterval(fChrono,10); //lancement du chrono tous les centièmes de secondes
   			}
   			function fStop(){
   				clearInterval(setTm);
   				tTime[nTime] = tmInterv;
   			}
   		</script>
   	</body>
   	</html>