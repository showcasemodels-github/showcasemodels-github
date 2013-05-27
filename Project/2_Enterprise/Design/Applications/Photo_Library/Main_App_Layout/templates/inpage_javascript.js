$(window).load(function() {
	//abort delete when image or album is in use
   // $('.imageId_error span[title*="abort"]').popup('errors');
	
// Popup Dialogs ===============================================================================
	//Album Rename

    $(".changeTitle").click(function(){
    	$(".box").removeClass("hide").addClass("show");
    	$(".changeTitle").addClass("hide");
    });
    $(".cancel").click(function(){
		$(".box").removeClass("show").addClass("hide");
		$(".changeTitle").removeClass("hide");
		
	});
    //=============================================================================================
    
//=================================================================================================
//FORM VALIDATION
    
    jQuery("#new_size_form,#resize_album_form,#add_album_form").validationEngine();

//=================================================================================================

	$('.image_holder').bind('click',function(){
	    $('.image_holder > div.active').removeClass('active');
	    $(this).find('> div').addClass('active');
	});
	
//=================================================================================================
//IMAGES JQUERY
	
	/*
	$('#upload-dialog input[name="upload_photo"]').live('click',function(){
		$('#upload-dialog #loader').fadeIn();
	});
	  
    $("#availableSize").click(function(){
        $("#available_sizesContainer").css({"visibility":"visible"}).slideDown("slow");
        $(".transparent_background").show();
    });
	$('#add_sizeContainer').live('click', function(){
		$("#available_sizesContainer").slideUp();
		$('#new_size_dialog,#popUpBackground').fadeIn();
	});
	$('.resize').live('click', function(){
		$("#available_sizesContainer").slideUp();
		$(".transparent_background").hide();
	});
	$('.deleteSize').live('click', function(){
		$("#available_sizesContainer").slideUp(function(){
			$(this).css({"visibility":"hidden"}).slideDown();});
			$(".transparent_background").hide();
			$(this).closest('li').find('.popUp_delete').fadeIn();
			$('.popUp_delete').css({
				"visibility":"visible"
		});
	});
	$('.keep_size').live('click', function(){
		$('.popUp_delete').css({
			"visibility":"hidden"
		});
		$("#available_sizesContainer").hide().slideUp(function(){
			$(this).css({"visibility":"visible"});
		});
	});
	*/
	
	$(".transparent_background").click(function(){
        $("#available_sizesContainer").slideUp("slow");
        $(".transparent_background").hide();
	});
	$('form.image_details_form').submit(function(e){
		e.preventDefault();
		$.php('/ajax/image_library/load_image_details',$(this).serialize());
	});
    //check if image is in use before delete
    $('form#image_delete').submit(function(e){
    		e.preventDefault();
    		$.php('/ajax/image_library/if_used',$(this).serialize());
    		
    		php.messages.defaultCallBack = function(msg,params) {
    			if(msg == 'Success.')
    			{
    				showLoader();
    				document.getElementById("image_sidebar").submit();
    			}
    			else{
    				$('.imageId_error').fadeIn();
    				$('.deleteImage_popUp').fadeOut();
    			}
    		}
    });
    //check if image filename is used
    $('form#image_sidebar').submit(function(e){
    	e.preventDefault();
	    	parent_form = $(this).closest('.album_form');
	    	
			$.php('/ajax/image_library/if_filename_exists',$(this).serialize());
			
			php.messages.defaultCallBack = function(msg,params) {
				if(msg == 'Success.')
				{
					showLoader();
					document.getElementById('image_sidebar').submit();
				}
				else{
					$('.imageName_error').fadeIn();
					$('.deleteAlbum_popUp').fadeOut();
				}
			}
    });
    //check if size is in use before delete
    $('input[name=delete_size]').click(function(e){
    	e.preventDefault();
    	
    	parent_form = $(this).closest('form.delete_image_size');
    	
    	$.php('/ajax/image_library/if_size_used',parent_form.serialize());
    	
		php.messages.defaultCallBack = function(msg,params) {
			if(msg == 'Success.'){
				showLoader();
				parent_form.submit();
			}
			else
			{
				$('.imageId_error').fadeIn();
				$('.popUp_delete').fadeOut();
			}
		}
    });
    //check if ablbum is in use before delete
    $('input[name=delete_album]').click(function(e){
    	e.preventDefault();
    	parent_form = $(this).closest('.album_form');
    	
		$.php('/ajax/image_library/if_album_used',parent_form.serialize());
		
		php.messages.defaultCallBack = function(msg,params) {
			if(msg == 'Success.')
			{
				showLoader();
				parent_form.find('#albumActionType').val('delete');
				parent_form.submit();
			}
			else
			{
				$('.imageId_error').fadeIn();
				$('.deleteAlbum_popUp').fadeOut();
			}
		}
    });
    
   
//=================================================================================================
//FAKE INPUT TYPE FILE
	$('.trueInputFile').change(function(){
		var trueValue = $(this).attr('value');
		trueValue = trueValue.replace('C:\\fakepath\\','');
		var hasValue = $('#fakeInputFile-text').text();
		if(hasValue){
			$('#fakeInputFile-text span').text(' ');
		}
		$('#fakeInputFile-text span').text(trueValue);
		
	});

//=================================================================================================
	$('input[type="submit"][name*="save"],input[type="submit"][name*="delete"]').live('click',function(){
		showLoader();
	});
	
});


