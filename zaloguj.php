<?php
session_start();
if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}
	$polaczenie=@new mysqli("mikozniak.nazwa.pl", "mikozniak_z7", "Miko1996","mikozniak_z7");
if ($polaczenie->connect_errno!=0)
{
	echo "Nie można połączyć się z serwerem BD";
}
else
{
	$login=$_POST['login'];
	$haslo=$_POST['haslo'];
		$login = htmlentities($login, ENT_QUOTES, 	"UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
	if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM users WHERE 	user='%s' AND pass='%s'",
		mysqli_real_escape_string($polaczenie,$login),
		mysqli_real_escape_string($polaczenie,$haslo))))
	{
	$ilu_userow = $rezultat->num_rows;
		if($ilu_userow>0)
		{	
			$wiersz = $rezultat->fetch_assoc();
			$fail=$wiersz['fail'];
			if ($fail>=3)
			{
			$_SESSION['blad']='<span >KONTO ZABLOKOWANE!</span>';
			}
			else
			{
            $polaczenie2=@new mysqli("mikozniak.nazwa.pl", "mikozniak_z7", "Miko1996","mikozniak_z7");
			if ($polaczenie2->connect_errno!=0)
			{
			echo "Nie można połączyć się z serwerem BD";
			}
			else
			{
			mysqli_set_charset($polaczenie2, "utf8");
			$zapytanie2 = "UPDATE users SET fail=0 WHERE user='$login' ;";
			mysqli_query ($polaczenie2,$zapytanie2) ;
			}
			$polaczenie2->close();
			if ($fail>0)
			{
			$_SESSION['fail']='<span>Uwaga błędne logowanie</span><br/>';
			}
			$_SESSION['zalogowany'] = true;
			$_SESSION['id'] = $wiersz['id'];
			$_SESSION['user'] = $wiersz['user'];
			$user=$_SESSION['id'];
			unset($_SESSION['blad']);
			}
			$rezultat->free_result();

		}
		else
		{	
            	$polaczenie2=@new mysqli("mikozniak.nazwa.pl", "mikozniak_z7", "Miko1996","mikozniak_z7");

			if ($polaczenie2->connect_errno!=0)
			{
			echo "Nie można połączyć się z serwerem BD";
			}
			else
			{
			mysqli_set_charset($polaczenie2, "utf8");
			$zapytanie2  = "SELECT * FROM users WHERE user='$login' ;";
			$query=mysqli_query ($polaczenie2,$zapytanie2) ;
			$row = mysqli_fetch_assoc($query);
			$fail = $row['fail'];
			$fail=$fail+1;
				if ($fail>=3)
			{
			$_SESSION['blad']='<span >KONTO ZABLOKOWANE!</span>';
			}
			else{
			$_SESSION['blad']='<span >Nieprawidłowy login lub hasło!</span>';}
			$zapytanie2 = "UPDATE users SET fail=$fail WHERE user='$login' ;";
			mysqli_query ($polaczenie2,$zapytanie2) ;
			}
			$polaczenie2->close();
			}
		}
	}
	$polaczenie->close();

	$polaczenie=@new mysqli("mikozniak.nazwa.pl", "mikozniak_z7", "Miko1996","mikozniak_z7");
if ($polaczenie->connect_errno!=0)
{
	echo "Nie można połączyć się z serwerem BD";
}
else
{
	mysqli_set_charset($polaczenie, "utf8");
		$zapytanie = mysqli_query ($polaczenie,"INSERT INTO Logi(userid) VALUES($user) ;");
		}

     $polaczenie->close();
	 header('Location: index.php');

?>
