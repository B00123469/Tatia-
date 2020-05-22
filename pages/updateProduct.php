<?php

$id = isset($_GET['id']) ? $_GET['id'] : '';

require_once '../src/dbcontroller.php';
$db_handle = new DBController();

$result = $db_handle->runQuery("SELECT * FROM tblproduct WHERE id=$id");

$update_message = "";
$update_success = "";

if($_POST){
    
    try{
        
        // posted values
        $code = trim(htmlspecialchars(strip_tags($_POST['code'])));
        $title = trim(htmlspecialchars(strip_tags($_POST['title'])));
        $price = htmlspecialchars(strip_tags($_POST['price']));
        
        // insert query
        $query = "UPDATE tblproduct
                    SET name='$title', code='$code', price=$price
                    WHERE id = $id";
        $update_result = $db_handle->runBooleanQuery($query);
        if($update_result) {
            $update_message = "Product updated successfully";
            $update_success = true;
        } else {
            $update_message = "Error while updating product";
            $update_success = false;
        }
    }
    // show error
    catch(Exception $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Update Product Details</title>
      
    <link href="../css/my_style.css" type="text/css" rel="stylesheet" />
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
          
</head>
<body>
  
    <!-- container -->
    <div class="container">
   
        <div class="page-header">
            <h1>Update Product Details</h1>
        </div>
      
    <!-- PHP insert code will be here -->
 
<!-- html form here where the product information will be entered -->
<form action="" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Product Code</td>
            <td><input type='text' name='code' class='form-control' required value="<?php echo htmlspecialchars($result[0]['code'], ENT_QUOTES);  ?>"/></td>
        </tr>
        <tr>
            <td>Title</td>
            <td><input type='text' name='title' class='form-control' required value="<?php echo htmlspecialchars($result[0]['name'], ENT_QUOTES);  ?>"/></td>
        </tr>
        
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' class='form-control' required value="<?php echo htmlspecialchars($result[0]['price'], ENT_QUOTES);  ?>"/></td>
        </tr>
        
        <tr>
            <td>Image</td>
            <td><img class="table-item-image" src="<?php echo $result[0]["image"]; ?>"></td>
        </tr>
        
        <tr>
            <td colspan="2" align="center">
            	<input type='submit' value='Update' class='btn btn-primary' />
                <a href="adminPanel.php" class='btn btn-primary' > Back </a>
            </td>
        </tr>
    </table>
    <div class="form-group <?php echo (!empty($update_message)) ? 'has-error' : ''; ?>">
<?php 
if($update_success) {
?>    
			<span class="help-block"><strong style="color: green"><?php echo $update_message; ?></strong></span>
<?php 
} else {
?>
			<span class="help-block"><strong style="color: red"><?php echo $update_message; ?></strong></span>
<?php 
}
?>			
	</div>
</form>
          
    </div> <!-- end container -->
      
  
</body>
</html>