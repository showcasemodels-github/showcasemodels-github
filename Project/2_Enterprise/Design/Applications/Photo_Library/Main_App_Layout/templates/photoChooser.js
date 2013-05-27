function loadPhotoChooserImages()
{
		$.php('/ajax/image_library/photo_chooser_images',
			{
				image_div:image_div,
				album_id:album_id,
				size_id:size_id,
				image_id:image_id
			}
		);
		
		$('#photo_chooser div#contentColumn:first').remove();
	
}
jQuery.fn.extend({
	scrollToMe: function () {
	    var x = jQuery(this).offset().top - 100;
	    jQuery('html,body').animate({scrollTop: x}, 500);
	}});

$(window).load(function(){
	
	image_div	= '';
	album_id	= '';
	size_id		= '';
	image_id	= '';
	texteditor = false;
	editor		= '';
//-------------------------------------------------------------------------------------------------


//show photo chooser
	$('.show_photo_chooser, .cke_button__image').live('click',function(){
		
		if($(this).hasClass('cke_button__image')){
			texteditor = true;
			editor = CKEDITOR.currentInstance;
		}
		
		image_div	= $(this).attr('id');
		image_id	= $(this).closest('div.image_group').find('input').val();
		
		if(image_id != 0)
			$.php('/ajax/image_library/photo_chooser',{image_div:image_div, image_id:image_id});
		else
			$.php('/ajax/image_library/photo_chooser',{image_div:image_div});
		
		php.complete = function(){
			
			album_id	= $('#default_album_id').val();
			size_id		= $('#default_size_id').val();
            
            if(album_id || !image_id){ //check if image id is correct		
            	$('#photo_chooser').show();
            	$('#photo_chooser #images_listing_container .image_holder div.active').scrollToMe();
			}
            else{
			    $('#popUpBackground,.imageId_error').fadeIn(function(){
			        $('.popUp_btn').live('click',function(){
			            $('#popUpBackground,.imageId_error').fadeOut();
			        });
			    });
			}
			
		};
		
		
	});
	
//-------------------------------------------------------------------------------------------------	
	//album images are shown
	$('#photo_chooser #leftColumn #sideNavigation span').live('click',function(){

		$('#photo_chooser #leftColumn #sideNavigation li.active').removeClass('active');
		$(this).closest('li').addClass('active');
		
		album_id	= $(this).attr('id');
		size_id		= '';
		image_id	= '';
		
		
		loadPhotoChooserImages();

	});
	
//-------------------------------------------------------------------------------------------------	
//album sizes are shown
	$('#photo_chooser_sizes').live('change',function(){

		size_id		= $(this).val();
		image_id	= '';
		
		loadPhotoChooserImages();
	});
	
//-------------------------------------------------------------------------------------------------	
//choose image
	
	$('#photo_chooser #images_listing_container .image_holder').live('click',function(){
		
		$('.image_holder > div.active').removeClass('active');
	    $(this).find('> div').addClass('active');
	    
		image_id	= $(this).attr('id');
		
		$.php('/ajax/image_library/photo_chooser_details', { image_id:image_id });
	});

	$('.chosen_image').live('click',function(){
		
		image_path	= $(this).attr('data-src');
		image_id	= $(this).attr('id');
		
		if(texteditor)
		{
			image_path = image_path.replace("_thumb","");
			editor.insertHtml('<img src="'+image_path+'" title="'+$(this).attr('data-title')+'" style="width:'+$(this).attr('data-width')+'px; height:'+$(this).attr('data-height')+'px;" alt="'+$(this).attr('data-alt')+'" />');
			texteditor = false;
			
			var dialog = CKEDITOR.dialog.getCurrent();
	    	dialog.hide();
		}
		
		else
		{
			if(image_div != ''){
				$("div#"+image_div+" div#img").css({'background-image':'url('+image_path+')'});
				$("div#"+image_div+" input[type=hidden].image_id").val(image_id);
			}
		}
		
		$('#photo_chooser').fadeOut(150, function(){
			$('#photo_chooser').empty();// Remove element nodes and prevent memory leaks
		});
		
		$("div#"+image_div+" div#img").scrollToMe();
	});

	$('.close_photo_chooser').live('click',function(){
		
		$('#photo_chooser').fadeOut(150, function(){
			$('#photo_chooser').empty();// Remove element nodes and prevent memory leaks
		});
	});

	//DELETE IMAGE
	$('span.delete_photo').live('click',function(){
		$(this).parent().remove();
	});
	
	
});