$(document).ready(function() {
	$('.addCategoryText').live('click',function(){
		$('p#category select:first-child').clone().appendTo('p#category');
	});
	
	$('.imageContainer').click(function(){
		if(!($(this).hasClass('selected'))){
			$('#productImages .selected').removeClass('selected');
			$(this).addClass('selected');
		}
	});
	
});
