<?php
session_start();
//database credentials
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','mytwitter');

$db = mysqli_connect('localhost', DBUSER, DBPASS,DBNAME);
