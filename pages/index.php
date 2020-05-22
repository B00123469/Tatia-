<?php
session_start();

require_once ("../src/dbcontroller.php");
require_once ("../src/utils.php");
$db_handle = new DBController();
$wishlist_message = "";
if (! empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "logout":
            // Check if the user is already logged in, if yes then redirect him to index page
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                // Destroy the session.
                session_destroy();
                header("location: index.php");
                exit;
            }
            break;
        case "addToWishlist":
            if(!isset($_SESSION["loggedin"])){
                alert("Please login to add products in wishlist");
                break;
            }
            $productByCode = $db_handle->runQuery("SELECT id FROM tblproduct WHERE code='" . $_GET["code"] . "'");
            $productId = $productByCode[0]["id"];
            $userId = $_SESSION["id"];
            //insert wishlist entry
            $query = "INSERT INTO tblwishlist(UserId_FK, ProductId_FK) VALUES ('$userId','$productId')";
            $result = $db_handle->runBooleanQuery($query);
            if($result) {
                $wishlist_message = "Product added to wishlist";
            } 
            break;
            
        case "removeFromWishlist":
            if(!isset($_SESSION["loggedin"])){
                alert("Please login to remove products from wishlist");
                break;
            }
            $remove_success = $db_handle -> removeProductFromWishlist($_SESSION["id"], $_GET["code"]);
            if($remove_success) {
                $wishlist_message = "Product removed from wishlist";
            } 
            break;
        case "addToCart":
            if (! empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
                $itemArray = array(
                    $productByCode[0]["code"] => array(
                        'name' => $productByCode[0]["name"],
                        'code' => $productByCode[0]["code"],
                        'quantity' => $_POST["quantity"],
                        'price' => $productByCode[0]["price"],
                        'image' => $productByCode[0]["image"]
                    )
                );
                
                if (! empty($_SESSION["cart_item"])) {
                    if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productByCode[0]["code"] == $k) {
                                if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
    }
}
?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<TITLE>Shoes by Tatia | Great place for beautiful heels & sandals for all ages.</TITLE>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<meta name="keywords" content="" />
<link href="../css/my_style.css" type="text/css" rel="stylesheet" />
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="../css/shop.css" rel="stylesheet" type="text/css" />
<link href="../css/owl.theme.css" rel="stylesheet" type="text/css"
	media="all">
<link href="../css/style.css" rel='stylesheet' type='text/css' />
<link href="../css/fontawesome-all.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</HEAD>
<BODY>
	<div class="banner-top container-fluid" id="home">
	<div class="form-group <?php echo (!empty($wishlist_message)) ? 'has-error' : ''; ?>">
		<span class="help-block"><strong style="color: green"><?php echo $wishlist_message; ?></strong></span>
	</div>
		<!-- header -->
		<header>
			<div class="row">
				<div class="col-md-3 top-info text-left mt-lg-4">
					<h6> 
<?php 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	echo "Logged In User :\n";
    echo "<u> ".$_SESSION["email"]. "</u>";
}
?>
                    </h6>
				</div>
				<div class="col-md-6 logo-w3layouts text-center">
					<h1 class="logo-w3layouts">
						<a class="navbar-brand" href="index.php"><img src="../images/ShoesLogo.png"/> </a>
					</h1>
				</div>

				<div class="col-md-3 top-info-cart text-right mt-lg-4">
					<ul class="cart-inner-info">
						<li class="button-log">
<?php 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
?>							
							<p class="text-center mt-2">
    							<a style="color: blue" class="btn-open" title="Logout" href="index.php?action=logout"> 
    								<span class="fa fa-user" aria-hidden="true">&nbsp;Logout</span>
								</a>
							</p>
<?php 
} else {
?>						
							<p class="text-center mt-2">
    							<a style="color: blue" class ="btn-open" title="Login" href="login.php"> 
    								<span class="fa fa-user" aria-hidden="true">&nbsp;Login</span>
    							</a>
    						</p>
<?php 
}
?>							
								
						</li>
						<li class="galssescart galssescart2 cart cart box_1">
							<a href="cartDisplay.php" class="top_googles_cart" title="View Cart">
									My Cart <i class="fas fa-cart-arrow-down"></i></a>
							</button>
						</li>
						<li>
<?php 
if(!isset($_SESSION["loggedin"])) {
?>											
						<p class="text-center mt-2">
							<a href="signup.php">Signup</a>
						</p>
<?php 
} 
?>						
						</li>
					</ul>
					
					
				</div>
			</div>

			<label class="top-log mx-auto"></label>
			<nav
				class="navbar navbar-expand-lg navbar-light  top-header mb-2">

				<button class="navbar-toggler mx-auto" type="button"
					data-toggle="collapse" data-target="#navbarSupportedContent"
					aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"> </span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav nav-mega mx-auto">
						<li class="nav-item active"><a class="nav-link ml-lg-0"
							href="index.php">Home <span class="sr-only">(current)</span>
						</a></li>
						<li class="nav-item"><a class="nav-link" href="about.html">About</a>
						</li>
<?php 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] === true) {
?>    
						<li class="nav-item"><a class="nav-link" href="adminPanel.php">Admin Panel</a>
						</li>
<?php 
}
?>
						<li class="nav-item"><a class="nav-link" href="contact.html">Contact</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<!-- //header -->
		<!-- banner -->
		<div class="banner">
			<div id="carouselExampleIndicators" class="carousel slide"
				data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0"
						class="active"></li>
				</ol>
				<div class="carousel-inner" role="listbox">
					<div class="carousel-item active">
						<div class="carousel-caption text-center">
							<h1>
								 Beautiful heels & sandals for all ages
							</h1>
						
						</div>
					</div>
					
						</div>
					</div> 
				</div>
				
			</div>
			<!--//banner -->
		</div>
	</div>

<!-- Products section -->
	<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
		<div class="container-fluid">
			<div class="inner-sec-shop px-lg-4 px-3">
				<h3 class="tittle-w3layouts my-lg-4 my-4">New Arrivals for you </h3>
				<div class="row">
<?php
$product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
if (! empty($product_array)) {
    $counter = 0;
    foreach ($product_array as $key => $value) {
        $isProductInWishList = false;
        if(isset($_SESSION["loggedin"])){
            $isProductInWishList = $db_handle -> checkIfProductInWishlist($_SESSION["id"], $product_array[$key]["id"]);
        }
?>
					<div class="col-md-3 product-men women_two">
						<div class="product-googles-info googles">
							<div class="men-pro-item">
								<div class="men-thumb-item">
									<img src="<?php echo $product_array[$key]["image"]; ?>" class="img-fluid" alt="" >
									<div class="men-cart-pro">
									</div>
									<span class="product-new-top">New</span>
								</div>
								<div class="item-info-product">
									<div class="product-item">
                            			<form method="post" action="index.php?action=addToCart&code=<?php echo $product_array[$key]["code"]; ?>">
                            				<input id="productCode" type="hidden" value="<?php echo $product_array[$key]["code"]; ?>" />
                                			<div class="product-tile-footer">
                                				<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                                				<div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
                                				<div class="cart-action" id="<?php echo $counter; ?>">
                                    				<div>
                                        				<input type="text" class="product-quantity" name="quantity" value="1" size="2" />
                                        				<input id="addToCart" type="submit" value="Add to Cart" class="btnAddAction" />
                                        			</div>
                                					<div>
<?php 
        if($isProductInWishList) {
?>                                				
														<a type="submit" title="Remove From Wishlist" class="btnAddAction" 
															href="index.php?action=removeFromWishlist&code=<?php echo $product_array[$key]["code"]; ?>"> Remove From Wishlist </a>
<?php 
        } else {
?>												
                                                		<a type="submit" title="Add To Wishlist" class="btnAddAction" 
															href="index.php?action=removeFromWishlist&code=<?php echo $product_array[$key]["code"]; ?>"> Add To Wishlist </a> 
<?php 
        }
?>                                                
                                					</div>
                            					</div>
                            				</div>
                            			</form>
                            		</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					</div>
	<?php
	   $counter +=1;
    }
}
?>
				</div>
			</div>
    	</div>
    </section>
    
    <!--footer -->
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

	<!-- //footer -->
</BODY>
</HTML>