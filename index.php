<html> 
    <body> 
        <form action="add.php" method="post"> 
            First Name : <input type="text" name="firstname" size="40" length="40" value="First Name"><BR> 
            Surname : <input type="text" name="surname" size="40" length="40" value="Surname"><BR> 
            Email Address : <input type="text" name="emailaddress" size="40" length="40" value="Email Address"><BR> 
            <input type="submit" name="submit" value="Submit"> 
            <input type="reset" name="reset" value="Clear It"> 
        </form> 
    </body> 
</html> 


<?php 
		function pg_connection_string_from_database_url() {
 		 extract(parse_url($_ENV["DATABASE_URL"]));
  		 return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
		}
		$pg_conn = pg_connect(pg_connection_string_from_database_url());
        #$db = pg_connect('host=localhost dbname=contacts user=postgres password=""'); 

        $firstname = pg_escape_string($_POST['firstname']); 
        $surname = pg_escape_string($_POST['surname']); 
        $emailaddress = pg_escape_string($_POST['emailaddress']); 

        $query = "INSERT INTO friends(firstname, surname, emailaddress) VALUES('" . $firstname . "', '" . $surname . "', '" . $emailaddress . "')";
        $result = pg_query($pg_conn,$query); 
        if (!$result) { 
            $errormessage = pg_last_error(); 
            echo "Error with query: " . $errormessage; 
            exit(); 
        } 
        printf ("These values were inserted into the database - %s %s %s", $firstname, $surname, $emailaddress); 
        pg_close(); 

    $result = pg_query($pg_conn,"SELECT * FROM friends");  
	echo "<table>";  
	while($row=pg_fetch_assoc($result)){echo "<tr>";  
	echo "<td align='center' width='200'>" . $row['firstname'] . "</td>";  
	echo "<td align='center' width='200'>" . $row['surname'] . "</td>";  
	echo "<td align='center' width='200'>" . $row['emailaddress'] . "</td>";
	echo "</tr>";}

	echo "</table>";

	echo "string";



        ?> 
