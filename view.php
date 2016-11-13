<?php
error_reporting(E_ALL);

ini_set('display_errors', 1);

//----------------------------------------RETRIEVE RECORDS - DATABASE--------------------------------------------------
//Obtain login credentials

require_once 'login.php';

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>View Records</title>";
echo "<link rel='stylesheet' href='CSS/homepage.css'		 media='screen and (min-width:769px)' />";
	 "<link rel='stylesheet' href='CSS/tablet-table.css'	 media='screen and (min-width:481px) and (max-width:768px)'/>";
     "<link rel='stylesheet' href='CSS/mobile-homepage.css'  media='screen and (max-width:480px)' />";
echo "</head>";
echo "<body>";
echo "<header><h1>View Records</h1></header>";
echo "<table>";
echo "<tr class='row'>";
echo "<th class='col-1'>ID</th>";
echo "<th class='col-2'>Year</th>";
echo "<th class='col-3'>Artist</th>";
echo "<th class='col-4'>Album</th>";
echo "<th class='col-5'>Rating</th>";
echo "<th class='col-6'>Subgenre</th>";
echo "<th class='col-7'>Publisher</th>";
echo "<th class='col-8'>Modify</th>";
echo "</tr>";

//Create connection to database
$conn = new mysqli($hn, $un, $pw, $db);

//Check if connection succeeded
if ($conn->connect_error) die($conn->connect_error);

//Retrieve records
$query  = "SELECT id, year, artist, album, rating, publisher, subgenre FROM jazz";
$result = $conn->query($query);

//Check if query succeeded
if (!$result) die ("Database access failed: " . $conn->error);

//Display retrieved records
$rows = $result->num_rows;
for ($j = 0 ; $j < $rows ; ++$j) {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo "<tr class='row'>";
    echo "<td class='col-1'>" . $row[0] . "</td>";
    echo "<td class='col-2'>" . $row[1] . "</td>";
    echo "<td class='col-3'>" . $row[2] . "</td>";
    echo "<td class='col-4'>" . $row[3] . "</td>";
	echo "<td class='col-5'>" . $row[4] . "</td>";
	echo "<td class='col-6'>" . $row[6] . "</td>";
	echo "<td class='col-7'>" . $row[5] . "</td>";

    echo "<td class='col-7'><a href='modify6.php?id=" . $row[0] . "'>Modify</a></td>";
    echo "</tr>";

}

$result->close();

echo "</table><br/><br/></body></html>";
echo "<a href='Project - Homepage.html'>Home</a>  | <a href = 'delete4.php'> Multi Delete</a>";

//Close connection
$conn->close();

?>

