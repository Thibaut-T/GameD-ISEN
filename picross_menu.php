<?php
session_start();
include("connexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf8" />
	<link rel="stylesheet"  href="home.css"/>
	<meta name="viewport" content="width=device=width,initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="icon" href="favicon.png" />
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<title>Picrosses of the Week - Picross</title>
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
					<li class="nav-item active">
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
					<button type="button" class="btn text-primary" data-toggle="modal" data-target="#myModal" style="width: 10em; background-color: white;">Rules</button>
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

	<div class="jumbotron jumbotron-fluid pt-4 pb-4">
		<div class="container text-center">
			<h1>Picrosses of the Week !</h1>
			<p>Let's see which Picross are On !</p>
		</div>
	</div>
	<div class="row">

		<div class="col-lg-3">

			<h1 class="my-4" style="text-decoration: underline; text-align:center;">Difficulty</h1>
			<div class="list-group" style="padding-bottom:5%;">
				<a href="#" class="list-group-item mb-2" style="background-color:#00FF00; text-align:center; padding:3%; color: white;">Easy</a>
				<a href="#" class="list-group-item mb-2" style="background-color:orange; text-align:center; color: white;">Medium</a>
				<a href="#" class="list-group-item mb-2" style="background-color:red; text-align:center; color: white;">Hard</a>
			</div>

		</div>
		<div class="col-md-9" style="height:800px;">
			<div class="row">
				<?php
				$compt=0;
				$compt2=0;
				$compt3=0;
				$requete="SELECT Name from picross WHERE Visibility=1";
				$result=mysqli_query($link,$requete);
				while ($ligne = mysqli_fetch_assoc($result)) {
					$name[$compt]= $ligne['Name']; //On associe a chaque indice du tableau prenom le resultat de la requête 
					$compt++;
				}
				$requete2="SELECT Author from picross WHERE Visibility=1";
				$result2=mysqli_query($link,$requete2);
				while ($ligne2 = mysqli_fetch_assoc($result2)) {
					$author[$compt2]= $ligne2['Author']; //On associe a chaque indice du tableau prenom le resultat de la requête 
					$compt2++;
				}

				$requete3="SELECT Difficulty from picross WHERE Visibility=1";
				$result3=mysqli_query($link,$requete3);
				while ($ligne3 = mysqli_fetch_assoc($result3)) {
					$difficulty[$compt3]= $ligne3['Difficulty']; //On associe a chaque indice du tableau prenom le resultat de la requête 
					$compt3++;
				}

				$nb=count($name);
				for($i=0;$i<$nb;$i++){
					$color=0;
					if($difficulty[$i]<=2){
						$color="#00FF00";
					}
					if(2<$difficulty[$i] && $difficulty[$i]<=4){
						$color="orange";
					}
					if(4<$difficulty[$i]){
						$color="red";
					}
					?>
					<div class="col-lg-4 col-md-6 mb-4" style="height:80%; ">
						<div class="card h-100" style="background-color:<?php echo"$color";?>">
							<a href="#"><img class="card-img-top" src="pictures/picross.jpg" alt=""></a>
							<div class="card-body">
								<h4 class="card-title" style="text-align:center; color:black; text-decoration:none;">
									<?php echo "$name[$i]";?>
								</h4>
								<h5><?php echo "Created by $author[$i]";?></h5>
								<input type="button" class="btn btn-danger" style="width: 100%;" value="Play">
							</div>
						</div> <!-- Card-->
					</div> <!-- col de la carte-->
					<?php
				}
				?>
			</div><!--La ligne-->
		</div><!--Col 9 -->
</body>
</html>