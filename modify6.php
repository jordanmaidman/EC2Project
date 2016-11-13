<?php
error_reporting(E_ALL);
//Obtain login credentials
require_once 'login.php';
//Create connection to database
$conn = new mysqli($hn, $un, $pw, $db);
?>
<!DOCTYPE html>
<html>
<head>
<style>.error {color: #FF0000} </style> 
</head>
<title>Modify Form </title>
<body>
<header>
<h1> Edit your input </h1>

<?php

//make sure we get the connection
//Check if connection succeeded
if ($conn->connect_error) die($conn->connect_error);


//VALIDATION OF INPUTS

$artisterr = $albumerr = $publishererr = $subgenreerr = $yearerr = $ratingerr = "";
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


//Verify if user already chose record to be Modified from the database table
$id = $_GET['id']; 
//RETRIEVE RECORDS
$currentquery = "SELECT * FROM jazz WHERE id=".$id;
$cr=$conn->query($currentquery);
$rows=$cr->num_rows;
$row=$cr->fetch_array(MYSQLI_NUM);

//UPDATE DATABASE
if (isset($_POST['update'])){
    if (!empty($_POST['artist'])   &&
    !empty($_POST['album'])    &&
    !empty($_POST['subgenre']) &&
    !empty($_POST['rating'])   &&
    !empty($_POST['year'])	  &&
    !empty($_POST['Publisher']) &&
	empty($yearerr) &&
	empty($artisterr) &&
	empty($albumerr) &&
	empty($publishererr)&&
	empty($subgenreerr) &&
	empty($ratingerr))
    {
    $artist = get_post($conn, 'artist');
    $album = get_post($conn, 'album');
    $rating = get_post($conn, 'rating');
    $subgenre = get_post($conn, 'subgenre');
    $publisher = get_post($conn, 'Publisher');
    $year =	get_post($conn, 'year');
    $updatequery = "UPDATE jazz SET year = '".$year."', artist = '".$artist."', album = '".$album."', Publisher = '".$publisher."' , subgenre = '".$subgenre."', rating = '".$rating."' where id =".$id;
    $updateresult   = $conn->query($updatequery);
    
	
    }



        if($updateresult) {

            header("Location:http://ec2-52-201-246-195.compute-1.amazonaws.com/Project2/view.php");
            
		}
		elseif(!$updateresult) {
			header('Location:http://ec2-52-201-246-195.compute-1.amazonaws.com/Project2/modify6.php?id='.$id);
			}
		
	}


?>


    <form method="post">
	
        <fieldset>
         <p>   Year       <input  type="text"  name="year"      id = "year"     class= "required"   value = "<?php echo $row[1];?>"/>  <span class = "error">* <?php echo $yearerr;     ?> </span><br><br></p>
         <p>   Artist 	  <input  type="text"  name="artist"    id = "artist"   class= "required"   value = "<?php echo $row[2];?>"/>  <span class = "error">* <?php echo $artisterr;   ?> </span><br><br></p>
         <p>   Album 	  <input  type="text"  name="album"     id = "album"    class= "required"   value = "<?php echo $row[3];?>"/>  <span class = "error">* <?php echo $albumerr;    ?> </span><br><br></p>
         <p>   Publisher  <input  type="text"  name="Publisher" id="publisher"  class= "required"   value = "<?php echo $row[6];?>"/>  <span class = "error">* <?php echo $publishererr;?> </span><br><br></p>
               
		 <p>  Subgenre <span class = "error">* <?php echo $subgenreerr;?></span> <br><br></p>
			
            <select name = "subgenre" name = "subgenre" class= "required">
                <option value= ""> </option>
                <option value="Ragtime"    <?php if($row[5] == "Ragtime")    echo "selected";?>>Ragtime</option>
                <option value="Dixieland"  <?php if($row[5] == "Dixieland")  echo "selected";?>>Dixieland</option>
                <option value="Blues"      <?php if($row[5] == "Blues")      echo "selected";?>>Blues</option>
                <option value="Swing"      <?php if($row[5] == "Swing")      echo "selected";?>>Swing</option>
                <option value="Bebop"      <?php if($row[5] == "Bebop")      echo "selected";?>>Bebop</option>
                <option value="Cool Jazz"  <?php if($row[5] == "Cool Jazz")  echo "selected";?>>Cool Jazz</option>
                <option value="Hard Bop"   <?php if($row[5] == "Hard Bop")   echo "selected";?>>Hard Bop</option>
                <option value="Modal Jazz" <?php if($row[5] == "Modal Jazz") echo "selected";?>>Modal Jazz</option>
                <option value="Funk"       <?php if($row[5] == "Funk")       echo "selected";?>>Funk</option>
                <option value="Symphonic"  <?php if($row[5] == "Symphonic")  echo "selected";?>>Symhonic</option>
                <option value="Orchestral" <?php if($row[5] == "Orchestral") echo "selected";?>>Orchestral</option>
            </select></br><br>
         <p> Rating <span class = "error">* <?php echo $ratingerr;?></span><br><br></p>
            <input type = "range" name="rating" min="1" max="10" value = "<?php echo $row[4];?>"><br><br>
			<input type = "submit" name= "update" value = "Update" />
			</fieldset>
    </form>
	<footer>  <a href='Project - Homepage.html'>Home</a> </footer>
<?php


    $updateresult->close();
    $conn->close();
    function get_post($conn, $var)
    {
    return $conn->real_escape_string($_POST[$var]);
    }
?>
    
</body>    
</html>
