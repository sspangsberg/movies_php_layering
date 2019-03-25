<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Movies</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
  <link rel="stylesheet" href="includes/css/main.css">
</head>


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




<body>
  <div class='container'>
    <div class='header'>
      <img class="headerImg" src="includes/images/moviesHeader.png" width="100%" alt="">
      <h4>Movies</h4>
    </div>
    <br/>
    <form id="movieForm" method="POST" action="business/handleMovie.php?action=create">
      <input type="hidden" id='movieID' name="movieID" value="">
      <div class="input-field">
        <label for="title">Title</label>
        <input type="text" id='title' name="title"/>
      </div>
      <br/>
      <div class="input-field">
        <label for="description">Description</label>
        <textarea class="materialize-textarea" name="description" id='description'></textarea>
      </div>
      <div class="input-field">
        <label for="imgUrl">Image URL</label>
        <textarea class="materialize-textarea" name="imgUrl" id='imgUrl'></textarea>
      </div>
    
      <br/>
      <br/>
      <button class="waves-effect waves-light btn" type='submit'>Add</button>
    </form>
    <br>
    <br>
    <br>
      <ul id='movies'>
           <?php readMovies(); ?>
      </ul>
  </div>

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

</body>

</html>