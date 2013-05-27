//asdasdasd
$(document).ready(function() { 
	$('.addToCart').submit(function(e){
		e.preventDefault(); 
		$.php('/ajax/shop/addProductToShoppingCart', $(this).serialize());
	});
});	
