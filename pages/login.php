<?php
// Initialize the session
session_start();

// Check if the user is already joined, if yes then redirect them to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
require_once ("../src/dbcontroller.php");

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

$db_handle = new DBController();
if($_POST) {
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));
    // Check if username is empty
    if(empty(trim($email))){
        $email_err = "Please enter email";
    } 
    
    // Check if password is empty with trim function
    if(empty(trim($password))){
        $password_err = "Please enter password";
    } 
    
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $query = "SELECT * FROM tbluser WHERE email = '$email'";
        
        $result = $db_handle -> runQuery($query);
        if(!empty($result)) {
            $db_password = $result[0]['password'];
            if($password == $db_password) {
                $id = $result[0]['id'];
                $role = $result[0]['role'];
                // Password is correct, so start a new session
                session_start();
                
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["email"] = $email;
                
                if($role === "Admin") {
                    $_SESSION["isAdmin"] = true;
                }
				
                // Redirect user to welcome page
                header("location: index.php");
            } else {
                $password_err = "The password you entered is not valid";
            }
        } else {
            $email_err = "No account found with this email. Please register.";
        }
        
    }
}

$db_handle->closeConnection();
?>

<!----html part----->

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Shoes by Tatia | Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="">
	<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
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
							<img src="../images/ShoesLogo.png"/> </a>
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
					<!---->
					<div class="overlay-login text-left">
						<button type="button" class="overlay-close1">
							<i class="fa fa-times" aria-hidden="true"></i>
						</button>
						
					</div>
					<!---->
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
						<li class="nav-item active">
							<a class="nav-link ml-lg-0" href="index.php">Home
								<span class="sr-only">(current)</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="about.html">About</a>
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
	
	<h2 class="text-center" style="text-decoration: underline;">Login</h2><br>
	<form action="#" method="post">
		<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
			<input type="email" class="form-control" placeholder="Email Id" name="email">
			<span class="help-block"><?php echo $email_err; ?></span>
		</div>
		<br>
		<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
			<input type="password" class="form-control" placeholder="password" name="password">
			<span class="help-block"><?php echo $password_err; ?></span>
		</div>
		<br>

		<div class="form-group">
			<input type="submit" class="btn btn-primary btn-block" value="Login" name="submit">
		</div>
	</form>
	<p class="text-center mt-2">Don't Have an Account ? <a href="signup.php">Signup here</a></p>
	
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