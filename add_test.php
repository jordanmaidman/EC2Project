<?php // sqltest.php
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  
//------------------HTML Header information

echo "<!DOCTYPE html>";
echo"<html>";
echo "<head>";
echo "<style>.error {color: #FF0000;} </style>";
echo "<link rel='stylesheet' href='CSS/update.css'		 media='screen and (min-width:501px)' />";
echo "<link rel='stylesheet' href='CSS/homepage-mobile.css' media='screen and (max-width:500px)'/>";
echo "</head>";
echo "<header>";
echo "<h1> Update the library</h1>";  


  if ($conn->connect_error) die($conn->connect_error);

  if (isset($_POST['delete']) && isset($_POST['id']))
  {
    $id   = get_post($conn, 'id');
    $query  = "DELETE FROM jazz WHERE id='$id'";
    $result = $conn->query($query);
    if (!$result) echo "DELETE failed: $query<br>" .
      $conn->error . "<br><br>";
  }

  if (!empty($_POST['artist'])   &&
      !empty($_POST['album'])    &&
	  !empty($_POST['subgenre']) &&
	  !empty($_POST['rating'])   &&
	  !empty($_POST['year'])	 &&
	  !empty($_POST['Publisher'])&&
	   empty($yearerr) &&
	   empty($artisterr) &&
	   empty($albumerr) &&
	   empty($publishererr)&&
	   empty($subgenreerr) &&
	   empty($ratingerr))
      {
    $artist   = get_post($conn, 'artist');
    $album = get_post($conn, 'album');
	$rating = get_post($conn, 'rating');
	$subgenre = get_post($conn, 'subgenre');
	$publisher = get_post($conn, 'Publisher');
	$year	  =	get_post($conn, 'year');
    $query    = "INSERT INTO jazz (year , artist, album, Publisher, subgenre, rating)  VALUES" .
      "('$year', '$artist', '$album', '$publisher' , '$subgenre' , '$rating')";
    $result   = $conn->query($query);
    if (!$result) echo "INSERT failed: $query<br>" .
      $conn->error . "<br><br>";
  }
  //-----------------------VALIDATION
  
$artisterr = $albumerr = $publishererr = $subgenreerr = $yearerr = "";
$rating = $artist = $album = $subgenre = $rating = $publisher = $year  =  "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
  if ($_POST['rating']) {
		$rating = test_input($_POST['rating']);
	}
	
   if (empty($_POST["artist"])) {
     $artisterr = "Name is required";
   } else {
     $artist = test_input($_POST["artist"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$artist)) {
       $artisterr = "This field should only contain letters and spaces";
     }
   }
  
   if (empty($_POST["album"])) {
     $albumerr = "Album Name is required";
   } else {
     $album = test_input($_POST["album"]);
     
   }
   if (empty($_POST['subgenre'])) {
	   $subgenreerr = "The Subgenre is required";
   } else {
	   $subgenre = test_input($_POST["subgenre"]);
   }
   
  if (empty($_POST["Publisher"])) {
     $publishererr = "A publisher is required";
   } else {
     $publisher = test_input($_POST["Publisher"]);
   }
   
   if (empty($_POST["year"])) {
   $yearerr = "a year is required";
   }  else {
     $year = test_input($_POST["year"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[0-9]*$/",$year)) {
       $yearerr = "This field should only contain numbers"; 
	 }
}
}
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
 
	   
  echo <<<_END
  <form action="add_test.php" method="post"><pre>
Year <input type="text" name="year"><span class = "error">* $yearerr </span>
Artist <input type="text" name= "artist"><span class = "error">* $artisterr</span>
Album <input type="text" name="album"><span class = "error">* $albumerr</span><br>
Publisher <input type="text" name = "Publisher"><span class = "error">* $publishererr</span><br>
	         
Subgenre <span class = "error">* $subgenreerr</span><select name = "subgenre" name = "subgenre">
	 <option value= ""> </option>
	<option value="Ragtime">Ragtime</option>
    <option value="Dixieland">Dixieland</option>
    <option value="Blues">Blues</option>
    <option value="Swing">Swing</option>
    <option value="Bebop">Bebop</option>
	<option value="Cool Jazz">Cool Jazz</option>
	<option value="Hard Bop">Hard Bop</option>
	<option value="Modal Jazz">Modal Jazz</option>
	<option value="Funk">Funk</option>
	<option value="Symphonic">Symphonic</option>
	<option value="Orchestral">Orchestral</option>
	</select></br>
Rating <span class = "error">* $ratingerr</span><input type = "range" name="rating" min="1" max="10"> 
		
<input type="submit" value="ADD RECORD">
  </pre></form>
  <a href='Project - Homepage.html'>Home</a>

_END;

  $query  = "SELECT * FROM jazz";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;

  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
	<pre>
       id   $row[0]
	   Year $row[1]
     Artist $row[2]
      Album $row[3]
  Publisher $row[4]
   Subgenre $row[5]
     Rating $row[6]
  </pre>
  <form action="add_test.php" method="post">
  <input type="hidden" name="delete" value="yes">
  <input type="hidden" name="id" value="$row[0]">
  <input type="submit" value="DELETE RECORD"></form>
_END;
  }

  $result->close();
  $conn->close();

  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
