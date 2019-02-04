<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<title>Product management</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="<?=base_url("assets/js/product.js")?>"></script>
	<link href="<?=base_url("assets/css/product.css")?>" rel="stylesheet">
	<script >
		const base_url = '<?php echo site_url();?>';
	</script>
	
</head>
<body class="mg-bot-30">
	<nav class="navbar navbar-default">
	  <div class="container ">
	    <div class="navbar-header">
	      <a class="navbar-brand" >ABC Management Product</a>
	    </div>
	    <ul class="nav navbar-nav">
	    </ul>
	  </div>
	</nav>
	<div class="container">
		<div>
			<ul class="breadcrumb">
			    <li class="active">Product List</li>
			</ul>
		</div>
		<div class="row">
		
			<div class="col-md-2 fload-right" >
				<a type="" class="btn btn-primary" id="button_add_product">Add product</a>
			</div>
		</div>

		<div  class="row mg-top-20" >

			<?php if(isset($products)){
				foreach($products as $product) {
			 ?>

			<div class="col-md-3 mg-top-20 " >
				<div class="card pd-right-10 pd-left-10 border-solid" >
					<div class="card-body pd-top-10" >
						<div class="image-height">
							<img src="http://localhost:5000/<?php echo $product['productImage'];?>" alt="product image not found" width="100%">
						</div>
						<p class="text-center">
							<b><?=$product['productName'] ?></b>
						</p>
						<p class="text-center">
							<i><?=$product['price'] ?>$</i>
						</p>
						<p class="text-center">
							discount <b><?=$product['discount'] ?>%</b>
						</p>
						<div align="center">
							<button onclick="view_product('<?=$product['_id'] ?>')"  class="btn btn-link" title="View Product Detail"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>
							<button onclick="update_product('<?=$product['_id'] ?>')"  class="btn btn-link" title="Update Product"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
							<button onclick="delete_product('<?=$product['_id'] ?>')" class="btn btn-link" title="Delete Product"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
						</div>
						
					</div>
				</div>
			</div>
			<?php } 
			} else {?>
			<div class="mg-left-50">
				<p>No Product</p>
			</div>
			<?php  } ?>

		</div>


	</div>

<!-- Start modal add product -->
<div class="modal fade" id="popupAddProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<form action="<?=site_url("product/create_product")?>" method="post" enctype="multipart/form-data" id="add-product-form">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="model_create_titile">Create New Product</h4>
				</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-3">Product Name:</div>
						<div class="col-md-5">
							<input type="text" class="form-control" name="productName" id="add_product_name" autocomplete="off">
							<br>
							<span class='text-danger' id="error_product_name"></span>
						</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-3">Price:</div>
					<div class="col-md-5">
						<div class="col-md-6 pd-right-0 pd-left-0">
							<input type="text" class="form-control" name="price" id="add_product_price" autocomplete="off">
							<br>
							<span class='text-danger' id="error_product_price"></span>
						</div>
						<div class="col-md-2 pd-left-5 pd-top-5">
							<p>$</p>
						</div>
						
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-3">Discount:</div>
					<div class="col-md-5">
						<div class="col-md-6 pd-right-0 pd-left-0">
							<input type="text" class="form-control" name="discount" id="add_product_discount" value="0" autocomplete="off">
							<br>
							<span class='text-danger' id="error_product_discount"></span>
						</div>
						<div class="col-md-2 pd-left-5 pd-top-5">
							<p>%</p>
						</div>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-3">Description:</div>
					<div class="col-md-5">
						<textarea type="text" class="form-control" name="description" id="add_product_description" autocomplete="off"></textarea> 
						<br>
						<span class='text-danger' id="error_product_description"></span>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-3">Upload Image:</div>
					<div class="col-md-5">
						<input type="file" class="" name="productImage" id="add_product_image" autocomplete="off">
						<br>
						<span class='text-danger' id="error_product_image"></span>
					</div>
				</div>
				<br/>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" id="btn_submit_add_product" class="btn btn-primary" >Add</button>
			</div>
		</div>
	</div>	
</form>

</div>
<!-- End modal add product -->
<!-- Start modal view product -->
<div class="modal fade" id="popupViewProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<form action="<?=site_url("product/create_product")?>" method="post" enctype="multipart/form-data" id="add-product-form">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="">View detail Product</h4>
				</div>
			<div class="modal-body">
				<div class="pd-50">
					<img src="" id="detail_productImage" alt="product image not found" width="100%">
				</div>
				<div class="row">
					<div class="col-md-3">Product Name:</div>
						<div class="col-md-5">
							<p id="detail_name" >null</p>
							<br>
						</div>
				</div>
				<div class="row">
					<div class="col-md-3">Real Price:</div>
					<div class="col-md-5">
						<p id="detail_price">null</p>
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">After Discount:</div>
					<div class="col-md-5">
						<p id="detail_after_discount">null</p>
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">Discount:</div>
					<div class="col-md-5">
						<p id="detail_discount">null</p>
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">Description:</div>
					<div class="col-md-5">
						<p id="detail_description">null</p>
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">Creade Date:</div>
					<div class="col-md-5">
						<p id="detail_create_date">null</p>
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">Update Date:</div>
					<div class="col-md-5">
						<p id="detail_update_date">null</p>
						<br>
					</div>
				</div>
				<br/>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>	
</form>

</div>
<!-- End modal view product -->

<!-- Start modal ask remove product -->
<div class="modal fade" id="popupDeleteProduct" role="dialog">
	
        <div class="modal-dialog">
            <!-- Modal content-->	        
            <div class="modal-content" align="center">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Information</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete this product?</p>                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default " data-dismiss="modal">No</button>
                	<button type="submit" id="btn_delete_product" class="btn btn-danger " >yes</button>
                </div>
            </div>
        </div>
	
</div>
<!-- End modal ask remove product -->
	
	
	
</body>
</html>