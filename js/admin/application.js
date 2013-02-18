$(document).ready(function() {
	
	$("#links").bind('paste', function(e) {
        var el = $(this);
       setTimeout(function() {
            var text = $(el).val();
            _ajaxCall(text);
        }, 100);
	});

	
	$("#links").bind('cut', function(e) {
		var el = $(this);
        setTimeout(function() { 
        	var text = $(el).val();
        	if (text == '') {
        		$('#boxes').html('').fadeOut('fast');
        	}
        }, 100);
	});
	
	$('.boxCheck').live('click', (function() {
		var id = $(this).attr('id');
		if ($('.' + id).is(':checked')) {
			$('.' + id).attr('checked', false);
		} else {
			$('.' + id).attr('checked', true);
		}
	}));
	function _ajaxCall(text) {
		
		$.ajax({
			url  : basepath + 'admin/photos/htmlextractor',
			type : "POST",
			data : "html="+escape(text),
			success: function(data) {		
				$('#boxes').html(data).fadeIn('fast');   	      
			}
		});				
	}
});