$(document).ready(function(){
	getSMTPState();
	$('select[name="use_smtp"]').change(function(){
		getSMTPState();
	});
	
});
function getSMTPState(){
	var state = $('select[name="use_smtp"]').val();
	if(state == 0){
		$('#smtp').find('input[name*="smtp_"]').attr('readonly',true);
	}
	else{
		$('#smtp').find('input[name*="smtp_"]').removeAttr('readonly');
	}
}