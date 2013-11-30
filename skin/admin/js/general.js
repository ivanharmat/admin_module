$(window).load(function() { 
    var browser_height = $(window).height() - (150);  
    $('#main_container').css('min-height', browser_height);
});

$(document).ready(function(){
	$.ajaxSetup({cache:false});

	// Hide Flash Message after 5 seconds
	var flash_massage = $('#flashdata').html().length;
	if(flash_massage > 0)
	{
		setTimeout(function(){
			$('#flashdata').fadeOut(1500, function(){
				$('#flashdata').html('');
			});
		}, 5000);
	}
});