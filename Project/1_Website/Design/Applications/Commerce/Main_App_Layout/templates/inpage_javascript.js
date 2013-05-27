$(document).ready(function() {
  	$('.removeFromCart').click(function() {
  		var id = $(this).attr("id"); alert(id)
  		$.php('/ajax/shop/removeProductFromShoppingCart?key='+id,{});
  		php.complete = function(){
		location.reload().delay(1000);
		}  			    
  	});
	
	
	
	$(".updateFromCart").click(function() {
		var id = $(this).attr("id"); 
	    var quantity =  $(".changequantity, #"+id).val(); 
	    $.php('/ajax/shop/changeItemQuantity?product_id='+id+'&quantity='+quantity,{});
		php.complete = function(){
		location.reload().delay(1000);
		}
	    
	});
});