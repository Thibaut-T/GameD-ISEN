<?php
$link = mysqli_connect("127.0.0.1", "root", "" , "picross") ;
if ($link == false)
{
	echo "Erreur de connexion : " . mysqli_connect_errno() ;
	die();
}
