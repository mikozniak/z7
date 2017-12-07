<?php
session_start();
?>
<!DOCTYPE html 
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Serwer plikow</title>
</head>

<body >

<header id="header">
<H2>Serwer plikow</H2>
</header>
	<?php
	 if((isset($_SESSION['zalogowany']))&&($_SESSION['zalogowany']==true)){
	 echo ' <ul class="menu_poziome">';
	 echo'<li><a href="logout.php" class="linkmenu">Wyloguj się!</a></li>';
echo ' </ul><section id="content">';
$login=$_SESSION['user'];
 $dir = 'pliki/'.$login;
         
 if ( !file_exists($dir) ) {
     $oldmask = umask(0);  
     mkdir ($dir, 0744);
 }
echo"<H2>Twoje pliki</H2>";
	if(isset($_SESSION['fail'])){
    echo $_SESSION['fail'];
	unset($_SESSION['fail']);
        	$polaczenie=@new mysqli("mikozniak.nazwa.pl", "mikozniak_z7", "Miko1996","mikozniak_z7");

if ($polaczenie->connect_errno!=0)
{
	echo "Nie można połączyć się z serwerem BD";
}
else
{
	mysqli_set_charset($polaczenie, "utf8");
	$logid=$_SESSION['id'];
			$zapytanie = mysqli_query ($polaczenie,"SELECT * FROM Logi WHERE userid=$logid;");
			$ile = mysqli_num_rows($zapytanie);
				for ($i = 1; $i <= $ile; $i++) 
		{
		$row = mysqli_fetch_assoc($zapytanie);
		$czas[$i] = $row['czas'];
		}
		echo $czas[$ile];
				echo "<br/>";
	$polaczenie->close();}}
	if(isset($_SESSION['ok'])){
    echo $_SESSION['ok'];
	unset($_SESSION['ok']);
	}
	 if(isset($_SESSION['blad'])){
  echo $_SESSION['blad'];
  unset($_SESSION['blad']);}
$id=$_GET['id'];
$idp=$_GET['idp'];
$idu=$_GET['idu'];
$filesa=$_SESSION['files'];
if (isset($id))
{
	if  (isset ($_SESSION['poprzedni']))
	{
	$adr=$_SESSION['poprzedni'];
	$adr="$adr/$filesa[$id]";
	}
	else
	{
	$adr="pliki/$login/$filesa[$id]";
	}
	$files = scandir($adr,1);	
	echo "<a href='index.php'>Powrót do folderu głównego</a><br/>";
	echo"Zawartość Folderu $filesa[$id]";

}
else
{
    $files = scandir("pliki/$login",1);
	echo"Zawartość Folderu ";
}
$_SESSION['poprzedni']=$adr;
$_SESSION['files']=$files;
$dlugosc=count ($files);
print"<table CELLPADDING=5 BORDER=1>
<tr><td>Nazwa</td><td>Akcja</td><td>Usuwanie</td></tr>\n";
for ($i=0;$i<($dlugosc-2);$i++)
{
$pos = strpos($files[$i], '.');
if ($pos !== false) 
{ 
if (isset($adr))
{
$file[$i]= "$adr/$files[$i]";
}
else
{
$file[$i]="pliki/$login/$files[$i]";
}
$fop="<a href='pobieranie.php?idp=$i'>Zapisz</a>";
$ufop="<a href='index.php?idp=$i'>Usuń</a>";
}
else
{
if (isset($adr))
{
$folder[$i]= "$adr/$files[$i]";
}
else
{
$folder[$i]="pliki/$login/$files[$i]";
}
$fop="<a href='index.php?id=$i'>Otwórz</a>";
$ufop="<a href='index.php?idu=$i'>Usuń</a>";
}
echo "<tr><td>$files[$i]</td><td>$fop</td><td>$ufop</td></tr>\n";
}
echo'</table>';
if (isset($idp))
{
	$file1=$_SESSION['file'];
	unlink($file1[$idp]);
	$_SESSION['ok']='<span>Usunięto plik</span><br/>';
	print"<script> window.location.replace('index.php');</script>";
}
if (isset($idu))
{   
	$folder1=$_SESSION['folder'];
	$test=scandir($folder1[$idu],1);
	if(isset($test[2]))
	{
	$_SESSION['blad']='<span>Najpierw usuń zawartość folderu</span><br/>';
	}
	else
	{
    $_SESSION['ok']='<span>Usunięto folder</span><br/>';
	}
	rmdir($folder1[$idu]);
	print"<script> window.location.replace('index.php');</script>";
}
$_SESSION['folder']=$folder;
$_SESSION['file']=$file;
echo "Tworzenie folderów";
print"<form action='foldery.php' method='POST'>
<input type='text' name='folder'/> <input type='submit' 
value='Stwórz folder'/> 
</form>";
echo "Dodaj Plik";
print"<form enctype='multipart/form-data' action='upload.php' method='POST'>
    <input name='userfile' type='file' />
    <input type='submit' value='Wyślij Plik' />
</form>";
}
else {
echo '<section id="content">';
print	"Korzystanie z komunikatora wymaga zalogowania<br/><form action='zaloguj.php' method='post'>
		Login: <br /> <input type='text' name='login' /> <br />
		Hasło: <br /> <input type='password' name='haslo' /><br/>
		<input type='submit' value='Zaloguj się' />
	</form>";

	 if(isset($_SESSION['blad'])){
  echo $_SESSION['blad'];}
  	echo'<br/><a href="rejestracja.php" >Zarejestruj się</a>';
 }
?>
</section>
<footer id="footer">  
 <p>Kontakt do administratora strony: <a href="mailto:mail.pl">admin</a>&nbsp;&nbsp;&nbsp;&nbsp;Gości:<?php include("licznik_wejsc.php"); ?></p>
</footer>

</body>
</html>
