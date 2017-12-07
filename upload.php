<?php
session_start();
$login=$_SESSION['user'];
	if  (isset ($_SESSION['poprzedni']))
	{
		$adr=$_SESSION['poprzedni'];
		$dir = "$adr/";
	}
	else
	{
	$dir = "pliki/$login/";
	}
$uploaddir = $dir;
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
 if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
 $_SESSION['ok']='<span >Dodano plik</span><br/>';
    } else {
       $_SESSION['blad']='<span >Nie udało się dodać pliku</span><br/>';
    }
	 header('Location: index.php');
?>
