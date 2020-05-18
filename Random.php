<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf8">
	<link rel="stylesheet" href="home.css">
	<meta name="viewport" content="width=device=width,initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="icon" href="favicon.png">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<title></title>
	<style type="text/css">
	table, th, td {
		border:1px solid black;
	}
	.case {
		width: 20px;
		height: 20px;
	}
	</style>
</head>
<body>
	<?php 
	if(!isset($_POST['ligne']) && !isset($_POST['colonne']) && !isset($_POST['difficulte'])){  // formulaire pour connaitre la taille et/ou la difficulté
		echo'<p>Tout types de réponses sont acceptés, mais certaines peuvent ne pas aboutir à une grille dans ce cas il sera affiché "Rien".</p>';
		echo"<form method='post' action='Random.php'>";
			echo"<fieldset>";
				echo"<label for='ligne'>Lignes</label> :";
				echo"<input type='text' name='ligne'/>";
				echo"<label for='colonne'>Colonnes</label> :";
				echo"<input type='text' name='colonne'/>";
				echo"<label for='difficulte'>Difficulté</label> :";
				echo"<input type='text' name='difficulte'/>";
				echo"<input type='submit' value='Valider' />";
			echo"</fieldset>";
		echo"</form>";
	}
	
	else{	
		
		$ligne=$_POST['ligne'];
		$colonne=$_POST['colonne'];
		$difficulte=$_POST['difficulte'];

		if($_POST['ligne']==''){
			$ligne=0;
		}
		if($_POST['colonne']==''){
			$colonne=0;
		}
		if($_POST['difficulte']== ''){
			$difficulte=0;
		}

		$retour=[];
	
		
		
		
		class picross{  // Structure picross qui résume toutes les informations liées à la grille
			public $lignes;
			public $colonnes;
			public $solution;
			public $nb_cases;
			public $nb_ligne; // Dans le cas ou la personne veut tout en random
			public $nb_colonne;
		}
		///////////////////////////////////////
		//Attention au chemin du fichier .exe//
		///////////////////////////////////////
		exec('Executables\Random.exe '.$ligne.' '.$colonne.' '.$difficulte.' ', $retour);  // Exécution du programme random en C

		if($retour==null || (!isset($retour[2]))){  // Si l'éxécution a été un échec
			echo"<p>Rien</p>";
		}
		else{
			$random = new picross();  // On crée une nouvelle grille
			$random->nb_ligne=$retour[0];
			$random->nb_colonne=$retour[1];
			for($i=2; $i<($random->nb_ligne)+2; $i++){	// On récupère la solution dans un tableau à doubles entrées
				for($y=2; $y<($random->nb_colonne)+2; $y++){
					$random->solution[$i-2][$y-2]=$retour[($random->nb_colonne*($i-2)+($y-2))+2];
				}
			}
			
			for($i=($random->nb_ligne*$random->nb_colonne)+2; $i<($random->nb_ligne*$random->nb_colonne)+2+$random->nb_ligne; $i++){ // On récupère les informations de chaque ligne
				$random->lignes[$i-(($random->nb_ligne*$random->nb_colonne)+2)]=$retour[$i];
			}
			
			for($i=($random->nb_ligne*$random->nb_colonne)+$random->nb_ligne+2; $i<(($random->nb_ligne*$random->nb_colonne)+$random->nb_ligne+$random->nb_colonne)+2;$i++){  // On récupère les informations de chaque colonne
				$random->colonnes[$i-(($random->nb_ligne*$random->nb_colonne)+$random->nb_ligne+2)]=$retour[$i];
			}
			
			$random->nb_case=$retour[($random->nb_ligne+$random->nb_colonne+($random->nb_ligne*$random->nb_colonne))+2]; // On récupère le nombre de case à noircir
			
			echo"<p>".$random->nb_case."/".$random->nb_ligne*$random->nb_colonne."</p>";
			echo"<table>"; // On affiche tout dans un tableau
			echo"<tr>";
			echo"<th class='case'></th>";
			for($i=0; $i<$random->nb_colonne; $i++){
				echo"<th class='case'>".$random->colonnes[$i]."</th>";
			}
			echo"</tr>";
			for($i=0; $i<$random->nb_ligne; $i++){
				echo"<tr>";
				echo"<td>".$random->lignes[$i]."</td>";
				for($y=0; $y<$random->nb_colonne; $y++){
					if($random->solution[$i][$y] ==0){
						echo"<td class='case'></td>";
					}
					else{
						echo"<td clases='case' style='background-color:black'></td>";
					}
					
				}
				echo"</tr>";
			}
			echo"</table>";
		}
	}
	?>
	
	
</body>
</html>