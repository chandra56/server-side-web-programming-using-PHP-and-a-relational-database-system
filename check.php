<?php
$total=0;
session_start();
if(isset($_REQUEST["add"])){
	
	$usr=$_GET["add"];
	$main=$usr."_cart";
	if(isset($_SESSION[$main])){
		$book_array_isbn=array_column($_SESSION[$main],"ISBN");
		if(!in_array($_GET["ISBN"],$book_array_isbn)){
			$count=count($_SESSION["$main"]);
			$book_array=array(
		'ISBN'=>$_REQUEST["ISBN"],
		'title'=>$_REQUEST["title"],
		'price'=>$_REQUEST["price"],
		'name'=>$_REQUEST["name"],
		'count'=>1
		
		);
		        $_SESSION[$main][$count]=$book_array;
				foreach($_SESSION[$_SESSION['user']."_cart"] as $keys=>$values){
                          $total=$total+$values["count"];				
				}
				foreach($_SESSION[$main] as $key => $csm)
					 {
					  $_SESSION[$main][$key]['tot'] = $total;
					 }
				if(isset($_REQUEST["titlesearch"])){
				$var=$_GET["search"];
				header("Location:search.php?titlesearch=yes&title=$var&tot=$total");	
				}
				else{
					$var=$_GET["search"];
					header("Location:search.php?authorsearch=yes&title=$var&tot=$total");
				}
		
	  }
       else{
		   $isbn=$_GET["ISBN"];
		   $key=array_search($isbn,array_column($_SESSION[$main],'ISBN'));
		   
		   $_SESSION[$main][$key]["count"]=$_SESSION[$main][$key]["count"]+1;
		   foreach($_SESSION[$_SESSION['user']."_cart"] as $keys=>$values){
                          $total=$total+$values["count"];				
				}
				foreach($_SESSION[$main] as $key => $csm)
					 {
					  $_SESSION[$main][$key]['tot'] = $total;
					 }
		   if(isset($_REQUEST["titlesearch"])){
				$var=$_GET["search"];
				header("Location:search.php?titlesearch=yes&title=$var&tot=$total");	
				}
				else{
					$var=$_GET["search"];
					header("Location:search.php?authorsearch=yes&title=$var&tot=$total");
				}
	   }	  
	}
	else{
		$book_array=array(
		'ISBN'=>$_REQUEST["ISBN"],
		'title'=>$_REQUEST["title"],
		'price'=>$_REQUEST["price"],
		'name'=>$_REQUEST["name"],
		'count'=>1
		
		);
		$_SESSION[$main][0]=$book_array;
		
		if(isset($_REQUEST["titlesearch"])){
		$var=$_GET["search"];
		foreach($_SESSION[$_SESSION['user']."_cart"] as $keys=>$values){
                          $total=$total+$values["count"];				
				}
				foreach($_SESSION[$main] as $key => $csm)
					 {
					  $_SESSION[$main][$key]['tot'] = $total;
					 }
		header("Location:search.php?titlesearch=yes&title=$var&tot=$total");	
		}
		else{
			$var=$_GET["search"];
			foreach($_SESSION[$_SESSION['user']."_cart"] as $keys=>$values){
                          $total=$total+$values["count"];				
				}
				foreach($_SESSION[$main] as $key => $csm)
					 {
					  $_SESSION[$main][$key]['tot'] = $total;
					 }
			header("Location:search.php?authorsearch=yes&title=$var&tot=$total");
		}
		
	}
}



?>