<?php
require_once '../src/dbcontroller.php';
$db_handle = new DBController();

$create_message = "";
$create_success = "";

if($_POST){
    try{
        
        // posted values
        $code = trim(htmlspecialchars(strip_tags($_POST['code'])));
        $title = trim(htmlspecialchars(strip_tags($_POST['title'])));
        $price = trim(htmlspecialchars(strip_tags($_POST['price'])));
        $image = trim(htmlspecialchars(strip_tags($_POST['image'])));
        $imagePath = "../images/";
        $imagePath .= $image;
        $row_count = $db_handle->numRows("SELECT * FROM tblproduct WHERE code='$code'");
        if(intval($row_count) > 0) {
            $create_success = false;
            $create_message = "Product code is not unique";
        }
        
        if(empty($create_message)) {
            // insert query
            $query = "INSERT INTO tblproduct(name,code,image,price) VALUES ('$title','$code','$imagePath',$price)";
            $result = $db_handle->runBooleanQuery($query);
            
            if($result) {
                $create_message = "Product created successfully";
                $create_success = true;
            } else {
                $create_message = "Error while creating product";
                $create_success = false;
            }
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
    <title>Create a Product</title>
      
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
          
</head>
<body>
  
    <!-- container -->
    <div class="container">
   
        <div class="page-header">
            <h1>Create Product</h1>
        </div>
      
    <form action="" method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Product Code</td>
                <td><input type='text' name='code' class='form-control' required/></td>
            </tr>
            <tr>
                <td>Title</td>
                <td><input type='text' name='title' class='form-control' required/></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><input type='text' name='price' class='form-control' required/></td>
            </tr>
            <tr>
                <td>Image File Name</td>
                <td><input type='text' name='image' class='form-control' required/></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Create' class='btn btn-primary' />
                    <a href='adminPanel.php' class='btn btn-primary'>Back</a>
                </td>
            </tr>
        </table>
        <div class="form-group <?php echo (!empty($create_message)) ? 'has-error' : ''; ?>">
<?php 
if($create_success) {
?>    
				<span class="help-block"><strong style="color: green"><?php echo $create_message; ?></strong></span>
<?php 
} else {
?>
				<span class="help-block"><strong style="color: red"><?php echo $create_message; ?></strong></span>
<?php 
}
?>			
    	</div>
    </form>
          
    </div> <!-- end container -->
      
  
</body>
</html>