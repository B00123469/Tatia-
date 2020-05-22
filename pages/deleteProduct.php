<?php

$id = isset($_GET['id']) ? $_GET['id'] : '';

require_once '../src/dbcontroller.php';
$db_handle = new DBController();

$delete_message = "";
$delete_success = "";
// delete query
$query = "DELETE FROM tblproduct WHERE id = $id";
$delete_result = $db_handle->runBooleanQuery($query);
if($delete_result) {
    $delete_message = "Product deleted successfully";
    $delete_success = true;
} else {
    $delete_message = "Error while deleting product";
    $delete_success = false;
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Delete Product</title>
      
    <link href="../css/my_style.css" type="text/css" rel="stylesheet" />
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
          
</head>
<body>
<div class="form-group <?php echo (!empty($delete_message)) ? 'has-error' : ''; ?>">
<?php 
if($delete_success) {
?>    
			<span class="help-block"><strong style="color: green"><?php echo $delete_message; ?></strong></span>
<?php 
} else {
?>
			<span class="help-block"><strong style="color: red"><?php echo $delete_message; ?></strong></span>
<?php 
}
?>			
</div>
<table class='table table-hover table-responsive table-bordered'>
<tr><td><a href="adminPanel.php" class='btn btn-primary' > Back </a></td></tr>
</table>
</body>
</html>