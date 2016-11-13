<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="utf-8">
        <title>Jazz Database</title>
        <link rel="stylesheet" href="CSS/homepage.css"		 media="screen and (min-width:769px)" />
		<link rel ="stylesheet"href="CSS/tablet-table.css"	 media="screen and (min-width:481px) and (max-width:768px)"/>
		<link rel="stylesheet" href="CSS/mobile-homepage.css" media="screen and (max-width:480px)" />
        
    </head>
    <body>
        <?php 
            // connection to database
            require_once 'login.php';
            $conn = new mysqli($hn, $un, $pw, $db);
            if ($conn->connect_error) die($conn->connect_error);

            $currentquery = "SELECT * FROM jazz";
            $cr=$conn->query($currentquery);
            $rows=$cr->num_rows;

            if ($rows == 0) {
                die("No such person");
            }
        ?>
        <header>
            <h1> Multi Delete Page </h1>
			<h2> You must select the items you wish to delete, click delete, and then repeat, so as to confirm your decision </h2>
        </header>
        
        <br/>
        <form name="multidelete" method="post" action="delete4.php">
        <table>
            <thead>
                <th>Year</th>
                <th>Artist</th>
                <th>Album</th>
				<th>Records to Delete</th>
            </thead>
            <tbody>
                <?php while ($row=$cr->fetch_array(MYSQLI_NUM)) { ?>
                <tr>
                    <td><?php echo $row[1];?></td>
                    <td><?php echo $row[2];?></td>
					<td><?php echo $row[3];?></td>
					
                    <td><input type="checkbox" name="checkbox[]" value="<?php echo $row[0];?>"></td>
                </tr>
                <?php } ?>
                <tr><td colspan=4><input type="submit" name= 'delete' value="Delete" /></td></tr>
				<tr><td colspan=4><a href ='Project - Homepage.html'> Home</a></td></tr>
            </tbody>
			
            <?php

            // Check if delete button active, start this 
            if(isset($_POST['delete'])) {
                $checkbox = $_POST['checkbox'];

                for($i=0;$i<count($checkbox);$i++) {
                    $ids = $checkbox[$i];
                    $deletequery = "DELETE FROM jazz WHERE id='$ids'";
                    $deleteresult   = $conn->query($deletequery);
                    if ($deleteresult) {
                
            }
                    if (!$deleteresult) echo "Update failed: $deletequery<br>" .
                        $conn->error . "<br><br>";
                }
            }
            $deleteresult->close();
            $conn->close();

            function get_post($conn, $var) {
            return $conn->real_escape_string($_POST[$var]);
            }

            ?>
			
        </table>
		</form>
		
		</body>
		<footer>
		<p><a href='Project - Homepage.html'>Home</a>  | <a href = 'view.php'> View</a></p>
		<footer>
		</html>
        
         
        
    
