<?php  

$currentpage = $_GET['id'];

sleep(2);
header('Location: Thread.php?id=' . $currentpage . '');		



?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>Thank you for posting a comment</h1>
</body>
</html>