<?php
    require_once '../src/dbcontroller.php';
    $db_handle = new DBController();
    $result = $db_handle->runQuery("SELECT * FROM tblproduct");
?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<TITLE>Administrator Panel</TITLE>
<link href="../css/my_style.css" type="text/css" rel="stylesheet" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

</HEAD>
<BODY>
	<div class="container" style="margin-top:10px;">
	<h1 class="text-center" style="background-color:#f8f9fa;  margin-bottom: 0px;">Admin Panel</h1>
    <nav class="navbar navbar-light bg-light">
    <form class="form-inline">
    <a href="createProduct.php" class="btn btn-outline-primary" type="button" title="Create New Product"> 
       <i class="fa fa-plus fa-lg" data-toggle="tooltip" title="Create A New Product" aria-hidden="true" >
        </i>
    	</a>
	    </form>
		</nav>
	<br>
	<div class="table-responsive-sm table-responsive-md table-responsive-lg">
<table class="table table-bordered text-center">
<tbody>
    <tr>
    <th style="text-align:left;">Title</th>
    <th style="text-align:left;" width="10%">Product Code</th>
    <th style="text-align:right;" width="10%">Price</th>
    <th style="text-align:center;" width="20%">Actions</th>
    </tr>
<?php 
    foreach ($result as $item){
?>
	<tr>
	<td style="text-align:left;"><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
	<td style="text-align:left;"><?php echo $item["code"]; ?></td>
	<td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
	<td style="text-align:center;">
		<a href="viewProduct.php?id=<?php echo $item["id"]; ?>" class='fa fa-eye fa-lg' title="View"></a> &nbsp;
        <a href="updateProduct.php?id=<?php echo $item["id"]; ?>" class="fa fa-pencil-square-o fa-lg" data-toggle="tooltip" title="Update" aria-hidden="true"></a>&nbsp;
      	<a href="deleteProduct.php?id=<?php echo $item["id"]; ?>" class="fa fa-trash-o fa-lg" data-toggle="tooltip" title="Delete" aria-hidden="true"></a>
	</td>
	</tr>
<?php 
    }
?>
</tbody>
</table>
</div>
</div>
<?php 
$db_handle->closeConnection();
?>
