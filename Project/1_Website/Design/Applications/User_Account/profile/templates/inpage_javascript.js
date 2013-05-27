$(document).ready(function(){
	
	$('.address_field').click(function(){
		//$('.editor_clicker').hide();
		$('.address_field').show();
		//$(this).hide();
		$(this).parent().children('.editor_clicker').show();
	});
	
	$('.details_field').click(function(){
		$('.editor_clicker').hide();
		$('.details_field').show();
		$(this).hide();
		$(this).parent().children('.editor_clicker').show();
	});
	
	$('input[name=btnClose]').click(function(){
		$('.editor_clicker').hide();
		$('.address_field').show();
		$('.details_field').show();
	});
	
	$('input[name=btnSave]').click(function(){
		column_name = $(this).parent().children('input[name=text_field],select[name=text_field]').attr('field');
		address_type = $(this).closest('div.address-row').attr('type');

		address_string = 'div.address-row[type="'+address_type+'"] ';
		
		if($(address_string+'input[field="'+column_name+'"],'+address_string+'select[field="'+column_name+'"]').val() == '')
			$(address_string+'span[name="'+column_name+'"]').slideDown().delay(1500).slideUp();
		else
		{
			address_id = $(this).closest('div.address-row').attr('value');
			new_value = $(this).parent().children('input[name=text_field],select[name=text_field]').val();
			new_text = new_value;
			
			$.php('/ajax/user/edit_field',{address_type:address_type, address_id:address_id, column_name:column_name, new_value:new_value });
			
			$html_tag = this;
			
			php.messages.defaultCallBack = function (msg, params){
				if(msg != '')
				{
					new_text = msg;
					$($html_tag).parent().parent().find('.address_field').text(new_text);
				}
				else
					$($html_tag).parent().parent().find('.address_field').text(new_text);
			}
			
			$(this).parent().children('input[name=text_field]').val(new_value);
			$('.editor_clicker').hide();
			$('.address_field').show();
		}
	});
	
	$('input[name=btnChange]').click(function(){
		column_name = $(this).parent().children('input[name=text_field]').attr('column');

		if($('input[column="'+column_name+'"],select[column="'+column_name+'"]').val() == '')
			$('span[name="'+column_name+'"]').slideDown().delay(1500).slideUp();
		else
		{
			new_value = $(this).parent().children('input[name=text_field]').val();
			
			$.php('/ajax/user/edit_profile', {column_name:column_name, new_value:new_value});
			$(this).parent().children('input[name=text_field]').val(new_value);
			$(this).parent().parent().children('.details_field').children('p').text(new_value);
			$('.editor_clicker').hide();
			$('.details_field').show();
		}
	});
	
//	$('.address-content-chooser').click(function(){
//		$('#selection-list').remove();
//		address_type = $(this).attr('type');
//		$(this).parent().hide();
//		$('.'+address_type+'_selector').show();
//		$.php('/ajax/user/show_addresses', {address_type:address_type});
//	});
//	
//	$('input[name=saveSelect]').click(function(){
//		address_id = $('input[name=addressSelect]:checked').val();
//		$.php('/ajax/user/select_address', {address_id:address_id});
//		$(this).parent().parent().hide();
//		$('.address-content-chooser').parent().show();
//	});
});