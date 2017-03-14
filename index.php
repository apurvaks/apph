<html>
 <head>
 <style type="text/css">
.form-style-1 {
    margin:10px auto;
    max-width: 400px;
    padding: 20px 12px 10px 20px;
    font: 13px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
.form-style-1 li {
    padding: 0;
    display: block;
    list-style: none;
    margin: 10px 0 0 0;
}
.form-style-1 label{
    margin:0 0 3px 0;
    padding:0px;
    display:block;
    font-weight: bold;
}
.form-style-1 input[type=text], 
.form-style-1 input[type=date],
.form-style-1 input[type=datetime],
.form-style-1 input[type=number],
.form-style-1 input[type=search],
.form-style-1 input[type=time],
.form-style-1 input[type=url],
.form-style-1 input[type=email],
textarea, 
select{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    border:1px solid #BEBEBE;
    padding: 7px;
    margin:0px;
    -webkit-transition: all 0.30s ease-in-out;
    -moz-transition: all 0.30s ease-in-out;
    -ms-transition: all 0.30s ease-in-out;
    -o-transition: all 0.30s ease-in-out;
    outline: none;  
}
.form-style-1 input[type=text]:focus, 
.form-style-1 input[type=date]:focus,
.form-style-1 input[type=datetime]:focus,
.form-style-1 input[type=number]:focus,
.form-style-1 input[type=search]:focus,
.form-style-1 input[type=time]:focus,
.form-style-1 input[type=url]:focus,
.form-style-1 input[type=email]:focus,
.form-style-1 textarea:focus, 
.form-style-1 select:focus{
    -moz-box-shadow: 0 0 8px #88D5E9;
    -webkit-box-shadow: 0 0 8px #88D5E9;
    box-shadow: 0 0 8px #88D5E9;
    border: 1px solid #88D5E9;
}
.form-style-1 .field-divided{
    width: 49%;
}

.form-style-1 .field-long{
    width: 100%;
}
.form-style-1 .field-select{
    width: 100%;
}
.form-style-1 .field-textarea{
    height: 100px;
}
.form-style-1 input[type=submit], .form-style-1 input[type=button]{
    background: #4B99AD;
    padding: 8px 15px 8px 15px;
    border: none;
    color: #fff;
}
  .form-style-1 input[type=reset], .form-style-1 input[type=button]{
    background: #4B99AD;
    padding: 8px 15px 8px 15px;
    border: none;
    color: #fff;
}
.form-style-1 input[type=submit]:hover, .form-style-1 input[type=button]:hover{
    background: #4691A4;
    box-shadow:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
}
  .form-style-1 input[type=reset]:hover, .form-style-1 input[type=button]:hover{
    background: #4691A4;
    box-shadow:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
}
.form-style-1 .required{
    color:red;
}
</style>


 </head>
 <body>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post"> 
<ul class="form-style-1">
    <li><label>Full Name <span class="required">*</span></label><input type="text" name="firstname" class="field-divided" placeholder="First" required/>&nbsp;<input type="text" name="surname" class="field-divided" placeholder="Last" required/></li>
    <li>
        <label>Email <span class="required">*</span>email should be less than 20 character</label>
        <input type="text" name="emailaddress" class="field-long" required/>
    </li>
    
   
    <li>
        <input type="submit" value="Submit" />&nbsp;<input type="reset" name="reset" value="Clear It"> 

    </li>
    
</ul>
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
       # printf ("These values were inserted into the database - %s %s %s", $firstname, $surname, $emailaddress); 
       # pg_close(); 

    $result = pg_query($pg_conn,"SELECT * FROM friends");  
    echo "<table border='1' align='center'>";  
    while($row=pg_fetch_assoc($result)){echo "<tr>";  
    echo "<td align='center' width='200'>" . $row['firstname'] . "</td>";  
    echo "<td align='center' width='200'>" . $row['surname'] . "</td>";  
    echo "<td align='center' width='200'>" . $row['emailaddress'] . "</td>";
    echo "</tr>";}

    echo "</table>";
  #  $result = pg_query($pg_conn,"DELETE FROM friends");  

   
    pg_close();


        ?> 
