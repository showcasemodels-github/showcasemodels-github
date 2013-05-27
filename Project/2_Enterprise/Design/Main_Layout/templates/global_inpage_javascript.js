//Start of Main_Layout global_inpage_javascript.js
$(document).ready(function(){
	
	$('.openDialog,.closeDialog').popup();
	$('.availableSize').popup('slideDownAction');
	
	CKEDITOR.replaceAll('editor');
	
	//JQUNIFORM
	$("select, input:checkbox, input:text, input:password, textarea, input:radio").uniform();
//-------------------------------------------------------------------------------------------------
        
//-------------------------------------------------------------------------------------------------
        //resize leftColumn navigation when it gets too long
        var has_images_column = $('#applicationContent').find('#applicationSideBar').attr('id');
        var module = $('body').attr('id');
        var multiplier = 1;
        
        if(module == 'image_library')
        {
        	multiplier = 2;
        }
        
        var left_column_height = (($('#leftColumn #heading:first').outerHeight() * multiplier) + $('#leftColumn #sideNavigation').outerHeight() + 20);
        if(has_images_column == 'applicationSideBar' || module == 'articles' || module == 'products' && has_images_column == 'applicationSideBar' ){
        	if(left_column_height > 600){
        		$('#leftColumn').css({
        			'height':'600px',
        			'overflow':'auto'
        		});
        		$('#nav_list span.nav,#leftColumn #heading,#sideNavigation').css({
        			'width':'279px'
        		});
        	}
        }


//-------------------------------------------------------------------------------------------------
        //Generate url for dialogs
        $('[class*="_dialog"] input[name="title"]').keyup(function(){
        	var url = $(this).val();
        	for(var i = url.length-1; i >=0; i--)
        		url = url.replace(' ','-');
        	$(this).closest('[class*="_dialog"]').find('input[name*="_url"]').val('/'+url.toLowerCase());
        });
        
});



//-------------------------------------------------------------------------------------------------

function showLoader(){
	$('body').append('<div class="loading"></div>');
}
function destroyLoader(){
	$('.loading').remove();
}
//-------------------------------------------------------------------------------------------------

