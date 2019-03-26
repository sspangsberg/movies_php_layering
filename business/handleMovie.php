<?php require_once("../persistence/movieDAO.php"); ?>

<?php

$action = $_GET["action"];

if ($action == "create")
{
	$title = $_POST["title"];
	$description = $_POST["description"];
	$imgUrl = $_POST["imgUrl"];
	createMovie( $title, $description, $imgUrl );
}
else if ($action == "delete")
{
	$movieID = $_GET["movieID"];
	deleteMovie($movieID);
}


header( "Location: " . "../index.php" );