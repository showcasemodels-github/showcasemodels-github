$(document).ready(function() {
	$('.addSubcategoryText').click(function(){
		//if($('p#subcategory').children('select').length < 3)
			$('p#subcategory select:first-of-type').clone().appendTo('p#subcategory');
	});
});
