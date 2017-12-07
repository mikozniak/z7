<?php
session_start();
if (!isset($_POST['folder']))
{
header('Location: index.php');
}
else
{
$folder=$_POST['folder'];
$login=$_SESSION['user'];
	if  (isset ($_SESSION['poprzedni']))
	{
		$adr=$_SESSION['poprzedni'];
		$dir = "$adr/$folder";
	}
	else
	{
	$dir = "pliki/$login/$folder";
	}
 if ( !file_exists($dir) ) {
     $oldmask = umask(0);  
     mkdir ($dir, 0744);
	 unset($_SESSION['bladf']);
	 $_SESSION['ok']='<span>Utworzono Folder</span><br/>';
 }
 else
 {
   $_SESSION['blad']='<span>Nie udało się utworzyć folderu</span><br/>';
 }
 header('Location: index.php');
}
?>
