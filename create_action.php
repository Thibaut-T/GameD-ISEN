<?php
session_start();
include("connexion.php");
if(isset($_GET['Submit'])){
	if(isset($_GET['Pname'])){
		$name = $_GET['Pname'];
	}
	if(isset($_GET['Slength'])){
		$length = $_GET['Slength'];
	}
	if(isset($_GET['Swidth'])){
		$width = $_GET['Swidth'];
	}
	if(isset($_GET['Visible'])){
		$view = $_GET['Visible'];
	}
	if(isset($_SESSION['utilisateur'])){
		$user = $_SESSION['utilisateur'];
	}else{
		$user = "Invité";
	}
	
	$query = "INSERT INTO picross(Name, Author, Visibility) VALUES ('$name', '$user', $view)";
	$result = mysqli_query($link, $query);
	if($result){
		
	}
}



