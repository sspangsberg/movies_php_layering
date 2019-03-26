<?php require_once("persistence/movieDAO.php"); ?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Movies</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
  <link rel="stylesheet" href="includes/css/main.css">
</head>


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