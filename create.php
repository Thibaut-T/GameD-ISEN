<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create a Picross - Picross</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device=width,initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="icon" href="favicon.png">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
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

	<div class="jumbotron jumbotron-fluid pt-4 pb-4">
		<div class="container text-center">
			<h1>Picross creator</h1>
			<p>Create your own Picross by completing this form.</p>
		</div>
	</div>

	<form action="create_action.php" method="get" class="was-validated" style="margin: auto; display: table;">
		<div class="form-group form-inline">
			<label for="name">Picross' Name :</label>
			<input type="text" name="Pname" class="form-control ml-3" placeholder="Name" required>
			<label></label>
			<div class="valid-feedback"></div>
			<div class="invalid-feedback">Please fill out this field.</div>
		</div>
		<div class="form-group form-inline mt-4">
			<label for="size" class="mr-3">Size :</label>
			<input type="text" name="Slength" class="form-control mr-3" placeholder="Length" required>
			<input type="text" name="Switdh" class="form-control" placeholder="Width" required>
			<div class="valid-feedback"></div>
			<div class="invalid-feedback">Please fill out this field.</div>
		</div>
		<div class="form-group form-inline mt-4">
			<div class="custom-control custom-radio custom-control-inline">
				<input type="radio" class="custom-control-input" id="Public" name="Visible" value="1" required>
				<label class="custom-control-label" for="Public">Public</label>
			</div>
			<div class="custom-control custom-radio custom-control-inline">
				<input type="radio" class="custom-control-input" id="Private" name="Visible" value="0" required>
				<label class="custom-control-label" for="Private">Private</label>
			</div> 
			<div class="valid-feedback"></div>
			<div class="invalid-feedback">Please fill out this field.</div>
		</div>
		<div class="text-center">
			<button type="submit" class="btn btn-primary" style="margin-right: 4.5em;" name="Submit">Create</button>
		</div>
	</form>
</body>
</html>