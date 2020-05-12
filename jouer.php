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
	<div class="naviguation">
		<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
			<a class="navbar-brand" href="#">
				<img src="./pictures/Picross.jpg" width="50" height="50" alt="">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link waves-effect waves-light" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link waves-effect waves-light" href="#">JSP</a>
					</li>
					<li class="nav-item">
						<a class="nav-link waves-effect waves-light" href="#">Account </a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Un truc</a>
						<div class="dropdown-menu dropdown-info" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item waves-effect waves-light" href="#">oui</a>
							<a class="dropdown-item waves-effect waves-light" href="#">non</a>
							<a class="dropdown-item waves-effect waves-light" href="#">peut-être</a>
						</div>
					</li>
				</ul>
				<form class="form-inline">
					<div class="md-form my-0">
						<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
					</div>
				</form>
			</div>
		</nav>
	</div>

	<div  class="float-left" style="margin-top: 20em; margin-left: 15em;">
		<div id="divChrono" style="margin-left: 4.5em;">00:00</div>
		<div style="margin-left: 2em;">
			<form id="formChrono">
				<input type="button" class="btn btn-success mt-1" id="bStart" value="Start" onClick="fStart()" />
				<input type="button" class="btn btn-danger mt-1" id="bStop" value="Stop" onClick="fStop()" />
			</form>
		</div>
		<div style="margin-left: 3.8em; margin-top: 2em;">
			<script type="text/javascript">
				var playerLives = ['&#128154;', '&#128154;', '&#128154;'];
				var hearts = playerLives.join("");
				document.write(hearts)
			</script>
		</div>
	</div>
	
	
	<div class="text-center float-left" style="margin-left: 18em; margin-top: 5em;">
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