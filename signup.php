<?php 
     include("require.php");
     $msg="";
	 if(isset($_POST['submit']))
	 {
		 $username = $_POST['username'];
		 $address = $_POST['address'];
		 $email = $_POST['email'];
		 $phone = $_POST['phone'];
		 $password = md5($_POST['password']);
 		 $sql ="INSERT INTO customer(username,address,email,phone,password) VALUES ('$username','$address','$email','$phone','$password')";
		 if(mysqli_query($con,$sql))
		 {
			 header('location:customer.php'); 
		 }
		 else
		 {
			 $msg = "Failed Registered"; 
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
				           SignUp<p style="color:red;"><?php echo $msg?></p>
				   </div>
				   <div class="panel-body">
						   <form class="form-horizontal" role="form" method="Post" action='signup.php' autocomplete="on">
							 <div class="form-group">
									<label for="username" class="col-sm-3 control-label">
										Username</label>
									<div class="col-sm-9">
										<input type="username" class="form-control" name="username" placeholder="Username" required>
									</div>
							</div>
							<div class="form-group">
									<label for="address" class="col-sm-3 control-label">
										Address</label>
									<div class="col-sm-9">
										<input type="address" class="form-control" name="address" placeholder="Address">
									</div>
							</div>
							<div class="form-group">
									<label for="email" class="col-sm-3 control-label">
										Email</label>
									<div class="col-sm-9">
										<input type="email" class="form-control" name="email" placeholder="Email" required>
									</div>
							</div>
							<div class="form-group">
									<label for="phone" class="col-sm-3 control-label">
										Phone</label>
									<div class="col-sm-9">
										<input type="phone" class="form-control" name="phone" placeholder="Phone" required>
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
									<div class="col-sm-offset-4 col-sm-9">
										<input type="submit" class="btn btn-primary" name="submit" value="Signup">
									</div>
							</div>
						   </form>
				   </div>
				   <div class="panel-footer">
				    <a href="customer.php" class="btn btn-primary btn-lg" role="button">Already have an account? Login</a>
				   </div>
				   
            </div>    
			
    </div>
</div>
</body>
</html>