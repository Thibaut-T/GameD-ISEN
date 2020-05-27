<?php
session_start();
include("connexion.php")
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

	<div class="row">
		<div class="col-md-7">
			<div class="btn-group-vertical btn-group-lg" style="margin-left: 10%; margin-top: 5%;">
				<div class="btn-group dropright">
					<button type="button" class="btn btn-primary dropdown-toggle mb-5 rounded p-5" data-toggle="dropdown" style="font-size: 20px; width: 300px;">Create your own Picross</button>
					<div class="dropdown-menu">
						<div id="parent" class="dropdown-item" href="#">Image
							<div id="hover-only" class="card" style="width: 450px;">
								<img class="card-img-top" src="./pictures/test.jpg">
								<div class="card-body">
									<h4 class="card-title">Image</h4>
									<p class="card-text">Create a Picross using an image of your choice.</p>
									<a href="#" class="btn btn-primary stretched-link mt-4">Create</a>
								</div>
							</div>
						</div>
						<div id="parent" class="dropdown-item" href="#">Manual
							<div id="hover-only" class="card" style="width: 450px;">
								<img class="card-img-top" src="./pictures/test.jpg">
								<div class="card-body">
									<h4 class="card-title">Manual</h4>
									<p class="card-text">Draw everything you want on the grid.</p>
									<a href="create.php" class="btn btn-primary stretched-link mt-4">Create</a>
								</div>
							</div>
						</div>
						<div id="parent" class="dropdown-item" href="#">Random generation
							<div id="hover-only" class="card" style="width: 450px;">
								<img class="card-img-top" src="./pictures/test.jpg">
								<div class="card-body">
									<h4 class="card-title">Auto gen</h4>
									<p class="card-text">Generate a random Picross, given a pre-defined size.</p>
									<a href="Random.php" class="btn btn-primary stretched-link mt-4">Create</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<a href="picross_menu.php"><button type="button" class="btn btn-light mb-5 rounded p-5" style="width: 300px;">Play a Picross</button></a>
				<a href="#"><button type="button" class="btn btn-danger rounded p-5" style="width: 300px;">Random</button></a>
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
			$requete = "SELECT Picross, Name, Score FROM historique ORDER BY Score DESC";
			$result = mysqli_query($link,$requete);
			?>
			<table class="table table-striped table-bordered mt-2">
				<thead>
					<tr>
						<th>Picture</th>
						<th>Name</th>
						<th>Picross</th>
						<th>Score</th>
					</tr>
				</thead>
				<?php
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						$query = "SELECT ProfilePic FROM comptes WHERE Name = '$row[Name]'";
						$resultat = mysqli_query($link,$query);
						$row2 = mysqli_fetch_assoc($resultat);
						echo "<tr>";
						echo "<td style='width: 120px; text-align: center;'>" ?><img src="<?php echo $row2['ProfilePic']?>" class="img-fluid" style="width:100%;">
						<?php
						echo "</td>";
						echo "<td>" .$row['Name']. "</td>";
						echo "<td>" .$row['Picross']. "</td>";
						echo "<td>" .$row['Score']. "</td>";
						echo "</tr>";
					}
				}
				?>
			</table>
		</div>
	</div>
</body>
</html>