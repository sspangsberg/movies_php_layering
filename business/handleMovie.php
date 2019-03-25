<?php

function connectToDB()
{
	$link = new \PDO(
		'mysql:host=localhost;dbname=MovieOnlyDB;charset=utf8mb4',
		'root',
		'',
		array(
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_PERSISTENT => false
		)
	);

	return $link;
}

// Create a new Movie (using Prepared Statements)
function createMovie($title, $description, $imgUrl)
{
	try
	{
		$cxn = connectToDB();

		/*
		 * Dynamic SQL - Vulnerable to SQL Injection
		 */
		$statement = "INSERT INTO Movie (Title, Description, imgUrl) 
									VALUES ('" . $title . "','" . $description . "', '" . $imgUrl . "')";
		
		$handle = $cxn->prepare($statement);
		$handle->execute();
				
		//close the connection
		$cxn = null;
	}
	catch(\PDOException $ex){
		print($ex->getMessage());
		var_dump($ex);
	}
}


function deleteMovie($movieID)
{
	try
	{
		$cxn = connectToDB();
		$statement = "DELETE FROM Movie WHERE MovieID = " . $movieID;
		$handle = $cxn->prepare( $statement );
		$handle->execute();
		//close the connection
		$cxn = null;
	}
	catch(\PDOException $ex){
		print($ex->getMessage());
	}
}

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