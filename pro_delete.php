<?php
	ob_start();
	session_start();
	include 'config/server.php';
	if(isset($_GET["Line"]))
	{
		$Line = $_GET["Line"];
		$_SESSION["strProductID"][$Line] = "";
		$_SESSION["strQty"][$Line] = "";
		$_SESSION["itemChanged"] = -1;
		$_SESSION["intLine"]--; 
	}
	header("location:cart.php");
?>