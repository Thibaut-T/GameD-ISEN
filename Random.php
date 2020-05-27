<?php
session_start();
include("connexion.php");
?>

<!DOCTYPE html>
<html lang="en">
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
	<title>Random creation - Picross</title>
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
	<div class="naviguation">
		<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
			<a class="navbar-brand" href="Home.php">
				<img src="./pictures/Picross.jpg" width="50" height="50" alt="">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link waves-effect waves-light" href="Home.php">Home<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link waves-effect waves-light" href="jouer.php">Play</a>
					</li>
					<li class="nav-item">
						<a class="nav-link waves-effect waves-light" href="create.php">Create</a>
					</li>
					<?php if(isset($_SESSION["utilisateur"])){
						$user = $_SESSION['utilisateur'];
						$query = "SELECT Name FROM comptes WHERE email = '$user'";
						$resultat = mysqli_query($link, $query);
						$result_rows = mysqli_fetch_assoc($resultat);
						echo "<li class='nav-item dropdown'>";
						echo "<a class='nav-link dropdown-toggle waves-effect waves-light' data-toggle='dropdown'>".$result_rows['Name']."</a>";
						echo "<div class='dropdown-menu'>";
						echo "<a class='dropdown-item' href='Account.php'>My Account</a>";
						echo "<a class='dropdown-item' href='deconnexion.php'>Log out</a>";
						echo "</div>";
						echo "</li>";
					}
					if(!isset($_SESSION["utilisateur"])): ?>
						<li class="nav-item">
							<a class="nav-link waves-effect waves-light" href="loginPage.php">Login</a>
						</li>
					<?php endif ?>
				</ul>
				<div class="md-form my-0">
					<button type="button" class="btn text-primary" data-toggle="modal" data-target="#myModal" style="width: 10em;">Rules</button>
					<div class="modal fade" id="myModal">
						<div class="modal-dialog">
							<div class="modal-content">
								<!-- Header -->
								<div class="modal-header">
									<h4 class="modal-title">Rules of the game</h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<!-- body -->
								<div class="modal-body">
									<p style="text-align: justify;">A Picross is a puzzle game where the goal is to guess what image is hidden behind a grid. The numbers around the grid are the hints that can help you find which blocks are black, and which are white. Each number tells you how many continuous black blocks exist in this row or column. For example, if a row has the numbers 5 10 this means that this row contains 5 black blocks in a row, 10 black blocks in a row and ANY number of white blocks between them</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</div>

	<div class="jumbotron jumbotron-fluid rounded">
		<div class="container text-center">
			<h1>Random generation</h1>
			<p>Generate a random Picross by typing the number of columns, rows and the difficulty you'd like.</p>
		</div>
	</div>

	<?php 
	if(!isset($_POST['ligne']) && !isset($_POST['colonne']) && !isset($_POST['difficulte'])){  // formulaire pour connaitre la taille et/ou la difficulté
		echo'<p>All inputs are accepted, but some may not result into an outcome, in which case it will be displayed "Nothing"</p>';
		echo"<form method='post' action='Random.php'>";
		echo"<fieldset>";
		echo"<label for='ligne'>Rows</label> :";
		echo"<input type='text' name='ligne' class='ml-2'/>";
		echo"<label for='colonne' class='ml-2'>Columns</label> :";
		echo"<input type='text' name='colonne' class='ml-2'/>";
		echo"<label for='difficulte' class='ml-2'>Difficulty</label> :";
		echo"<input type='text' name='difficulte' class='ml-2'/>";
		echo"<input type='submit' value='Generate' class='ml-2'/>";
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
			
			echo"<p class='text-center mt-4'>You have ".$random->nb_case." boxes to fill over ".$random->nb_ligne*$random->nb_colonne."</p>";
			echo"<table style='margin-left: 45%;'>"; // On affiche tout dans un tableau
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