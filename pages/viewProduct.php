<?php

$id=isset($_GET['id']) ? $_GET['id'] : '';

require_once '../src/dbcontroller.php';
$db_handle = new DBController();
    
$result = $db_handle->runQuery("SELECT * FROM tblproduct WHERE id=$id");

?>

<!DOCTYPE HTML>
<html>
<head>
    <title>View Product Details</title>
      
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
            <h1>Product Details</h1>
        </div>
      
 
<!-- html form here where the product information will be entered -->
<form action="">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Product Code</td>
            <td><?php echo htmlspecialchars($result[0]["code"], ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Title</td>
            <td><?php echo htmlspecialchars($result[0]["name"], ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><?php echo htmlspecialchars($result[0]["price"], ENT_QUOTES);  ?></td>
        </tr>
        <tr>
            <td>Image</td>
            <td><img class="table-item-image" src="<?php echo $result[0]["image"]; ?>"></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <a href="adminPanel.php" class='btn btn-primary' > Back </a>
            </td>
        </tr>
    </table>
</form>
          
    </div> <!-- end container -->
      
  
</body>
</html>