<?php 



	/****
	 * 
	 * 
	 * ROuter firewall
	 * 
	 * 
	 * */

	include 'env.php';

	include 'librarys/palta/Palta.php';

	include 'models/DBAbstract.php';
	include 'models/Usuarios.php';

	$section = "landing";

	if(isset($_GET["slug"])){
		$section = $_GET['slug'];
	}

	if(!file_exists( 'controllers/'.$section.'Controller.php')){
		$section = "error";
	}

	include 'controllers/'.$section.'Controller.php';



 ?>