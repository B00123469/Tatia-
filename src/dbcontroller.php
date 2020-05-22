<?php
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "test";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}
		return $conn;
	}
	
	function runQuery($query) {
	    $resultset = [];
		$result = mysqli_query($this->conn,$query);
		if(!empty($result)) {
    		while($row=mysqli_fetch_assoc($result)) {
    			$resultset[] = $row;
    		}	
		}
		return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
	
	function runBooleanQuery($query) {
	    $result  = mysqli_query($this->conn,$query);
	    return $result;
	}
	
	function closeConnection() {
	    mysqli_close($this->conn);
	}
	
	function getSqlStatement($query) {
	    return mysqli_prepare($this->conn, $query);
	}
	
	function checkIfProductInWishlist($userId, $productId) {
	    $rowCount = $this->numRows("SELECT * FROM tblwishlist WHERE UserId_FK=$userId && ProductId_FK=$productId");
	    if($rowCount > 0) {
	        return true;
	    } else {
	        return false;
	    }
	}
	
	function removeProductFromWishlist($userId, $productCode) {
	    $query = "SELECT id FROM tblproduct WHERE code='" . $productCode . "'";
	    $productId = $this->runQuery($query);
	    
	    if(!empty($productId)) {
	        $query = "DELETE FROM tblwishlist WHERE ProductId_FK=" . $productId[0]["id"] . "&& UserId_FK=" . $userId;
	        $delete_result = $this->runBooleanQuery($query);
	        if($delete_result) {
	            return true;
	        } else {
	            return false;
	        }
	        
	    }
	}
}
?>