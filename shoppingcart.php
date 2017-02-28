<?php
session_start();
include("require.php");
$counter=1;
$p=0;
$totalcount=0;
$updatedcount=0;
?>


<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
#buy{
	padding-top:50px;
}
</style>
</head>
<body>
<div class="container" id="buy">
<?php if(!empty($_SESSION[$_SESSION['user']."_cart"])){?>
	
	
		<table class="table table-striped">
				<thead>
				   <tr>
				   <th>ISBN</th>
				   <th>Author Name</th>
				   <th>Title</th>
				   <th>Count</th>
				   <th>Price</th>
				   
				   </tr>
				</thead>
				<tbody>
				<?php foreach($_SESSION[$_SESSION['user']."_cart"] as $keys=>$values){ 
				$totalcount=$totalcount+$values["count"]*$values["price"];
				
				?>
		            <tr>
					   <td><?php echo $values['ISBN'];?></td>
					   <td><?php echo $values['name'];?></td>
					   <td><?php echo $values['title'];?></td>
					   <td><?php echo $values['count'];?></td>
				       <td><?php echo $values['count']."x".$values['price']."= $ ".$values['count']*$values['price']; ?></td>
					</tr>
<?php }} ?>
                </tbody>
				<tfoot>
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?php echo "<b>Total: $</b>".$totalcount; ?></td>
				</tr>
				<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><a href="shoppingcart.php?buy=yes" class="btn btn-primary btn-lg <?php echo isset($_REQUEST["buy"])?"disabled":"active"?>" role="button">Buy</a></td>
				</tr>
				</tfoot>
				</table>
<?php if(isset($_REQUEST["buy"])){
	$usr=$_SESSION["user"];
	$basketId=rand();
	//echo $usr;
	$updatebasket = "INSERT INTO shoppingbasket VALUES ($basketId,'$usr')";
    mysqli_query($con,$updatebasket);
	foreach($_SESSION[$_SESSION['user']."_cart"] as $keys=>$values){
		$updatedcount=$totalcount;
		$z=$values["count"];
		$isbn=$values["ISBN"];
		$num=$values["count"];
		$validate=mysqli_query($con ,"SELECT ISBN,SUM(number) as number from stocks where ISBN=$isbn GROUP BY ISBN");
		$pricequery=mysqli_query($con ,"SELECT price from book where ISBN=$isbn");
		$next = mysqli_fetch_assoc($validate);
		$pricerow = mysqli_fetch_assoc($pricequery);
		$validatenum=$next["number"];
		$price=$pricerow["price"];
		if($validatenum>=$values["count"]){
		$check=mysqli_query($con ,"select * from stocks where ISBN=$isbn");
		$count = mysqli_num_rows($check);
		if($count>1){
			$counter=$num;
			//echo "hello".$values["count"];
		  while($row= mysqli_fetch_array($check)){
			  
			 
			  if($counter>$row["number"]){
				   $p=$counter-$row["number"];
			  if($p>0){
				  //echo "hi";
				  $sn=$row['warehouseCode'];
				  $snumber=$row['number'];
				  //echo $sn;
				  $updatestocks = "UPDATE stocks SET stocks.number = 0 WHERE stocks.ISBN = $isbn and stocks.warehouseCode=$sn";
				  mysqli_query($con,$updatestocks);
				  $updateshipping = "INSERT INTO shippingorder(ISBN,warehouseCode,username,number) VALUES ($isbn,$sn,'$usr','$snumber')";
				  if(mysqli_query($con,$updateshipping)){
					  
				  }
				  else{
					  //echo "Nope1";
					  $updateship = "UPDATE shippingorder SET shippingorder.number = shippingorder.number+$num WHERE shippingorder.ISBN = $isbn and shippingorder.warehouseCode=$sn";
                       mysqli_query($con,$updateship);
				  }
				  $counter=$p;
				  
			  }
			  else{
				  //echo "hello";
				  $sn=$row['warehouseCode'];
				  //echo $sn;
				  $updatestocks = "UPDATE stocks SET stocks.number = $p WHERE stocks.ISBN = $isbn and stocks.warehouseCode=$sn";
				  mysqli_query($con,$updatestocks);
				  $updateshipping = "INSERT INTO shippingorder(ISBN,warehouseCode,username,number) VALUES ($isbn,$sn,'$usr','$snumber')";
				  if(mysqli_query($con,$updateshipping)){
					  
				  }
				  else{
					  //echo "Nope2";
					  $updateship = "UPDATE shippingorder SET shippingorder.number = shippingorder.number+$num WHERE shippingorder.ISBN = $isbn and shippingorder.warehouseCode=$sn";
                       mysqli_query($con,$updateship);
				  }
				
			  }
			  }
			  else if($counter<$row["number"]&&$counter!=0){
				  //echo "main";
				  $sn=$row['warehouseCode'];
				  //echo $sn;
				  $m=$row['number']-$counter;
				  $updatestocks = "UPDATE stocks SET stocks.number = $m WHERE stocks.ISBN = $isbn and stocks.warehouseCode=$sn";
				  mysqli_query($con,$updatestocks);
				  $updateshipping = "INSERT INTO shippingorder(ISBN,warehouseCode,username,number) VALUES ($isbn,$sn,'$usr','$num')";
				  if(mysqli_query($con,$updateshipping)){
					  
				  }
				  else{
					  //echo "Nope3";
					  $updateship = "UPDATE shippingorder SET shippingorder.number = shippingorder.number+$num WHERE shippingorder.ISBN = $isbn and shippingorder.warehouseCode=$sn";
                       mysqli_query($con,$updateship);
				  }
				  $counter=0;
			  }
			
			
		  }
		}
		else{
			//echo "new";
			$row = mysqli_fetch_assoc($check);
			$sn=$row["warehouseCode"];
			$f=$row["number"]-$num;
				$updatestocks = "UPDATE stocks SET stocks.number = $f WHERE stocks.ISBN = $isbn and stocks.warehouseCode=$sn";
		         mysqli_query($con,$updatestocks);
				 $updateshipping = "INSERT INTO shippingorder(ISBN,warehouseCode,username,number) VALUES ($isbn,$sn,'$usr','$num')";
				  if(mysqli_query($con,$updateshipping)){
					  
				  }
				  else{
					  //echo "Nope4";
					  $updateship = "UPDATE shippingorder SET shippingorder.number = shippingorder.number+$num WHERE shippingorder.ISBN = $isbn and shippingorder.warehouseCode=$sn";
                       mysqli_query($con,$updateship);
				  }
		}
		
		$updatecontains = "INSERT INTO contains(ISBN,basketID,number) VALUES ($isbn,$basketId,$num)";
		mysqli_query($con,$updatecontains);
		
		}
		else{
			echo "<h3>Sorry!!! ISBN: ".$isbn." Title: ".$values["title"]." in the basket is out of stock!!!Only ".$validatenum." books are available!!</h3>";
		    $updatedcount=$totalcount-$price;
			echo "<h3>Updated total billing price is ".$updatedcount."</h3><br>";
			echo "<h3>All the Orders are placed removing unavailable books from the basket(due to Multiple customers buying the same item)</h3><br/>";
			}
		
	}
	unset($_SESSION[$usr."_cart"]); echo "<h3>All the Orders are placed</h3><br/>"?>
	
	<p><a href="search.php" class="btn btn-primary btn-lg" role="button">Continue Shopping</a></p>
	
<?php } ?>				
				
				</div>

                      


</body>
</html>