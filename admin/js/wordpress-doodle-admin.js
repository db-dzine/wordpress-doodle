(function( $ ) {
	'use strict';

	// Options
	var doodle_options = $('.doodle-options');
	var doodle_options_wrapper = $('.doodle-options-wrapper');
	
	doodle_options.on('click', '.doodle-options-add', function(e){
		e.preventDefault();

		var doodle_option_wrapper = $('.doodle-option-wrapper');
		var to_copy = doodle_option_wrapper.last().clone();

		doodle_options_wrapper.append(to_copy);
	});

	doodle_options.on('click', '.doodle-options-remove', function(e){
		e.preventDefault();

		var checkoptions = $('.doodle-option-wrapper');
		if(checkoptions.length > 1) {

			var closest = $(this).parents('.doodle-option-wrapper');
			closest.remove();
		}
	});

	// Dates
	var doodle_dates = $('.doodle-dates');
	var doodle_dates_wrapper = $('.doodle-dates-wrapper');
	
	doodle_dates.on('click', '.doodle-dates-add', function(e){
		e.preventDefault();

		var doodle_date_wrapper = $('.doodle-date-wrapper');
		var to_copy = doodle_date_wrapper.last().clone();

		doodle_dates_wrapper.append(to_copy);
	});

	doodle_dates.on('click', '.doodle-dates-remove', function(e){
		e.preventDefault();

		var checkdates = $('.doodle-date-wrapper');
		if(checkdates.length > 1) {

			var closest = $(this).parents('.doodle-date-wrapper');
			closest.remove();
		}
	});

})( jQuery );
