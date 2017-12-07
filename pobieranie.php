<?php
session_start();
$idp=$_GET['idp'];
$file=$_SESSION['file'];
if (file_exists($file[$idp])) {
	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file[$idp]).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file[$idp]));
    readfile($file[$idp]);
	}
?>
