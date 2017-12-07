<?php

/* plikowi  licznik_ip_log.txt trzeba nadac atrybuty 777 */
$file = "licznik_ip_log.txt";

// zapisywanie ip do pliku
$ipadd = getenv(REMOTE_ADDR);
$addip = "TRUE";
$hits = 0;

if (file_exists($file)) { } else { echo "$file nie istnieje!"; exit; }

$fp = fopen($file,"r");
while (!feof($fp))
{
	$line = fgets($fp, 4096); //czas
	$line=trim($line);
	if ($line != "") { $hits++; }

	// Jezeli ip bylo juz zapisane...
	if ($line==$ipadd) { $addip = "FALSE"; }
}
fclose($fp);

// jezeli nie ma zapisane ip w pliku...
if ($addip == "TRUE")
{
	$fp = fopen($file,"a");
	fwrite($fp, "\n");
	fwrite($fp, $ipadd);
	fclose($fp);
	$hits++;
}

// Wyswietlanie ilosci odwiedzin unikalnych
echo $hits;
?>
