$(document).ready(function(){
	$('#button_add_product').click(function(e){
		$('#model_create_titile').html("Create New Product");
		$('#error_product_name').html("");
		$('#error_product_price').html("");
		$('#error_product_discount').html("");
		$('#error_product_image').html("");
		$('#add_product_name').val('');
		$('#add_product_price').val('');
		$('#add_product_discount').val(0);
		$('#add_product_description').val('');
		$('#btn_submit_add_product').html("Add");
		$('#add-product-form').attr("action",base_url+"/product/create_product");

		$('#popupAddProduct').modal('toggle');
	});

	$('#add-product-form').on('submit',function(e){
		$('#error_product_name').html("");
		$('#error_product_price').html("");
		$('#error_product_discount').html("");
		$('#error_product_image').html("");
		var validation = true;
		var numbers = /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/;
		if($.trim($('#add_product_name').val()) == ""){
			$('#error_product_name').html("required");
			validation = false;
		}
		if($.trim($('#add_product_price').val()) == ""){
			$('#error_product_price').html("required");
			validation = false;
		}
		else if(!$.trim($('#add_product_price').val()).match(numbers))
		{
			validation = false;
			$('#error_product_price').html("accept only number");
		}

		if($.trim($('#add_product_discount').val()) == ""){
			$('#error_product_discount').html("required");
			validation = false;
		}
		else if(!$.trim($('#add_product_discount').val()).match(numbers))
		{
			validation = false;
			$('#error_product_discount').html("accept only number");
		}

		var modal_title = $('#model_create_titile').html();
		if(modal_title == "Create New Product"){
			if($.trim($('#add_product_image').val()) == ""){
				$('#error_product_image').html("required");
				validation = false;
			}
		}
		if(!validation)
		{
			e.preventDefault();
		}
	});

	$('#btn_delete_product').click(function(e){
		var uri = window.location.href;
		var product_id = $(this).attr("product_id");
		$.ajax({
			url: "http://localhost:5000/products/"+product_id, 
			type: 'DELETE', 
			data: {product_id:product_id},				
			success: function(data){
				if(data.n == "1")
				{
					window.location.href = uri;
				}
				else
				{
					alert("delete not success");
				}
			}
		});
	});
	

});


function delete_product(product_id) {
	$('#popupDeleteProduct').modal('toggle');
	$('#btn_delete_product').attr("product_id", product_id);
}

function view_product(product_id) {
	$.ajax({
		url: "http://localhost:5000/products/"+product_id, 
		type: 'GET', 
		data: {product_id:product_id},				
		success: function(data){
			$('#detail_productImage').attr("src","http://localhost:5000/"+data.product['productImage']);
			$('#detail_name').html(data.product['productName']);
			$('#detail_price').html(data.product['price']+"$");
			$('#detail_after_discount').html(((100 - parseFloat(data.product['discount']))*parseFloat(data.product['price'])/100) +"$");
			$('#detail_discount').html(data.product['discount']+'%');
			if (data.product['description']!= "") {
				$('#detail_description').html(data.product['description']);
			} else {
				$('#detail_description').html("null");
			}
			var createDate = new Date(data.product['createDate']);
			$('#detail_create_date').html(formatDate1(createDate));

			if(typeof data.product['updateDate'] !== 'undefined'){
				var updateDate = new Date(data.product['updateDate']);
				$('#detail_update_date').html(formatDate1(updateDate));
			} else {
				$('#detail_update_date').html("null");
			}
			$('#popupViewProduct').modal('toggle');
		}
	});
}

function update_product(product_id) {
	$.ajax({
		url: "http://localhost:5000/products/"+product_id,
		type: 'GET',
		data: {product_id:product_id},				
		success: function(data){
			$('#model_create_titile').html("Update Product");
			$('#error_product_name').html("");
			$('#error_product_price').html("");
			$('#error_product_discount').html("");
			$('#error_product_image').html("");
			$('#add_product_name').val(data.product['productName']);
			$('#add_product_price').val(data.product['price']);
			$('#add_product_discount').val(data.product['discount']);
			$('#add_product_description').val(data.product['description']);
			$('#btn_submit_add_product').html("Update");
			$('#add-product-form').attr("action",base_url+"/product/update_product/"+product_id);
			
			$('#popupAddProduct').modal('toggle');
		}
	});

}

function formatDate1(date) {
	var dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
	var dayName = dayNames[date.getDay()];

	var monthNames = [
	"Jan", "Feb", "Mar",
	"Apr", "May", "Jun", "Jul",
	"Aug", "Sep", "Oct",
	"Nov", "Dec"
	];

	var day = date.getDate();
	var dayIndex = date.getDay();
	var monthIndex = date.getMonth();
	var year = date.getFullYear();
	var hour = date.getHours();
	var minute = date.getMinutes();
	var second = date.getSeconds();

	if(day<10){
		day = '0'+day;
	}

	if(hour<10){
		hour = '0'+hour;
	}

	if(minute<10){
		minute = '0'+minute;
	}
	if(second<10){
		second = '0'+second;
	}

	return dayNames[dayIndex]+' '+monthNames[monthIndex]+' '+day +' '+ year+' '+hour+':'+minute+':'+second ;
}