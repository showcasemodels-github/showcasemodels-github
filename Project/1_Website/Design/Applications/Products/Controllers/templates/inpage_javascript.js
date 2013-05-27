$(document).ready(function(){ 
	$('.addToCart').submit(function(e){
		e.preventDefault(); 
		$.php('/ajax/shop/addProductToShoppingCart', $(this).serialize());
		
		php.complete = function(){
			$('#shoppingCartDropDown').slideDown();
		};
	});
	
	var options = {  
	        zoomType: 'standard',  
	        lens:true,  
	        showPreload: true,
	        title: false,            
	        showEffect: 'fadein',
	        hideEffect: 'fadeout',
	        fadeinSpeed: 'fast',
	        fadeoutSpeed: 'fast',
	        zoomWidth: 574,  
	        zoomHeight:399,  
	        xOffset:0,  
	        yOffset:0,  
	        position:'right'  
	        //...MORE OPTIONS  
		};	
		$('.productImageHover').jqzoom(options); 
		
		$('.productUl li img').click(function(){
			var clickThumb = $(this).attr('rel');
			$('.productImageHover').unbind('.productImageHover');
			
			$('.productImageHover').parent().hide();
			$('.productImageHover').removeClass('productImageHover');
			
			
			//display clicked image
			$('.'+clickThumb).show();
			$('.'+clickThumb+' a').addClass('productImageHover').jqzoom(options);
		});		
});	

	function changeImage(imgSrcSmallVersion, imgSrcLargeVersion) {

	}
