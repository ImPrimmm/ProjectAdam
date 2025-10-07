<?php
session_start(); // mulai session

// hapus semua session
session_unset();  
session_destroy(); 

// redirect ke halaman login (atau index)
header("Location: index.php");
exit;
?>
