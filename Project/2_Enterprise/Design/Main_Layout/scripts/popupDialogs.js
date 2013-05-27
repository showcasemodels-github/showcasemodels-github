/*
 * Popup dialog javascript
 * by: starfish internet solutions
 * April 16, 2013
 * 
 * use 'class="openDialog"' for buttons intended to show the dialogs, also don't forget
 * that this buttons "id" attribute is used to determine which dialog to get.
 * 
 * dialogs must have or use the buttons "id" attribute partnered with the word "Dialog" for
 * the dialog's "class" attribute
 * 
 * use 'class="closeDialog"' for buttons intended to hide the current dialog
 * 
 * 
 * */

;(function($){
	var methods = {
		init : function (options)
		{
			var elem	= $(this)
			var opts = $.extend(
			{
				'background' : '#popUpBackground'
			}, options);
			
			//PRIVATE METHOD
			var loadBackground = function()
			{
				$('body').append('<div id="popUpBackground"></div>');
			}
			return this.each(function()
			{
				elem.click(function()
				{
					methods.dialogAction($(this),opts.background);
				});
			},loadBackground());
		},
		
		//PUBLIC METHOD: how to call ( methods.dialogAction(elem, background) )
		dialogAction : function (elem, background)
		{
			if(elem.hasClass('openDialog'))
			{
				var d = elem.attr('id')
				$('[class*="'+d+'Dialog"]').fadeIn();
				$(background).fadeIn();
			}
			else
			{
				elem.closest('div[class*="Dialog"],div[class*="popupDialog"]').fadeOut();
				$(background).fadeOut();
			}
		},
		slideDownAction : function ()
		{
			$('.availableSize').click(function()
			{
		        $("#available_sizesContainer").css({"visibility":"visible"}).slideDown("slow");
		        $(".transparent_background").show();
			});
		},
		addSubcategoryArticle : function ()
		{
			$('span.addSubCategory').click(function(){
				category_id = $(this).children('input[name=category_id]').val();
				$('div.addSubCategoryDialog input[name=category_id]').val(category_id);
			});			
			$('span.addArticle').click(function(){
				category_id		= $(this).children('input[name=category_id]').val();
				subcategory_id	= $(this).children('input[name=subcategory_id]').val();

				$('div.addArticleDialog input[name=category_id]').val(category_id);
				$('div.addArticleDialog input[name=subcategory_id]').val(subcategory_id);
			});			
		}
		
	}
	$.fn.popup = function(options){
		 // Method calling logic
	    if ( methods[options] ) {
	      return methods[ options ].apply( this, Array.prototype.slice.call( arguments, 1 ));
	    } else if ( typeof method === 'object' || ! options ) {
	      return methods.init.apply( this, arguments );
	    } else {
	      $.error( 'Method ' +  options + ' does not exist on popup dialogs' );
	    } 
	}
})(jQuery);