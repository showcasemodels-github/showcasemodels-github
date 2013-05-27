$(document).ready(function(){
	$('.registration').validate({
		rules:
		{
			reTypePassword: {
		      equalTo: "#password"
		    },
		    email: {
		    	email: true
		    }
		},
	    messages:
	    {
	    	reTypePassword: {
	        	equalTo:'Password does not match'
	        },
	        email: {
	        	email:'Please use a valid email address'
	        }
	    }
	});
	
	$('#registrationEmail').focusout(function(){
		
		input = this;
		
		if($(input).val().length > 0)
		{
			email = $(input).val();
			
			$.php('/ajax/user/check_email',{email:email});
			
			php.messages.defaultCallBack = function(msg)
			{
				if(msg == 'exists')
				{
					email_exists = true;
					$(input).parent().append('<label id="email_exists" class="error">Email address already exists.</label>');
				}
				else
				{
					email_exists = false;
				}
			}
		}
	});
	

	$('input[name=editProfile]').click(function(){
		$('div.userProfile').hide(1000);
		$('div.editProfile').show(1000);
	});
	
	$('input[name=saveProfile]').click(function(){
		$('div.editProfile').hide(1000);
		$('div.userProfile').show(1000);
		
		var firstname = $('input[name=editLastname]').val();
		var lastname = $('input[name=editFirstname]').val();
		var email = $('input[name=editEmail]').val();
		var address = $('input[name=editAddress]').val();
		var address2 = $('input[name=editAddress_2]').val();
		var city = $('input[name=editCity]').val();
		var state = $('#editState option:selected').val()
		var otherstate = $('input[name=editOther_state]').val();
		var zipcode = $('input[name=editZipcode]').val();
		var country = $('#editCountry option:selected').val()
		var phone = $('input[name=editPhone]').val();
		var fax = $('input[name=editFax]').val();
		var company = $('input[name=editCompany]').val();
		
		$.php('/ajax/profile/editAccountIngo', firstname:firstname lastname:lastname email:email address:address);
	});
	
});

