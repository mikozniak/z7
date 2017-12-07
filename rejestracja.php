<?php
session_start();
?>
<!DOCTYPE html 
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Komunikator</title>
</head>

<body>

<header id="header">
<H2>Rejestracja</H2>
</header>
 
<section id="content">
Rejestracja<br/><form action='rejestracja.php' method='post'>
		Login: <br /> <input type='text' name='login' /> <br />
		Hasło: <br /> <input type='password' name='haslo' /> <br />
		Rejestracja dozwolona jest tylko po podaniu kodu  <br /> <input type='password' name='kod' /> <br /><br />
		<input type='submit' value='Zarejestruj się' />
	</form><br/>
	  <br/><a href="index.php" >Wróć na stronę główną</a>
<?php
if (isset($_POST['kod']))
{
	if  ($_POST['kod'] === "grad")
	{
        	$polaczenie=@new mysqli("mikozniak.nazwa.pl", "mikozniak_z7", "Miko1996","mikozniak_z7");

if ($polaczenie->connect_errno!=0)
{
	echo "Nie można połączyć się z serwerem BD";
}
else
{
	$login=$_POST['login'];
	$haslo=$_POST['haslo'];
		
		$zapytanie = mysqli_query ($polaczenie,"INSERT INTO users VALUES (NULL, '$login' ,'$haslo',0);");
		$polaczenie->close();
	 	print"<script> window.location.replace('index.php');</script>";
}
	}
	else
	{
		echo "<br/>ZŁY KOD";
	}
}
?>
<br>
</section>
   
   
<footer id="footer">  
 <p>Kontakt do administratora strony: <a href="mailto:mail.pl">admin</a>&nbsp;&nbsp;&nbsp;&nbsp;Gości:<?php include("licznik_wejsc.php"); ?></p>
</footer>

</body>
</html>
