<?php 
$host = "localhost";
$username = "root";
$password="";
$db_name= "wedevs";

$conn= new mysqli($host, $username, $password, $db_name);
if (mysqli_connect_errno()) {
	echo "Error: Could not connect to database.";
	exit;
}
extract($_POST);

	if (isset($_POST['readrecord'])) {
		$data =  '<table class="table table-bordered table-striped ">
						<tr class="bg-dark text-white">
							<th>No.</th>
							<th>Name</th>
							<th>Slug</th>
							<th>Description</th>
							<th>Price</th> 
							<th>Edit</th>
							<th>Delete</th>
						</tr>'; 

		$displayquery= "SELECT * FROM `products`";
	    $result= mysqli_query($conn, $displayquery);

	if(mysqli_num_rows($result) > 0){

		$number = 1;
		while ($row = mysqli_fetch_array($result)) {
			
			$data .= '<tr>  
				<td>'.$number.'</td>
				<td>'.$row['name'].'</td>
				<td>'.$row['slug'].'</td>
				<td>'.$row['description'].'</td>
				<td>'.$row['price'].'</td>
				<td>
					<button onclick="GetProductDetails('.$row['id'].')" class="btn btn-info">Edit</button>
				</td>
				<td>
					<button onclick="DeleteProduct('.$row['id'].')" class="btn btn-danger">Delete</button>
				</td>
    		</tr>';
    		$number++;

		}
	} 
	 $data .= '</table>';
    	echo $data;
	}


   //insert records into database
	if (isset($_POST['name']) && isset($_POST['slug']) && isset($_POST['description']) && isset($_POST['price'])) {

		$stmt=$conn->prepare("INSERT INTO `products`(`name`, `slug`, `description`, `price`) VALUES ( '$name', '$slug', '$description' , '$price' )" );

		$stmt->bind_param("ssss",$name,$slug,$description,$price);
		$stmt->execute();
		$stmt->close();
	}

	//delete 
	if (isset($_POST['deleteid'])) {
	    
	    $productid = $_POST['deleteid'];
	    $deletequery= " DELETE FROM products where id='$productid' ";
	    mysqli_query($conn, $deletequery);
	}

	//update 
	if(isset($_POST['id']) && isset($_POST['id']) != "")
	{
	    $product_id = $_POST['id'];
	    $query = "SELECT * FROM products WHERE id = '$product_id'";
	    if (!$result = mysqli_query($conn,$query)) {
	        exit(mysqli_error());
	    }
	    
	    $response = array();

	    if(mysqli_num_rows($result) > 0) {
	        while ($row = mysqli_fetch_assoc($result)) {
	       
	            $response = $row;
	        }
	    }
	    else
	    {
	        $response['status'] = 200;
	        $response['message'] = "Data not found!";
	    }
	 
	    echo json_encode($response);
	}
		else
		{
		    $response['status'] = 200;
		    $response['message'] = "Invalid Request!";
		}

	if(isset($_POST['hidden_product_idupd'])){

	$hidden_product_idupd = $_POST['hidden_product_idupd'];
	$nameupd = $_POST['nameupd'];
	$slugupd = $_POST['slugupd'];
    $descriptionupd = $_POST['descriptionupd'];
    $priceupd = $_POST['priceupd'];

    $stmt = $conn->prepare(" UPDATE `products` SET `name`='$nameupd',`slug`='$slugupd',`description`='$descriptionupd',`price`='$priceupd' WHERE id= '$hidden_product_idupd' ");

    $stmt->bind_param("ssss",$name,$slug,$description,$price);
	$stmt->execute();
	$stmt->close();
	}
     


?>