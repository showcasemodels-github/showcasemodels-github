$(document).ready(function() {

	//jQuery("form").validationEngine();    

//-------------------------------------------------------------------------------------------------  

	//ADD IMAGE       
    $('#add_photos').click(function(){
		image_counter = ($('#product_photos').children().length)-1;
		
		$('.image_clone > div').clone().attr('id','gallery_image_'+image_counter).appendTo('#product_photos');
		$('#product_photos').find('#gallery_image_'+image_counter+' span.show_photo_chooser').attr('id','gallery_image_'+image_counter);
		$('#gallery_image_'+image_counter).find('input.image_id').attr('name','image_id[]');
		$('#gallery_image_'+image_counter).find('input.gallery_image_id').attr('name','gallery_image_id[]');
		
		
	});
    
	$('span.addCategory').click(function(){
		$('div.addCategory_popUp, #popUpBackground').fadeIn();
	});

	$('span.addSubCategory').click(function(){ 
		$('div.addSubCategory_popUp, #popUpBackground').fadeIn();
		
		category_id = $(this).children('input[name=category_id]').val();
		
		$('div.addSubCategory_popUp input[name=category_id]').val(category_id);
	});

	$('span.addProduct').click(function(){ 
		$('div.addArticle_popUp, #popUpBackground').fadeIn();
		
		category_id		= $(this).children('input[name=category_id]').val();
		subcategory_id	= $(this).children('input[name=subcategory_id]').val();
		
		$('div.addArticle_popUp input[name=category_id]').val(category_id);
		$('div.addArticle_popUp input[name=subcategory_id]').val(subcategory_id);
	});

	$('span.deleteCategory').click(function(){
		$('div.deleteCategory_popUp, #popUpBackground').fadeIn();
	});

	$('span.deleteSubCategory').click(function(){
		$('div.deleteSubCategory_popUp, #popUpBackground').fadeIn();
	});

	$('span.deleteProduct').click(function(){
		$('div.deleteArticle_popUp, #popUpBackground').fadeIn();
	});

	$('span.keep_product, span.cancel').click(function(){
		$('div.popupDialog, div.popUp_delete, #popUpBackground').fadeOut();
	});
	
	//available sizes
    $("#variation").click(function(){
        $("#available_variationsContainer").css({"visibility":"visible"}).slideDown("slow");
        $(".transparent_background").show();
    });
    
    $('.transparent_background').live('click', function(){
		$("#available_variationsContainer").slideUp();
	});
    
    $('input[type="submit"][name*="save"],input[type="submit"][name*="delete"]').live('click',function(){
		showLoader();
	});
	
});
