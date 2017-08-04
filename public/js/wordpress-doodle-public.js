(function( $ ) {
	'use strict';

	$(document).ready(function() {

	$('a#doodle-button').on('click', function(){
		var width = $(this).data('width');
		var height = $(this).data('height');

		newwindow=window.open($(this).attr('href'),'','height='+ height +',width='+ height);
		if (window.focus) { 
			newwindow.focus();
		}
		return false;
		});
	});

})( jQuery );