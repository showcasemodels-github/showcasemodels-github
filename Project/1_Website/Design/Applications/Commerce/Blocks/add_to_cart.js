$(document).ready(function() {
	//$('div#shoppingCartDropDown').hide();
	
	$('.addToCart').click(function(){
		var id = $(this).attr("product_id");
		$.php('/ajax/eshop/addProductToShoppingCart?product_id='+id,{});
		
			php.complete = function ()  {
				alert('product added');
				//$('div#shoppingCartDropDown').slideDown(500);
		}	
	});
});	


