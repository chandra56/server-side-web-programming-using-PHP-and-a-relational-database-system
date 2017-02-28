<?php
     
include("require.php");
$msg="";
$username="";
if(isset($_POST['submit']))

{
    $username = $_POST['username'];
	$password = $_POST['password'];
	$md5password=md5($password);
	$result = mysqli_query($con , "SELECT username FROM customer WHERE username = '$username' and password='$md5password'");
	$count = mysqli_num_rows($result);
	if($count==1){
		
		session_start();
		$_SESSION['user'] = $username;
		
		header("location: search.php");
	}
    else{
		$msg="Invalid Credentials";
	}

	
}

?>


<!DOCTYPE HTML>
<html>
<head>
<style>
body { 
  background: url(bookstore1.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

.panel-primary {

margin-top:30px;
}
.row{
	padding-top:80px;
}

</style>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
		
            <div class="panel panel-primary">
				   <div class="panel-heading">
				           Login
		                        <p style="color:red;"><?php echo $msg?></p>
				   </div>
				   <div class="panel-body">
						   <form class="form-horizontal" role="form" method="Post" action='customer.php' autocomplete="on">
							 <div class="form-group">
									<label for="username" class="col-sm-3 control-label">
										Username</label>
									<div class="col-sm-9">
										<input type="username" class="form-control" name="username" placeholder="Username" required>
									</div>
							</div>
							<div class="form-group">
									<label for="password" class="col-sm-3 control-label">
										Password</label>
									<div class="col-sm-9">
										<input type="password" class="form-control" name="password" placeholder="Password" required>
									</div>
							</div>
							<div class="form-group last">
									<div class="col-sm-offset-3 col-sm-9">
										<input type="submit" class="btn btn-info" name="submit" value="Login">
									</div>
							</div>
						   </form>
				   </div>
				   <div class="panel-footer">
					   <div class="col-sm-offset-3">
					        <a href="signup.php" class="btn btn-primary" role="button">New users must register here</a>
					   </div>
				   </div>
            </div>    
			
    </div>
</div>
</body>
</html>