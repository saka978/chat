<?php

$usernameChat = $_GET[uname];
$passwordChat = $_GET[psw];

$host = "10.0.1.128";
$database = "mydatabase";
$username = "user";
$password = "password";

$con = pg_connect("host=$host dbname=$database user=$username password=$password")
        or die ("Could not connect to the server");

$query = "select password from logintable where username ='$usernameChat';";

$rs = pg_query($con, $query) or die ("cannot execute query: $query\n");
//echo pg_fetch_result($rs,0,0);
echo $usernameChat . "\n";
//echo $passwordChat . "\n";
if( pg_fetch_result($rs,0,0) == $passwordChat){
        if(preg_match('/^(10|192|172)\./', $_SERVER['REMOTE_ADDR'])){
         header("Location: http://10.0.0.222:2020/?name=$usernameChat");
         die;
        } else {
        header("Refresh:0; url=http://193.219.91.103:2020/?name=$usernameChat");die;}
} else {header("Refresh:0; url=login.html");}
pg_close($con);

?>