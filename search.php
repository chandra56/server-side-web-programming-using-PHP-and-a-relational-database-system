<?php
session_start();
include("require.php");
$usr=$_SESSION["user"];
//echo print_r($_SESSION[$usr."_cart"]);
//unset($_SESSION[$usr."_cart"]);
function check($isbn){
	foreach($_SESSION[$_SESSION['user']."_cart"] as $keys=>$values){
		if($values["ISBN"]==$isbn){
			return $keys;
			//echo $keys;
		}
	}
}

?>


<!DOCTYPE HTML>
<html>
<head>
<style>

.panel-primary {

margin-top:30px;
}
.row{
	padding-top:50px;
}

</style>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
function update(){
	
	var x=document.getElementById('cartnum').innerHTML;
	document.getElementById('cartnum').innerHTML=(parseInt(x)+1).toString();
	
	var k=document.getElementById('stores').innerHTML;
	document.getElementById('stores').innerHTML=(parseInt(k)-1).toString();
}


</script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 ">
		
            <div class="panel panel-primary">
				   <div class="panel-heading">
				           Search Books
		                        
				   </div>
				   <div class="panel-body">
						   <form class="form-horizontal" role="form" method="GET" action='search.php' >
							 <div class="form-group">
									<div class="col-sm-9">
										<input type="text" class="form-control" name="title" placeholder="Search" value="<?php echo isset($_REQUEST["title"])?$_REQUEST["title"]:""; ?>" required>
									</div>
							</div>
							
							<div class="form-group">
									<div class="col-sm-9">
										<input type="submit" class="btn btn-info" name="titlesearch" value="Search By Title">
									</div>
							</div>
							
							<div class="form-group last">
									<div class="col-sm-9">
										<input type="submit" class="btn btn-primary" name="authorsearch" value="Search By Author">
									</div>
							</div>
						   </form>
				   </div>
				   <div class="panel-footer">
				        <a href="shoppingcart.php" class="btn btn-primary btn-md">
          <span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart <b style="color:red;"><?php echo isset($_SESSION[$usr."_cart"])?$_SESSION[$usr."_cart"][0]["tot"]:'0'?></b></a>
						<a href="logout.php" class="btn btn-primary" role="button" style="float:right;">Logout</a>
				   </div>
				   
            </div>    
			
    </div>
</div>
<?php
if(!isset($_SESSION[$usr.'_cart'])){
if(isset($_GET['titlesearch'])||isset($_REQUEST['titlesearch']))
	{
		
		$title = $_GET['title'];
		
		$sql = mysqli_query($con , "select a.name,b.ISBN,b.title,b.price,m.number from book b INNER JOIN writtenby w on b.ISBN=w.ISBN INNER JOIN author a on w.ssn=a.ssn INNER JOIN (SELECT ISBN,SUM(number) as number from stocks GROUP BY ISBN) as m on m.ISBN=w.ISBN where b.title LIKE '%$title%' AND m.number > 0;");
		
		
		$count = mysqli_num_rows($sql);
		//echo $_SESSION[$usr."_cart"][$_GET["key"]]["count"];
		
		if($count == 0)
		{
			echo "Sorry No books Available";
		}else{?>
			
		<div class="contaner">
			<table class="table table-striped">
		
				<thead>
				   <tr>
				   <th>ISBN</th>
				   <th>Author Name</th>
				   <th>Title</th>
				   <th>Price</th>
				   <th>Stock Available</th>
				   </tr>
				</thead>
				<tbody>
				<?php while($row= mysqli_fetch_array($sql))
			{?>
					<tr>
					   <td><?php echo $row['ISBN'];?></td>
					   <td><?php echo $row['name'];?></td>
					   <td><?php echo $row['title'];?></td>
				       <td><?php echo "$ ".$row['price'];?></td>
					   <td id="stores"><?php echo $row['number'];?></td>
					   <td><a href="check.php?add=<?php echo $_SESSION["user"];?>&ISBN=<?php echo $row['ISBN']?>&search=<?php echo $title ?>&title=<?php echo $row['title']; ?>&price=<?php echo $row['price']?>&name=<?php echo $row['name']?>&titlesearch=yes>" onclick="update();" class="btn btn-success" role="button">Add to shopping cart</a></td>
					</tr>
	<?php }}?>
				</tbody>
			</table>
		</div>
				 
				
	<?php }?>

	
	<?php
if(isset($_REQUEST['authorsearch']))
	{
		$title = $_GET['title'];
		
		$sql = mysqli_query($con , "select a.name,b.ISBN,b.title,b.price,m.number from book b INNER JOIN writtenby w on b.ISBN=w.ISBN INNER JOIN author a on w.ssn=a.ssn INNER JOIN (SELECT ISBN,SUM(number) as number from stocks GROUP BY ISBN) as m on m.ISBN=w.ISBN where a.name LIKE '%$title%' AND m.number > 0;");
		
		
		$count = mysqli_num_rows($sql);
		
		if($count == 0)
		{
			echo "Sorry No books Available";
		}else{?>
			
		<div class="contaner">
			<table class="table table-striped">
				<thead>
				   <tr>
				   <th>ISBN</th>
				   <th>Author Name</th>
				   <th>Title</th>
				   <th>Price</th>
				   <th>Stock Available</th>
				   </tr>
				</thead>
				<tbody>
				<?php while($row= mysqli_fetch_array($sql))
			{?>
					<tr>
					   <td><?php echo $row['ISBN'];?></td>
					   <td><?php echo $row['name'];?></td>
					   <td><?php echo $row['title'];?></td>
				       <td><?php echo "$ ".$row['price'];?></td>
					   <td id="stores"><?php echo $row['number'];?></td>
					   <td><a href="check.php?add=<?php echo $_SESSION["user"];?>&ISBN=<?php echo $row['ISBN']?>&search=<?php echo $title ?>&title=<?php echo $row['title']; ?>&price=<?php echo $row['price']?>&name=<?php echo $row['name']?>&authorsearch=yes>" onclick="update();" class="btn btn-success" role="button">Add to shopping cart</a></td>
					</tr>
	<?php }}?>
				</tbody>
			</table>
		</div>
				 
				
<?php }}else{
	//echo "hello";
	if(isset($_GET['titlesearch'])||isset($_REQUEST['titlesearch']))
	{
		
		$title = $_GET['title'];
		
		$sql = mysqli_query($con , "select a.name,b.ISBN,b.title,b.price,m.number from book b INNER JOIN writtenby w on b.ISBN=w.ISBN INNER JOIN author a on w.ssn=a.ssn INNER JOIN (SELECT ISBN,SUM(number) as number from stocks GROUP BY ISBN) as m on m.ISBN=w.ISBN where b.title LIKE '%$title%' AND m.number > 0;");
		
		
		$count = mysqli_num_rows($sql);
		//echo $_SESSION[$usr."_cart"][$_GET["key"]]["count"];
		
		if($count == 0)
		{
			echo "Sorry No books Available";
		}else{?>
			
		<div class="contaner">
			<table class="table table-striped">
		
				<thead>
				   <tr>
				   <th>ISBN</th>
				   <th>Author Name</th>
				   <th>Title</th>
				   <th>Price</th>
				   <th>Stock Available</th>
				   </tr>
				</thead>
				<tbody>
				<?php while($row= mysqli_fetch_array($sql)){$val=check($row['ISBN']); echo $val;?>
					<tr>
					   <td><?php echo $row['ISBN'];?></td>
					   <td><?php echo $row['name'];?></td>
					   <td><?php echo $row['title'];?></td>
				       <td><?php echo "$ ".$row['price'];?></td>
					   <td id="stores"><?php $book_array_isbn=array_column($_SESSION[$usr."_cart"],"ISBN");
		                               if(in_array($row["ISBN"],$book_array_isbn)){$val=check($row["ISBN"]);if(($row["number"]-$_SESSION[$usr.'_cart'][$val]["count"])>0){echo $row["number"]-$_SESSION[$usr.'_cart'][$val]["count"]; }else{echo 0;}} else{echo $row["number"];} ?></td>
					   <td><a href="check.php?add=<?php echo $_SESSION["user"];?>&ISBN=<?php echo $row['ISBN']?>&search=<?php echo $title ?>&title=<?php echo $row['title']; ?>&price=<?php echo $row['price']?>&name=<?php echo $row['name']?>&titlesearch=yes>" onclick="update();" class="btn btn-success <?php $book_array_isbn=array_column($_SESSION[$usr."_cart"],"ISBN");
		                               if(in_array($row["ISBN"],$book_array_isbn)){$val=check($row["ISBN"]);if(($row["number"]-$_SESSION[$usr.'_cart'][$val]["count"])>0){echo "active"; }else{echo "disabled";}} else{echo "active";} ?>" role="button">Add to shopping cart</a></td>
					</tr>
	<?php }}?>
				</tbody>
			</table>
		</div>
				 
				
	<?php }?>

	
	<?php
if(isset($_REQUEST['authorsearch']))
	{
		$title = $_GET['title'];
		
		$sql = mysqli_query($con , "select a.name,b.ISBN,b.title,b.price,m.number from book b INNER JOIN writtenby w on b.ISBN=w.ISBN INNER JOIN author a on w.ssn=a.ssn INNER JOIN (SELECT ISBN,SUM(number) as number from stocks GROUP BY ISBN) as m on m.ISBN=w.ISBN where a.name LIKE '%$title%' AND m.number > 0;");
		
		
		$count = mysqli_num_rows($sql);
		
		if($count == 0)
		{
			echo "Sorry No books Available";
		}else{?>
			
		<div class="contaner">
			<table class="table table-striped">
				<thead>
				   <tr>
				   <th>ISBN</th>
				   <th>Author Name</th>
				   <th>Title</th>
				   <th>Price</th>
				   <th>Stock Available</th>
				   </tr>
				</thead>
				<tbody>
				<?php while($row= mysqli_fetch_array($sql))
			{?>
					<tr>
					   <td><?php echo $row['ISBN'];?></td>
					   <td><?php echo $row['name'];?></td>
					   <td><?php echo $row['title'];?></td>
				       <td><?php echo "$ ".$row['price'];?></td>
					   <td id="stores"><?php $book_array_isbn=array_column($_SESSION[$usr."_cart"],"ISBN");
		                               if(in_array($row["ISBN"],$book_array_isbn)){$val=check($row["ISBN"]);if(($row["number"]-$_SESSION[$usr.'_cart'][$val]["count"])>0){echo $row["number"]-$_SESSION[$usr.'_cart'][$val]["count"]; }else{echo 0;}} else{echo $row["number"];} ?></td>
					   <td><a href="check.php?add=<?php echo $_SESSION["user"];?>&ISBN=<?php echo $row['ISBN']?>&search=<?php echo $title ?>&title=<?php echo $row['title']; ?>&price=<?php echo $row['price']?>&name=<?php echo $row['name']?>&authorsearch=yes>" onclick="update();" class="btn btn-success <?php $book_array_isbn=array_column($_SESSION[$usr."_cart"],"ISBN");
		                               if(in_array($row["ISBN"],$book_array_isbn)){$val=check($row["ISBN"]);if(($row["number"]-$_SESSION[$usr.'_cart'][$val]["count"])>0){echo "active"; }else{echo "disabled";}} else{echo "active";} ?>" role="button">Add to shopping cart</a></td>
					</tr>
	<?php }}?>
				</tbody>
			</table>
		</div>
				 
				
<?php }}
	?>
</body>
</html>