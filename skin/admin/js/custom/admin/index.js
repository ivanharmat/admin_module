$(document).ready(function(){
	$.ajaxSetup({cache:false});

	$('#sign_in_form').submit(function(e){
		e.preventDefault();
		$('#sign_in_button').attr('disabled', 'disabled');
		$('#sign_in_button').html('<i class="fa fa-spinner fa-spin"></i> Sign In');
		$('#sign_in_results').hide();
		console.log($('#sign_in_form').serialize());
		$.ajax({
			url : '/admin/authenticate/',
			type : 'POST',
			data : $('#sign_in_form').serialize(),
			success : function(data){
				var json = JSON.parse(data);
				if(json.success)
				{
					window.location = json.redirect;
				}
				else
				{
					$('#sign_in_results').html(json.errors);
					$('#sign_in_results').fadeIn(1500, function(){
						$('#sign_in_results').show();
					});
					$('#sign_in_button').removeAttr('disabled');
					$('#sign_in_button').html('<i class="fa fa-lock"></i> Sign In');
					if(json.hide_form)
					{
						$('#sign_in_button').attr('disabled', 'disabled');
					}
				}
			}
		});
	});
});