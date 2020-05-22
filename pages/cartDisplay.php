<?php
// Initialize the session
session_start();
require_once ("../src/dbcontroller.php");

$db_handle = new DBController();

$itemArray = [];
$remove_message = "";
$remove_success = "";

if (isset($_SESSION["loggedin"])) {
    $query = "SELECT * FROM tblwishlist WHERE UserId_FK=" . $_SESSION["id"];
    $product_array = $db_handle->runQuery($query);
    
    if(!empty($product_array)) {
        foreach ($product_array as $product) {
            $productId = $product["ProductId_FK"];
            $product_details = $db_handle->runQuery("SELECT * FROM tblproduct WHERE id=" . $productId);
            $item = array(
                $product_details[0]["id"] => array(
                    'name' => $product_details[0]["name"],
                    'code' => $product_details[0]["code"],
                    'price' => $product_details[0]["price"],
                    'image' => $product_details[0]["image"]
                )
            );
            $itemArray = array_merge($itemArray, $item);
        }
    }
} 

if (! empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "addToCart":
            if($_POST){
                if(!empty($_POST['products_checked'])) {
                    foreach($_POST['products_checked'] as $value){
                        $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" .$value . "'");
                        $itemArray = array(
                            $productByCode[0]["code"] => array(
                                'name' => $productByCode[0]["name"],
                                'code' => $productByCode[0]["code"],
                                'quantity' => 1,
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
                                        $_SESSION["cart_item"][$k]["quantity"] += 1;
                                    }
                                }
                            } else {
                                $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                            }
                        } else {
                            $_SESSION["cart_item"] = $itemArray;
                        }
                    }
                }
            }
            break;
        case "removeFromCart":
            if (! empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                        if (empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                }
            }
            break;
        case "removeFromWishlist":
            $remove_success = $db_handle -> removeProductFromWishlist($_SESSION["id"], $_GET["code"]);
            if($remove_success) {
                $remove_message = "Product removed from wishlist";
            } else {
                $remove_message = "Error while removing product from wishlist";
            }
            break;
        case "emptyCart":
            unset($_SESSION["cart_item"]);
            break;
    }
}

$db_handle->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Shoes by Tatia | Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="">
	<!-- <script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script> -->
	 <link href="../css/my_style.css" rel='stylesheet' type='text/css' />
	 <link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
	 <link href="../css/login_overlay.css" rel='stylesheet' type='text/css' /> 
	 <link href="../css/style6.css" rel='stylesheet' type='text/css' />
	 <link href="../css/shop.css" rel="stylesheet" type="text/css" /> 
	<link href="../css/style.css" rel='stylesheet' type='text/css' />
	 <link href="../css/fontawesome-all.css" rel="stylesheet">
	<!-- s -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
    	$("#wishlistForm").submit(function(){
    		 if ($('input:checkbox').filter(':checked').length < 1){
		        alert("Check at least one product");
		 		return false;
    		 }
    	});
    	
    	$("#ckbCheckAll").click(function () {
    	    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    	});
    });
    </script>
</head>

<body>
	<div class="banner-top container-fluid" id="home">
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
						<a class="navbar-brand" href="index.php">
							<img src="../images/ShoesLogo.png"/> </a>
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

<!-- Shopping cart -->
<div id="shopping-cart">
	<div class="txt-heading"><strong>Shopping Cart</strong></div>

	<a id="btnEmpty" href="cartDisplay.php?action=emptyCart">Buy Now</a>
	&nbsp;&nbsp;
	<a id="btnEmpty" href="cartDisplay.php?action=emptyCart">Empty Cart</a>
<?php
if (isset($_SESSION["cart_item"])) {
    $total_quantity = 0;
    $total_price = 0;
    ?>	
<table class="tbl-cart">
			<tbody>
				<tr>
					<th style="text-align: left;">Title</th>
					<th style="text-align: left;">Code</th>
					<th style="text-align: right;" width="5%">Quantity</th>
					<th style="text-align: right;" width="10%">Unit Price</th>
					<th style="text-align: right;" width="10%">Total Price</th>
					<th style="text-align: center;" width="5%">Remove</th>
				</tr>	
<?php
    foreach ($_SESSION["cart_item"] as $item) {
        
        $item_price = $item["quantity"] * $item["price"];
        ?>
				<tr>
					<td><img src="<?php echo $item["image"]; ?>"
						class="cart-item-image" /><?php echo $item["name"]; ?></td>
					<td><?php echo $item["code"]; ?></td>
					<td style="text-align: right;"><?php echo $item["quantity"]; ?></td>
					<td style="text-align: right;"><?php echo "$ ".$item["price"]; ?></td>
					<td style="text-align: right;"><?php echo "$ ". number_format($item_price,2); ?></td>
					<td style="text-align: center;">
						<a href="cartDisplay.php?action=removeFromCart&code=<?php echo $item["code"]; ?>"
						class="btnRemoveAction"><img src="../images/icon-delete.png"
							alt="Remove Item" /></a></td>
				</tr>
				<?php
        $total_quantity += $item["quantity"];
        $total_price += ($item["price"] * $item["quantity"]);
    }
    ?>

<tr>
					<td colspan="2" align="right">Total:</td>
					<td align="right"><?php echo $total_quantity; ?></td>
					<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
					<td></td>
				</tr>
			</tbody>
		</table>		
  <?php
} else {
    ?>
<div class="no-records">Your Cart is Empty</div>
<?php
}
?>
</div>
	
<br>
<br>

<!-- Wishlist -->
<div id="shopping-cart">
	<div class="txt-heading"><strong>Wishlist</strong></div>
	<div class="form-group <?php echo (!empty($remove_message)) ? 'has-error' : ''; ?>">
<?php 
if($remove_success) {
?>    
			<span class="help-block"><strong style="color: green"><?php echo $remove_message; ?></strong></span>
<?php 
} else {
?>
			<span class="help-block"><strong style="color: red"><?php echo $remove_message; ?></strong></span>
<?php 
}
?>			
	</div>

<?php
if (!isset($_SESSION["loggedin"])) {
?>	
<div class="form-group">
		<span class="help-block"><strong style="color: red">Please login to see your wishlist</strong></span>
</div>
<?php 
} else {
?>
<form id="wishlistForm" method="post" action="cartDisplay.php?action=addToCart">
    <input type="submit" id="btnAddToCart" value="Add To Cart"/><br>
    <table class="tbl-cart">
    	<tbody>
    		<tr>
    			<th style="text-align: left;"><input type="checkbox" id="ckbCheckAll"/></th>
    			<th style="text-align: left;">Title</th>
    			<th style="text-align: left;">Code</th>
    			<th style="text-align: right;" width="10%">Price</th>
    			<th style="text-align: center;" width="5%">Remove</th>
    		</tr>	
<?php
    if(!empty($itemArray)) {
        foreach($itemArray as $item) {
?>
			
			<tr>
				<td style="text-align: left;"><input type="checkbox" class="checkBoxClass" name="products_checked[]" value="<?php echo $item["code"]; ?>"/></td>
				<td><img src="<?php echo $item["image"]; ?>"
					class="cart-item-image" /><?php echo $item["name"]; ?></td>
				<td><?php echo $item["code"]; ?></td>
				<td style="text-align: right;"><?php echo "$ ".$item["price"]; ?></td>
				<td style="text-align: center;">
					<a href="cartDisplay.php?action=removeFromWishlist&code=<?php echo $item["code"]; ?>"
						class="btnRemoveAction">
						<img src="../images/icon-delete.png" alt="Remove Item" />
					</a>
				</td>
			</tr>
<?php
        }
?>


			</tbody>
		</table>
	</form>		
  <?php
    } else {
    ?>
<div class="no-records">Your wishlist is Empty</div>
<?php
    }
}
?>
</div>

<br>
<br>

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