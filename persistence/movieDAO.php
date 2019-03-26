<?php

function connectToDB()
{
	$link = new \PDO(
		'mysql:host=mysql71.unoeuro.com;dbname=learningeachday_dk_db;charset=utf8mb4',
		'learningeachday_dk',
		'pbweb2019',
		array(
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_PERSISTENT => false
		)
	);

	return $link;
}



function readMovies()
{
	try {
		$cxn = connectToDB();

		$handle = $cxn->prepare( 'SELECT * FROM Movie ORDER BY Title DESC' );
		$handle->execute();

		// Using the fetchAll() method might be too resource-heavy if you're selecting a truly massive amount of rows.
		// If that's the case, you can use the fetch() method and loop through each result row one by one.
		// You can also return arrays and other things instead of objects.  See the PDO documentation for details.
		$result = $handle->fetchAll( \PDO::FETCH_OBJ );

		foreach ( $result as $row ) {
			print( movieTemplate($row) );
		}
	}
	catch(\PDOException $ex){
		print($ex->getMessage());
	}
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


// Utility function to provide some basic styling for a movie
function movieTemplate($row)
{
	return $template = "	
	<div>
	  <input class='movieID' type=\"hidden\" name='movieID' id='movieID' value='" . $row->MovieID . "' >
      
      <label>Title:</label>
      <label class='title'><strong>" . $row->Title. "</strong></label>
    </div>
    <div>
      <label>Description:</label>
			<label class='description'>" . $row->Description. "</label>			
		</div>
		<div>	
			<img src='" . $row->imgUrl . "' width='200px'/>
		</div>
    <br>
    <a href='business/handleMovie.php?action=delete&movieID=" . $row->MovieID . "' class='waves-effect waves-light btn edit'>Delete</a>
	<br><br><br><br>";
	
}


?>