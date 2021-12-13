<?php
$dsn = 'mysql:dbname=agenda;host=localhost';
$user = 'root';
$password = '';

/* $dsn = 'mysql:dbname=id18112947_agenda;host=localhost';
$user = 'id18112947_root';
$password = '^hcxNw#9kgE/9g!&'; */
 
try
{
	$pdo = new PDO($dsn,$user,$password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo "PDO error".$e->getMessage();
	die();
}
?>