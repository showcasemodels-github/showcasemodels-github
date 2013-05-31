$(document).ready(function() {
	$('.addCategoryText').click(function(){
		if($('p#category').children('select').length < 3)
			$('p#category select:first-of-type').clone().appendTo('p#category');
	});
	
	$('.addSpecificationText').click(function(){
		if($('p#specifications').children('input').length < 5){
			
			$('p#specifications input:first-child').clone().val('New Entry').appendTo('p#specifications');
		}
	});
	
	$('.imageContainer').click(function(){
		if(!($(this).hasClass('selected'))){
			$('#productImages .selected').removeClass('selected');
			$(this).addClass('selected');
		}
	});
	
});
