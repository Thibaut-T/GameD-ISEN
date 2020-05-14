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
	<title>Picross - The greatest game on Earth</title>
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
					<li class="nav-item active">
						<a class="nav-link waves-effect waves-light" href="Home.php">Home <span class="sr-only">(current)</span></a>
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
	
	<div class="row">
		<div class="col-md-7">
			<div class="btn-group-vertical btn-group-lg" style="margin-left: 10%; margin-top: 5%;">
				<div class="btn-group dropright">
					<button type="button" class="btn btn-primary dropdown-toggle mb-5 rounded p-5" data-toggle="dropdown" style="font-size: 20px;">Pre-existing Picross</button>
					<div class="dropdown-menu">
						<div id="parent" class="dropdown-item" href="#">Easy
							<div id="hover-only" class="card" style="width: 450px;">
								<img class="card-img-top" src="./pictures/test.jpg">
								<div class="card-body">
									<h4 class="card-title">Easy</h4>
									<p class="card-text">Newcomer ? Play this mode to get used to the game.</p>
									<a href="#" class="btn btn-primary stretched-link mt-4">Play</a>
								</div>
							</div>
						</div>
						<div id="parent" class="dropdown-item" href="#">Normal
							<div id="hover-only" class="card" style="width: 450px;">
								<img class="card-img-top" src="./pictures/test.jpg">
								<div class="card-body">
									<h4 class="card-title">Normal</h4>
									<p class="card-text">Tailor-made for those with some experience</p>
									<a href="#" class="btn btn-primary stretched-link mt-4">Play</a>
								</div>
							</div>
						</div>
						<div id="parent" class="dropdown-item" href="#">Hard
							<div id="hover-only" class="card" style="width: 450px;">
								<img class="card-img-top" src="./pictures/test.jpg">
								<div class="card-body">
									<h4 class="card-title">Hard</h4>
									<p class="card-text">Only Ugo knows how to solve a hard Picross</p>
									<a href="#" class="btn btn-primary stretched-link mt-4">Play</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<a href="create.php"><button type="button" class="btn btn-light mb-5 rounded p-5">Create your own Picross</button></a>
				<button type="button" class="btn btn-danger rounded p-5">Random</button>
			</div>
		</div>
		<div class="col-md-5 float-right mt-1">
			<div class="jumbotron jumbotron-fluid rounded">
				<div class="container text-center">
					<h1>Leaderboard</h1>
					<p>Here, you can check the best performances of the history of Picross</p>
				</div>
			</div>
			<?php
			include("connexion.php");
			$requete = "SELECT ProfilePic, Name FROM comptes";
			$result = mysqli_query($link,$requete);
			?>
			<table class="table table-striped table-bordered mt-2">
				<thead>
					<tr>
						<th>Picture</th>
						<th>Name</th>
						<th>Score</th>
					</tr>
				</thead>
				<?php
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						$query = "SELECT Score FROM historique WHERE name = '$row[Name]'";
						$resultat = mysqli_query($link,$query);
						$row2 = mysqli_fetch_assoc($resultat);
						echo "<tr>";
						echo "<td>" .$row['ProfilePic']. "</td>";
						echo "<td>" .$row['Name']. "</td>";
						echo "<td>" .$row2['Score']. "</td>";
						echo "</tr>";
					}
				}
				?>
			</table>
		</div>
	</div>
</body>
</html>