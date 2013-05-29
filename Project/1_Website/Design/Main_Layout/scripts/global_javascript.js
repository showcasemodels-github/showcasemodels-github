var items = {}
$(document).ready(function() { 
	//add class active
	$('.productNavigation div:first-of-type').addClass('active');
	
	$('li#military').mouseenter(function(){
		$('.productNavigationWrapper').show();
	});
	//hide event of dropdown
	$('.bannerWrapper').mouseenter(function(){
		$('.productNavigationWrapper').hide();
	});
	
	
	
	
	items.getItems = function () 
	{
		$.php('/ajax/shop/fetchNumberOfItems');
	}

	items.interval = setInterval(items.getItems, 1000);
});	


