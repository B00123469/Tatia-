<?php
require_once ("../src/dbcontroller.php");

// Define variables and initialize with empty values
$email_error = $password_error = $firstname_error = $lastname_error = $confirm_password_error = "";
$registration_success = "";

$db_handle = new DBController();
if($_POST) {
    $email = trim(htmlspecialchars(strip_tags($_POST['email'])));
    $password = trim(htmlspecialchars(strip_tags($_POST['password'])));
    $confirm_password = trim(htmlspecialchars(strip_tags($_POST['confirm_password'])));
    $firstname = trim(htmlspecialchars(strip_tags($_POST['first_name'])));
    $lastname = trim(htmlspecialchars(strip_tags($_POST['last_name'])));
    
    // Check if username is empty
    if(empty($email)) {
        $email_error = "Please enter email";
    } 
    
    // Check if password is empty
    if(empty($password)) {
        $password_error = "Please enter password";
    } elseif(strlen($password) < 6){
        $password_error = "Password must have atleast 6 characters.";
    }
    
    // Check if first name is empty
    if(empty($firstname)) {
        $firstname_error = "Please enter first name";
    } 
    
    // Check if last name is empty
    if(empty($lastname)) {
        $lastname_error = "Please enter last name";
    } 
    
    // Check if confirm password is empty
    if(empty($confirm_password)) {
        $confirm_password_error = "Please enter confirm password";
    } elseif(empty($password_error) && ($password != $confirm_password)){
        $confirm_password_error = "Passwords do not match";
    }
    
    
    
    if(empty($email_error) && empty($password_error) && empty($confirm_password_error) && empty($firstname_error) && empty($lastname_error)){
        // Prepare a select statement
        $query = "SELECT * FROM tbluser WHERE email = '$email'";
        $result = $db_handle -> runQuery($query);
        if(empty($result)) {
            $query = "INSERT INTO tbluser (firstname, lastname, password, role, email) VALUES ('$firstname', '$lastname', '$password', 'Customer', '$email')";
            $result = $db_handle -> runBooleanQuery($query);
            if(!empty($result)) {
                $registration_success = "User registered successfully. Please login.";
            } 
            
        } else {
            $email_error = "An account exists with this email. Please login.";
        }
        
    }
}

$db_handle->closeConnection();
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title>Shoes by Tatia | SignUp</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="">
	<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
	 <link href="../css/shop.css" rel="stylesheet" type="text/css" /> 
	<link href="../css/style.css" rel='stylesheet' type='text/css' />
	 <link href="../css/fontawesome-all.css" rel="stylesheet">
	<!-- s -->
</head>

<body>
	<div class="banner-top container-fluid" id="home">
		<!-- header -->
		<header>
			<div class="row">
				<div class="col-md-3 top-info text-left mt-lg-4">
				</div>
				<div class="col-md-6 logo-w3layouts text-center">
					<h1 class="logo-w3layouts">
						<a class="navbar-brand" href="index.php">
							<img src="../images/ShoesLogo.png"/> 
						</a>
					</h1>
				</div>

				<div class="col-md-3 top-info-cart text-right mt-lg-4">
					<ul class="cart-inner-info">
						<li class="button-log">
							<a class="btn-open" href="login.php">
								<span class="fa fa-user" aria-hidden="true"></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		
			<label class="top-log mx-auto"></label>
			<nav class="navbar navbar-expand-lg navbar-light bg-light top-header mb-2">

				<button class="navbar-toggler mx-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
				    aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						
					</span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav nav-mega mx-auto">
						<li class="nav-item  active">
							<a class="nav-link ml-lg-0" href="index.php">Home
								<span class="sr-only">(current)</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="about.html">About</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="adminPanel.php">Admin</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="contact.html">Contact</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>
	</div>
	<!--// header_top -->

<div class="container col-md-6 col-sm-6 col-12 mt-5">
	
	<h2 class="text-center" style="text-decoration: underline;">Sign Up</h2><br>
	<form action="#" method="post">
		
		<div class="form-group <?php echo (!empty($firstname_error)) ? 'has-error' : ''; ?>">
			<input type="text" class="form-control" placeholder="First name" name="first_name">
			<span class="help-block"><?php echo $firstname_error; ?></span>
		</div>
		<br>
		<div class="form-group <?php echo (!empty($lastname_error)) ? 'has-error' : ''; ?>">
			<input type="text" class="form-control" placeholder="Last name" name="last_name">
			<span class="help-block"><?php echo $lastname_error; ?></span>
		</div>
		<br>

		<!-- <input type="number" class="form-control" placeholder="Mobile number" name=""><br> -->

		<div class="form-group <?php echo (!empty($email_error)) ? 'has-error' : ''; ?>">
			<input type="email" class="form-control" placeholder="Email id" name="email">
			<span class="help-block"><?php echo $email_error; ?></span>
		</div>
		<br>

		<div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
			<input type="password" class="form-control" placeholder="Password" name="password">
			<span class="help-block"><?php echo $password_error; ?></span>
		</div>
		<br>
		
		<div class="form-group <?php echo (!empty($confirm_password_error)) ? 'has-error' : ''; ?>">
			<input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password">
			<span class="help-block"><?php echo $confirm_password_error; ?></span>
		</div>
		<br>

		<!-- <input type="number" class="form-control" placeholder="Pin number" name=""><br> -->

		<input type="submit" class="btn btn-primary btn-block" value="Register" name="submit">
		<div class="form-group <?php echo (!empty($registration_success)) ? 'has-error' : ''; ?>">
			<span class="help-block"><strong style="color: green"><?php echo $registration_success; ?></strong></span>
		</div>
	</form>
	<p class="text-center mt-2">Already Have an Account ? <a href="login.php">Login here</a></p>
</div>
<br>
<br>

	<!--footer -->
	<footer class="py-lg-5 py-3">
	<div class="container-fluid px-lg-5 px-3">
	<div class="row footer-top-w3layouts">
		<div class="col-lg-3 footer-grid-w3ls">
			<div class="footer-title">
				<h3>About Us</h3>
			</div>
	<div class="footer-text">
<p> family run business, with over 40 years' experience of high street retailing in the best locations in Ireland.
At present we have stores in Dundrum Shopping Centre, and in Henry Street in Dublin.

	
	<ul class="footer-social text-left mt-lg-4 mt-3">
    <li class="mx-2">
		<a href="#">
		<span class="fab fa-facebook-f"></span>
			</a>
		</li>
		<li class="mx-2">
		<a href="#">
		<span class="fab fa-twitter"></span>
		</a>
		</li>
			<li class="mx-2">
			<a href="#">
				<span class="fab fa-google-plus-g"></span>
					</a>
		</li>
		<li class="mx-2">
		<a href="#">
		<span class="fab fa-linkedin-in"></span>
			</a>
			</li>
		<li class="mx-2">
			<a href="#">
		<span class="fas fa-rss"></span>
			</a>
			</li>
		<li class="mx-2">
		<a href="#">
			<span class="fab fa-vk"></span>
			</a>
			</li>
		</ul>
		</div>
				</div>
				
	<div class="col-lg-3 footer-grid-w3ls">
	<div class="footer-title">
		<h3>Quick Links</h3>
		</div>
		<ul class="links">
		<li>
			<a href="index.html">Home</a>
				</li>
				<li>
				<a href="about.html">About</a>
				</li>
				<li>
							<a href="contact.html">Contact Us</a>
						</li>
					</ul>
				</div>
				
			</div>
			<div class="footer-css mt-4">
				<p class="copy-right text-center ">&copy; 2020 Shoes by Tatia. All Rights Reserved
					
				</p>
			</div>
		</div>
	</footer>
	<!-- //footer -->

	
</body>

</html>