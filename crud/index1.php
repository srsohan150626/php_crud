<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h1 class="text-primary text-uppercase text-center">Simple CRUD Application</h1>

		<div class="d-flex justify-content-end">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"> Insert Product </button>
	    </div>
	    <h2 class="text-danger">All Records</h2>
	    <div id="records_content"></div>
	    	<!-- The Modal -->
		<div class="modal" id="myModal">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <!-- Modal Header -->
		      <div class="modal-header">
		        <h4 class="modal-title">Simple CRUD Application</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		      </div>

		      <!-- Modal body -->
		      <div class="modal-body">
		        <div class="form-group">
		        	<label> Name:</label>
		        	<input type="text" name="" id="name" class="form-control" placeholder="Product Name">
		        </div>
		        <div class="form-group">
		        	<label> Slug:</label>
		        	<input type="text" name="" id="slug" class="form-control" placeholder="product_slug">
		        </div>

		      
		        <div class="form-group">
		        	<label> Description:</label>
		        	<input type="text" name="" id="description" class="form-control" placeholder="Product Description">
		        </div>
		        <div class="form-group">
		        	<label>Price:</label>
		        	<input type="text" name="" id="price" class="form-control" placeholder="Product Price">
		        </div>
		      </div>

		      <!-- Modal footer -->
		      <div class="modal-footer">
		      	<button type="button" class="btn btn-success" data-dismiss="modal" onclick="addRecord()">Save</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		      </div>

		    </div>
		  </div>
		</div>
	<!---update modal---->
	<div class="modal" id="update_product_modal">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <!-- Modal Header -->
		      <div class="modal-header">
		        <h4 class="modal-title">Simple CRUD Application</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		      </div>

		      <!-- Modal body -->
		      <div class="modal-body">
		        <div class="form-group">
		        	<label> Name:</label>
		        	<input type="text" name="" id="update_name" class="form-control">
		        </div>
		        <div class="form-group">
		        	<label> Slug:</label>
		        	<input type="text" name="" id="update_slug" class="form-control">
		        </div>

		      
		        <div class="form-group">
		        	<label> Description:</label>
		        	<input type="text" name="" id="update_description" class="form-control">
		        </div>
		        <div class="form-group">
		        	<label>Price:</label>
		        	<input type="text" name="" id="update_price" class="form-control">
		        </div>
		      </div>

		      <!-- Modal footer -->
		      <div class="modal-footer">
		      	<button type="button" class="btn btn-success" data-dismiss="modal" onclick="updateRecord()">Update</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		        <input type="hidden" name="" id="hidden_product_id">
		      </div>

		    </div>
		  </div>
		</div>
	    
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

  <script type="text/javascript">
  	$(document).ready(function(){
  		readRecords();
  	});
  	function readRecords(){
  		var readrecord= "readrecord";
  		$.ajax({
  			url:"backend1.php",
			type:"post",
			data:{readrecord:readrecord},
			success:function(data, status){
  				$('#records_content').html(data);
  			}
  		});
  	}

  	function addRecord(){
  		var name= $('#name').val();
  		var slug= $('#slug').val();
  		var description= $('#description').val();
  		var price= $('#price').val();

  		$.ajax({
  			url:"backend1.php",
  			type:'post',
  			data: { name: name,
  				slug: slug,
  				description: description,
  				price: price
  			},

  			success:function(data, status){
  				readRecords();
  			}

  		})
  	}

  	//delete records
  	function DeleteProduct(deleteid){
  		var conf= confirm("Are you sure ");
  		if(conf==true){
  			$.ajax({
  				url: "backend1.php",
  				type: "post",
  				data: { deleteid: deleteid },
  				success:function(data, status){
  				readRecords();
  			}

  			})
  		}
  	}

  	//update 
  	function GetProductDetails(id){
  		$('#hidden_product_id').val(id);

  		$.post("backend1.php", {
  			id:id
  		}, function(data, status){
  			var product = JSON.parse(data);
  			$('#update_name').val(product.name);
  			$('#update_slug').val(product.slug);
  			$('#update_description').val(product.description);
  			$('#update_price').val(product.price);
  		}
  		);
  	$('#update_product_modal').modal("show");
}

  	function updateRecord() {
    var nameupd = $("#update_name").val();
    var slugupd = $("#update_slug").val();
    var descriptionupd = $("#update_description").val();
    var priceupd = $("#update_price").val();
    var hidden_product_idupd = $("#hidden_product_id").val();
    $.post("backend1.php", {
            hidden_product_idupd: hidden_product_idupd,
            nameupd: nameupd,
            slugupd: slugupd,
            descriptionupd: descriptionupd,
            priceupd: priceupd
        },
        function (data, status) {
            $("#update_product_modal").modal("hide");
            readRecords();
        }
    );
}

  </script>
</body>
</html>