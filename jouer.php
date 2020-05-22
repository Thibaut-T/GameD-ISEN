<?php
session_start();
function lecture_fichier($path){
		$Lines=file($path);    
		$picross["lignes"]=explode(';',$Lines[1])[0];
		$picross["colonnes"]=explode(';',$Lines[2])[0];
		$picross["nb_cases"]=explode(';',$Lines[3+$Lines[1]])[0];
		
		for($i=3;$i<3+$picross["lignes"];$i++)              
			for($x=0;$x<$Lines[2];$x++)
				if($x==$Lines[2]-1)
					$picross["solution"][$x][$i-3]=explode(';',explode(',',$Lines[$i])[$x])[0];
				else 
					$picross["solution"][$x][$i-3]=explode(',',$Lines[$i])[$x];
		
		for($i=0;$i<$picross["lignes"];$i++)
			if($i==$picross["lignes"]-1)
				$picross["nb_lignes"][$i]=explode(';',explode(',',$Lines[4+$Lines[1]])[$i])[0];
			else $picross["nb_lignes"][$i]=explode(',',$Lines[4+$Lines[1]])[$i];
		
		for($i=0;$i<$picross["colonnes"];$i++)    
			if($i==$picross["colonnes"]-1)
					$picross["nb_colonnes"][$i]=explode(';',explode(',',$Lines[5+$Lines[1]])[$i])[0];
			else  $picross["nb_colonnes"][$i]=explode(',',$Lines[5+$Lines[1]])[$i]; 
			
		return $picross;
	}
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
	<style type="text/css">
		table, th, td {
			border:1px solid black;
			background-size: contain;
			background-repeat: no-repeat;
		}
		.case {
			width: 20px;
			height: 20px;
		}
	</style>
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
		<div id="vie" style="margin-top: 2%; margin-left: -1.5%;">
			<script type="text/javascript">
				var playerLives = ['&#128154;', '&#128154;', '&#128154;'];
				var hearts = playerLives.join("");
				document.write(hearts)
			</script>
		</div>
	</div>
	
	
	<div class="text-center float-left" id="zone" style="margin-left: 6.5%; margin-top: 5%; width: 400px; height: 400px; background-color:black;">
			<?php
			$nom='maison';
			$path='Files/'.$nom.'.txt';
		$picross=lecture_fichier($path); // On lit le fichier
		$case_plein=0;
		echo"<p id='plein' style='visibility: hidden; margin: auto'>0 / ".$picross['nb_cases']."</p>";
		echo"<table id='tableau' style='visibility: hidden; display : inline-block; margin: auto'"; // On affiche tout dans un tableau
			echo"<tr>";
			echo"<th class='case' ></th>"; // Instruction de chaque colonne
			for($i=0; $i<$picross["colonnes"]; $i++){
				echo"<th class='case'>".$picross["nb_colonnes"][$i]."</th>";
			}
			echo"</tr>";
			for($i=0; $i<$picross["lignes"]; $i++){
				echo"<tr>";
				echo"<th>".$picross["nb_lignes"][$i]."</th>"; // Instruction de chaque ligne
				for($y=0; $y<$picross["colonnes"]; $y++){  // Tableau vide rempli au fur et à mesure des clics
					echo'<td id="case '.$y.$i.'" onmousedown="clicsouris('.$y.', '.$i.', '.$picross["solution"][$y][$i].', event, '.$picross["nb_cases"].')"></td>';
				}
				echo"</tr>";
			}
			echo"</table>";
			echo"<p id='fin'></p>";
	?>
	</div>
	<div>
	<p id="case"></p>
	</div>

	<script type="text/javascript">
		var setTm=0;
		var tmStart=0;
		var tmNow=0;
		var tmInterv=0;
		var tTime=[];
		var bloquer=0;
		var case_plein=0;
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
				if(bloquer != -1){
					fStop();
					if (tmInterv == 0) {
						tmStart = new Date();
						document.getElementById("zone").style.backgroundColor = "White";
						document.getElementById("tableau").style.visibility = "visible";
						document.getElementById("plein").style.visibility = "visible";
					}
					else { //si on repart après un clic sur Stop
						tmNow = new Date();
						Pause = tmNow-tmInterv;
						tmStart = new Date(Pause);
					}
					bloquer=1;
					setTm=setInterval(fChrono,10); //lancement du chrono tous les centièmes de secondes
				}
   			}
   			function fStop(){
				if(bloquer !=-1){
					bloquer=0;
				}
   				clearInterval(setTm);
   				tTime[nTime] = tmInterv;
   			}
		 document.oncontextmenu = new Function("return false");  //On bloque le menu contextuel engendré par le click droit
		 function clicsouris(ligne, colonne, solution, event, tot_case){  //Fonction qui suivant le click de la souris et de la solution gère l'affichage
			if(bloquer !=0 && bloquer != -1){
				var id="case "+ligne.toString()+colonne.toString();  //id de la case de l'appel de cette fonction
				
				if(event.button == 0 || event.button == 1){			 //Si clic gauche
					var mycase= document.getElementById(id);
					if(mycase.style.backgroundColor != "black"){
						if(solution == 1){								 //Si la case est bien pleine
							var couleur="black";
							case_plein++;
							document.getElementById("plein").innerHTML= case_plein + " / " + tot_case;
							if(case_plein == tot_case){											//Si c'est gagné
								document.getElementById("fin").innerHTML= " YOU WIN! ";
								fStop();
								bloquer=-1;
							}
						}
						else{											//Si c'est une erreur
							var couleur="red";
						}
						document.getElementById(id).style.backgroundColor = couleur; //On change la couleur de fond
						document.getElementById(id).style.backgroundImage = "none";  
						if(solution !=1){
							setTimeout(function(){document.getElementById(id).style.backgroundColor = "white"; //Si c'est une erreur on affiche une croix après un temps de pause
							document.getElementById(id).style.backgroundImage = "url('pictures/croix_rouge.png')";}, 200);				
							playerLives.pop();
							var hearts = playerLives.join("");
							document.getElementById("vie").innerHTML = hearts;
							if(playerLives.length == 0){
								document.getElementById("fin").innerHTML= " YOU LOSE! ";
								fStop();
								bloquer=-1;
							}
						}
					}
				}
				else if(event.button == 2){ 					   //Si clic droit
					var mycase= document.getElementById(id);
					if(mycase.style.backgroundColor == "black"){
						case_plein--;
						document.getElementById("plein").innerHTML= case_plein + " / " + tot_case;
					}
					if(mycase.style.backgroundImage == 'url("pictures/croix.png")'){
						document.getElementById(id).style.backgroundImage = "none";
					}
					else{
						document.getElementById(id).style.backgroundColor = "white";    //On affiche une croix
						document.getElementById(id).style.backgroundImage = "url('pictures/croix.png')";			 
					}
				}
			}
		 }
   		</script>
   	</body>
   	</html>